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

class QuickbooksPurchaseOrderLib extends QuickbooksLib
{

    /**
     * @param $ids
     * @param bool $preview
     * @return array
     */
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

    /**
     * Creates QB Purchase Order object with Vendor referenced
     * @param Vendor $vendor
     * @return \QuickBooks_IPP_Object_PurchaseOrder
     */
    public function createPurchaseOrder(Vendor $vendor)
    {
        $qbPO = new \QuickBooks_IPP_Object_PurchaseOrder();
        $qbVendor = $this->container->get("numa.dms.quickbooks.vendor")->dmsToQbVendor($vendor);
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
            $qbItem = $this->container->get("numa.dms.quickbooks.item")->insertVehicleItem($item);

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

            $qbItem = $this->container->get("numa.dms.quickbooks.item")->insertQBItem($qbService, $qbService, $qbService, $qbExpenseAccountSetting, $qbIncomeAccountSetting, false, $amount);
        }

        $Line->setDescription($qbItem->getDescription());
        $SalesItemLineDetail->setItemRef($qbItem->getId());
        $SalesItemLineDetail->setUnitPrice($amount);
        $SalesItemLineDetail->setQty($qty);
        $Line->addSalesItemLineDetail($SalesItemLineDetail);
        $qbPO->addLine($Line);
        return $qbPO;
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

    public function previewQBPO($ids)
    {
        $em = $this->container->get('doctrine');
        $items = $em->getRepository("NumaDOAAdminBundle:Item")->findByIds($ids);
        foreach ($items as $item) {
            $this->insertPurchaseOrdersForItem($item);
        }
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

    public function createItemPO(Item $item)
    {
        $qbPODocNumber = $this->generateQBPODocNumber($item);
        $qbPO = $this->findQBPOByDocNumber($qbPODocNumber);

        if (!$qbPO instanceof \QuickBooks_IPP_Object_PurchaseOrder) {
            $qbPO = new \QuickBooks_IPP_Object_PurchaseOrder();
        }
        $qbItem = $this->container->get("numa.dms.quickbooks.item")->insertVehicleItem($item);

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
            $qbVendor = $this->container->get("numa.dms.quickbooks.vendor")->dmsToQbVendor($vendor);
            $qbPO->setDocNumber($qbPODocNumber);
            $qbPO->setVendorRef($qbVendor->getId());
        }

        return $qbPO;
    }

    public function generateQBPODocNumber(Item $item)
    {
        return $item->getDealerId() . "_" . $item->getId();
    }

    public function findQBPOByDocNumber($docNumber)
    {
        return $this->findQBByDocNumber('PurchaseOrder', $docNumber);
    }

}