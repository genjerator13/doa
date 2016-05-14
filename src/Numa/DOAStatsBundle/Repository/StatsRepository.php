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
        if(!empty($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
        }
        $today = new \DateTime();
        //dump($today->format("Y-m-d h:m:s"));die();
        if($entity instanceof Item){

            $sql = "INSERT INTO `stats` (`id`, `table_name`, `table_id`, `date_visited`, `status`, `http_user_agent`, `http_accept`, `http_accept_language`, `http_accept_encoding`, `http_referer`, `http_cookie`, `http_conection`, `remote_address`, `remote_port`, `request_url`, `request_time`)
                                 VALUES (NULL, 'item', '".$entity->getId()."', '".$today->format("Y-m-d h:m:s")."', '', '".$_SERVER['HTTP_USER_AGENT']."', '".$_SERVER['HTTP_ACCEPT_ENCODING']."', '".$_SERVER['HTTP_ACCEPT_LANGUAGE']."', '".$_SERVER['HTTP_ACCEPT_ENCODING']."', '".$referer."', '".$_SERVER['HTTP_COOKIE']."', '".$_SERVER['HTTP_CONNECTION']."', '".$_SERVER['REMOTE_ADDR']."', '".$_SERVER['REMOTE_PORT']."', '".$_SERVER['REQUEST_URI']."', '".$_SERVER['REQUEST_TIME']."')";

            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();
        }

    }
}
