<?php

namespace Numa\DOAAdminBundle\Listeners;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\User;
use \Numa\DOAAdminBundle\Entity\Item as Item;
use \Numa\DOAAdminBundle\Entity\ItemField as ItemField;
use Numa\DOADMSBundle\Entity\DealerComponent;
use Numa\DOADMSBundle\Entity\DMSUser;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\Finance;
use Numa\DOADMSBundle\Entity\FinanceService;
use Numa\DOADMSBundle\Entity\Leasing;
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
        } elseif ($entity instanceof ListingForm) {
            $spam = $this->container->get('numa.dms.text')->isSpam($entity->getComment());
            $entity->setSpam($spam);
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
        if (!empty($plainPassword)) {

            $entity->setPassword($encodedPassword);
        }
        return $encodedPassword;
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof Item) {

            if ($entity->getSold() && empty($entity->getSoldDate())) {
                $entity->setSoldDate(new \DateTime());
                $dealer = $entity->getDealer();
                if($dealer instanceof Catalogrecords){
                    $entity->setActive(false);
                }
                //$entityManager->flush();
            }
//            dump($entity);die();
            if ($args->hasChangedField("VIN")) {
                $this->vinchange = true;
            }
        }

    }

    public function postUpdate(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();
        if ($entity instanceof Item) {
            $this->container->get('mymemcache')->delete('featured_' . $entity->getDealerId());
        } elseif ($entity instanceof Billing) {
            $this->container->get("Numa.Dms.Listing")->createListingByBillingTradeIn($entity);
            $this->container->get("Numa.Dms.Sale")->createSaleByBilling($entity);
            $this->container->get("Numa.Dms.Sale")->setListingSoldIfActive($entity);
        } elseif ($entity instanceof Catalogrecords) {
            $this->container->get('mymemcache')->deleteDealerCache($entity);
        } elseif ($entity instanceof DealerComponent) {
            $this->container->get('mymemcache')->deleteDealerCache($entity->getDealer());
        }
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        if ($entity instanceof Item) {
            if ($entity->getSold()) {
                $entity->setSoldDate(new \DateTime());
                $dealer = $entity->getDealer();
                if($dealer instanceof Catalogrecords){
                    $entity->setActive(false);
                }
            }
            $seo = $em->getRepository('NumaDOAModuleBundle:Seo')->findOneBy(array('table_name' => 'item', 'table_id' => $entity->getId()));

            $seoService = $this->container->get("Numa.Seo");
            $seo = $seoService->prepareSeo($entity);

            $em->flush();

            //add item to QB
            //$this->container->get('numa.dms.quickbooks.item')->addItemToQB(array($entity->getId()));

        } elseif ($entity instanceof PartRequest) {
            $this->container->get('Numa.Emailer')->sendNotificationEmail($entity, $entity->getDealer(), $entity->getCustomer());
        } elseif ($entity instanceof ServiceRequest) {
            $this->container->get('Numa.Emailer')->sendNotificationEmail($entity, $entity->getDealer(), $entity->getCustomer());
        } elseif ($entity instanceof ListingForm) {
            if (!$entity->getSpam()) {
                $this->container->get('Numa.Emailer')->sendNotificationEmail($entity, $entity->getDealer(), $entity->getCustomer());
            }
        } elseif ($entity instanceof FinanceService) {
            $this->container->get('Numa.Emailer')->sendNotificationEmail($entity, $entity->getDealer(), $entity->getCustomer());
        } elseif ($entity instanceof Finance) {
            $this->container->get('Numa.Emailer')->sendNotificationEmail($entity, $entity->getDealer(), $entity->getCustomer());
        } elseif ($entity instanceof Leasing) {
            $this->container->get('Numa.Emailer')->sendNotificationEmail($entity, $entity->getDealer(), $entity->getCustomer());
        } elseif ($entity instanceof Billing) {
            $this->container->get("Numa.Dms.Listing")->createListingByBillingTradeIn($entity);
            $this->container->get("Numa.Dms.Sale")->createSaleByBilling($entity);
            $this->container->get("Numa.Dms.Sale")->setListingSoldIfActive($entity);
        } elseif ($entity instanceof DealerGroup) {
            $entity->setDealerCreator($this->container->get("numa.dms.user")->getSignedDealer());
            $em->flush();
        }
    }

    public function postLoad(LifecycleEventArgs $args)
    {

    }


}
