<?php

namespace Numa\DOAAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ItemRepository extends EntityRepository {

    public function getItemFields($item_id) {

        $q = 'SELECT i FROM ItemField WHERE i.item_id=' . $item_id;
        $query = $this->getEntityManager()
                ->createQuery($q);
        $res = $query->getResult();
        return $res;
    }

    public function findFeatured($max = 5) {
        if (empty($max)) {
            $max = 5;
        }
        $q = 'SELECT i FROM NumaDOAAdminBundle:Item i WHERE i.featured = 1 AND i.active=1';
        $query = $this->getEntityManager()->createQuery($q)->setMaxResults($max);
        $res = $query->getResult(); //getOneOrNullResult();
        return $res;
    }
    /**
     * Returns saved ads for the requested user id
     * @param integer $user_id
     * @return \Numa\DOAAdminBundle\Entity\Item
     */
    public function findSavedAds($user_id) {
        $user_id = intval($user_id);
        $qb = $this->getEntityManager()
                ->createQueryBuilder();
        $qb->select('i')->distinct()
                ->add('from', 'NumaDOAAdminBundle:Item i LEFT JOIN i.UserItems ui')
                //->from('NumaDOAAdminBundle:Item', 'i')
                //->join('NumaDOAAdminBundle:UserItem', 'ui')
                ->where('ui.user_id=:user_id')
                ->andWhere('ui.item_type= :item_type')                
                ->setParameter('item_type', \Numa\DOAAdminBundle\Entity\UserItem::SAVED_AD)
                ->setParameter('user_id', $user_id)
                ;                

        $itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        return $itemsQuery;
    }

}
