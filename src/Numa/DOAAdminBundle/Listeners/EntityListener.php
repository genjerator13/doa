<?php

namespace Numa\DOAAdminBundle\Listeners;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Numa\DOAAdminBundle\Entity\User;
use \Numa\DOAAdminBundle\Entity\Item as Item;
use \Numa\DOAAdminBundle\Entity\ItemField as ItemField;

class EntityListener {

    protected $container;

    public function __construct($container = null) {
        $this->container = $container;
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
        } elseif ($entity instanceof User || $entity instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords) {

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

        if ($entity instanceof User || $entity instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords) {
            $this->setPassword($entity);
            $pass = $entity->getPassword();
            if(!empty($pass)){
                $args->setNewValue('password', $entity->getPassword());
            }
            
        }
        if ($entity instanceof Item) {
            //$entity->equalizeItemFields();
        }
    }

    public function postUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();

        if ($entity instanceof User || $entity instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords) {
            //$this->setPassword($entity);
        } elseif ($entity instanceof Item) {
            $command = new \Numa\DOAAdminBundle\Command\DBUtilsCommand();
            $command->setContainer($this->container);
            //$resultCode = $command->makeHomeTabs(false);
        }
    }

    public function postLoad(LifecycleEventArgs $args) {

        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
    }

}
