<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 28.4.17.
 * Time: 13.53
 */

namespace Numa\Util\Component;


use Numa\DOAAdminBundle\Entity\ImageCarousel;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImageComponent implements ComponentView
{
    private $componentEntity;
    private $container;
    public function setContainer(ContainerInterface $container){
        $this->container = $container;
    }
    public function __construct(ComponentEntityInterface $componentEntity)
    {
        $this->componentEntity = $componentEntity;
    }

    public function display()
    {
        $images = array();

        $em = $this->container->get("doctrine.orm.entity_manager");
        $images = $em->getRepository("NumaDOAAdminBundle:ImageCarousel")->findByComponent($this->componentEntity);

        if($images[0] instanceof ImageCarousel){
            $res = $images[0]->getSrc();

            return "/upload/dealers/" . $res;
        }


    }


    public function setComponentEntity(ComponentEntityInterface $componentEntity){
        $this->componentEntity = $componentEntity;
    }

}