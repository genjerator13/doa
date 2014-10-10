<?php 

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ListingfieldRepository extends EntityRepository
{
    public function findOneByProperty($propertyName,$category_id)
    {
        $categories = array(0);
        if(!empty($category_id)){
            $categories[]=$category_id;
        }
        $q='SELECT l FROM NumaDOAAdminBundle:Listingfield l WHERE 
                    (l.caption like \''.$propertyName.'\'  OR 
                     l.caption like \'%'.$propertyName.'%\'     ) AND l.category_sid IN ('.  implode(',', $categories).')';
        $query =  $this->getEntityManager()
            ->createQuery($q)->setMaxResults(1) ;
        $res =$query->getOneOrNullResult();//getOneOrNullResult();

         return $res;
    }

    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AcmeStoreBundle:Product p ORDER BY p.name ASC'
            )
            ->getResult();
    }
}