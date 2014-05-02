<?php

namespace Numa\DOAAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ListingFieldListsRepository extends EntityRepository {
    /**
     * 
     * @param type $propertyName
     * @param type $listing_field_id
     * @return type
     */
    public function findOneByValue($propertyName, $listing_field_id) {

        $q = 'SELECT l FROM NumaDOAAdminBundle:ListingfieldLists l WHERE 
                    ( l.listing_field_id = ' . $listing_field_id . ' AND
                    (l.value like \'' . $propertyName . '\'  OR 
                     l.value like \'%' . $propertyName . '%\'     )) ';
        $query = $this->getEntityManager()
                        ->createQuery($q)->setMaxResults(1);
        $res = $query->getOneOrNullResult(); //getOneOrNullResult();
        return $res;
    }


    /**
     * 
     * @param type $property
     * @return type
     */
    public function findAllBy($property) {
        $qb = $this->getEntityManager()
                ->createQueryBuilder();
        $qb->select('lfl')
                ->from('NumaDOAAdminBundle:ListingfieldLists', 'lfl')
                ->join('NumaDOAAdminBundle:Listingfield', 'l')
                ->where('lfl.listing_field_id=l.id')
                ->andWhere('l.caption like :property')
                ->setParameter('property', "%" . $property . "%");
        ;

        //$res = $query; //->getResult();
        ;
        return $qb;
    }
    
    public function getListingValueById($id){
        if(empty($id)){
            return NULL;
        }
        $list = $this->find($id);
        if(!empty($list)){
            return $list->getValue();
        }
        return NULL;
    }

}
