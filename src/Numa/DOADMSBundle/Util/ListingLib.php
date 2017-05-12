<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Category;
use Numa\DOAAdminBundle\Entity\Listingfield;
use Numa\DOAAdminBundle\Entity\ListingFieldLists;
use Numa\DOAAdminBundle\Entity\ItemField;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Sale;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\SimpleXMLElement;

class ListingLib
{
    protected $container;

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container = null) // this is @service_container
    {
        $this->container = $container;
    }

    /**
     * If the billing from the $billing param has tidMake and TidModel entered, create new item
     * @param Billing $billing
     * @return bool (false if no item is created(already created or tidmake or tidmodel are not entered, true if item is created
     */
    public function createListingByBillingTradeIn(Billing $billing, $insertToDB = true)
    {
        if (!empty($billing->getTidMake()) && !empty($billing->getTidModel())) {
            $em = $this->container->get('doctrine.orm.entity_manager');
            //check if vin exists already
            $currentItem = $em->getRepository("NumaDOAAdminBundle:Item")->findOneBy(array('VIN' => $billing->getTidVin()));

            if (!$currentItem instanceof Item) {
                $item = new Item();
                $item->setCategory($billing->getItem()->getCategory());
                $item->setMake($billing->getTidMake());
                $item->setModel($billing->getTidModel());
                $item->setMileage($billing->getTidMilleage());
                $item->setVin($billing->getTidVin());
                $item->setYear($billing->getTidYear());
                $item->setDealer($billing->getDealer());
                if ($insertToDB) {
                    $em->persist($item);
                    $em->flush();
                }
                return true;
            }
        }
        return false;
    }

    public function insertItem(Item $item)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        if (!empty($item->getId())) {
            $em->persist($item);
        }
        $em->flush();
    }

    public function deleteItems($itemIds)
    {
        if (!is_array($itemIds)) {
            $itemIds = explode(",", $itemIds);
        }
        if (is_array($itemIds) || $itemIds instanceof Collection) {
            foreach ($itemIds as $itemId) {
                $this->deleteItem($itemId);
            }
        }
    }

    public function deleteItem($item)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        if (!$item instanceof Item) {
            $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($item);
        }
        if (!$item instanceof Item) {
            return;
        }
        $securityContext = $this->container->get('security.authorization_checker');

