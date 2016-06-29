<?php

namespace Numa\DOADMSBundle\Repository;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository {
    public function findByDealerId($dealer_id){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('cust')
            ->add('from', 'NumaDOADMSBundle:Customer cust')
            ->where("cust.dealer_id=:dealer_id")
            ->setParameter('dealer_id', $dealer_id);

        $res = $qb->getQuery()->getResult();

        return $res;
    }

}