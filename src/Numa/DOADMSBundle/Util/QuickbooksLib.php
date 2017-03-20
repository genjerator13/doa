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
        foreach($items as $item)
        {
            $this->insertItem($item);
        }
    }

    public function addToQBPO($ids)
    {
        $em = $this->container->get('doctrine');
        $items = $em->getRepository("NumaDOAAdminBundle:Item")->findByIds($ids);
        foreach($items as $item)
        {
            $this->insertItemPO($item);
        }
    }
    public function insertItemPO(Item $item)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();
        $title = $this->container->get("numa.dms.listing")->getListingTitle($item);

        $PurchaseService = new \QuickBooks_IPP_Service_PurchaseOrder();

        $qbPO = new \QuickBooks_IPP_Object_PurchaseOrder();


        $qbItem = $this->insertItem($item);
        dump($qbItem);

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
        $sale   = $item->getSale();
        dump($sale);
        $vendor = false;
        if($sale instanceof Sale){
            $vendor = $sale->getVendor();
            $qbPO->setTotalAmt($sale->getInvoiceAmt());
            $Line->setAmount($sale->getInvoiceAmt());
        }
        $qbPO->addLine($Line);
        dump($vendor);
        if($vendor instanceof Vendor){
            $qbVendor = $this->dmsToQbVendor($vendor);
            $qbPO->setVendorRef($qbVendor->getId());
        }


        $resp = $PurchaseService->add($qbo->getContext(), $qbo->getRealm(), $qbPO);
        dump($qbPO);

        if(!$resp)
        {
            print($PurchaseService->lastError($qbo->getContext()));
            return false;
        }
    }
    public function insertItem(Item $item)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();


        $title = $this->container->get("numa.dms.listing")->getListingTitle($item);

        $qbItem = $this->findQBItemByName($title);
        $update=true;
        if(empty($qbItem)){
            $qbItem = new \QuickBooks_IPP_Object_Item();
            $update=false;
        }
        $qbdesc = $this->getQBDesc($item);

        $itemService = new \QuickBooks_IPP_Service_Item();

        $qbItem->setName($title);
        $qbItem->setDesc($qbdesc);
        $qbItem->setDescription($qbdesc);
        $qbItem->setSku($item->getVIN());
        $qbItem->setType('Service');
        $qbItem->setIncomeAccountRef('67');
        $qbItem->setExpenseAccountRef('84');

        $qbItem->setQtyOnHand(1);
        $today = new \DateTime();;

        $qbItem->setInvStartDate($today->format("Y-m-d"));
        //$qbItem->setTrackQtyOnHand(true);
        //$qbItem->setInventoryAssetAccount("aaaaa");

        if($update){
            $resp = $itemService->update($qbo->getContext(), $qbo->getRealm(),$qbItem->getId(), $qbItem);
        }else{
            $resp = $itemService->add($qbo->getContext(), $qbo->getRealm(), $qbItem);
            $qbItem = $this->findQBItemByName($qbItem->getName());
        }

        if(!$resp)
        {
            print($itemService->lastError($qbo->getContext()));
            return false;
        }

        $em = $this->container->get('doctrine.orm.entity_manager');

        $item->setQbItemId($qbItem->getId());
        $em->flush($item);
        return $qbItem;
    }

    public function getQBDesc(Item $item){
        $qbdesc="";
        $qbdesc .=$this->setDescriptionProperty("Stock Number",$item->getStockNr());
        $qbdesc .=$this->setDescriptionProperty("Body Style",$item->getBodyStyle());
        $qbdesc .=$this->setDescriptionProperty("Trim",$item->getTrim());
        $qbdesc .=$this->setDescriptionProperty("Body Description",$item->getBodyDescription());
        $qbdesc .=$this->setDescriptionProperty("Exteriour Color",$item->getExteriorColor());
        return $qbdesc;
    }

    public function setDescriptionProperty($title,$value){

        return empty($value)?"":$title.":".$value."\n";
    }

    public function findQBItemByName($name){
        $qbo = $this->container->get("numa.quickbooks")->init();
        $ItemService = new \QuickBooks_IPP_Service_Term();
        $items = $ItemService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM Item WHERE name = '".$name."'");
        if(!empty($items[0])){
            return $items[0];
        }
        return false;

    }

    public function getAllSuppliers(){
        $qbo = $this->container->get("numa.quickbooks")->init();

        $VendorService = new \QuickBooks_IPP_Service_Vendor();

        $qbVendors = $VendorService->query($qbo->getContext(), $qbo->getRealm(),"SELECT * FROM Vendor ORDER BY CompanyName ");

        return $qbVendors;
    }

    public function getSupplier($name){
        $qbo = $this->container->get("numa.quickbooks")->init();
        $supplierService = new \QuickBooks_IPP_Service_Vendor();
        $items = $supplierService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM Vendor WHERE CompanyName = '".$name."'");
        if(!empty($items[0])) {
            return $items[0];
        }
        return false;
    }

    public function dmsToQbVendor(Vendor $vendor){
        $qbo = $this->container->get("numa.quickbooks")->init();
        $VendorService = new \QuickBooks_IPP_Service_Vendor();

//        $itemService = new \QuickBooks_IPP_Service_Item();


        $qbVendor = $this->getSupplier($vendor->getCompanyName());

        if($qbVendor instanceof \QuickBooks_IPP_Object_Vendor){
            //update supplier
            $qbVendor = $this->addSupplier($qbVendor, $vendor);
            $resp = $VendorService->update($qbo->getContext(), $qbo->getRealm(),$qbVendor->getId(), $qbVendor);
        }else{
            //insert new supplier
            $qbVendor = new \QuickBooks_IPP_Object_Vendor();
            $qbVendor = $this->addSupplier($qbVendor, $vendor);
            $resp = $VendorService->add($qbo->getContext(), $qbo->getRealm(), $qbVendor);
        }
        return $qbVendor;
    }

    public function addSupplier(\QuickBooks_IPP_Object_Vendor $qbVendor, Vendor $vendor){

        $qbVendor->setCompanyName($vendor->getCompanyName());
        $qbVendor->setDisplayName($vendor->getCompanyName());
        $qbVendor->setPrimaryPhone($vendor->getHomePhone());
        $qbVendor->setPrimaryEmail($vendor->getEmail());

        return $qbVendor;
    }

    public function parseId($qbid){
        return intval(str_replace(array("{","}","-"),"",$qbid));
    }

}