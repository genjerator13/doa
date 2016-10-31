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
            ->andWhere("cust.status NOT LIKE 'deleted' OR cust.status IS NULL")
            ->setParameter('dealer_id', $dealer_id);

        $res = $qb->getQuery()->getResult();

        return $res;
    }

    public function findByDealerGroupId($dealer_group_id){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('cust')

            ->add('from', 'NumaDOADMSBundle:Customer cust')
            ->innerJoin('NumaDOAAdminBundle:Catalogrecords', 'd', "WITH", "d.id=cust.dealer_id")
            ->where("d.dealer_group_id=:dealer_group_id")
            ->andWhere("cust.status NOT LIKE 'deleted' OR cust.status IS NULL")
            ->setParameter('dealer_group_id', $dealer_group_id);

        $res = $qb->getQuery()->getResult();

        return $res;
    }


    public function findAllNotDeleted(){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('cust')
            ->add('from', 'NumaDOADMSBundle:Customer cust')
            ->Where("cust.status NOT LIKE 'deleted' OR cust.status IS NULL");

        $res = $qb->getQuery()->getResult();

        return $res;
    }

}