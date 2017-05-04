<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 28.4.17.
 * Time: 13.53
 */

namespace Numa\Util\Component;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CarouselComponent extends ComponentView
{
    private $componentEntity;
    private $container;
    public function setContainer(ContainerInterface $container){
        $this->container = $container;
    }

    private $setting;

    public function __construct(ComponentEntityInterface $componentEntity)
    {
        $this->componentEntity = $componentEntity;
    }


    public function display()
    {
        $images = array();

//            if ($component instanceof Component) {
//                $images = $em->getRepository("NumaDOAAdminBundle:ImageCarousel")->findByComponent($component->getId());
//            }elseif($component instanceof DealerComponent){
//                $images = $em->getRepository("NumaDOAAdminBundle:ImageCarousel")->findByDealerComponent($component->getId());
//            }
        $em = $this->container->get("doctrine.orm.entity_manager");
        $images = $em->getRepository("NumaDOAAdminBundle:ImageCarousel")->findByComponent($this->componentEntity);

        if(!empty($this->setting['output']) && $this->setting['output']=="list"){
            return $images;
        }
        //dump($images);die();
        $templating  = $this->container->get('templating');
        $imageSize = $this->setting['image_size'];
        $class = $this->setting['class'];


        $html = $templating->render('NumaDOASiteBundle:TemplatesElements:carousel.html.twig', array(
            'images' => $images,
            'class' => $class,
            'carouselId' => $this->componentEntity->getName().$this->componentEntity->getId(),
            'image_size' => $imageSize,
        ));

//        dump($html);
//        die();
        return $this->componentWrapper($this->componentEntity,$html);
    }


    public function setComponentEntity(ComponentEntityInterface $componentEntity){
        $this->componentEntity = $componentEntity;
    }

    public function setSettings($setting){
        $this->setting = $setting;
    }

}