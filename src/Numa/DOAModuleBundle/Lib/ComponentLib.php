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

    function getComponentsForPage($pageUrl,$dealer_id){
        $em = $this->container->get('doctrine.orm.entity_manager');
        $component = $em->getRepository('NumaDOAModuleBundle:Page')->findPageComponentByUrl($pageUrl,$dealer_id);
        return $component;
    }

}