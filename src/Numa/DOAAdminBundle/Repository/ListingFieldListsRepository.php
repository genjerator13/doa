<?php

namespace Numa\DOAAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ListingFieldListsRepository extends EntityRepository
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

    /**
     * @param $propertyName
     * @param $listing_field_id
     * @return bool|mixed
     * Finds one listing by its value
     */
    public function findOneByValue($propertyName, $listing_field_id)
    {
        $hash = sha1('findOneByValueList' . $propertyName . $listing_field_id);
        $return = false;
        if ($this->memcache) {
            $return = $this->memcache->get($hash);
        }
        if ($return === false) {
            $propertyName = str_replace("'", "", $propertyName);
            $q = 'SELECT l FROM NumaDOAAdminBundle:ListingfieldLists l WHERE 
                     l.listing_field_id = :listing_field_id AND
                     l.value like :propertyname  OR
                     l.value like :propertyname2 ';
            $query = $this->getEntityManager()
                ->createQuery($q)
                //->andWhere('cl.status like :status')
                ->setParameter('listing_field_id',  $listing_field_id )
                ->setParameter('propertyname',  $propertyName )
                ->setParameter('propertyname2', "%" . $propertyName . "%")
                ->setMaxResults(1);
            $res = $query->getOneOrNullResult(); //getOneOrNullResult();
            if ($this->memcache) {
                $this->memcache->set($hash, $res);
            }
            return $res;
        }
        return $return;
    }

    /**
     * @param $listing_field_id
     * @param $order ("ASC","DESC) order by value
     * @return array
     * returns all the listing list for the requested listing field
     */
    public function findAllByListingField($listing_field_id, $order = "ASC")
    {
        $order = "ASC";
        if (strtoupper($order) == "DESC") {
            $order = "DESC";
        }
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('lfl')
            ->from('NumaDOAAdminBundle:ListingfieldLists', 'lfl')
            ->where('lfl.listing_field_id=:id')
            ->orderBy('lfl.value', $order)
            ->setParameter('id', $listing_field_id);

        $result = $qb->getQuery()->getResult();
        return $result;
    }

    /**
     * @param $property
     * @param int $cat category of the listing (0 all, 1 car...)
     * @param bool|false $result Should it returns results
     * @param bool|false $byid result rueturs  as array('id'=>caption) or array('caption'=caption)
     * @return array|bool|\Doctrine\ORM\QueryBuilder
     */
    public function findAllBy($property, $cat = 0, $result = false, $byid = false)
    {

        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('lfl')
            ->from('NumaDOAAdminBundle:ListingfieldLists', 'lfl')
            ->join('NumaDOAAdminBundle:Listingfield', 'l')
            ->where('lfl.listing_field_id=l.id')
            ->andWhere('l.caption like :property')
            ->orderBy('lfl.value', 'DESC')
            ->setParameter('property', "%" . $property . "%");;
        if ($cat > 0) {
            $qb->andWhere('l.category_sid=:csid')
                ->setParameter('csid', $cat);
        }
        $res = array();
        if ($result) {
            $hash = sha1('findAllByList' . $property . $cat);
            $return = false;
            if ($this->memcache) {
                $return = $this->memcache->get($hash);
            }
            if ($return === false) {
                $result = $qb->getQuery()->getResult();
                foreach ($result as $key => $value) {
                    if (!$byid) {
                        $res[$value->getValue()] = $value->getValue();
                    } else {
                        $res[$value->getId()] = $value->getValue();
                    }
                }
                if ($this->memcache) {
                    $this->memcache->set($hash, $res);
                }
                return $res;
            }
            return $return;
        }//$res = $query; //->getResult();
        ;

        return $qb;
    }

    /**
     * @param $id
     * @return null|string returns listing caption by id
     */
    public function getListingValueById($id)
    {
        if (empty($id)) {
            return NULL;
        }
        $list = $this->find($id);
        if (!empty($list)) {
            return $list->getValue();
        }
        return NULL;
    }

    /**
     * @param $fieldId
     * @return string JSON
     * Returns all models for a requested $fieldId
     */
    public function getJsonListModels($fieldId)
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $query = $qb->select('tp')
            ->from('NumaDOAAdminBundle:ListingFieldLists', 'tp')
            ->where('tp.listing_field_id=:field_id')
            ->setParameter('field_id', $fieldId)
            ->getQuery();;

        $results = $query->getResult();
        $jsonArray = array();

        foreach ($results as $res) {

            $name = str_replace(array("'", ".", ",", "}", "{", "\""), "", $res->getValue());
            $jsonArray[$res->getId()] = $name;
        }
        return json_encode($jsonArray);
    }


    public function getListingFieldIdFromString($name){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $query = $qb->select('lf')
            ->from('NumaDOAAdminBundle:Listingfield', 'lf')
            ->where('lf.caption like :name')
            ->setParameter('name', "%".$name."%")
            ->getQuery()->setMaxResults(1);
        return $query->getOneOrNullResult();
    }

}
