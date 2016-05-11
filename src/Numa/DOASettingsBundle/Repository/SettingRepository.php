<?php

namespace Numa\DOASettingsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\User;

class SettingRepository extends EntityRepository {


    public function findDealers()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
            ->from('NumaDOASettingsBundle:Setting', 's');
        $qb->Where('s.name like :name');
        $qb->setParameter("name", "host");

        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();
        return $res;
    }

    public function getSettingsForUser($user){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
            ->from('NumaDOASettingsBundle:Setting', 's');

        if($user instanceof Catalogrecords){
            $qb->Where('s.dealer_id like :dealer_id');
            $qb->setParameter("dealer_id", $user->getId());
        }
        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();
        return $res;
    }
}
