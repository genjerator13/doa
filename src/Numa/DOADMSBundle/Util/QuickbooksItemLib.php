<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;

class QuickbooksItemLib
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

    public function getQBItemDesc(Item $item)
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

    public function getQBItemPrice(Item $item)
    {
        $sale = $item->getSale();
        if ($sale instanceof Sale) {
            return $sale->getInvoiceAmt();
        }
        //throw exception
    }

    public function findQBItemByName($name)
    {
        return $this->container->get("numa.dms.quickbooks")->findQBEntityByField("Item","name",$name);
    }

    public function findQBItemBySku($sku)
    {
        return $this->container->get("numa.dms.quickbooks")->findQBEntityByField("Item","sku",$sku);
    }

    public function addItemToQB($ids)
    {
        $em = $this->container->get('doctrine');

        $items = $em->getRepository("NumaDOAAdminBundle:Item")->findByIds($ids);
        foreach ($items as $item) {
            //$this->insertQBItem($item);
        }
    }

    public function insertVehicleItem(Item $item)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();

        $title = $this->container->get("numa.dms.listing")->getListingTitle($item);
        $desc = $this->getQBDesc($item);
        $amount = $this->getQBPrice($item);

        $qbExpenseAccountSetting = $this->container->get("numa.settings")->getValue2("Inventory");
        $qbIncomeAccountSetting = $this->container->get("numa.settings")->getValue3("Inventory");
        $qbIncomeAccountSetting = $this->container->get("numa.settings")->getValue4("Inventory");

        return $this->insertQBItem($title, $desc, $item->getVIN(), $qbExpenseAccountSetting, $qbIncomeAccountSetting, $qbIncomeAccountSetting, $amount, "Inventory", true);
    }

    public function insertQBItem($title, $desc, $sku, $qbExpenseAccount, $qbIncomeAccount, $qbAssetAccount, $amount, $type = "Service", $trackQtyOnHand = false)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();


        //get QB service name from settings
        //if not set
        //search qb service based by property
        //if not found create a new one
        $qbItem = $this->findQBItemBySku($sku);

        if (empty($qbItem)) {
            $qbItem = new \QuickBooks_IPP_Object_Item();
        }
        $eAccountO = $this->container->get("numa.dms.quickbooks.account")->getAccount($qbExpenseAccount);
        $iAccountO = $this->container->get("numa.dms.quickbooks.account")->getAccount($qbIncomeAccount);
        $AAccountO = $this->container->get("numa.dms.quickbooks.account")->getAccount($qbAssetAccount);

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

        if (!empty($qbItem->getId())) {
            $resp = $itemService->update($qbo->getContext(), $qbo->getRealm(), $qbItem->getId(), $qbItem);
        } else {
            $resp = $itemService->add($qbo->getContext(), $qbo->getRealm(), $qbItem);
        }

        if (!$resp) {
            print($itemService->lastError($qbo->getContext()));
            die();
            return false;
        }

        return $qbItem;
    }


}