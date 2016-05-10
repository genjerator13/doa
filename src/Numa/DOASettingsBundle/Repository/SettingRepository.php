<?php

namespace Numa\DOASettingsBundle\Repository;

use Doctrine\ORM\EntityRepository;

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
}
