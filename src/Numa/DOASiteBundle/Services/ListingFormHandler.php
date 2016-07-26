<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 18.7.16.
 * Time: 15.36
 */

namespace Numa\DOASiteBundle\Services;
use Numa\DOADMSBundle\Entity\ListingForm;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOASiteBundle\Services\ContainerInterface;

class ListingFormHandler
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

    public function handleListingForm(ListingForm $listingForm,$dealer=null){


        $item = $listingForm->getItem();
        $em = $this->container->get('doctrine.orm.entity_manager');
        //dump($listingForm->getDealer());die();
        $this->container->get('Numa.DMSUtils')->attachCustomerByEmail($listingForm,$listingForm->getDealer(),$listingForm->getEmail(),$listingForm->getCustName(),$listingForm->getCustLastName(),$listingForm->getPhone());

        $em->persist($listingForm);
        $em->flush();


    }
}