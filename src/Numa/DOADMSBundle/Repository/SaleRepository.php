<?php

namespace Numa\DOADMSBundle\Repository;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
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

    public function findByDate($dateStart, $dateEnd, $dealer_id, $sold = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOADMSBundle:Sale', 's')
            ->Where('i.dealer_id IN (' . $dealer_id . ')')
            ->andWhere('i.sale_id IS NOT NULL')
            ->leftJoin('NumaDOAAdminBundle:Item', 'i', "WITH", "s.id=i.sale_id");
        if(!is_null($sold)){
            $qb->andWhere('i.sold = :sold')
                ->setParameter('sold', $sold);
        }
        if(!empty($dateStart) && empty($dateEnd))
        {
            $qb->andWhere('s.invoice_date >= :date')
                ->setParameter('date', $dateStart->format('Y-m-d'));
        }
        if(empty($dateStart) && !empty($dateEnd))
        {
            $qb->andWhere('s.invoice_date <= :date1')
                ->setParameter('date1', $dateEnd->format('Y-m-d'));
        }
        if(!empty($dateStart) && !empty($dateEnd))
        {
            $qb->andWhere('s.invoice_date BETWEEN :date AND :date1')
                ->setParameter('date', $dateStart->format('Y-m-d'))
                ->setParameter('date1', $dateEnd->format('Y-m-d'));
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

    public function findByDealer($dealer)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s,i.id as item_id,i.VIN as vin,i.stock_nr as stock_nr')
            ->from('NumaDOADMSBundle:Sale', 's')
            ->andWhere('i.sale_id IS NOT NULL')
            ->andWhere('s.invoice_date IS NOT NULL')
            ->leftJoin('NumaDOAAdminBundle:Item', 'i', "WITH", "s.id=i.sale_id");

        if($dealer instanceof Catalogrecords) {
            $qb->andWhere('i.dealer_id IN (' . $dealer->getId() . ')');
        }

        $qb->orderBy("s.id","DESC");
        $query = $qb->getQuery();


        $res = $query->getResult(); //->getResult();
        return $res;
    }
}