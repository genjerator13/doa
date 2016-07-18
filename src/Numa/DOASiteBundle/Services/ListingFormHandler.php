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

    public function handleListingForm(ListingForm $listingForm){


        $item = $listingForm->getItem();
        $em = $this->container->get('doctrine.orm.entity_manager');
        if(!empty($listingForm->getDealer())) {
            $customer = $em->getRepository('NumaDOADMSBundle:Customer')->findOneBy(array('email' => $listingForm->getEmail(), 'dealer_id' => $listingForm->getDealer()->getId()));

            if (empty($customer)) {
                $customer = new Customer();
                $customer->setFirstName($listingForm->getCustName());
                $customer->setLastName($listingForm->getCustLastName());
                $customer->setEmail($listingForm->getEmail());
                $customer->setCatalogrecords($listingForm->getDealer());
                $customer->setHomePhone($listingForm->getPhone());
                $em->persist($customer);
            }
        }

        $listingForm->setCustomer($customer);
        $em->persist($listingForm);
        $em->flush();


    }
}