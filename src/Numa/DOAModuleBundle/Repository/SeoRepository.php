<?php

namespace Numa\DOAModuleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Item;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Collections\Criteria;

class SeoRepository extends EntityRepository {
    public function findSeoByItem(Item $item){
        if($item->getId()){
            $qb = $this->getEntityManager()
                ->createQueryBuilder();
            $qb->select('s')
                ->add('from', 'NumaDOAModuleBundle:Seo s')


                ->where('s.table_id=:table_id')
                ->andWhere('s.table_name= :table_name')
                ->setParameter('table_name', 'item')
                ->setParameter('table_id', $item->getId())
            ;

            $seo = $qb->getQuery()->getOneOrNullResult();
            return $seo;
        }
        return null;
    }
}