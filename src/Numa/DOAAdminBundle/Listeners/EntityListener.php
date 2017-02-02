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

class EntityListener
{

    protected $container;
    protected $vinchange = false;

    public function __construct($container = null)
    {
        $this->container = $container;
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
//
//
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        if ($entity instanceof Item) {

            if($entity->getSold() && empty($entity->getSoldDate())){
                $entity->setSoldDate(new \DateTime());
                $entityManager->flush();
            }
            //$this->vinchange = false;
            if ($args->hasChangedField("VIN")) {
//                $decodedvin = $this->container->get("numa.dms.listing")->vindecoder($entity);
//                $entity->setVindecoder($decodedvin);
//                $entityManager->flush($entity);
                $this->vinchange = true;
            }
        }

    }

    public function postUpdate(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();

        $entityManager = $args->getEntityManager();

        if ($entity instanceof Item) {
            $this->container->get('mymemcache')->delete('featured_' . $entity->getDealerId());
            if ($this->vinchange) {

                //$decodedvin = $this->container->get("numa.dms.listing")->vindecoder($entity);
                //$entity->setVindecoder($decodedvin);
                //$entityManager->flush($entity);
                //$this->container->get("numa.dms.listing")->insertFromVinDecoder($entity);
            }

        } elseif ($entity instanceof Billing) {
            $this->container->get("Numa.Dms.Listing")->createListingByBillingTradeIn($entity);
            $this->container->get("Numa.Dms.Sale")->createSaleByBilling($entity);
        }
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        if ($entity instanceof Item) {
            if($entity->getSold()){
                $entity->setSoldDate(new \DateTime());
            }
        } elseif ($entity instanceof PartRequest) {
            $this->container->get('Numa.Emailer')->sendNotificationEmail($entity, $entity->getDealer(), $entity->getCustomer());
        } elseif ($entity instanceof ServiceRequest) {
            $this->container->get('Numa.Emailer')->sendNotificationEmail($entity, $entity->getDealer(), $entity->getCustomer());
        } elseif ($entity instanceof ListingForm) {
            $this->container->get('Numa.Emailer')->sendNotificationEmail($entity, $entity->getDealer(), $entity->getCustomer());
        } elseif ($entity instanceof Billing) {
            $this->container->get("Numa.Dms.Listing")->createListingByBillingTradeIn($entity);
            $this->container->get("Numa.Dms.Sale")->createSaleByBilling($entity);
            if(!empty($entity->getItem())){
                $item = $entity->getItem();
                $item->addBilling($entity);
                if($entity->getItem() instanceof Item) {
                    $entity->getItem()->setSold(true);
                    $entity->getItem()->setSoldDate(new \DateTime());
                    $entity->getItem()->setActive(false);
                }
            }
            $em->flush();

        } elseif ($entity instanceof DealerGroup) {
            $entity->setDealerCreator($this->container->get("numa.dms.user")->getSignedDealer());
            $em->flush();
        }
    }

    public function postLoad(LifecycleEventArgs $args)
    {

    }


}
