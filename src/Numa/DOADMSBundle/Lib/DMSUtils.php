<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 25.7.16.
 * Time: 14.40
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
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
            $dealer_id=null;
            if($dealer instanceof Catalogrecords){
                $dealer_id=$dealer->getId();
            }
            $customer = $em->getRepository('NumaDOADMSBundle:Customer')->findOneBy(array('email' => $email, 'dealer_id' => $dealer_id));

            if(!empty($customer) && $customer->getStatus()=="deleted"){
                $customer->setStatus(NULL);
            }
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

    public function attachCustomerByName($entity,$dealer,$email,$custName="",$custLastName="",$homePhone=""){
        $em = $this->container->get("doctrine.orm.entity_manager");
        if(!empty($custName)) {
            $dealer_id=null;
            if($dealer instanceof Catalogrecords){
                $dealer_id=$dealer->getId();
            }
            $customer = $em->getRepository('NumaDOADMSBundle:Customer')->findOneBy(array('first_name' => $custName, 'last_name' => $custLastName));

            if(!empty($customer) && $customer->getStatus()=="deleted"){
                $customer->setStatus(NULL);
            }
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

        $em = $this->container->get("doctrine.orm.entity_manager");
        $pages = $em->getRepository('NumaDOAModuleBundle:Page')->findBy(array('dealer_id' => null));
        foreach($pages as $page){
            $existPage = $em->getRepository('NumaDOAModuleBundle:Page')->findOneBy(array('url'=>$page->getUrl(),'dealer_id' => $dealer_id));
            $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($dealer_id);

            if(!($existPage instanceof page)){
                //create new page
                $newPage = new Page();

                $newPage->setUrl($page->getUrl());
                $newPage->setDealer($dealer);//
                $em->persist($newPage);
            }
        }
        $em->flush();
        //get pages with dealer id is null
        //loop
            //if url,dealer_id does not exist create new page with dealer_id and url
    }

    public function clearCache()
    {
        $command = 'php ' . $this->container->get('kernel')->getRootDir() . '/console numa:dbutil cacheclear';


        $process = new \Symfony\Component\Process\Process($command);
        $process->start();

        ///$this->addFlash('success', "Http cache is cleared.");
        return true;
    }

    public function clearCacheFile($parameter='NumaDOASiteBundle:Default:index.html.twig')
    {
        $command = 'php app/console kmlf:twig --clear --env=prod '.$parameter;


        $process = new \Symfony\Component\Process\Process($command);
        $process->start();

        ///$this->addFlash('success', "Http cache is cleared.");
        return true;
    }
}