//        if (!(($securityContext->isGranted('ROLE_ADMIN'))
//                && ($item->getDealer() instanceof Catalogrecords)
//                && ($item->getDealer()->getDmsStatus() == "activated")
//                //&& ($item->getSold())
//            )
//            && ($item instanceof Item)
//        ) {
        foreach ($item->getItemField() as $itemField) {
            if (stripos($itemField->getFieldType(), "array") !== false && stripos($itemField->getFieldStringValue(), "http") === false) {
                $web_path = $this->container->getParameter('web_path');
                $filename = $web_path . $itemField->getFieldStringValue();
                if (file_exists($filename) && is_file($filename)) {
                    unlink($filename);
                }
                $em->remove($itemField);
            }
        }
        $em->getRepository("NumaDOADMSBundle:Billing")->delete($item->getId());
        $em->getRepository("NumaDOADMSBundle:ListingForm")->deleteByItemId($item->getId());
        $em->getRepository("NumaDOAAdminBundle:Item")->delete($item->getId());
        $em->getRepository("NumaDOADMSBundle:Sale")->delete($item->getSaleId());
        //}

    }

    public function decodeVin($vin)
    {
        $res = array();
        $trim = array();

        try {
            $buzz = $this->container->get('buzz');
            $error = "";
            $url = 'http://ws.vinquery.com/restxml.aspx?accesscode=c2bd1b1e-5895-446b-8842-6ffaa4bc4633&reportType=1&vin=' . $vin;
            //testurl
            //$url = "http://doa.local/upload/restxml.xml";
            $response = $buzz->get($url, array('User-Agent' => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'));

            if ($buzz->getLastResponse()->getStatusCode() != 200) {
                $error['ERROR'] = "SERVER ERROR";
                return $error;
            }
            $dealerXml = new SimpleXMLElement($response->getContent());

            $json = json_encode($dealerXml);
            ;
            if ($buzz->getLastResponse()->getStatusCode() != 200) {
                $error['ERROR'] = "WRONG VIN";
                return $error;
            }
            $vinArray = (json_decode($json,true));
            $data =$vinArray['VIN']['Vehicle'];

            if(empty($vinArray['VIN']['Vehicle'][0])){
                $data=array();
                $data[0] =$vinArray['VIN']['Vehicle'];

            }

            foreach ($data as $key => $vehicle) {

                foreach ($vehicle['Item'] as $item) {

                    $itemXml = $item["@attributes"];
                    $itemValue = $itemXml['Value'];
                    $itemUnit = $itemXml['Unit'];

                    $itemKey = $itemXml['Key'];

                    if ($itemValue != "N/A" && $itemValue != "No data") {
                        if (!empty($itemUnit)) {
                            $itemValue = $itemValue . " " . $itemUnit;
                        }
                        $res[$key][$itemKey] = $itemValue;
                    }
                }
                $res[$key]['itemfields'] = $this->formatItemFields($res[$key]);

            }

        } catch (Exception $ex) {
            $error['ERROR'] = "NO CONNECTION";
            return $error;
        }

        return $res;
    }

    private function formatItemFields($res){
        $em = $this->container->get('doctrine.orm.entity_manager');
        $itemFields = array();

        foreach ($res as $key=>$item) {
            if ($item == "Std." || $item == "Opt.") {
                $listingField = $em->getRepository(ListingFieldLists::class)->getListingFieldIdFromString($key);

                if($listingField instanceof Listingfield) {
                    $itemFields[$listingField->getId()] = $item;
                }
            }
        }
        return $itemFields;
    }


    public function vindecoder($item)
    {
        $vin = "";
        $em = $this->container->get('doctrine.orm.entity_manager');
        if (!$item instanceof Item) {
            $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($item);
        }
        if ($item instanceof Item) {
            if (!empty($item->getVIN())) {
                $vin = $item->getVIN();
            }
        }

        if (empty($vin)) {
            return;;
        }

        $decodedVin = $this->decodeVin($vin);

        if (is_array($decodedVin)) {
            if (!array_key_exists("ERROR", $decodedVin)) {
                return json_encode($decodedVin, true);
            }
        }
        return false;
    }

    public function insertFromVinDecoder($item)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        if (!$item instanceof Item) {
            $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($item);
        }
        if (!$item instanceof Item) {
            return;
        }
        $vindecoderItems = $item->getVindecoderItems();
        $this->vinDecoderInsertion($item, $vindecoderItems);

    }

    public function vinDecoderInsertion($item, $vindecoderItems)
    {
        if (!empty($vindecoderItems)) {
            foreach ($vindecoderItems as $key => $itemVin) {
                $this->vinDecoderInsertField($item, $itemVin, $key);
            }
        }
    }

    public function vinDecoderInsertField($item, $itemVin, $key)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        if (strtolower($itemVin) == "std.") {
            $criteria = new \Doctrine\Common\Collections\Criteria();
            $criteria->where(Criteria::expr()->eq("field_name", $key));
            $currentItemField = null;

            if (!empty($item->getItemField())) {
                $currentItemField = $item->getItemField()->matching($criteria);
            }
            if ($currentItemField instanceof ArrayCollection && $currentItemField->first() instanceof ItemField) {
                //$currentItemField->first()->setFieldBooleanValue(true);

            } else {
                $if = new ItemField();
                $if->setFieldName($key);
                $if->setFieldType('boolean');
                $if->setFieldBooleanValue(true);
                $if->setFieldStringValue("true");
                $if->setFieldIntegerValue(1);
                $item->addItemField($if);
                $em->persist($if);
                //$em->flush($item);
            }
        }
    }

    public function getProperty($item, $property)
    {
        $function = $this->asFunction($property);
        $splitName = explode(":", $property);
        if (count($splitName) > 1) {
            if (strtolower($splitName[0]) == "sale") {
                if ($item->getSale() instanceof Sale) {
                    $function = $this->asFunction($splitName[1]);
                    if (method_exists($item->getSale(), $function)) {
                        return $item->getSale()->{$function}();
                    }
                }
            }

            if (strtolower($splitName[0]) == "billing") {
                $em = $this->container->get('doctrine.orm.entity_manager');
                $billing = $em->getRepository('NumaDOADMSBundle:Billing')->findOneBy(array("Item" => $item));

                if ($billing instanceof Billing) {
                    $function = $this->asFunction($splitName[1]);
                    if (method_exists($billing, $function)) {
                        return $billing->{$function}();
                    }
                }
            }
        }

        if (method_exists($item, $function)) {
            return $item->{$function}();
        }
    }

    public function asFunction($property)
    {

        $function = 'get' . str_ireplace(array(" ", "_"), '', ucfirst($property));
        return $function;
    }

    public function archiveItem($item)
    {
        $item = $this->getItem($item);
        if ($item instanceof Item) {
            $item->setArchiveStatus('archived');
            $item->setArchivedDate(new \DateTime());
        }
    }

    public function getItem($item)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        if (is_numeric($item)) {
            $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($item);
        }
        return $item;
    }

    public function setSoldDateItem($item)
    {
        $item = $this->getItem($item);
        if ($item instanceof Item) {
            $item->setSoldDate(new \DateTime());
        }
    }

    /**
     * @param Item $item
     * @return string
     */
    public function getMetaTitle(Item $item)
    {
        $desc = $item->getYear() . " " . $item->slug($item->getMake()) . " " . $item->slug($item->getModel());
        $cat = $item->getCategory();
        if ($item->getCategoryId() == 4 || ($cat instanceof Category && $cat->getId() == 4)) {
            $desc = $desc . " " . $item->getFloorPlan();
        } elseif ($item->getCategoryId() == 1 || ($cat instanceof Category && $cat->getId() == 1)) {
            if (!empty($item->getTrim())) {
                //$desc .= " " . $item->slug($item->getTrim());
                $desc .= " " . $item->getTrim();
            }
        }
        return $desc;
    }

    public function getListingTitle(Item $item)
    {
        $desc = $item->getYear() . " " . $item->slug($item->getMake()) . " " . $item->slug($item->getModel());
        if ($item->getCategoryId() == 4) {
            $desc = $desc . " " . $item->getFloorPlan();
        } elseif ($item->getCategoryId() == 1) {
            if (!empty($item->getTrim())) {
                $desc .= " " . $item->getTrim();
            }
        }
        return $desc;
    }


    public function getMetaDescription(Item $item)
    {
        return $item->getCurrentSellerComment();
    }

    public function getMetaKeywords(Item $item)
    {
        $keywords = array();
        $keywords[] = $this->getMetaTitle($item);


        return implode(",", $keywords);
    }
}