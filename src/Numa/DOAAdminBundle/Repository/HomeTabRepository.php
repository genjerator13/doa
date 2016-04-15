<?php

namespace Numa\DOAAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class HomeTabRepository extends EntityRepository {

    /**
     * 
     * @param type $propertyName
     * @param type $listing_field_id
     * @return type
     */
    private $memcache;

 
    public function setMemcached($memcachce)
    {
        $this->memcache = $memcachce;
    }

    public function deleteAllHomeTabs(){
//        $qb = $this->getEntityManager()
//            ->createQueryBuilder();
//        $qb->delete('')
//            ->add('from', 'NumaDOAAdminBundle:HomeTab')
//        ;
//
//        $itemsQuery = $qb->getQuery();
//        $itemsQuery->execute();
//

        $sql = "DELETE FROM home_tab";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();
    }

}
