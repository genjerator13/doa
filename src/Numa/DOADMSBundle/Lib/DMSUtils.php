<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 25.7.16.
 * Time: 14.40
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOADMSBundle\Entity\Customer;

class DMSUtils
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

    public function attachCustomerByEmail($entity,$dealer,$email,$custName="",$custLastName="",$homePhone=""){
        $em = $this->container->get("doctrine.orm.entity_manager");
        if(!empty($email)) {
            $customer = $em->getRepository('NumaDOADMSBundle:Customer')->findOneBy(array('email' => $email, 'dealer_id' => $dealer->getId()));

            if (!$customer instanceof Customer) {
                $customer = new Customer();
                $customer->setFirstName($custName);
                $customer->setLastName($custLastName);
                $customer->setEmail($email);
                $customer->setCatalogrecords($dealer);
                $customer->setHomePhone($homePhone);
                $em->persist($customer);
            }
            $entity->setCustomer($customer);
        }
    }
}