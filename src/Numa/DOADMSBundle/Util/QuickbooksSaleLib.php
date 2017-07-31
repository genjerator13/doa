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
        //$customer = $em = $this->container->get("doctrine.orm.entity_manager")->getRepository(Customer::class)->find($billing->getCustomer()->getId());

        $qbCustomer = $this->container->get("numa.dms.quickbooks.customer")->insertCustomerToQBCustomer($customer);

        $qbSale->setDocNumber($docNumber);
        $qbSale->setCustomerRef($qbCustomer->getId());
        $qbSale->setDueDate($billing->getDateBilling()->format("Y-m-d"));

        $item = $billing->getItem();

        if ($item instanceof Item) {
            $qbSale = $this->addVehicleLine($qbSale, $item);
        }

        //$qbSale = $this->addLineToSale($qbSale, $sku, $desc,1,1,1,1,1)


        return $qbSale;
    }

    public function generateQBSaleDocNumber(Billing $billing)
    {
        $itemStr = "_0_";
        if ($billing->getItem() instanceof Item) {
            $itemStr = "_" . $billing->getItem()->getId() . "_";
        }
        return $billing->getDealerId() . "_" . $billing->getId() . $itemStr;
    }

    public function findQBSaleByDocNumber($docNumber)
    {
        return $this->findQBByDocNumber('SalesReceipt', $docNumber);
    }

    public function addVehicleLine(\QuickBooks_IPP_Object_SalesReceipt $qbSale, Item $item)
    {

        $sku = $item->getVin();
        $description = $this->container->get("numa.dms.quickbooks.item")->getQBItemDesc($item);
        $qty = 1;

        $amount = $this->container->get("numa.dms.quickbooks.item")->getQBItemPrice($item);;
        $rate = $amount;
        $saleTax = 0;
        $accountName = $this->container->get("numa.settings")->getValue2("Inventory", $item->getDealer());
        $account = $this->container->get("numa.dms.quickbooks.account")->getAccount($accountName);
        $qbSale->setLine(null);
        $this->addLineToSale($qbSale, $sku, $description, $qty, $rate, $amount, $saleTax, $account, $item);
        return $qbSale;
    }

    public function addLineToSale(\QuickBooks_IPP_Object_SalesReceipt $qbSale, $sku, $description, $qty, $rate, $amount, $saleTax, $account, $item)
    {
        $Line = new \QuickBooks_IPP_Object_Line();
        $Line->setDetailType('SalesItemLineDetail');

        $Line->setSku($sku);
        $Line->setDescription($description);
        $Line->setQty($qty);
        $Line->setRate($rate);
        $Line->setAmount($amount);
        $Line->setSaleTax($saleTax);
        $qbItem = $this->container->get("numa.dms.quickbooks.item")->findQBItemBySku($sku);

        if (!$qbItem instanceof \QuickBooks_IPP_Object_Item) {
            $qbItem = $this->container->get("numa.dms.quickbooks.item")->insertVehicleItem($item);
        }


        $SalesItemLineDetail = new \QuickBooks_IPP_Object_SalesItemLineDetail();

        $accountId = "{-17}";
        if ($account instanceof \QuickBooks_IPP_Object_Account) {
            $accountId = $account->getId();
        }

        $SalesItemLineDetail->setAccountRef($accountId);
        $Line->addSalesItemLineDetail($SalesItemLineDetail);

        $qbSale->addLine($Line);

        $SalesItemLineDetail = new \QuickBooks_IPP_Object_SalesItemLineDetail();

        $SalesItemLineDetail->setItemRef($qbItem->getId());
        $SalesItemLineDetail->setUnitPrice(1111);
        $SalesItemLineDetail->setQty($qty);
        $SalesItemLineDetail->setTaxCodeRef("6");
        $Line->setAmount(1111);
        $Line->addSalesItemLineDetail($SalesItemLineDetail);

        return $qbSale;
    }

    public function insertQBSaleToQB(\QuickBooks_IPP_Object_SalesReceipt $qbSale)
    {
        return $this->insertQBEntityToQB($qbSale);
    }


}