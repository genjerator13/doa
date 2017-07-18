<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;

use Numa\DOADMSBundle\Entity\Sale;
use Numa\DOADMSBundle\Entity\Vendor;

class QuickbooksLib
{
    protected $container;
    protected $dealer;

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }

    public function setDealer(Catalogrecords $dealer)
    {
        $this->dealer = $dealer;
    }

    public function getDealer()
    {
        return $this->dealer;
    }

    public function addToQB($ids)
    {
        $em = $this->container->get('doctrine');

        $items = $em->getRepository("NumaDOAAdminBundle:Item")->findByIds($ids);
        foreach ($items as $item) {
            //$this->insertItem($item);
        }
    }

    public function addToQBPO($ids, $preview = false)
    {
        $em = $this->container->get('doctrine');
        $items = $em->getRepository("NumaDOAAdminBundle:Item")->findByIds($ids);
        $qbpos = array();
        foreach ($items as $item) {
            $qbpos[] = $this->insertPurchaseOrdersForItem($item, $preview);
        }
        return $qbpos;
    }

    public function previewQBPO($ids)
    {
        $em = $this->container->get('doctrine');
        $items = $em->getRepository("NumaDOAAdminBundle:Item")->findByIds($ids);
        foreach ($items as $item) {
            $this->insertPurchaseOrdersForItem($item);
        }
    }

    /**
     * Creates QB Purchase Order object with Vendor referenced
     * @param Vendor $vendor
     * @return \QuickBooks_IPP_Object_PurchaseOrder
     */
    public function createPurchaseOrder(Vendor $vendor)
    {
        $qbPO = new \QuickBooks_IPP_Object_PurchaseOrder();
        $qbVendor = $this->dmsToQbVendor($vendor);
        $qbPO->setVendorRef($qbVendor->getId());
        return $qbPO;
    }

    public function addLineToPurchaseOrder($qbPO, $item, $amount, $qty = 1, $property = 'vehicle')
    {
        $Line = new \QuickBooks_IPP_Object_Line();
        $Line->setDetailType('ItemBasedExpenseLineDetail');

        $Line->setAmount($amount);

        $SalesItemLineDetail = new \QuickBooks_IPP_Object_ItemBasedExpenseLineDetail();
        if ($property == 'vehicle') {
            $qbItem = $this->insertVehicleItem($item);

        } else {
            $qbService = $property;
            if (stripos($property, "get") === 0) {
                $qbService = strip_tags(strtolower(substr($property, 3)));
            };
            $settingLib = $this->container->get("numa.settings");
            $qbServiceSetting = $settingLib->get($qbService);
            $qbExpenseAccountSetting = $settingLib->getValue2($qbService);
            $qbIncomeAccountSetting = $settingLib->getValue3($qbService);

            if (!empty($qbServiceSetting)) {
                $qbService = strip_tags($qbServiceSetting);
            }

            $qbItem = $this->insertItem($qbService, $qbService, $qbService, $qbExpenseAccountSetting, $qbIncomeAccountSetting, false, $amount);
        }

        $Line->setDescription($qbItem->getDescription());
        $SalesItemLineDetail->setItemRef($qbItem->getId());
        $SalesItemLineDetail->setUnitPrice($amount);
        $SalesItemLineDetail->setQty($qty);
        $Line->addSalesItemLineDetail($SalesItemLineDetail);
        $qbPO->addLine($Line);
        return $qbPO;
    }

    public function addLineToBill($qbBill,$property, $amount, $description)
    {
        $Line = new \QuickBooks_IPP_Object_Line();
        $Line->setDetailType('AccountBasedExpenseLineDetail');

        $Line->setAmount($amount);

        $SalesItemLineDetail = new \QuickBooks_IPP_Object_AccountBasedExpenseLineDetail();


        //$settingLib = $this->container->get("numa.settings");

        $Line->setDescription($description);
        $AccountBasedExpenseLineDetail = new \QuickBooks_IPP_Object_AccountBasedExpenseLineDetail();
        $AccountBasedExpenseLineDetail->setAccountRef('{-17}');

        $Line->setAccountBasedExpenseLineDetail($AccountBasedExpenseLineDetail);

        $qbBill->addLine($Line);
        return $qbBill;
    }

    public function createItemPO(Item $item)
    {
        $qbPODocNumber = $this->generateQBPODocNumber($item);
        $qbPO = $this->findQBPOByDocNumber($qbPODocNumber);

        if (!$qbPO instanceof \QuickBooks_IPP_Object_PurchaseOrder) {
            $qbPO = new \QuickBooks_IPP_Object_PurchaseOrder();
        }
        $qbItem = $this->insertVehicleItem($item);

        $Line = new \QuickBooks_IPP_Object_Line();
        $Line->setDetailType('ItemBasedExpenseLineDetail');

        $Line->setAmount($item->getPrice());
        $Line->setDescription($qbItem->getDescription());
        $SalesItemLineDetail = new \QuickBooks_IPP_Object_ItemBasedExpenseLineDetail();
        $SalesItemLineDetail->setItemRef($qbItem->getId());
        $SalesItemLineDetail->setUnitPrice($item->getPrice());
        $SalesItemLineDetail->setQty(1);
        $Line->addSalesItemLineDetail($SalesItemLineDetail);

        //vendor
        $sale = $item->getSale();

        $vendor = false;
        if ($sale instanceof Sale) {
            $vendor = $sale->getVendor();
            $qbPO->setTotalAmt($sale->getInvoiceAmt());
            $Line->setAmount($sale->getInvoiceAmt());
        }
        $qbPO->setLine(null);
        //if (empty($qbPO->getID())) {
        $qbPO->addLine($Line);
        //}

        if ($vendor instanceof Vendor) {
            $qbVendor = $this->dmsToQbVendor($vendor);
            $qbPO->setDocNumber($qbPODocNumber);
            $qbPO->setVendorRef($qbVendor->getId());
        }

        return $qbPO;
    }

    public function insertItemPO(Item $item)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();
        $qbPO = $this->createItemPO($item);

        $PurchaseService = new \QuickBooks_IPP_Service_PurchaseOrder();

        if (!empty($qbPO->getId())) {

            $resp = $PurchaseService->update($qbo->getContext(), $qbo->getRealm(), $qbPO->getId(), $qbPO);
        } else {

            $resp = $PurchaseService->add($qbo->getContext(), $qbo->getRealm(), $qbPO);
        }

        if (!$resp) {
            return false;
        }
        return true;
    }

    public function insertItemBills(Item $item)
    {
        $qbo = $this->container->get("numa.quickbooks")->init($this->dealer);

        $vendors = $this->container->get("numa.dms.sale")->getAllVendors($item, true);
        $QBBills = array();

        foreach ($vendors as $vendor) {
            $QBBill = $this->createQBBill($item, $vendor);
            $QBBills[] = $QBBill;
        }

        $this->insertQBBills($QBBills);

        return true;
    }

    public function createQBBill($item, $vendorArray)
    {
        $vendor = $vendorArray[0]['vendor'];
        $property = $vendorArray[0]['property'];
        $qbVendor = $vendorArray[0]['qbVendor'];
        $qbItem = $vendorArray[0]['qbItem'];

        $qbo = $this->container->get("numa.quickbooks")->init($this->dealer);

        $docNumber = $this->generateQBBillDocNumber($item, $property);
        $qbBill = $this->findQBBillByDocNumber($docNumber);

        if (!$qbBill instanceof \QuickBooks_IPP_Object_Bill) {
            $qbBill = new \QuickBooks_IPP_Object_Bill();
        }
        $qbBill->setDocNumber($docNumber);
        $qbBill->setVendorRef($qbVendor->getId());
        $qbBill->setItemRef($qbItem->getId());
        foreach ($vendorArray as $vendorItem) {

            $this->addLineToBill($qbBill,$property, $vendorItem['amount'], "test");
        }


        return $qbBill;
    }

    /**
     * Finds a QB bill by doc number or if there is no bill with that QB number, creates a new one
     * @param $docNumber
     * @return
     */
    public function findQBBillByDocNumber($docNumber)
    {
        return $this->findQBByDocNumber('Bill', $docNumber);
    }

    /**
     * Find QB entity by docnumber
     * @param $QBentity
     * @param $docNumber
     * @return bool
     */
    public function findQBByDocNumber($QBentity, $docNumber)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();
        $ItemService = new \QuickBooks_IPP_Service_Term();
        $items = $ItemService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM " . $QBentity . " WHERE DocNumber = '" . $docNumber . "'");
        if (!empty($items[0])) {
            return $items[0];
        }
        return false;
    }

    public function insertPurchaseOrder(\QuickBooks_IPP_Object_PurchaseOrder $qbPO)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();

        $PurchaseService = new \QuickBooks_IPP_Service_PurchaseOrder();
        $resp = $PurchaseService->add($qbo->getContext(), $qbo->getRealm(), $qbPO);

        if (!$resp) {
            print($PurchaseService->lastError($qbo->getContext()));
            return false;
        }
        //dump($qbPO->getDocNumber().":::::::::::::::::::::::::::::::::::");
        if (!empty($qbPO->getDocNumber())) {
            $ItemService = new \QuickBooks_IPP_Service_Term();
            $po = $ItemService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM PurchaseOrder WHERE docNumber = '" . $qbPO->getDocNumber() . "'");
            //    dump($po[0]);
            if (!empty($po[0])) {
                return $po[0];
            }
        }
        return $qbPO;
    }

    public function insertVehicleItem(Item $item)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();

        $title = $this->container->get("numa.dms.listing")->getListingTitle($item);
        $desc = $this->getQBDesc($item);
        $amount = $this->getQBPrice($item);

        $qbItem = $this->findQBItemByName($title);

        $update = true;
        if (empty($qbItem)) {
            $qbItem = new \QuickBooks_IPP_Object_Item();
            $update = false;
        }

        $qbExpenseAccountSetting = $this->container->get("numa.settings")->getValue2("Inventory");
        $qbIncomeAccountSetting = $this->container->get("numa.settings")->getValue3("Inventory");
        $qbIncomeAccountSetting = $this->container->get("numa.settings")->getValue4("Inventory");

        return $this->insertItem($title, $desc, $item->getVIN(), $qbExpenseAccountSetting, $qbIncomeAccountSetting, $qbIncomeAccountSetting, $amount, "Inventory", true);
    }

    public function insertItem($title, $desc, $sku, $qbExpenseAccount, $qbIncomeAccount, $qbAssetAccount, $amount, $type = "Service", $trackQtyOnHand = false)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();


        //get QB service name from settings
        //if not set
        //search qb service based by property
        //if not found create a new one
        $qbItem = $this->findQBItemByName($title);
        $update = true;
        if (empty($qbItem)) {
            $qbItem = new \QuickBooks_IPP_Object_Item();
            $update = false;
        }
        $eAccountO = $this->getAccount($qbExpenseAccount);
        $iAccountO = $this->getAccount($qbIncomeAccount);
        $AAccountO = $this->getAccount($qbAssetAccount);

        $itemService = new \QuickBooks_IPP_Service_Item();

        $qbItem->setName($title);
        $qbItem->setDesc($desc);
        $qbItem->setDescription($desc);
        $qbItem->setCost($amount);
        $qbItem->setQtyOnHand(1);
        $qbItem->setSku($sku);
        $qbItem->setType($type);
        $qbItem->setTrackQtyOnHand($trackQtyOnHand);
        $qbItem->setIncomeAccountRef('67');
        $qbItem->setExpenseAccountRef('84');
        $qbItem->setAssetAccountRef('85');
        if (!empty($eAccountO)) {
            $qbItem->setExpenseAccountRef($eAccountO->getId() . "");
        }

        if (!empty($iAccountO)) {
            $qbItem->setIncomeAccountRef($iAccountO->getId() . "");
        }
        if (!empty($AAccountO)) {
            $qbItem->setExpenseAccountRef($AAccountO->getId() . "");
        }

        $qbItem->setQtyOnHand(1);
        $today = new \DateTime();;

        $qbItem->setInvStartDate($today->format("Y-m-d"));
        //$qbItem->setTrackQtyOnHand(true);

        if ($update) {
            $resp = $itemService->update($qbo->getContext(), $qbo->getRealm(), $qbItem->getId(), $qbItem);
        } else {
            $resp = $itemService->add($qbo->getContext(), $qbo->getRealm(), $qbItem);
            $qbItem = $this->findQBItemByName($qbItem->getName());
        }

        if (!$resp) {
            print($itemService->lastError($qbo->getContext()));
            die();
            return false;
        }

        return $qbItem;
    }

    public function getAccount($account)
    {
        if (!empty($account)) {
            $qbo = $this->container->get("numa.quickbooks")->init();
            $ItemService = new \QuickBooks_IPP_Service_Term();
            $accountr = $ItemService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM Account WHERE name = '" . $account . "'");

            if (!empty($accountr[0])) {
                return $accountr[0];
            }
        }
        return false;
    }

    public function getQBDesc(Item $item)
    {
        $qbdesc = "";
        $qbdesc .= $this->setDescriptionProperty("Stock Number", $item->getStockNr());
        $qbdesc .= $this->setDescriptionProperty("Body Style", $item->getBodyStyle());
        $qbdesc .= $this->setDescriptionProperty("Trim", $item->getTrim());
        $qbdesc .= $this->setDescriptionProperty("Body Description", $item->getBodyDescription());
        $qbdesc .= $this->setDescriptionProperty("Exteriour Color", $item->getExteriorColor());
        return $qbdesc;
    }

    public function getQBPrice(Item $item)
    {
        $sale = $item->getSale();
        if ($sale instanceof Sale) {
            return $sale->getInvoiceAmt();
        }
        //throw exception
    }

    public function setDescriptionProperty($title, $value)
    {

        return empty($value) ? "" : $title . ":" . $value . "\n";
    }

    public function findQBItemByName($name)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();
        $ItemService = new \QuickBooks_IPP_Service_Term();
        $items = $ItemService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM Item WHERE name = '" . $name . "'");
        if (!empty($items[0])) {
            return $items[0];
        }
        return false;

    }

    public function findQBPOByDocNumber($docNumber)
    {
        return $this->findQBByDocNumber('PurchaseOrder', $docNumber);
    }

    public function getAllSuppliers()
    {
        $qbo = $this->container->get("numa.quickbooks")->init();

        $VendorService = new \QuickBooks_IPP_Service_Vendor();

        $qbVendors = $VendorService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM Vendor ORDER BY CompanyName ");

        return $qbVendors;
    }

    /**
     * Returns QB vendor object for requested name, if notfound returns false
     * @param $name
     * @return \QuickBooks_IPP_Service_Vendor|false
     */
    public function getSupplier($name)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();
        $supplierService = new \QuickBooks_IPP_Service_Vendor();

        $items = $supplierService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM Vendor WHERE CompanyName = '" . addslashes($name) . "'");

        if (!empty($items[0])) {
            return $items[0];
        }
        return false;
    }

    /**
     * For a DMS Vendor entity returns QB vendor object
     * If the DMS vendor name exists just update, else crete new QB vendor record
     * @param Vendor $vendor
     * @return bool|false|\QuickBooks_IPP_Object_Vendor
     */
    public function dmsToQbVendor(Vendor $vendor)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();
        $VendorService = new \QuickBooks_IPP_Service_Vendor();

