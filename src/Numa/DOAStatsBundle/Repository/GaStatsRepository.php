<?php

namespace Numa\DOAStatsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\User;
use Numa\DOAStatsBundle\Entity\Stats;

class GaStatsRepository extends EntityRepository {

    public function getVisitorsByMonth()
    {
        $sql = "SELECT count( * ) as c , YEAR( FROM_UNIXTIME( `request_time` ) ) AS year, month( FROM_UNIXTIME( `request_time` ) ) AS
MONTH FROM `stats`
GROUP BY YEAR( FROM_UNIXTIME( `request_time` ) ) , month( FROM_UNIXTIME( `request_time` ) )";
        $res = $this->getEntityManager()->getConnection()->fetchAll($sql);
        return $res;
    }

    public function getVisitorsByDay()
    {
        $month = date("m");
        $sql = "SELECT count( * ) as c , YEAR( FROM_UNIXTIME( `request_time` ) ) AS year, month( FROM_UNIXTIME( `request_time` ) ) AS
month, day( FROM_UNIXTIME( `request_time` ) ) AS
day FROM `stats`
GROUP BY YEAR( FROM_UNIXTIME( `request_time` ) ) , day( FROM_UNIXTIME( `request_time` ) )";
        $res = $this->getEntityManager()->getConnection()->fetchAll($sql);
        return $res;
    }

    public function FindByDateAndDealer($date, $dealer){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
            ->from('NumaDOAStatsBundle:GaStats', 's');
        if(!empty($dealer_ids)){
            $qb->andWhere('s.dealer_id = :dealer_id')
                ->setParameter("dealer_id", $dealer->getId());
        }
        $qb->andWhere('s.date_stats = :date')
            ->setParameter("date", '.$date->format("Y-m-d H:i:s").');
        $query = $qb->getQuery();
        $res = $query->getResult();
        return $res;
    }
}
