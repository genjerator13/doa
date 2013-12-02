<?php 

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ListingfieldRepository extends EntityRepository
{
    public function findOneByProperty($propertyName)
    {

        $query =  $this->getEntityManager()
            ->createQuery(
                'SELECT l FROM NumaDOAAdminBundle:Listingfield l WHERE l.caption like \'%'.$propertyName.'%\' AND l.category_sid IN (0,2)'
            )->setMaxResults(1) ;

         return $query->getOneOrNullResult();
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