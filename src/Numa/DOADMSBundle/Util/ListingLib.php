<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


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
}