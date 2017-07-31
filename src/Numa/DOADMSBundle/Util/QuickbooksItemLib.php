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

class QuickbooksItemLib extends QuickbooksLib
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

    public function getDealer()
    {
        return $this->dealer;
    }

    public function setDealer(Catalogrecords $dealer)
    {
        $this->dealer = $dealer;
    }

    /**
     * finds QB item by name
     * @param $name
     * @return mixed
     */
    public function findQBItemByName($name)
    {
        return $this->findQBEntityByField("Item", "name", $name);
    }

    /**
     * @param $ids
     */
    public function addItemToQB($ids)
    {
        $em = $this->container->get('doctrine');

        $items = $em->getRepository("NumaDOAAdminBundle:Item")->findByIds($ids);
        foreach ($items as $item) {
            //$this->insertQBItem($item);
        }
    }

    /**
     * Add vehicle item to QB
     * @param Item $item
     * @return bool|mixed|\QuickBooks_IPP_Object_Item
     */
    public function insertVehicleItem(Item $item)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();

        $title = $this->container->get("numa.dms.listing")->getListingTitle($item);
        $desc = $this->getQBItemDesc($item);
        $amount = $this->getQBItemPrice($item);

        $qbIncomeAccountSetting = $this->container->get("numa.settings")->getValue3("Inventory");
        $qbExpenseAccountSetting = $this->container->get("numa.settings")->getValue2("Inventory");
        $qbAssetAccount = $this->container->get("numa.settings")->getValue4("Inventory");

        $qbItem = $this->fillQBItem($title, $desc, $item->getVIN(), $qbIncomeAccountSetting, $qbExpenseAccountSetting, $qbAssetAccount, $amount, "Inventory", true);
        return $this->insertQBItemToQB($qbItem);
    }

    /**
     * Generates description for the QB item
     * @param Item $item
     * @return string
     */
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

    /**
     * generates a line in a QB item description
     * @param $title
     * @param $value
     * @return string
     */
    public function setDescriptionProperty($title, $value)
    {
        return empty($value) ? "" : $title . ":" . $value . "\n";
    }

    /**
     * Get a price from the DMS item entity
     * @param Item $item
     * @return mixed
     */
    public function getQBItemPrice(Item $item)
    {
        $sale = $item->getSale();
        if ($sale instanceof Sale) {
            return $sale->getInvoiceAmt();
        }
        //throw exception
    }

    public function fillQBItem($title, $desc, $sku, $qbIncomeAccount, $qbExpenseAccount, $qbAssetAccount, $amount, $type = "Service", $trackQtyOnHand = false)
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


        if (!empty($iAccountO)) {
            $qbItem->setIncomeAccountRef($iAccountO->getId() . "");
        }
        if (!empty($eAccountO)) {
            $qbItem->setExpenseAccountRef($eAccountO->getId() . "");
        }
        if (!empty($AAccountO)) {
            $qbItem->setAssetAccountRef($AAccountO->getId() . "");
        }

        $qbItem->setQtyOnHand(1);
        $today = new \DateTime();;

        $qbItem->setInvStartDate($today->format("Y-m-d"));
        //$qbItem->setTrackQtyOnHand(true);

        return $qbItem;
    }

    /**
     * finds QB item by sku
     * @param $sku
     * @return mixed
     */
    public function findQBItemBySku($sku)
    {

        $ret = $this->findQBEntityByField("Item", "Sku", $sku);

        return $ret;

    }

    public function insertQBItemToQB($qbItem)
    {
        return $this->insertQBEntityToQB($qbItem);
    }


}