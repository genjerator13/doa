<?php

namespace Numa\DOAAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class HomeTabRepository extends EntityRepository
{

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

    public function deleteAllHomeTabs()
    {
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

    public function findByDealer($dealer_id = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ht')
            ->from('NumaDOAAdminBundle:HomeTab', 'ht');


        if ($dealer_id == null) {
            $qb->Where('ht.dealer_id is NULL');
        } else {
            $qb->Where('ht.dealer_id = :dealer_id');
            $qb->setParameter("dealer_id", $dealer_id);
        }
        $query = $qb->getQuery();

        $res = $query->getResult(); //->getResult();

        return $res;
    }

}
