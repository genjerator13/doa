<?php

namespace Numa\DOAStatsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\User;
use Numa\DOAStatsBundle\Entity\Stats;

class StatsRepository extends EntityRepository {
    public function insertLog($entity){


        $referer = "";
        $cookie = "";
        $connection = "";
        if(!empty($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
        }
        if(!empty($_SERVER['HTTP_COOKIE'])) {
            $cookie = $_SERVER['HTTP_COOKIE'];
        }
        if(!empty($_SERVER['HTTP_CONNECTION'])) {
            $connection = $_SERVER['HTTP_CONNECTION'];
        }
        $today = new \DateTime();
        //dump($today->format("Y-m-d h:m:s"));die();
        if($entity instanceof Item){

            $sql = "INSERT INTO `stats` (`id`, `table_name`, `table_id`, `date_visited`, `status`, `http_user_agent`, `http_accept`, `http_accept_language`, `http_accept_encoding`, `http_referer`, `http_cookie`, `http_conection`, `remote_address`, `remote_port`, `request_url`, `request_time`)
                                 VALUES (NULL, 'item', '".$entity->getId()."', '".$today->format("Y-m-d h:m:s")."', '', '".$_SERVER['HTTP_USER_AGENT']."', '".$_SERVER['HTTP_ACCEPT_ENCODING']."', '".$_SERVER['HTTP_ACCEPT_LANGUAGE']."', '".$_SERVER['HTTP_ACCEPT_ENCODING']."', '".$referer."', '".$cookie."', '".$connection."', '".$_SERVER['REMOTE_ADDR']."', '".$_SERVER['REMOTE_PORT']."', '".$_SERVER['REQUEST_URI']."', '".$_SERVER['REQUEST_TIME']."')";

            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();
        }

    }

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
}
