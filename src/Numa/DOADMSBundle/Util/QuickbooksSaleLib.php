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
use Numa\DOADMSBundle\Entity\Billing;

class QuickbooksSaleLib
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

    public function createQBSale(Billing $billing)
    {

        $qbo = $this->container->get("numa.quickbooks")->init($this->dealer);
        $docNumber = $this->generateQBSaleDocNumber($billing);
        $qbSale = $this->findQBSaleByDocNumber($docNumber);

        if (!$qbSale instanceof \QuickBooks_IPP_Object_SalesReceipt) {
            $qbSale = new \QuickBooks_IPP_Object_SalesReceipt();
        }
        $qbSale->setDocNumber($docNumber);
        $item = $billing->getItem();

        if ($item instanceof Item) {
            $qbSale = $this->addVehicleLine($qbSale, $item);
        }

        return $qbSale;
    }

    public function findQBSaleByDocNumber($docNumber)
    {
        return $this->container->get("numa.dms.quickbooks")->findQBByDocNumber('SalesReceipt', $docNumber);
    }

    public function generateQBSaleDocNumber(Billing $billing)
    {
        $itemStr = "_0_";
        if ($billing->getItem() instanceof Item) {
            $itemStr = "_" . $billing->getItem()->getId() . "_";
        }
        return $billing->getDealerId() . "_" . $billing->getId() . $itemStr;
    }

    public function addVehicleLine(\QuickBooks_IPP_Object_SalesReceipt $qbSale, Item $item)
    {
        $title = $this->container->get("numa.dms.listing")->getListingTitle($item);
        $sku = $item->getVin();
        $description = $this->container->get("numa.dms.quickbooks.item")->getQBItemDesc($item);
        $qty = 1;

        $amount = $this->container->get("numa.dms.quickbooks.item")->getQBItemPrice($item);;
        $rate = $amount;
        $saleTax = 0;
        $accountName = $this->container->get("numa.settings")->getValue2("Inventory", $item->getDealer());
        $account = $this->container->get("numa.dms.quickbooks.account")->getAccount($accountName);

        $this->addLineToSale($qbSale, $sku, $description, $qty, $rate, $amount, $saleTax, $account,$item);
        return $qbSale;
    }

    public function addLineToSale(\QuickBooks_IPP_Object_SalesReceipt $qbSale, $sku, $description, $qty, $rate, $amount, $saleTax, $account,$item)
    {
        $Line = new \QuickBooks_IPP_Object_Line();
        $Line->setDetailType('AccountBasedExpenseLineDetail');

        $Line->setSku($sku);
        //$Line->setDescription($description);
        $Line->setQty($qty);
        $Line->setRate($rate);
        $Line->setAmount($amount);
        $Line->setSaleTax($saleTax);
        $qbItem = $this->container->get("numa.dms.quickbooks.item")->findQBItemBySku($sku);
        if(!$qbItem instanceof \QuickBooks_IPP_Object_Item){
            $qbItem = $this->container->get("numa.dms.quickbooks.item")->insertVehicleItem($item);
        }

        $Line->setItemRef($qbItem->getId());
        $AccountBasedExpenseLineDetail = new \QuickBooks_IPP_Object_AccountBasedExpenseLineDetail();

        $accountId = "{-17}";
        if ($account instanceof \QuickBooks_IPP_Object_Account) {
            $accountId = $account->getId();
        }

        $AccountBasedExpenseLineDetail->setAccountRef($accountId);
        $Line->setAccountBasedExpenseLineDetail($AccountBasedExpenseLineDetail);

        $qbSale->addLine($Line);
        dump($qbSale);die();
        return $qbSale;
    }

    public function insertBillingToQBasSaleReceipt($billing)
    {
        $qbSale = $this->createQBSale($billing);
        return $this->insertQBSaleToQB($qbSale);
    }

    public function insertQBSaleToQB(\QuickBooks_IPP_Object_SalesReceipt $qbSale)
    {
        $SaleService = new \QuickBooks_IPP_Service_SalesReceipt();
        $qbo = $this->container->get("numa.quickbooks")->init($this->dealer);

        if (empty($qbSale->getId())) {
            if ($resp = $SaleService->add($qbo->getContext(), $qbo->getRealm(), $qbSale)) {
                return $qbSale;
            } else {
                dump('SaleReceipt add failed...? ' . $SaleService->lastError());
                return false;
            }
        } else {
            if ($resp = $SaleService->update($qbo->getContext(), $qbo->getRealm(), $qbSale->getId(), $qbSale)) {
                return $qbSale;
            } else {
                dump('SaleReceipt update failed...? ' . $SaleService->lastError());
                return false;
            }
        }

        return $qbSale;
    }


}