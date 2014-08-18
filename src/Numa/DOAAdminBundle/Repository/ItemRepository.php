<?php 
 
namespace Numa\DOAAdminBundle\Repository;
use Doctrine\ORM\EntityRepository;
      
class ItemRepository extends EntityRepository
{
    public function getItemFields($item_id)
    {
            
        $q='SELECT i FROM ItemField WHERE i.item_id='.$item_id;
        $query =  $this->getEntityManager()
            ->createQuery($q);
        $res =$query->getResult();
         return $res;
    }
    
    public function findFeatured($max=5)
    {
        if(empty($max)){
           $max = 5; 
        }
        $q='SELECT i FROM NumaDOAAdminBundle:Item i WHERE i.featured = 1 AND i.active=1';
        $query =  $this->getEntityManager()->createQuery($q)->setMaxResults($max) ;
        $res =$query->getResult();//getOneOrNullResult();
         return $res;
    }
}