<?php

namespace Numa\DOADMSBundle\Repository;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\DealerGroup;
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

    public function findOneByIdAndDealersId($customerId, $dealersIds=null){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('cust')

            ->add('from', 'NumaDOADMSBundle:Customer cust');
            if(!empty($dealersIds)) {
                $qb->andWhere('cust.dealer_id IN (:ids)');
                $qb->setParameter('ids', $dealersIds);
            }
        $qb->andWhere('cust.id= :id')
            ->setParameter('id', $customerId);

        $res = $qb->getQuery()->getOneOrNullResult();

        return $res;
    }


    public function findAllNotDeleted(){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('cust')
            ->add('from', 'NumaDOADMSBundle:Customer cust')
            ->Where("cust.status NOT LIKE 'deleted' OR cust.status IS NULL");
//        if($dealer instanceof Catalogrecords){
//            $qb->andWhere("cust.dealer_id=:dealer_id")
//               ->setParameter("dealer_id",$dealer->getId());
//        }elseif($dealer instanceof DealerGroup){
//            $qb->innerJoin('NumaDOAAdminBundle:Catalogrecords', 'd', "WITH", "d.id=cust.dealer_id");
//            $qb->andWhere("d.dealer_group_id=:dealer_group_id")
//                ->setParameter("dealer_group_id",$dealer->getId());
//        }
        //dump($qb->getQuery()->getSQL());die();
        $res = $qb->getQuery()->getResult();

        return $res;
    }

}