//        $itemService = new \QuickBooks_IPP_Service_Item();

        $qbVendor = $this->getSupplier($vendor->getCompanyName());
        if ($qbVendor instanceof \QuickBooks_IPP_Object_Vendor) {
            //update supplier
            $qbVendor = $this->addSupplier($qbVendor, $vendor);
            $resp = $VendorService->update($qbo->getContext(), $qbo->getRealm(), $qbVendor->getId(), $qbVendor);
        } else {
            //insert new supplier
            $qbVendor = new \QuickBooks_IPP_Object_Vendor();
            $qbVendor = $this->addSupplier($qbVendor, $vendor);
            $resp = $VendorService->add($qbo->getContext(), $qbo->getRealm(), $qbVendor);
        }
        if (!$resp) {
//            dump($VendorService->lastError($qbo->getContext()));die();
            return false;
        }
        return $qbVendor;
    }

    /**
     * @param \QuickBooks_IPP_Object_Vendor $qbVendor
     * @param Vendor $vendor
     * @return \QuickBooks_IPP_Object_Vendor
     * Maps DMS vendor into QB vendors
     */
    public function addSupplier(\QuickBooks_IPP_Object_Vendor $qbVendor, Vendor $vendor)
    {

        $qbVendor->setCompanyName($vendor->getCompanyName());
        $qbVendor->setDisplayName($vendor->getCompanyName());
        $qbVendor->setGivenName($vendor->getFirstName());
        $qbVendor->setFamilyName($vendor->getLastName());

        $Email = new \QuickBooks_IPP_Object_PrimaryEmailAddr();
        $Email->setAddress($vendor->getEmail());
        $qbVendor->setPrimaryEmailAddr($Email);

        $PrimaryPhone = new \QuickBooks_IPP_Object_PrimaryPhone();
        $PrimaryPhone->setFreeFormNumber($vendor->getHomePhone());
        $qbVendor->setPrimaryPhone($PrimaryPhone);

        $Fax = new \QuickBooks_IPP_Object_Fax();
        $Fax->setFreeFormNumber($vendor->getFax());
        $qbVendor->setFax($Fax);

        $Mobile = new \QuickBooks_IPP_Object_Mobile();
        $Mobile->setFreeFormNumber($vendor->getMobilePhone());
        $qbVendor->setMobile($Mobile);

        $BillAddr = new \QuickBooks_IPP_Object_BillAddr();
        $BillAddr->setLine1($vendor->getAddress());
        $BillAddr->setCity($vendor->getCity());
        $BillAddr->setCountry($vendor->getCountry());
        $BillAddr->setPostalCode($vendor->getZip());
        $BillAddr->setState($vendor->getState());
        $qbVendor->setBillAddr($BillAddr);


        return $qbVendor;
    }

    /**
     * @param $qbid
     * @return int
     * parse qb id into int  {-12}  => 12
     */
    public function parseId($qbid)
    {
        return intval(str_replace(array("{", "}", "-"), "", $qbid));
    }

    /**
     * @param $dealer
     * imports all vendors from QB to DMS
     */
    public function qbToDMSVendors($dealer)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $qbSuppliers = $this->getAllSuppliers();

        foreach ($qbSuppliers as $supplier) {
            $vendor = $this->createVendorFromQB($dealer, $supplier);
        }
        $em->flush();
    }

    /**
     * @param $dealer
     * @param $supplier
     * @return Vendor
     * Creates vendor from QB supplier
     */
    public function createVendorFromQB($dealer, $supplier)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $qbid = $this->parseId($supplier->getId());

        $vendor = $em->getRepository(Vendor::class)->findOneBy(array("qb_supplier_id" => $qbid));

        if (!$vendor instanceof Vendor) {
            $vendor = new Vendor();
            $em->persist($vendor);
        }

        $vendor->setQbSupplierId($qbid);
        $vendor->setCatalogrecords($dealer);
        $vendor->setCompanyName($supplier->getCompanyName());
        $vendor->setFirstName($supplier->getGivenName());
        $vendor->setLastName($supplier->getFamilyName());

        if ($supplier->getPrimaryEmailAddr()) {
            $vendor->setEmail($supplier->getPrimaryEmailAddr()->getAddress());
        }

        if ($supplier->getPrimaryPhone()) {
            $vendor->setHomePhone($supplier->getPrimaryPhone()->getFreeFormNumber());
        }

        if ($supplier->getMobile()) {
            $vendor->setMobilePhone($supplier->getMobile()->getFreeFormNumber());
        }

        if ($supplier->getFax()) {
            $vendor->setFax($supplier->getFax()->getFreeFormNumber());
        }

        if ($supplier->getBillAddr()) {
            $vendor->setCity($supplier->getBillAddr()->getCity());
            $vendor->setCountry($supplier->getBillAddr()->getCountry());
            $vendor->setZip($supplier->getBillAddr()->getPostalCode());
            $vendor->setState($supplier->getBillAddr()->getCountrySubDivisionCode());
            $vendor->setAddress($supplier->getBillAddr()->getLine1());
        }

        $vendor->setStatus(null);
        return $vendor;
    }

    /**
     * @param $vendors collection of dms Vendors
     * Adds collection of vendors to QB
     */
    public function importVendorsToQB($vendors)
    {
        if (!empty($vendors)) {
            foreach ($vendors as $vendor) {
                $vendor = $this->dmsToQbVendor($vendor);
            }
        }
    }

    /**
     * @param $dealer
     * add (update) all dealers vendors to QB
     */
    public function importAllDealerVendorsToQB($dealer)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $vendors = $em->getRepository(Vendor::class)->findByDealerId($dealer->getId());
        $this->importVendorsToQB($vendors);
    }

    public function insertPurchaseOrdersForItem(Item $item, $preview = false, $vendors = false)
    {
        if (!empty($vendors)) {
            $vendors = $this->container->get("numa.dms.sale")->getAllVendors($item);
        }
        $QBPOs = array();
        foreach ($vendors as $vendor) {
            $qbPO = $this->createPurchaseOrder($vendor[0]['vendor']);
            $qbPO->setDocNumber($vendor[0]['docnum']);
            foreach ($vendor as $vendorItem) {
                $this->addLineToPurchaseOrder($qbPO, $item, $vendorItem['amount'], 1, $vendorItem['property']);
            }
            if (!$preview) {
                $qbPO = $this->insertPurchaseOrder($qbPO);
            }
            $QBPOs[] = $qbPO;
        }

        return $QBPOs;
    }

    public function addAccount($name, $type)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();

        $AccountService = new \QuickBooks_IPP_Service_Account();

        $Account = new \QuickBooks_IPP_Object_Account();

        $Account->setName($name);
        $Account->setDescription($name);
        $Account->setAccountType($type);

        if ($resp = $AccountService->add($qbo->getContext(), $qbo->getRealm(), $Account)) {
            return $Account;
        }
        //dump($name);
        //dump($type);
        //dump($Account);
        return false;
    }

    public function generateQBPODocNumber(Item $item)
    {
        return $item->getDealerId() . "_" . $item->getId();
    }

    public function generateQBBillDocNumber(Item $item, $property)
    {

        if (stripos($property, "get") === 0) {
            $property = strip_tags(strtolower(substr($property, 3)));
        };
        return $item->getDealerId() . "_" . $item->getId() . "_" . $property;
    }

    public function insertQBBill(\QuickBooks_IPP_Object_Bill $qbBill){
        $BillService = new \QuickBooks_IPP_Service_Bill();
        $qbo = $this->container->get("numa.quickbooks")->init();
        if(empty($qbBill->getId())) {
            if ($resp = $BillService->add($qbo->getContext(), $qbo->getRealm(), $qbBill)) {
                return $qbBill;
            } else {
                dump('Bill add failed...? ' . $BillService->lastError());
                return false;
            }
        }else{
            if ($resp = $BillService->update($qbo->getContext(), $qbo->getRealm(),$qbBill->getId(), $qbBill)) {
                return $qbBill;
            } else {
                dump('Bill update failed...? ' . $BillService->lastError());
                return false;
            }
        }
    }
    public function insertQBBills($qbBills){
        foreach ($qbBills as $qbBill) {
            $this->insertQBBill($qbBill);
        }
        
    }
}