<?php

namespace Numa\DOAModuleBundle\Lib;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Component;
use Numa\DOAModuleBundle\Entity\Page;
use Numa\DOAModuleBundle\Entity\Seo;
use Symfony\Component\DependencyInjection\Container;

/**
 * Created by PhpStorm.
 * User: root
 * Date: 10.11.15.
 * Time: 18.07
 */
class ComponentLib
{
    public function __construct(Container $container) {
        $this->container = $container;
    }

    function getComponentsForPage($pageUrl){
        $em = $this->container->get('doctrine.orm.entity_manager');
        //get page entity by page url and by delaerid
        $session = $this->container->get('session');
        $dealer_id = $session->get('dealer_id');
        $component = $em->getRepository('NumaDOAModuleBundle:Page')->findPageComponentByUrl($pageUrl,$dealer_id);
        return $component;
    }

}