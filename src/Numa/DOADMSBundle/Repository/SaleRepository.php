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
        $qb->select('s,i.make,i.year,i.model,i.VIN,i.stock_nr')
            ->from('NumaDOADMSBundle:Sale', 's')
            ->Where('i.dealer_id IN (' . $dealer_id . ')')
            ->andWhere('i.sale_id IS NOT NULL');
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

    public function findByDate2($date, $date1, $dealer_id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOADMSBundle:Sale', 's')
            ->Where('i.dealer_id IN (' . $dealer_id . ')')
            ->andWhere('i.sale_id IS NOT NULL');
        //$qb->leftJoin('NumaDOAAdminBundle:Item', 'i');
        $qb->leftJoin('NumaDOAAdminBundle:Item', 'i', "WITH", "s.id=i.sale_id");

        if(!empty($date) && empty($date1))
        {
            $qb->andWhere('s.invoice_date >= :date')
                ->setParameter("date", $date);
        }
        if(empty($date) && !empty($date1))
        {
            $qb->andWhere('s.invoice_date <= :date1')
                ->setParameter("date1", $date1);
        }
        if(!empty($date) && !empty($date1))
        {
            $qb->andWhere('s.invoice_date BETWEEN :date AND :date1')
                ->setParameter("date", $date)
                ->setParameter("date1", $date1);
        }
        $qb->orderBy("s.invoice_date","DESC");
        $qb->andWhere('s.invoice_date is not null');

        $query = $qb->getQuery();

        $res = $query->getResult(); //->getResult();

        return $res;
    }

    public function getCountSaleMadePeriod($dateStart=null,$dateEnd=null,$dealer_id){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
            ->from('NumaDOADMSBundle:Sale', 's')
            ->Where('i.dealer_id IN (' . $dealer_id . ')')
            ->andWhere('i.sale_id IS NOT NULL')
            ->innerJoin('NumaDOAAdminBundle:Item', 'i')
        ;
        //$dStart = new \DateTime('now')

        if(!empty($dateStart) && !empty($dateEnd)){
            $qb->where('s.invoice_date BETWEEN :start AND :end')
                ->setParameter('start', $dateStart->format('Y-m-d'))
                ->setParameter('end', $dateEnd->format('Y-m-d'));
        }
        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();
        return $res;
    }
}