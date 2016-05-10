<?php

namespace Numa\DOAAdminBundle\Listeners;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Numa\DOAAdminBundle\Entity\User;
use \Numa\DOAAdminBundle\Entity\Item as Item;
use \Numa\DOAAdminBundle\Entity\ItemField as ItemField;
use Numa\DOADMSBundle\Entity\DMSUser;
use Numa\DOAModuleBundle\Entity\Seo;

class EntityListener {

    protected $container;

    public function __construct($container = null) {
        $this->container = $container;
    }

    public function preFlush(PreFlushEventArgs $args)
    {

//        $em  = $args->getEntityManager();
//        $uow = $em->getUnitOfWork();
//        dump($uow->getScheduledEntityUpdates());
//        dump($uow->getScheduledEntityInsertions());
//        dump($uow->getScheduledCollectionUpdates());
//
//
//        foreach ($uow->getScheduledEntityUpdates() as $updated) {
//
//            if ($updated instanceof Item) {
//                //$entity->equalizeItemFields();
//                $setting = $this->container->get("Numa.settings");
//                $title = $setting->generateItemTitle($updated);
//                //$entityManager = $this->container->get('doctrine');
//
//                $seo = $em->getRepository('NumaDOAModuleBundle:Seo')->findOneBy(array('table_name'=>'item','table_id'=>$updated->getId()));
//                if(empty($seo)) {
//                    $seo = new Seo();
//                }
//                $seo->setTitle($title);
//                dump($seo);die();
//                $em->persist($seo);
//                //$entityManager->flush();
//            }
//        }

        //$uow->computeChangeSets();

    }

    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        dump("preupdateXXXX");
//        $em = $eventArgs->getEntityManager();
//        $uow = $em->getUnitOfWork();
//
//        foreach ($uow->getScheduledEntityInsertions() as $entity) {
//
//            if($entity instanceof Item){
//
//                //$seoPost =$request->get("numa_doamodulebundle_seo");
//                $seoService = $this->container->get("Numa.Seo");
//                $seo = $seoService->prepareSeo($entity, array(), false);
//                //dump($seo);die();
//                $classMetadata = $em->getClassMetadata('Numa\DOAModuleBundle\Entity\Seo');
//                $uow->computeChangeSet($classMetadata, $seo);
//            }
//        }
//
//        foreach ($uow->getScheduledEntityUpdates() as $entity) {
////            if($entity instanceof Item){
////                $seoPost =$request->get("numa_doamodulebundle_seo");
////                $seoService = $this->container->get("Numa.Seo");
////                $seo = $seoService->prepareSeo($entity,$seoPost);
////
////                $classMetadata = $em->getClassMetadata('Numa\DOAModuleBundle\Entity\Seo');
////                $uow->computeChangeSet($classMetadata, $seo);
////            }
//        }

    }

    public function prePersist(LifecycleEventArgs $args) {
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

    private function setPassword($entity) {
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($entity);
        $plainPassword = $entity->getPassword();
        $encodedPassword = $encoder->encodePassword($plainPassword, $entity->getSalt());

        if (!empty($plainPassword)) {

            $entity->setPassword($encodedPassword);
        }
    }

    public function preUpdate(PreUpdateEventArgs $args) {


        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof User || $entity instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords || $entity instanceof DMSUser) {

            $this->setPassword($entity);

            $pass = $entity->getPassword();
            if(!empty($pass)){

                //$args->setNewValue('password', $pass);
                //dump($entity);die();
            }
        }

        if ($entity instanceof Item) {
                //$entity->equalizeItemFields();
                //$setting = $this->container->get("Numa.settings");
                //$title = $setting->generateItemTitle($entity);
                //$entityManager = $this->container->get('doctrine');


                //$entity->setSeo($seo);
//dump($seo);die();
                //$entityManager->persist($seo);
                //$entityManager->flush();
            }
    }

    public function postUpdate(LifecycleEventArgs $args) {

        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        if ($entity instanceof User || $entity instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords) {
            //$this->setPassword($entity);
        } elseif ($entity instanceof Item) {

            $command = new \Numa\DOAAdminBundle\Command\DBUtilsCommand();
            $command->setContainer($this->container);
            //$resultCode = $command->makeHomeTabs(false);
        }


    }

    public function postPersist(LifecycleEventArgs $args) {

    }

    public function postLoad(LifecycleEventArgs $args) {

        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
    }

}
