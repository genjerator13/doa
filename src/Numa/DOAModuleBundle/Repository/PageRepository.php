<?php

namespace Numa\DOAModuleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Item;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Constraints\DateTime;

class PageRepository extends EntityRepository
{
    public function findPageByUrl($url)
    {
        $current_date = new \DateTime();;
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('ad')
            ->add('from', 'NumaDOAModuleBundle:Ad ad')
            ->join('ad.PageAds pa')
            ->join('pa.Page p')
            ->where('p.url=:url')
            ->andWhere('ad.start_date <= :start_date')
            ->andWhere('ad.end_date  >=  :end_date')
            ->setParameter('url', $url)
            ->setParameter('start_date', $current_date)
            ->setParameter('end_date', $current_date);

        $page = $qb->getQuery()->getResult();
        return $page;
    }
}