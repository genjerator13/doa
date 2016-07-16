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
            ->join('pa.Ad', 'ad')
            ->where('p.url=:url')
//            ->andWhere('ad.start_date <= :start_date')
//            ->andWhere('ad.end_date  >=  :end_date')
            ->setParameter('url', $url);
//            ->setParameter('start_date', $current_date)
//            ->setParameter('end_date', $current_date);

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function findCustomPageByUrl($dealer_id, $url)
    {
        $url = "/" . $url;
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('p')
            ->add('from', 'NumaDOAModuleBundle:Page p')
            ->where('p.url=:url')
            ->andWhere('p.dealer_id=:dealer_id')
            ->setParameter('url', $url)
            ->setParameter('dealer_id', $dealer_id);

        $query = $qb->getQuery()->setMaxResults(1);
        //
        return $query->getOneOrNullResult();
    }

    public function findPagesByDealer($dealer_id)
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('p')
            ->add('from', 'NumaDOAModuleBundle:Page p')
            ->where('p.dealer_id=:dealer_id')
            ->setParameter('dealer_id', $dealer_id);
        $query = $qb->getQuery();
        return $query->getResult();
    }


    public function findPageComponentByUrl($url, $dealer_id = null)
    {
        //remove /page from $url

        if (stripos($url, "page") !== false) {
            $url = substr($url,5,strlen($url)-1);
        }

        $qb = $this->getEntityManager()
            ->createQueryBuilder();

        $qb->select('p')
            ->add('from', 'NumaDOAModuleBundle:page p')
            ->join('p.PageComponent', 'pc')
            ->join('pc.Component', 'c')
            ->andWhere('p.url like :url');
        $qb->setParameter('url', $url);
        if (empty($dealer_id)) {
            $qb->andWhere('p.dealer_id is null');
        } else {
            $qb->andWhere('p.dealer_id=:dealer_id');
            $qb->setParameter('dealer_id', $dealer_id);

        }

        $page = $qb->getQuery()->setMaxResults(1)->getOneOrNullResult();
        //dump($qb->getQuery());die();
        if ($page instanceof Page) {
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
            ->join('pc.Component', 'c')
            ->where('p.id like :page_id');
        $qb->setParameter('page_id', $page_id);


        $page = $qb->getQuery()->getOneOrNullResult();
        if ($page instanceof Page) {
            return $page->getComponent();
        }

        return null;
    }
}