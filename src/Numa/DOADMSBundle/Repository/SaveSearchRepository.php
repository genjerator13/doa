<?php

namespace Numa\DOADMSBundle\Repository;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\SaveSearch;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityRepository;

class SaveSearchRepository extends EntityRepository {


    public function findActiveByDealer($dealer_id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ss')
            ->from("NumaDOADMSBundle:SaveSearch", 'ss')
            ->Where('ss.dealer_id IN (' . $dealer_id . ')')
            ->andWhere('ss.date_valid>:today')
            ->setParameter("today",new \DateTime())
        ;
            ///->andWhere('ss`.active=1');
        /// ;
        $qb->orderBy("ss.id","DESC");
        $query = $qb->getQuery();


        $res = $query->getResult(); //->getResult();
        return $res;
    }
}