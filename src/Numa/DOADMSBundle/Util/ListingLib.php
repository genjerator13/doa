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
            $currentItem = $em->getRepository("NumaDOAAdminBundle:Item")->findOneBy(array('VIN'=>$billing->getTidVin()));

            if(!$currentItem instanceof Item) {
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
        if(!is_array($itemIds)){
            $itemIds = explode(",",$itemIds);
        }
        if(is_array($itemIds) || $itemIds instanceof Collection) {
            foreach ($itemIds as $itemId) {
                $this->deleteItem($itemId);
            }
        }
    }

    public function deleteItem($itemId)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        if(!$itemId instanceof Item){
            $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($itemId);
        }

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
        }
//        dump($item->getSaleId());die();
        $em->getRepository("NumaDOADMSBundle:Billing")->delete($itemId);
        $em->getRepository("NumaDOAAdminBundle:Item")->delete($itemId);
        $em->getRepository("NumaDOADMSBundle:Sale")->delete($item->getSaleId());
    }
}