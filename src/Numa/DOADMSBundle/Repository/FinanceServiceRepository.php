<?php

namespace Numa\DOADMSBundle\Repository;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;

class FinanceServiceRepository extends EntityRepository
{
    /**
     * @param $ids
     * Activate or deactivate (depends by $active param) list of ids separated by ,
     */
    public function delete($ids)
    {
        if (!empty($ids)) {
            $qb = $this->getEntityManager()
                ->createQueryBuilder()
                ->delete('NumaDOADMSBundle:FinanceService', 'fs')
                ->where('fs.id in (' . $ids . ")");
            $qb->getQuery()->execute();
        }
    }

    public function findByDealerGroupId($dealer_group_id){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('financeService')
            ->add('from', 'NumaDOADMSBundle:FinanceService financeService')
            ->innerJoin('NumaDOAAdminBundle:Catalogrecords', 'd', "WITH", "d.id=financeService.dealer_id")
            ->where("d.dealer_group_id=:dealer_group_id")
            ->setParameter('dealer_group_id', $dealer_group_id);

        $res = $qb->getQuery()->getResult();

        return $res;
    }
}