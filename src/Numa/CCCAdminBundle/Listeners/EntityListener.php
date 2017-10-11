<?php

namespace Numa\CCCAdminBundle\Listeners;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Numa\CCCAdminBundle\Entity\CustomRate;
use Numa\CCCAdminBundle\Entity\Dispatchcard;
use Numa\CCCAdminBundle\Entity\User;

class EntityListener
{

    protected $container;

    public function __construct($container = null)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if ($entity instanceof Dispatchcard) {
            //get user
            //if CSR user, add user name to dispatch card name
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if ($user instanceof User) {
                $entity->setCsrName($user->getName());
//                dump($user);
//                die();
            }

        }
    }


    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        if ($entity instanceof CustomRate) {
            $this->container->get("numa.customer")->createCustomRatesValues($entity);
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        if ($entity instanceof CustomRate) {
            $this->container->get("numa.customer")->createCustomRatesValues($entity);
        }
    }

}
