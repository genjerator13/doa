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

    public function findByDate($date, $date1, $dealer_id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b')
            ->from('NumaDOADMSBundle:Billing', 'b')
            ->Where('b.dealer_id IN (' . $dealer_id . ')');
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