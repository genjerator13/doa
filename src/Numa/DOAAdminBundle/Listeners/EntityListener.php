<?php

namespace Numa\DOAAdminBundle\Listeners;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Numa\DOAAdminBundle\Entity\User;
use \Numa\DOAAdminBundle\Entity\Item as Item;
use \Numa\DOAAdminBundle\Entity\ItemField as ItemField;
use Numa\DOADMSBundle\Entity\DMSUser;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\PartRequest;
use Numa\DOADMSBundle\Entity\ServiceRequest;
use Numa\DOADMSBundle\Entity\ListingForm;
use Numa\DOAModuleBundle\Entity\Seo;

class EntityListener
{

    protected $container;

    public function __construct($container = null)
    {
        $this->container = $container;
    }

    public function onFlush(OnFlushEventArgs $eventArgs)
    {

        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            if ($entity instanceof Item) {
                //$em->getRepository('NumaDOAAdminBundle:Item')->generateCoverPhotos();
            }
        }
        foreach ($uow->getScheduledEntityUpdates() as $entity) {

            if ($entity instanceof Item) {
                //$em->getRepository('NumaDOAAdminBundle:Item')->generateCoverPhotos();
            }elseif($entity instanceof Billing){


//                if(!empty($entity->getTidMake()) && !empty($entity->getTidModel())){
//                    //check if vin exists already
//                    $item = new Item();
//                    //$item->set($entity->getTidKm());
//
//                    $item->setMake($entity->getTidMake());
//                    $item->setModel($entity->getTidModel());
//                    $item->setMillea($entity->getTidMilleage());
//                    $item->setVin($entity->getTidVin());
//                    $item->setYear($entity->getTidYear());
//                    $item->setDealer($entity->getDealer());
//                }
            }
        }
    }


    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        //before save Item

        if ($entity instanceof Item) {
            if ($this->container->get('security.token_storage')->getToken()) {
                $user = $this->container->get('security.token_storage')->getToken()->getUser();
                if ($user instanceof Numa\DOAAdminBundle\Entity\User) {
                    $entity->setUser($user);
                }
            }
            //before save Item Field
        } elseif ($entity instanceof ItemField) {
            if ($entity->getFieldType() == 'list') {
                $value = $entityManager->getRepository('NumaDOAAdminBundle:ListingfieldLists')->getListingValueById($entity->getFieldIntegerValue());
                if (!empty($value)) {
                    $entity->setFieldStringValue($value);
                }
            }
        } elseif ($entity instanceof User || $entity instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords || $entity instanceof DMSUser) {

            $this->setPassword($entity);
        }
    }

    private function setPassword($entity)
    {
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($entity);
        $plainPassword = $entity->getPassword();
        $encodedPassword = $encoder->encodePassword($plainPassword, $entity->getSalt());
//        dump($plainPassword);
//        dump($encodedPassword);
//        dump($entity);
        //die();
        if (!empty($plainPassword)) {

            $entity->setPassword($encodedPassword);

        }
        return $encodedPassword;
        //dump($entity);
        //die();
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {


//        $entity = $args->getEntity();
//        $entityManager = $args->getEntityManager();
//
//        if ($entity instanceof User || $entity instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords || $entity instanceof DMSUser) {
//            dump($entity->getPassword());
//            $rawPass = $entity->getPassword();
//            $this->setPassword($entity);
//
//            $pass = $entity->getPassword();
//            if (!empty($rawPass)) {
//
//                //$args->setNewValue('password', $pass);
//                dump($pass);
//                dump($entity);die();
//            }
       // }

    }

    public function postUpdate(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();

        $entityManager = $args->getEntityManager();

        if ($entity instanceof Item ) {
            $this->container->get('mymemcache')->delete('featured_'.$entity->getDealerId());
        }elseif($entity instanceof Billing){
            $this->container->get("Numa.Dms.Listing")->createListingByBillingTradeIn($entity);
            $this->container->get("Numa.Dms.Sale")->createSaleByBillingTradeIn($entity);
        }


    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Item ) {
            $this->container->get('mymemcache')->delete('featured_'.$entity->getDealerId());
        }elseif($entity instanceof PartRequest){
            $this->container->get('Numa.Emailer')->sendNotificationEmail($entity,$entity->getDealer(),$entity->getCustomer());
        }elseif($entity instanceof ServiceRequest){
            $this->container->get('Numa.Emailer')->sendNotificationEmail($entity,$entity->getDealer(),$entity->getCustomer());
        }elseif($entity instanceof ListingForm){
            $this->container->get('Numa.Emailer')->sendNotificationEmail($entity,$entity->getDealer(),$entity->getCustomer());
        }elseif($entity instanceof Billing){
            $this->container->get("Numa.Dms.Listing")->createListingByBillingTradeIn($entity);
            $this->container->get("Numa.Dms.Sale")->createSaleByBillingTradeIn($entity);

        }
    }

    public function postLoad(LifecycleEventArgs $args)
    {

    }

}
