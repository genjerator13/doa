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

    public function prepareSeo(Item $item, array $seoPosts=array()){
        $em = $this->container->get('doctrine.orm.entity_manager');


        $seoRep = $em->getRepository("NumaDOAModuleBundle:Seo");

        $seo = $seoRep->findSeoByItem($item);
        if(empty($seo)){
            $seo = new Seo();
            $em->persist($seo);

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

        if($seo->getAutogenerate() || empty($seoPosts)){

            $setting = $this->container->get("Numa.settings");
            $title = $setting->generateItemTitle($item);
            $seo->setTitle($title);
        }
        $em->flush();
        return $seo;

    }

}