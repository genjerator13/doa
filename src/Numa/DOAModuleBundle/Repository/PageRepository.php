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
        $qb->select('p,pa,ad')
            ->add('from', 'NumaDOAModuleBundle:Page p')
            ->join('p.PageAds pa')
            ->join('pa.Ad ad');
            //->where('p.url=:url')
//            ->andWhere('ad.start_date <= :start_date')
//            ->andWhere('ad.end_date  >=  :end_date')
            //->setParameter('url', $url);
//            ->setParameter('start_date', $current_date)
//            ->setParameter('end_date', $current_date);

        $page = $qb->getQuery()->getOneOrNullResult();
        return $page;
    }
}