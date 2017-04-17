<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Entity\Sale;
use Numa\DOADMSBundle\Entity\Vendor;

class QuickbooksLib
{
    protected $container;


    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }

    public function addToQB($ids)
    {
        $em = $this->container->get('doctrine');

        $items = $em->getRepository("NumaDOAAdminBundle:Item")->findByIds($ids);
        foreach ($items as $item) {
            //$this->insertItem($item);
        }
    }

    public function addToQBPO($ids,$preview=false)
    {
        $em = $this->container->get('doctrine');
        $items = $em->getRepository("NumaDOAAdminBundle:Item")->findByIds($ids);
        $qbpos=array();
        foreach ($items as $item) {
            $qbpos[] = $this->insertPurchaseOrdersForItem($item,$preview);
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
            if(!empty($qbServiceSetting)){
                $qbService = strip_tags($qbServiceSetting);
            }

            $qbItem = $this->insertItem($qbService, $qbService, $qbService,$qbExpenseAccountSetting,$qbIncomeAccountSetting,false,$amount);
        }

        $Line->setDescription($qbItem->getDescription());
        $SalesItemLineDetail->setItemRef($qbItem->getId());
        $SalesItemLineDetail->setUnitPrice($amount);
        $SalesItemLineDetail->setQty($qty);
        $Line->addSalesItemLineDetail($SalesItemLineDetail);
        $qbPO->addLine($Line);
        return $qbPO;
    }

    public function createItemPO(Item $item)
    {
        $qbPO = new \QuickBooks_IPP_Object_PurchaseOrder();
        $qbItem = $this->insertItem($item);

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
        $qbPO->addLine($Line);

        if ($vendor instanceof Vendor) {
            $qbVendor = $this->dmsToQbVendor($vendor);
            $qbPO->setVendorRef($qbVendor->getId());
        }

        return $qbPO;
    }

    public function insertItemPO(Item $item)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();
        $qbPO = $this->createItemPO($item);

        $sale = $item->getSale();
        //$sale->getAllVendors();


        $PurchaseService = new \QuickBooks_IPP_Service_PurchaseOrder();
        $resp = $PurchaseService->add($qbo->getContext(), $qbo->getRealm(), $qbPO);

        if (!$resp) {
            print($PurchaseService->lastError($qbo->getContext()));
            return false;
        }
        return true;
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
        return true;
    }

    public function insertVehicleItem(Item $item)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();

        $title = $this->container->get("numa.dms.listing")->getListingTitle($item);
        $desc = $this->getQBDesc($item);

        //update Item with QB id reference
        $em = $this->container->get('doctrine.orm.entity_manager');
        $item->setQbItemId($item->getId());
        $sale = $item->getSale();
        if($sale instanceof Sale){
            $amount = $sale->getInvoiceAmt();
        }
        $em->flush($item);

        $qbItem = $this->findQBItemByName($title);
        $update = true;
        if (empty($qbItem)) {
            $qbItem = new \QuickBooks_IPP_Object_Item();
            $update = false;
        }
        return $this->insertItem($title, $desc, $item->getVIN(),false,false,false,$amount,"Inventory",true);
    }

    public function insertItem($title, $desc, $sku,$qbExpenseAccount, $qbIncomeAccount, $qbAssetAccount,$amount,$type="Service",$trackQtyOnHand=false)
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
        }else{
            $desc=$qbItem->getDescription();
            $sku =$qbItem->getSKU();
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
        if(!empty($eAccountO)){
            $qbItem->setExpenseAccountRef($eAccountO->getId()."");
        }

        if(!empty($iAccountO)){
            $qbItem->setIncomeAccountRef($iAccountO->getId()."");
        }
        if(!empty($AAccountO)){
            $qbItem->setExpenseAccountRef($AAccountO->getId()."");
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
        dump($type);
        dump($amount);
        dump($qbItem);
        if (!$resp) {
            print($itemService->lastError($qbo->getContext()));die();
            return false;
        }


        //die();
        return $qbItem;
    }

    public function getAccount($account){
        if(!empty($account)) {
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

    public function getAllSuppliers()
    {
        $qbo = $this->container->get("numa.quickbooks")->init();

        $VendorService = new \QuickBooks_IPP_Service_Vendor();

        $qbVendors = $VendorService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM Vendor ORDER BY CompanyName ");

        return $qbVendors;
    }

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

    public function insertPurchaseOrdersForItem(Item $item,$preview=false){
        $vendors =  $this->container->get("numa.dms.sale")->getAllVendors($item);
        $QBPOs   =  array();
        foreach ($vendors as $vendor){
            $qbPO = $this->createPurchaseOrder($vendor[0]['vendor']);
            foreach($vendor as $vendorItem) {
                $this->addLineToPurchaseOrder($qbPO, $item, $vendorItem['amount'],1, $vendorItem['property']);
            }
            if(!$preview) {
                $qbPO = $this->insertPurchaseOrder($qbPO);
            }
            $QBPOs[]=$qbPO;
        }

        return $QBPOs;
    }
}