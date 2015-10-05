<?php 

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ListingfieldRepository extends EntityRepository
{
    public function findOneByProperty($propertyName,$category_id,$exact=false)
    {
        $categories = array(0);
        if(!empty($category_id)){
            $categories[]=$category_id;
        }
        $q='SELECT l FROM NumaDOAAdminBundle:Listingfield l WHERE 
                    l.caption like \''.$propertyName.'\'  ';
        if(!$exact){
               $q .=  ' OR  l.caption like \'%'.$propertyName.'%\'      ';
        }
              $q .=  ' AND l.category_sid IN ('.  implode(',', $categories).')';
        $query =  $this->getEntityManager()
            ->createQuery($q)->setMaxResults(1) ;
        $res =$query->getOneOrNullResult();//getOneOrNullResult();
     
        return $res;
    }
    
    public function findAllByCaption($caption, $categories = array()) {

        $qb = $this->getEntityManager()
                ->createQueryBuilder();
        $qb->select('lf')
                ->from('NumaDOAAdminBundle:Listingfield', 'lf')
                ->andWhere('l.caption like :caption')
                ->andWhere('l.category_sid like :categories')                                
                ->setParameter('property', "%" . $property . "%");
        if(is_array($categories) && !empty($categories)){
                $qb    ->andWhere('r.winner IN (:categories)')
                ->setParameter('categories', $categories);
        ;
        }
        $res = $query->getResult(); //getOneOrNullResult();
        return $res;
    }
    
    public function findAllByType($type, $categories = array()) {
        
        $qb = $this->getEntityManager()
                ->createQueryBuilder();
        $qb->select('lf')
                ->from('NumaDOAAdminBundle:Listingfield', 'lf')
                ->andWhere('lf.type like :type')
                //->andWhere('lf.category_sid like :categories')                                
                ->setParameter('type', "%" . $type . "%");
        if(is_array($categories) && !empty($categories)){
            
                $qb->andWhere('lf.category_sid IN (:categories)')
                ->setParameter(':categories', $categories);
        ;
        }
        $qb->addOrderBy("lf.caption");
        $query = $qb->getQuery();
        //
        $res = $query->getResult(); //getOneOrNullResult();

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


    public function findByCategory($catId) {

        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('lf')
            ->from('NumaDOAAdminBundle:Listingfield', 'lf')
            ->andWhere('lf.category_sid in('.$catId.',0)')
            ->andWhere('lf.type not like \'boolean\'')
            ->orderBy("lf.order");


        $query = $qb->getQuery();

        $res = $query->getResult(); //getOneOrNullResult();

        return $res;
    }
}