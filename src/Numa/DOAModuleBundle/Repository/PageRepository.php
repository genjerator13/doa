<?php

namespace Numa\DOAModuleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\DealerGroup;
use Numa\DOAModuleBundle\Entity\Page;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Constraints\DateTime;

class PageRepository extends EntityRepository
{
    public function findPageByUrl($url)
    {

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

    public function findPageByUrl2($url, $dealer_id = null)
    {

//        $qb = $this->getEntityManager()
//            ->createQueryBuilder();
//        $qb->select('p')
//            ->add('from', 'NumaDOAModuleBundle:Page p')
//            ->where('p.url=:url')
//            ->setParameter('url', $url);
//        if (empty($dealer_id)) {
//            $qb->andWhere('p.dealer_id is :dealer_id');
//        } else {
//            $qb->andWhere('p.dealer_id=:dealer_id');
//        }
//        $qb->setParameter('dealer_id', $dealer_id);
//        $query = $qb->getQuery()->setMaxResults(1);
//
//        return $query->getOneOrNullResult();
//
//        //

        //remove /page from $url

        if (stripos($url, "page") !== false) {
            $url = substr($url, 5, strlen($url) - 1);
        }
        preg_match('/\/details\/([\d]*)/', $url, $matches, PREG_OFFSET_CAPTURE);
        $itemid = null;

        if(!empty($matches[0])){

            $url = "/details/{number}/{description}";
            $itemid = $matches[1][0];
        }

        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('p')
            ->add('from', 'NumaDOAModuleBundle:Page p')
            ->where('p.url=:url')
            ->setParameter('url', $url);
        if (empty($dealer_id)) {
            $qb->andWhere('p.dealer_id is :dealer_id');
        } else {
            $qb->andWhere('p.dealer_id=:dealer_id');
        }
        $qb->setParameter('dealer_id', $dealer_id);
        $query = $qb->getQuery()->setMaxResults(1);
        //dump($query);die();
        return $query->getOneOrNullResult();
        
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

    public function countByDealer($dealer)
    {

        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('p')->distinct()
            ->add('from', 'NumaDOAModuleBundle:Page p');

        if($dealer instanceof DealerGroup){
            $qb->Join('NumaDOAAdminBundle:Catalogrecords', 'd');
            $qb->andWhere('p.dealer_id=d.id');
            $qb->andWhere('p.dealer_id is not null');
            $qb->andWhere('d.dealer_group_id=:dealer_group_id')
                ->setParameter('dealer_group_id', $dealer->getId());
        }else{
            $dealer_id=null;
            if($dealer instanceof Catalogrecords){
                $dealer_id=$dealer->getId();
            }
            $qb->andWhere('p.dealer_id=:dealer_id')
               ->setParameter('dealer_id', $dealer_id);
        }

        $query = $qb->getQuery();
        //dump($query->getSQL());die();
        return $query->getResult();
    }


    public function findPageComponentByUrl($url, $dealer_id = null,$name="")
    {
        //remove /page from $url

        if (stripos($url, "page") !== false) {
            $url = substr($url, 5, strlen($url) - 1);
        }
        preg_match('/\/details\/([\d]*)/', $url, $matches, PREG_OFFSET_CAPTURE);
        $itemid = null;

        if(!empty($matches[0])){

            $url = "/details/{number}/{description}";
            $itemid = $matches[1][0];
        }

        $qb = $this->getEntityManager()
            ->createQueryBuilder();

        $qb->select('c')
            ->add('from', 'NumaDOAModuleBundle:Component c')
            ->join('c.PageComponent', 'pc')
            ->join('pc.Page', 'p')

            ->andWhere('p.url like :url');
        $qb->setParameter('url', $url);
        if (empty($dealer_id)) {
            $qb->andWhere('p.dealer_id is null');
        } else {
            $qb->andWhere('p.dealer_id=:dealer_id');
            $qb->setParameter('dealer_id', $dealer_id);

        }
        if (!empty($name)) {
            $qb->andWhere('c.name = :name');
            $qb->setParameter('name', $name);
        }
        $query = $qb->getQuery();

        $query->useResultCache(true);

        $page = $query->setMaxResults(1)->getOneOrNullResult();
        //if page is not found check for listing details page

        if($page instanceof Page && !empty($itemid)){
            $page->setItemId($itemid);
        }

        return $page;
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

    public function findPageComponentByDealerId($dealer)
    {
        $dealer_id = $dealer;
        $theme="";
        if($dealer instanceof Catalogrecords){
            $dealer_id = $dealer->getId();
            $theme=$dealer->getSiteTheme();
        }
        $qb = $this->getEntityManager()
            ->createQueryBuilder();

        $qb->select('c')
            ->add('from', 'NumaDOAModuleBundle:Component c')
            ->join('c.PageComponent', 'pc')
            ->join('pc.Page', 'p')
            ->andWhere('p.dealer_id like :dealer_id');
        if(!empty($theme)) {
            $qb->andWhere('c.theme=:theme OR c.theme IS NULL');
            $qb->setParameter('theme', $dealer->getSiteTheme());
        }
        $qb->setParameter('dealer_id', $dealer->getId());

        $components = $qb->getQuery()->getResult();

        return $components;
    }

    public function delete($page_id,$dealer_id){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();

        $qb->delete(null,"p,pc")
            ->add('from', 'NumaDOAModuleBundle:Page p')
            ->where('p.dealer_id =:dealer_id')
            ->andWhere('p.id = :page_id');
        $qb->setParameter('dealer_id', $dealer_id);
        $qb->setParameter('page_id', $page_id);
        dump($qb->getQuery()->getSQL());
        $qb->getQuery()->execute();
        die();

        $components = $qb->getQuery()->getResult();

        return $components;
    }
}