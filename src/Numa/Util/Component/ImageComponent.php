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
    private $setting;
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
        $src=false;
        if(!empty($this->setting['output']) && ($this->setting['output']=="src")){
            $src=true;
        }
        if($images[0] instanceof ImageCarousel){
            if($src) {
                $res = $images[0]->getSrc();
                return "/upload/dealers/" . $res;
            }
            return $images[0];
        }


    }

    public function setSettings($setting){
        $this->setting = $setting;
    }

    public function setComponentEntity(ComponentEntityInterface $componentEntity){
        $this->componentEntity = $componentEntity;
    }

}