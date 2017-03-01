<?php

namespace Numa\DOAStatsBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GaStatsRepository extends EntityRepository
{

    public function getVisitorsByMonth($dealer_id, $todaysYear)
    {
        $sql = "SELECT SUM(sessions) as sessions ,
                YEAR(`date_stats`) AS year,
                month(`date_stats`) AS month
                FROM `ga_stats`
                WHERE dealer_id = $dealer_id
                AND YEAR(`date_stats`) = $todaysYear
                GROUP BY YEAR(`date_stats`) , month(`date_stats`)";
        $res = $this->getEntityManager()->getConnection()->fetchAll($sql);
        return $res;
    }

    public function getVisitorsByDay($dealer_id, $day,$period)
    {
        $day = $day->format("Y-m-d");
//        dump($day);
//        die();
        $sql = "SELECT sessions,date_stats,
                YEAR(`date_stats`) AS year,
                month(`date_stats`) AS month,
                day(`date_stats`) AS day
                FROM `ga_stats`
                WHERE dealer_id = $dealer_id
                AND `date_stats`>=$day
                GROUP BY (31-DAY(`date_stats`))";
        //                //AND YEAR(`date_stats`) = $todaysYear
        //AND month(`date_stats`) = $todaysMonth
        $res = $this->getEntityManager()->getConnection()->fetchAll($sql);
        return $res;
    }

    public function FindByDateAndDealer($date, $dealer)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
            ->from('NumaDOAStatsBundle:GaStats', 's');
        if (!empty($dealer)) {
            $qb->Where('s.dealer_id = :dealer_id')
                ->setParameter("dealer_id", $dealer->getId());
        }
        if (!empty($date)) {
            $qb->andWhere('s.date_stats = :date')
                ->setParameter("date", $date->format("Y-m-d H:i:s"));
        }
        $query = $qb->getQuery()->setMaxResults(1);
        $res = $query->getOneOrNullResult();
        return $res;
    }
}
