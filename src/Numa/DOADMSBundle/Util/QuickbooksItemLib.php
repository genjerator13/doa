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


        $qbItem = $this->fillQBItem($title, $desc, $item->getVIN(),  $amount, "Inventory", true);
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

    /**
     * Get a price from the DMS item entity
     * @param Item $item
     * @return mixed
     */
    public function getQBItemSoldFor(Item $item)
    {
        $sale = $item->getSale();
        if ($sale instanceof Sale) {
            return $sale->getSellingPrice();
        }
        //throw exception
    }

    public function fillQBItem($title, $desc, $sku, $amount, $type = "Service", $trackQtyOnHand = false)
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

        $eAccountO   = $this->container->get("numa.dms.quickbooks.account")->getExpenseAccount();
        $iAccountO   = $this->container->get("numa.dms.quickbooks.account")->getIncomeAccount();
        $AAccountO   = $this->container->get("numa.dms.quickbooks.account")->getAssetAccount();
        $purchaseTax = $this->container->get("numa.dms.quickbooks.tax")->getPurchaseTax();
        $saleTax     = $this->container->get("numa.dms.quickbooks.tax")->getSaleTax();

        $itemService = new \QuickBooks_IPP_Service_Item();

        $qbItem->setName($title);
        $qbItem->setDesc($desc);
        $qbItem->setDescription($desc);
        $qbItem->setCost($amount);
        $qbItem->setUnitPrice($amount);
        $qbItem->setQtyOnHand(1);
        $qbItem->setSku($sku);
        $qbItem->setType($type);
        $qbItem->setTrackQtyOnHand($trackQtyOnHand);
        $qbItem->setIncomeAccountRef('67');
        $qbItem->setExpenseAccountRef('84');
        $qbItem->setAssetAccountRef('85');
        if($purchaseTax instanceof \QuickBooks_IPP_Object_TaxCode) {
            $qbItem->setPurchaseTaxCodeRef($purchaseTax->getId());
        }
        if($saleTax instanceof \QuickBooks_IPP_Object_TaxCode) {
            $qbItem->setSalesTaxCodeRef($saleTax->getId());
        }

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

    /**
     * returns all service type items
     * @return bool|array
     */
    public function getAllServiceItems()
    {
        $qbo = $this->container->get("numa.quickbooks")->init();

        $ItemService = new \QuickBooks_IPP_Service_Item();

        $qbItems = $ItemService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM Item WHERE type='service' ORDER BY name ");
        $r = array();
        foreach ($qbItems as $item) {
            $r[$item->getName()] = $item->getName();
        }

        return $r;
    }


}