<?php

namespace Numa\DOADMSBundle\Repository;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;

class BillingRepository extends EntityRepository
{
    public function maxInvoiceNr($dealer_id)
    {
        $prefix ="";
        if(!empty($dealer_id)){
            $prefix= "where dealer_id=$dealer_id";
        }
        $sql = "SELECT MAX( invoice_nr )+1 FROM billing".$prefix;

        $res = $this->getEntityManager()->getConnection()->fetchArray($sql);
        if (!empty($res[0])) {
            return $res[0];
        }
        return false;
    }

    public function generateInvoiceNumber($dealer_id){
        $val = $dealer_id.time();
        return hash('crc32', $val);
    }

    public function findByDate($date, $date1, $dealer_id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b')
            ->from('NumaDOADMSBundle:Billing', 'b')
            ->Where('b.dealer_id IN (' . $dealer_id . ')')
            ->andWhere('b.item_id IS NOT NULL')
            ->andWhere('b.active=1')

        ;
            if(!empty($date) && empty($date1))
            {
                $qb->andWhere('b.date_billing > :date')
                    ->setParameter("date", $date);
            }
            if(empty($date) && !empty($date1))
            {
                $qb->andWhere('b.date_billing < :date1')
                    ->setParameter("date1", $date1);
            }
            if(!empty($date) && !empty($date1))
            {
                $qb->andWhere('b.date_billing BETWEEN :date AND :date1')
                    ->setParameter("date", $date)
                    ->setParameter("date1", $date1);
            }
        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();
        return $res;
    }

    public function findByDateNoItem($date, $date1, $dealer_id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b')
            ->from('NumaDOADMSBundle:Billing', 'b')
            ->Where('b.dealer_id IN (' . $dealer_id . ')')
            ->andWhere('b.item_id IS NULL')
            ->andWhere('b.active=1');
        if(!empty($date) && empty($date1))
        {
            $qb->andWhere('b.date_billing > :date')
                ->setParameter("date", $date);
        }
        if(empty($date) && !empty($date1))
        {
            $qb->andWhere('b.date_billing < :date1')
                ->setParameter("date1", $date1);
        }
        if(!empty($date) && !empty($date1))
        {
            $qb->andWhere('b.date_billing BETWEEN :date AND :date1')
                ->setParameter("date", $date)
                ->setParameter("date1", $date1);
        }
        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();
        return $res;
    }

    public function findByDateReports($dateStart, $dateEnd, $dealer_id, $sold=null,$orderBy="bill_of_sale")
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOAAdminBundle:Item', 'i')
            ->Where('i.dealer_id IN (' . $dealer_id . ')')
            ->andWhere('i.sale_id IS NOT NULL')

        ;

        if($orderBy!='invoice') {
            $qb->leftJoin('NumaDOADMSBundle:Billing', 'b', "WITH", "i.id=b.item_id")
                ->andWhere('b.active=1');
            $qb->andWhere('b.date_billing is not null');
        }else{
            $qb->andWhere('s.invoice_date IS NOT NULL');
            $qb->andWhere('s.vendor_id IS NOT NULL');
        }
        $qb->leftJoin('NumaDOADMSBundle:Sale', 's', "WITH", "i.sale_id=s.id");
        if($sold===false){
            $qb->andWhere('i.sold = 0 OR i.sold is null');
        }elseif($sold===true){
            $qb->andWhere('i.sold = 1');
        }
        $order = "b.date_billing";
        if($orderBy=="invoice"){
            $order = "s.invoice_date";
        }
        if(!empty($dateStart) && empty($dateEnd))
        {
            $qb->andWhere($order.' >= :date')
                ->setParameter('date', $dateStart->format('Y-m-d'));
        }
        if(empty($dateStart) && !empty($dateEnd))
        {
            $qb->andWhere($order.' <= :date1')
                ->setParameter('date1', $dateEnd->format('Y-m-d'));
        }
        if(!empty($dateStart) && !empty($dateEnd))
        {

            $qb->andWhere($order.' BETWEEN :date AND :date1')
                ->setParameter('date', $dateStart->format('Y-m-d'))
                ->setParameter('date1', $dateEnd->format('Y-m-d'));
        }
        $qb->orderBy($order,"DESC");

        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();

        return $res;
    }

    public function findByDealer($dealer)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b')
            ->from('NumaDOADMSBundle:Billing', 'b');
        if($dealer instanceof Catalogrecords) {
            $qb->Where('b.dealer_id IN (' . $dealer->getId() . ')');
        }
        $qb->orderBy("b.id","DESC");
        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();
        return $res;
    }

    public function delete($ids)
    {
        if (!empty($ids)) {
            $qb = $this->getEntityManager()
                ->createQueryBuilder()
                ->delete('NumaDOADMSBundle:Billing', 'b')
                ->where('b.item_id in (' . $ids . ")");
            $qb->getQuery()->execute();
        }
    }

}