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

    public function getVisitors()
    {
        $year = date("Y");
        $month = "05";
        //dump($month);die();
        $sql = "SELECT COUNT(date_visited) FROM stats WHERE date_visited like '%".$year."-".$month."%'";
        $sql1 = "SELECT COUNT(date_visited) FROM stats WHERE date_visited like '%".$year."-06%'";
        $res = $this->getEntityManager()->getConnection()->fetchArray($sql);
        $res1 = $this->getEntityManager()->getConnection()->fetchArray($sql1);
        return array(array(1, $res), array(2, $res1));
    }
}
