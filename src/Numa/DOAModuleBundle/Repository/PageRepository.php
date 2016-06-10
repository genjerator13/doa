<?php

namespace Numa\DOAModuleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAModuleBundle\Entity\Page;
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
        $qb->select('p')
            ->add('from', 'NumaDOAModuleBundle:Page p')
            ->join('p.PageAds', 'pa')
            ->join('pa.Ad','ad')
            ->where('p.url=:url')
//            ->andWhere('ad.start_date <= :start_date')
//            ->andWhere('ad.end_date  >=  :end_date')
            ->setParameter('url', $url);
//            ->setParameter('start_date', $current_date)
//            ->setParameter('end_date', $current_date);

        $query = $qb->getQuery();
        dump($query->getResult());
        die();
        return $page;
    }

    public function findPageComponentByUrl($url,$dealer_id=null)
    {

        $qb = $this->getEntityManager()
            ->createQueryBuilder();

        $qb->select('p')
            ->add('from', 'NumaDOAModuleBundle:page p')
            ->join('p.PageComponent', 'pc')
            ->join('pc.Component','c')
            ->andWhere('p.url like :url');
        $qb->setParameter('url', $url);
        if(empty($dealer_id)){
            $qb->andWhere('p.dealer_id is null');
        }else{
            $qb->andWhere('p.dealer_id=:dealer_id');
            $qb->setParameter('dealer_id', $dealer_id);

        }

        $page = $qb->getQuery()->setMaxResults(1)->getOneOrNullResult();

        if($page instanceof Page) {
            return $page->getComponent();
        }

        return null;
    }

    public function findPageComponentByPageId($page_id)
    {

        $qb = $this->getEntityManager()
            ->createQueryBuilder();

        $qb->select('p')
            ->add('from', 'NumaDOAModuleBundle:page p')
            ->join('p.PageComponent', 'pc')
            ->join('pc.Component','c')
            ->where('p.id like :page_id');
        $qb->setParameter('page_id', $page_id);


        $page = $qb->getQuery()->getOneOrNullResult();
        if($page instanceof Page) {
            return $page->getComponent();
        }

        return null;
    }
}