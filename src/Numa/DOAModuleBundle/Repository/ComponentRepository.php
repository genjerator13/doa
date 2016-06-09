<?php

namespace Numa\DOAModuleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAModuleBundle\Entity\Page;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Constraints\DateTime;

class ComponentRepository extends EntityRepository
{
    public function findByDealerAndId($dealer_id,$component_id)
    {

        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('c')
            ->add('from', 'NumaDOAModuleBundle:Component c')
            ->andWhere('c.dealer_id=:dealer_id')
            ->andWhere('c.id=:id')
//            ->andWhere('ad.start_date <= :start_date')
//            ->andWhere('ad.end_date  >=  :end_date')
            ->setParameter('dealer_id', $dealer_id)
            ->setParameter('id', $component_id)
            ->setMaxResults(1);
//            ->setParameter('start_date', $current_date)
//            ->setParameter('end_date', $current_date);

        $query = $qb->getQuery();
        dump($query->getResult());
        die();
        return $query->getResult();
    }

}