<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\Customer;

class QuickbooksSaleLib extends QuickbooksLib
{

    public function insertBillingToQBSaleReceipt($billing)
    {
        $qbSale = $this->createQBSale($billing);
        return $this->insertQBSaleToQB($qbSale);
    }

    public function createQBSale(Billing $billing)
    {

        $docNumber = $this->generateQBSaleDocNumber($billing);
        $qbSale = $this->findQBSaleByDocNumber($docNumber);

        if (!$qbSale instanceof \QuickBooks_IPP_Object_SalesReceipt) {
            $qbSale = new \QuickBooks_IPP_Object_SalesReceipt();
        }
        $customer = $billing->getCustomer();

        $qbCustomer = $this->container->get("numa.dms.quickbooks.customer")->insertCustomerToQBCustomer($customer);

        $qbSale->setDocNumber($docNumber);
        $qbSale->setCustomerRef($qbCustomer->getId());
        $qbSale->setDueDate($billing->getDateBilling()->format("Y-m-d"));

        $item = $billing->getItem();

        if ($item instanceof Item) {
            $qbSale = $this->addVehicleLine($qbSale, $item);
        }

        if(!empty($billing->getWarranty())) {
            $serviceCostName=$this->getServiceCost('warranty');

            $assetAccount = $this->getServiceCostAssetAccount('warranty');

            if($serviceCostName instanceof \QuickBooks_IPP_Object_Item) {
                $qbSale = $this->addLineCostToSale($qbSale, $serviceCostName,$assetAccount, $billing->getWarranty(), 1, 1, 1);
            }
        }

        return $qbSale;
    }

    public function addLineCostToSale($qbSale, $qbItem,$assetAccount, $amount,$qty,$rate){

        $Line = new \QuickBooks_IPP_Object_Line();
        $Line->setSku($qbItem->getSku());
        $Line->setDetailType('SalesItemLineDetail');
        $Line->setDescription($qbItem->getDescription());
        $Line->setAmount($qbItem->getUnitPrice());
        $SalesItemLineDetail = new \QuickBooks_IPP_Object_SalesItemLineDetail();

        $accountId = "{-17}";
        if ($assetAccount instanceof \QuickBooks_IPP_Object_Account) {
            $accountId = $assetAccount->getId();
        }

        $SalesItemLineDetail->setAccountRef($accountId);

        $SalesItemLineDetail->setItemRef($qbItem->getId());

        $SalesItemLineDetail->setUnitPrice($amount);
        $SalesItemLineDetail->setQty($qty);
        $SalesItemLineDetail->setTaxCodeRef($qbItem->getSalesTaxCodeRef());
        $Line->setAmount($amount);
        $Line->setUnitPrice($amount);
        $Line->addSalesItemLineDetail($SalesItemLineDetail);
        $qbSale->addLine($Line);

        return $qbSale;
    }

    public function generateQBSaleDocNumber(Billing $billing)
    {
        $itemStr = "_0_";
        if ($billing->getItem() instanceof Item) {
            $itemStr = "_" . $billing->getItem()->getId() . "_";
        }
        return $billing->getDealer()->getId() . "_" . $billing->getId() . $itemStr;
    }

    public function findQBSaleByDocNumber($docNumber)
    {
        return $this->findQBByDocNumber('SalesReceipt', $docNumber);
    }

    public function addVehicleLine(\QuickBooks_IPP_Object_SalesReceipt $qbSale, Item $item)
    {

        $sku = $item->getVin();
        $description = $this->container->get("numa.dms.quickbooks.item")->getQBItemDesc($item);

        $amount = $this->container->get("numa.dms.quickbooks.item")->getQBItemSoldFor($item);;
        $rate = $amount;
        $saleTax = 0;
        $accountName = $this->container->get("numa.settings")->getValue2("Inventory", $item->getDealer());
        $account = $this->container->get("numa.dms.quickbooks.account")->getAccount($accountName);
        $qbSale->setLine(null);
        $this->addLineToSale($qbSale, $sku, $description, 1, $rate, $amount, $saleTax, $account, $item);
        return $qbSale;
    }

    public function addLineToSale(\QuickBooks_IPP_Object_SalesReceipt $qbSale, $sku, $description, $qty, $rate, $amount, $saleTax, $account, $item)
    {
        $Line = new \QuickBooks_IPP_Object_Line();
        $Line->setDetailType('SalesItemLineDetail');



        $qbItem = $this->container->get("numa.dms.quickbooks.item")->findQBItemBySku($sku);

        if (!$qbItem instanceof \QuickBooks_IPP_Object_Item) {
            $qbItem = $this->container->get("numa.dms.quickbooks.item")->insertVehicleItem($item);
        }

        $Line->setSku($sku);
        $Line->setDescription($description);
        $Line->setQty($qty);
        $Line->setRate($rate);
        $Line->setSaleTax($saleTax);
        $Line->setAmount($amount);

        $SalesItemLineDetail = new \QuickBooks_IPP_Object_SalesItemLineDetail();

        $accountId = "{-17}";
        if ($account instanceof \QuickBooks_IPP_Object_Account) {
            $accountId = $account->getId();
        }

        $SalesItemLineDetail->setAccountRef($accountId);

        $SalesItemLineDetail->setItemRef($qbItem->getId());
        //$price  = $this->container->get("numa.dms.quickbooks.item")->getQBItemPrice($item);

        $SalesItemLineDetail->setUnitPrice($amount);
        $SalesItemLineDetail->setQty($qty);
        $SalesItemLineDetail->setTaxCodeRef($qbItem->getSalesTaxCodeRef());

        $Line->addSalesItemLineDetail($SalesItemLineDetail);
        $qbSale->addLine($Line);

        return $qbSale;
    }

    public function insertQBSaleToQB(\QuickBooks_IPP_Object_SalesReceipt $qbSale)
    {
        return $this->insertQBEntityToQB($qbSale);
    }

    public function getServiceCost($name){
        if($name=='warranty'){
            $serviceItemName = $this->container->get("numa.settings")->getStripped($name);
            $qbItem = $this->container->get("numa.dms.quickbooks.item")->findQBItemByName($serviceItemName);
            return $qbItem;
        }

    }
    public function getServiceCostAssetAccount($name){
        if($name=='warranty') {
            $accountName = $this->container->get("numa.settings")->getStripped($name,array(),array(),"Value4");
            $account = $this->container->get("numa.dms.quickbooks.account")->getAccount($accountName);
        }
    }


}