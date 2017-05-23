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

class ImageComponent extends ComponentView
{
    private $componentEntity;
    private $container;
    private $setting;

    public function setContainer(ContainerInterface $container)
    {
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

        if(!empty($images[0]) && $images[0] instanceof ImageCarousel){
            if (!empty($this->setting['template'])) {
                $html = $this->processSetting($images[0]);
                return $this->componentWrapper($this->componentEntity,$html);
            }
            if (!empty($this->setting['output']) && ($this->setting['output'] == "src")) {
                $res = $images[0]->getSrc();
                $templating  = $this->container->get('templating');

                return "/upload/dealers/" . $res;
            }

            if (!empty($this->setting['output']) && ($this->setting['output'] == "image_text")) {
                return $this->componentEntity->getValue();
            }

            return $images[0];
        }
    }

    public function processSetting($image)
    {
        $template_params = array();
        $html = "";
        if (!empty($this->setting['template_params'])) {
            $template_params = $this->setting['template_params'];
        }

        $template_params['image'] = $image;
        if (!empty($this->setting['template'])) {
            $templating = $this->container->get('templating');
            $html = $templating->render($this->setting['template'], $template_params);
        }
        return $html;
    }

    public function setSettings($setting)
    {
        $this->setting = $setting;
    }

    public function setComponentEntity(ComponentEntityInterface $componentEntity)
    {
        $this->componentEntity = $componentEntity;
    }

}