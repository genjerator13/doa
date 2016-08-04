<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 25.7.16.
 * Time: 14.40
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOAModuleBundle\Entity\Page;

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

    public function generatePagesForDealer($dealer_id){
        dump($dealer_id);
        $em = $this->container->get("doctrine.orm.entity_manager");
        $pages = $em->getRepository('NumaDOADMSBundle:Page')->findBy(array('dealer_id' => null));
        foreach($pages as $page){
            $existPage = $em->getRepository('NumaDOADMSBundle:Page')->findOneBy(array('url'=>$page->getUrl(),'dealer_id' => $dealer_id));
            if(!($existPage instanceof page)){
                //create new page
                $newPage = new Page();
                $newPage->setUrl();
                $newPage->setDealer();//
                $em->persist($newPage);
            }
        }
        $em->flush();
        //get pages with dealer id is null
        //loop
            //if url,dealer_id does not exist create new page with dealer_id and url
    }
}