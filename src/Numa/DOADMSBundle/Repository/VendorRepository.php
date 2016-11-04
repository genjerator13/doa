<?php

namespace Numa\DOADMSBundle\Repository;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;

class VendorRepository extends EntityRepository {
    public function findByDealerId($dealer_id){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('vend')
            ->add('from', 'NumaDOADMSBundle:Vendor vend')
            ->where("vend.dealer_id=:dealer_id")
            ->andWhere("vend.status NOT LIKE 'deleted' OR vend.status IS NULL")
            ->setParameter('dealer_id', $dealer_id);
        $res = $qb->getQuery()->getResult();

        return $res;
    }
    public function findAllNotDeleted(){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('vend')
            ->add('from', 'NumaDOADMSBundle:Vendor vend')
            ->Where("vend.status NOT LIKE 'deleted' OR vend.status IS NULL");

        $res = $qb->getQuery()->getResult();
//        dump($res);die();

        return $res;
    }

    public function findByDealerGroupId($dealer_group_id){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('vend')

            ->add('from', 'NumaDOADMSBundle:Vendor vend')
            ->innerJoin('NumaDOAAdminBundle:Catalogrecords', 'd', "WITH", "d.id=vend.dealer_id")
            ->where("d.dealer_group_id=:dealer_group_id")
            ->andWhere("vend.status NOT LIKE 'deleted' OR vend.status IS NULL")
            ->setParameter('dealer_group_id', $dealer_group_id);

        $res = $qb->getQuery()->getResult();

        return $res;
    }

}