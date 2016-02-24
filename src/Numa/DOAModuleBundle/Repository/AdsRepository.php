<?php

namespace Numa\DOAModuleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Constraints\DateTime;

class AdsRepository extends EntityRepository
{
    public function findPageByUrl($pageid)
    {
        $current_date = new \DateTime();;
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('ad')
            ->add('from', 'NumaDOAModuleBundle:Ad ad')
            ->join("ad.Pages pa")
            ->where("pa.page_id=:pageid")
            ->andWhere('ad.start_date <= :start_date')
            ->andWhere('ad.end_date  >=  :end_date')

            ->setParameter('pageid', $pageid)
            ->setParameter('start_date', $current_date)
            ->setParameter('end_date', $current_date);

        $page = $qb->getQuery()->getResult();
        return $page;
    }
}