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
}