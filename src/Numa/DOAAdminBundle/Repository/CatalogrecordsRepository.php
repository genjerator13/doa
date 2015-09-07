<?php

namespace Numa\DOAAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class CatalogrecordsRepository extends EntityRepository {

    public function xfindByDCategory($dcatId) {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('d')->distinct()
            ->add('from', 'NumaDOAAdminBundle:Catalogrecords d')
            ->innerJoin('NumaDOAAdminBundle:DealerCategories','dc',"WITH","d.id=dc.dealer_id")
            ->andWhere("dc.category_id=".$dcatId);
        ;
        $query = $qb->getQuery();
        //dump($query);
        return $query->getResult();
    }



    public function isInProgress() {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('cl')->distinct()
            ->add('from', 'NumaDOAAdminBundle:CommandLog cl')
            ->andWhere('cl.status like :status ')
            ->andWhere('cl.count is not null ')
            ->andWhere('cl.current is not null ')
            ->setParameter('status', "%pending%")
            ->orderBy('cl.id', 'DESC');
        //$qb->getMaxResults(1);
        $query = $qb->getQuery();
        return $query->getResult();
    }


}
