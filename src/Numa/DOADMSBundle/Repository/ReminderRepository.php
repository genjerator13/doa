<?php

namespace Numa\DOADMSBundle\Repository;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityRepository;

class ReminderRepository extends EntityRepository
{
    public function findByCustomerDealer($dealer)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('r')
            ->from('NumaDOADMSBundle:Reminder', 'r')
            ->leftJoin('NumaDOADMSBundle:Customer', 'c', "WITH", "c.id=r.customer_id");
        if ($dealer instanceof Catalogrecords) {
            $qb->Where('c.dealer_id = ' . $dealer->getId());
        }
        $qb->orderBy("r.id", "DESC");
        $query = $qb->getQuery();
        $res = $query->getResult();
        return $res;
    }

    public function findByDate($date, $date1, $dealer_ids)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('r')
            ->from('NumaDOADMSBundle:Reminder', 'r')
            ->leftJoin('NumaDOADMSBundle:Customer', 'c', "WITH", "c.id=r.customer_id");
        if(!empty($dealer_ids)){
            $qb->andWhere('c.dealer_id IN (' . $dealer_ids . ')');
        }
        $qb->andWhere('r.date BETWEEN :date AND :date1')
            ->setParameter("date", $date->format('Y-m-d H:i:s'))
            ->setParameter("date1", $date1->format('Y-m-d H:i:s'));
        $query = $qb->getQuery();
        $res = $query->getResult();
        return $res;
    }
}