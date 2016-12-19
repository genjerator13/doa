<?php

namespace Numa\DOADMSBundle\Repository;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityRepository;

class SaleRepository extends EntityRepository {
    public function delete($ids)
    {
        if (!empty($ids)) {

            $qb = $this->getEntityManager()
                ->createQueryBuilder()
                ->delete('NumaDOADMSBundle:Sale', 's')
                ->where('s.id in (' . $ids . ")");
            $qb->getQuery()->execute();
        }
    }

    public function findByDate($date, $date1, $dealer_id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
            ->from('NumaDOADMSBundle:Sale', 's')
            ->Where('i.dealer_id IN (' . $dealer_id . ')');
        if(!empty($date) && empty($date1))
        {
            $qb->andWhere('s.invoice_date > :date')
                ->setParameter("date", $date);
        }
        if(empty($date) && !empty($date1))
        {
            $qb->andWhere('s.invoice_date < :date1')
                ->setParameter("date1", $date1);
        }
        if(!empty($date) && !empty($date1))
        {
            $qb->andWhere('s.invoice_date BETWEEN :date AND :date1')
                ->setParameter("date", $date)
                ->setParameter("date1", $date1);
        }
        $qb->join('NumaDOAAdminBundle:Item', 'i');
        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();
        return $res;
    }
}