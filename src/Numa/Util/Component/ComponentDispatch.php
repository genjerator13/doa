<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 28.4.17.
 * Time: 13.53
 */

namespace Numa\Util\Component;


use Doctrine\Common\Collections\Criteria;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAModuleBundle\Entity\Page;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ComponentDispatch
{
    protected $container;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getComponent($name, $type = "Text", $source = "page",$theme="",$setting=array()){
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("name", $name));//->getMaxResults(1);

        $request = $this->container->get("request");

        $pathinfo = $request->getPathInfo();

//        if (substr($pathinfo, 0, 2) === "/e") {
//            $pathinfo = substr($pathinfo, 2, strlen($pathinfo) - 1);
//        }
        $em = $this->container->get('doctrine.orm.entity_manager');
//        s$dealer = $em->getRepository("NumaDOAAdminBundle:Catalogrecords")->getDealerByHost($host);
        $dealer = $this->container->get("numa.dms.user")->getDealerByHost();



        $dealer_id = null;
        $page = null;
        $component = null;

        if ($dealer instanceof Catalogrecords) {

            if ($source == "page") {
                $page = $em->getRepository('NumaDOAModuleBundle:Page')->findPageComponentByUrl($pathinfo, $dealer->getId());
                if ($page instanceof Page) {
                    $components = $page->getComponent();
                }


            } elseif ($source == "dealer") {
                $dealerComponents = $em->getRepository('NumaDOADMSBundle:DealerComponent')->findBy(array('Dealer'=>$dealer));
                $components= new \Doctrine\Common\Collections\ArrayCollection($dealerComponents);
                //$components = $dealer->getComponent();

            }

        }

        if (!empty($components)) {
            $componentsArray = $components->matching($criteria);

            if (!empty($componentsArray) and $componentsArray->count() > 0) {
                $component = $componentsArray->first();
            }
        }

        if(! $component instanceof ComponentEntityInterface){
            return;
        }

        if(strtolower($type)=="text" || strtolower($type)=="html"  || strtolower($type)=="template"){
            $componentxxx =new TextComponent($component);
            return $componentxxx;
        }elseif(strtolower($type)=="carousel"){

            $componentxxx =new CarouselComponent($component);
            $componentxxx->setContainer($this->container);
            $componentxxx->setSettings($setting);
            return $componentxxx;
        }elseif(strtolower($type)=="image"){

            $componentxxx =new ImageComponent($component);
            $componentxxx->setContainer($this->container);
            $componentxxx->setSettings($setting);

            return $componentxxx;
        }

        return $component;
    }

}