<?php

namespace Numa\DOADMSBundle\Repository;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;

class ListingFormRepository extends EntityRepository
{


    /**
     * @param $ids
     * Activate or deactivate (depends by $active param) list of ids separated by ,
     */
    public function delete($ids)
    {
        if (!empty($ids)) {

            $qb = $this->getEntityManager()
                ->createQueryBuilder()
                ->delete('NumaDOADMSBundle:ListingForm', 'l')
                ->where('l.id in (' . $ids . ")");
            $qb->getQuery()->execute();
        }
    }

    public function getAllFormsByDealer($dealer_id,$limit=10)
    {
        $sql = "SELECT dealer_id, id, cust_name, cust_last_name, email, date_created, status FROM `listing_form` WHERE dealer_id = " . intval($dealer_id) . " UNION SELECT dealer_id, id, cust_name, email, date_created, status FROM `part_request` WHERE dealer_id = " . intval($dealer_id) . " UNION SELECT dealer_id, id, cust_name, email, date_created, status FROM `service_request` WHERE dealer_id = " . intval($dealer_id) . " UNION SELECT dealer_id, id, cust_name, email, date_created, status FROM `finance` WHERE dealer_id = " . intval($dealer_id) . "";
        $sql = "(SELECT dealer_id, id, cust_name,cust_last_name, email, date_created, status,type FROM `listing_form` WHERE dealer_id = " . intval($dealer_id) . " )
UNION (SELECT dealer_id, id, cust_name, cust_last_name, email, date_created, status,\"part\" FROM `part_request` WHERE dealer_id = " . intval($dealer_id) . " )
UNION (SELECT dealer_id, id, cust_name, cust_last_name, email, date_created, status,\"service\" FROM `service_request` WHERE dealer_id = " . intval($dealer_id) . ")
UNION (SELECT dealer_id, id, cust_name, cust_last_name, email, date_created, status,\"finance\" FROM `finance` WHERE dealer_id =" . intval($dealer_id) . ")
order by date_created desc limit $limit";

        $stmt = $this->getEntityManager()->getConnection()->fetchAll($sql);
        return $stmt;
    }

}