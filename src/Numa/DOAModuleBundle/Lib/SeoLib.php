<?php

namespace Numa\DOAModuleBundle\Lib;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAModuleBundle\Entity\Seo;
use Symfony\Component\DependencyInjection\Container;

/**
 * Created by PhpStorm.
 * User: root
 * Date: 10.11.15.
 * Time: 18.07
 */
class SeoLib
{
    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function prepareSeo(Item $item, $seoPosts=array(),$autogenerate=true,$flush=true,$em=null){
        if($em==null) {
            $em = $this->container->get('doctrine.orm.entity_manager');
        }

        $persists = false;
        $seoRep = $em->getRepository("NumaDOAModuleBundle:Seo");

        $seo = $seoRep->findSeoByItem($item);

        if(empty($seo)){
            $seo = new Seo();
            $persists = true;
        }

        if($seo instanceof Seo) {
            if (!empty($seoPosts)) {
                if (!empty($seoPosts['title'])) {
                    $seo->setTitle($seoPosts['title']);
                }

                if (!empty($seoPosts['description'])) {
                    $seo->setDescription($seoPosts['description']);
                }
                if (!empty($seoPosts['keywords'])) {
                    $seo->setKeywords($seoPosts['keywords']);
                }
                $seo->setActive(false);
                if (array_key_exists('active',$seoPosts) ) {
                    $seo->setActive($seoPosts['active']);
                }
                $seo->setAutogenerate(false);
                if (array_key_exists('autogenerate',$seoPosts) ) {
                    $seo->setAutogenerate($seoPosts['autogenerate']);
                }
            }
            $seo->setTableName('item');
            $seo->setTableId($item->getId());

        }


        if(!$autogenerate){
            $seo->setTitle("");
            $seo->setDescription("");
            $seo->setKeywords("");
        }elseif(($seo->getAutogenerate() && empty($seoPosts))){
            $setting = $this->container->get("Numa.settings");

            $title = $setting->generateItemTitle($item);
            $description = $setting->generateItemDescription($item);
            $keywords = $setting->getItemKeywords($item);
            $seo->setTitle($title);
            $seo->setDescription($description);
            $seo->setKeywords($keywords);
        }
        if($persists){
            $em->persist($seo);
        }
        return $seo;

    }

    public function generateSeoForFeed($feed_id){
        $feed_id = intval($feed_id);

        if(!empty($feed_id)){
            $em = $this->container->get('doctrine.orm.entity_manager');


            $feed = $em->getRepository("NumaDOAAdminBundle:Importfeed")->find($feed_id);
            if($feed->getAutogenerateSeo()) {
                $items = $em->getRepository("NumaDOAAdminBundle:Item")->findByFeedId($feed_id);;

                foreach ($items as $item) {
                    //$seoService = $this->container->get("Numa.Seo");

                    $seo = $this->prepareSeo($item,array(),$feed->getAutogenerateSeo(),$em);

                }
                $em->flush();

                $em->clear();
            }
        }
    }

    function generateSeoForPage($pageUrl){
        $em = $this->container->get('doctrine.orm.entity_manager');

    }

}