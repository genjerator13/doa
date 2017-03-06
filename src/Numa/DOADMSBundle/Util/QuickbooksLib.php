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

    public function insertItem(Item $item)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();


        $title = $this->container->get("numa.dms.listing")->getListingTitle($item);

        $itemService = new \QuickBooks_IPP_Service_Item();

        $qbItem = new \QuickBooks_IPP_Object_Item();
        $qbItem->setName($title);
        $qbItem->setType('Inventory');
        $qbItem->setIncomeAccountRef('67');
        $qbItem->setExpenseAccountRef('84');

        $qbItem->setQtyOnHand(1);
        $today = new \DateTime();;

        $qbItem->setInvStartDate($today->format("Y-m-d"));
        $qbItem->setTrackQtyOnHand(true);
        $qbItem->setInventoryAssetAccount("aaaaa");


        $PurchaseOrderService = new \QuickBooks_IPP_Service_PurchaseOrder();

        $pos = $PurchaseOrderService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM PurchaseOrder");

//print_r($terms);

        foreach ($pos as $PurchaseOrder)
        {
            dump($PurchaseOrder);
        }
        die();


        if ($resp = $itemService->add($qbo->getContext(), $qbo->getRealm(), $qbItem)) {
        }
        else
        {
            print($itemService->lastError($qbo->getContext()));
            return false;
        }
        return $qbItem;
    }

}