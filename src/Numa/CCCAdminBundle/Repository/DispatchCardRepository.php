<?php

namespace Numa\CCCAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\CCCAdminBundle\Entity\Customers;

class DispatchCardRepository extends EntityRepository {

    public function findLast($customer=null) {
        
        
        $date = strtotime(date("Y-m-d").' -24 months');
        $today_startdatetime = new \DateTime();
        $today_startdatetime->setTimestamp($date);
        $today_enddatetime = new \DateTime();
        $today_enddatetime->setTimestamp(time());

        $qb = $this->getEntityManager()
                ->createQueryBuilder();

        $qb->select('d')->distinct()
        ->add('from', 'NumaCCCAdminBundle:Dispatchcard d')
        ->where('d.dateorder >= :today_startdatetime')
        ->andWhere('d.dateorder <= :today_enddatetime')
        ->setParameter('today_startdatetime', $today_startdatetime)
        ->setParameter('today_enddatetime', $today_enddatetime)
        ->orderBy('d.id', 'DESC')
            ->setMaxResults(1000)
        ;
        if($customer instanceof Customers){
            $qb->andWhere('d.customer_id=:customer');
            $qb->setParameter('customer', $customer->getId());
        }
        //dump($customer);die();

        $query = $qb->getQuery();

        return $query->getResult();
    }

}
