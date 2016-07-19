<?php

namespace Numa\DOADMSBundle\Repository;

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

    public function findByDate($date, $date1)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b')
            ->from('NumaDOADMSBundle:Billing', 'b')
            ->Where('b.date_created BETWEEN :date AND :date1')
            ->setParameter("date", $date)
            ->setParameter("date1", $date1);

        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();
        return $res;
    }

}