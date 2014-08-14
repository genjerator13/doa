<?php 
 
namespace Numa\DOAAdminBundle\Repository;
use Doctrine\ORM\EntityRepository;
      
class ItemRepository extends EntityRepository
{
    public function removeAllItemFields($item_it)
    {
            
        $q='SELECT l FROM NumaDOAAdminBundle:ListingfieldLists l WHERE 
                    ( l.listing_field_id = '.$listing_field_id.' AND
                    (l.value like \''.$propertyName.'\'  OR 
                     l.value like \'%'.$propertyName.'%\'     )) ';
        $query =  $this->getEntityManager()
            ->createQuery($q)->setMaxResults(1) ;
        $res =$query->getOneOrNullResult();//getOneOrNullResult();
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