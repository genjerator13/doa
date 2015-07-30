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
    private $memcache;

 
    public function setMemcached($memcachce)
    {
        $this->memcache = $memcachce;
    }
    
    public function findOneByValue($propertyName, $listing_field_id) {
        $hash = sha1('findOneByValueList' . $propertyName . $listing_field_id);
        $return = $this->memcache->get($hash);
        if ($return === false) {
            $propertyName = str_replace("'", "", $propertyName);
            $q = 'SELECT l FROM NumaDOAAdminBundle:ListingfieldLists l WHERE 
                     l.listing_field_id = ' . $listing_field_id . ' AND
                     l.value like \'' . $propertyName . '\'  OR 
                     l.value like \'%' . $propertyName . '%\'     ';
            $query = $this->getEntityManager()
                            ->createQuery($q)->setMaxResults(1);
            $res = $query->getOneOrNullResult(); //getOneOrNullResult();
            $this->memcache->set($hash, $res);
            return $res;
        }
        return $return;
    }

    /**
     * 
     * @param type $property
     * @return type
     */
    public function findAllBy($property, $cat = 0, $result = false, $byid = false) {

        $qb = $this->getEntityManager()
                ->createQueryBuilder();
        $qb->select('lfl')
                ->from('NumaDOAAdminBundle:ListingfieldLists', 'lfl')
                ->join('NumaDOAAdminBundle:Listingfield', 'l')
                ->where('lfl.listing_field_id=l.id')
                ->andWhere('l.caption like :property')
                //->andWhere('l.category_sid like :property')
                ->orderBy('lfl.value', 'DESC')
                ->setParameter('property', "%" . $property . "%");
        ;
        if ($cat > 0) {

            $qb->andWhere('l.category_sid=:csid')
                    ->setParameter('csid', $cat);
        }

        $res = array();

        if ($result) {
            $hash = sha1('findAllByList' . $property . $cat);
            $return = $this->memcache->get($hash);
            if ($return === false) {
                $result = $qb->getQuery()->getResult();
                foreach ($result as $key => $value) {
                    if (!$byid) {
                        $res[$value->getValue()] = $value->getValue();
                    } else {
                        $res[$value->getId()] = $value->getValue();
                    }
                }
                $this->memcache->set($hash, $res);
                return $res;
            }
            return $return;
        }

        //$res = $query; //->getResult();
        ;

        return $qb;
    }

    public function getListingValueById($id) {
        if (empty($id)) {
            return NULL;
        }
        $list = $this->find($id);
        if (!empty($list)) {
            return $list->getValue();
        }
        return NULL;
    }

    public function getJsonListModels($fieldId) {
        $qb = $this->getEntityManager()
                ->createQueryBuilder();
        $query = $qb->select('tp')
                ->from('NumaDOAAdminBundle:ListingFieldLists', 'tp')
                ->where('tp.listing_field_id=:field_id')
                ->setParameter('field_id', $fieldId)
                ->getQuery();
        ;

        $results = $query->getResult();
        $jsonArray = array();

        foreach ($results as $res) {

            $name = str_replace(array("'", ".", ",", "}", "{", "\""), "", $res->getValue());
            $jsonArray[$res->getId()] = $name;
        }
        return json_encode($jsonArray);
    }

}
