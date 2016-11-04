<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Doctrine\Common\Collections\Collection;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOAAdminBundle\Entity\Item;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\SimpleXMLElement;

class ListingLib
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

    public function createListingByBillingTradeIn(Billing $billing)
    {
//        dump($billing->getItem());die();
        if (!empty($billing->getTidMake()) && !empty($billing->getTidModel())) {
            $em = $this->container->get('doctrine.orm.entity_manager');
            //check if vin exists already
            $currentItem = $em->getRepository("NumaDOAAdminBundle:Item")->findOneBy(array('VIN' => $billing->getTidVin()));

            if (!$currentItem instanceof Item) {
                $item = new Item();

                //$item->set($entity->getTidKm());
                $item->setCategory($billing->getItem()->getCategory());
                $item->setMake($billing->getTidMake());
                $item->setModel($billing->getTidModel());
                $item->setMileage($billing->getTidMilleage());
                $item->setVin($billing->getTidVin());
                $item->setYear($billing->getTidYear());
                $item->setDealer($billing->getDealer());
                $em->persist($item);
                $em->flush();
            }
        }
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
        $securityContext = $this->container->get('security.authorization_checker');

        if (($securityContext->isGranted('ROLE_ADMIN')) && ($item->getDealer()->getDmsStatus() == "activated") && ($item->getSold())) {

        } else {
            if ($item instanceof Item) {
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
            }
        }
    }

    public function decodeVin($vin)
    {
        $res = array();

        try {
            $buzz = $this->container->get('buzz');
            $error = "";
            $url = 'http://ws.vinquery.com/restxml.aspx?accesscode=c2bd1b1e-5895-446b-8842-6ffaa4bc4633&reportType=1&vin=' . $vin;

            $response = $buzz->get($url, array('User-Agent' => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'));

            if ($buzz->getLastResponse()->getStatusCode() != 200) {
                $error['ERROR'] = "SERVER ERROR";
                return $error;
            }
            $dealerXml = new SimpleXMLElement($response->getContent());

            $json = json_encode($dealerXml);

            if ($buzz->getLastResponse()->getStatusCode() != 200) {
                $error['ERROR'] = "WRONG VIN";
                return $error;
            }
            if (!empty($dealerXml->VIN[0]->Vehicle)) {
                foreach ($dealerXml->VIN[0]->Vehicle->Item as $item) {
                    $array = json_decode(json_encode((array)$item), TRUE);
                    $itemXml = $array["@attributes"];
                    $itemValue = $itemXml['Value'];
                    $itemUnit = $itemXml['Unit'];

                    $itemKey = $itemXml['Key'];
                    if ($itemValue != "N/A" && $itemValue != "No data") {
                        if (!empty($itemUnit)) {
                            $itemValue = $itemValue . " " . $itemUnit;
                        }
                        $res[$itemKey] = $itemValue;
                    }

                }
            }
        }catch(Exception $ex){
            $error['ERROR'] = "NO CONNECTION";
            return $error;
        }
        return $res;
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

    public function insertFromVinDecoder($item){
        $em = $this->container->get('doctrine.orm.entity_manager');
        if (!$item instanceof Item) {
            $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($item);
        }
        if (!$item instanceof Item) {
            return;
        }
        $vindecoderItems = $item->getVindecoderItems();
        if(!empty($vindecoderItems)) {
            foreach ($vindecoderItems as $itemVin)
            {

            }
        }

    }
}