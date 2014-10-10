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
            $user = $this->container->get('security.context')->getToken()->getUser();
            $entity->setUser($user);
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

    private function setPassword(&$entity) {
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($entity);
        $plainPassword = $entity->getPassword();
        $encodedPassword = $encoder->encodePassword($plainPassword, $entity->getSalt());
        echo $plainPassword . "::::" . $encodedPassword;
        if(!empty($plainPassword)){
            $entity->setPassword($encodedPassword);
        }
    }
    public function preUpdate(PreUpdateEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        if ($entity instanceof User || $entity instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords) {
            $this->setPassword($entity);
            $args->setNewValue('password', $entity->getPassword());
        }
    }
    public function postUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        
        if ($entity instanceof User || $entity instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords) {
            $this->setPassword($entity);die('11111');
            
        }
    }

    public function postLoad(LifecycleEventArgs $args) {

        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

    }

}
