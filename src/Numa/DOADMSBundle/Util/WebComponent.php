<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 7.10.16.
 * Time: 15.34
 */

namespace Numa\DOADMSBundle\Util;
use Doctrine\Common\Collections\Criteria;
use Numa\DOAModuleBundle\Entity\Component;
use Numa\DOADMSBundle\Entity\DealerComponent;
use Numa\DOAModuleBundle\Entity\PageComponent;
use Numa\DOAAdminBundle\Entity\ImageCarousel;
use Numa\DOAModuleBundle\Entity\Page;

class WebComponent
{
    protected $container;

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }

    public function getComponent($name, $type = "Text", $source = "page"){
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("name", $name));//->getMaxResults(1);
        if (strtolower($type) == "carousel") {
            $criteria->andWhere(Criteria::expr()->eq("name", $name));
        }
        $request = $this->container->get("request");

        $pathinfo = $request->getPathInfo();

//        if (substr($pathinfo, 0, 2) === "/d") {
//            $pathinfo = substr($pathinfo, 2, strlen($pathinfo) - 1);
//        }
        $em = $this->container->get('doctrine.orm.entity_manager');
        //$host = trim(strip_tags($request->getHost()));
        //$dealer = $em->getRepository("NumaDOAAdminBundle:Catalogrecords")->getDealerByHost($host);
        $dealer = $this->container->get("numa.dms.user")->getDealerByHost();


        $dealer_id = null;
        $page = null;
        $component = null;
        $value = "";

        if ($dealer instanceof Catalogrecords) {
            if ($source == "page") {
                $page = $em->getRepository('NumaDOAModuleBundle:Page')->findPageComponentByUrl($pathinfo, $dealer->getId());
                if ($page instanceof Page) {
                    $components = $page->getComponent();
                }

            } elseif ($source == "dealer") {
                $components = $dealer->getComponent();
            }
        }

        if (!empty($components)) {
            $componentsArray = $components->matching($criteria);

            if (!empty($componentsArray) and $componentsArray->count() > 0) {
                $component = $componentsArray->first();
            }
        }

        if (!($component instanceof Component) && !($component instanceof DealerComponent)) {
            if ($type != "image_text") {
                if ($source == "page" && $page instanceof Page) {
                    $comp = new Component();
                    $comp->setName($name);
                    $comp->setType($type);
                    $pc = new PageComponent();
                    $pc->setComponent($comp);
                    $pc->setPage($page);
                    $em->persist($comp);
                    $em->persist($pc);
                    $em->flush();
                    $value = $comp->getValue();
                } elseif ($source == "dealer") {

                    $comp = new DealerComponent();
                    $comp->setDealer($dealer);
                    $comp->setName($name);
                    $comp->setType($type);
                    $em->persist($comp);

                    $em->flush();
                    $value = $comp->getValue();
                }
            }
        } else {
            $value = $component->getValue();

        }
        if (empty($value)) {
            $value = "";
        }

        if (strtolower($type) == "carousel") {
            $em = $this->container->get('doctrine.orm.entity_manager');
            $images = array();

            if ($component instanceof Component) {
                $images = $em->getRepository("NumaDOAAdminBundle:ImageCarousel")->findByComponent($component->getId());
            }elseif($component instanceof DealerComponent){
                $images = $em->getRepository("NumaDOAAdminBundle:ImageCarousel")->findByDealerComponent($component->getId());
            }

            return $images;
        } elseif (strtolower($type) == "template") {

        } elseif ((strtolower($type) == "image" || strtolower($type) == "image_object") && ($component instanceof Component || $component instanceof DealerComponent)) {
            $em = $this->container->get('doctrine.orm.entity_manager');
            $images = array();

            if ($component instanceof Component ) {
                $images = $em->getRepository("NumaDOAAdminBundle:ImageCarousel")->findByComponent($component->getId());
            }

            if ($component instanceof DealerComponent) {
                $images = $em->getRepository("NumaDOAAdminBundle:ImageCarousel")->findByDealerComponent($component->getId());

            }


            if (!empty($images[0])) {
                if(strtolower($type) == "image_object"){
                    $image = $images[0];
                    $image->setSrc("/upload/dealers/".$image->getSrc());
                    return $image;
                }
                $uploadDir = "/" . ImageCarousel::getUploadDir();
                $res = $images[0]->getSrc();
//                dump($uploadDir."/dealers/".$res);
//                // set button1 = "/upload/dealers/3/component/40/fast-cars-3.jpg"   %}
//                //dump($res);
//                //die();
                return "/upload/dealers/" . $res;
            }

        } elseif (strtolower($type) == "image") {

//            preg_match("/\<img.+src\=(?:\"|\')(.+?)(?:\"|\')(?:.+?)\>/", $value, $matches);
//            $value = "";
//            if (!empty($matches[1])) {
//                $value = $matches[1];
//            }

        }elseif (strtolower($type) == "image_text") {

            if(!empty($component->getValue())) {
                return $component->getValue();
            }
            return "";
        }


        return $value;
    }


}