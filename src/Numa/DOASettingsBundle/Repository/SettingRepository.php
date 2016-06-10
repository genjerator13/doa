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

    public function getSingle($name,$section="",$dealer=null){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
            ->from('NumaDOASettingsBundle:Setting', 's');
        if($dealer instanceof Catalogrecords){
            $qb->andWhere('s.dealer_id like :dealer_id');
            $qb->setParameter("dealer_id", $dealer->getId());
        }else{
            $qb->andWhere('s.dealer_id like :dealer_id');
            $qb->setParameter("dealer_id", null);
        }

        if(!empty($name)){
            $qb->andWhere('s.name like :name');
            $qb->setParameter("name", $name);
        }

        if(!empty($section)){
            $qb->andWhere('s.section like :section');
            $qb->setParameter("section", $section);
        }

        $query = $qb->getQuery();
        $res = $query->setMaxResults(1)->getOneOrNullResult(); //->getResult();
        return $res;
    }
}
