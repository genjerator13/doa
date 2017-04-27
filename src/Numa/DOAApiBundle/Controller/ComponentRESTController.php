<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAApiBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;


class ComponentRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $component = $this->getDoctrine()->getRepository('NumaDOAModuleBundle:Component')->findAll();
        return $component;
    }
    /**
     * @Rest\View
     */
    public function byPageAction($page_id)
    {
        $component = $this->getDoctrine()->getRepository('NumaDOAModuleBundle:Page')->findPageComponentByPageId($page_id);
        return $component;
    }

    /**
     * @Rest\View
     */
    public function byDealerAction($dealer_id)
    {
        $component = $this->getDoctrine()->getRepository('NumaDOAModuleBundle:Page')->findPageComponentByDealerId($dealer_id);
        return $component;
    }

    public function allComponentsByDealerAction($dealer_id)
    {
        $dealer = $this->getDoctrine()->getRepository(Catalogrecords::class)->find($dealer_id);
        $components = $this->getDoctrine()->getRepository('NumaDOAModuleBundle:Page')->findPageComponentByDealerId($dealer);
        $dealerComponents = $this->getDoctrine()->getRepository('NumaDOAModuleBundle:Component')->findDealerComponentByDealerId($dealer);

        $comp = array();
        foreach($components as $component){
            $temp = array();
            $temp['id'] = $component->getId();
            $temp['name'] = $component->getName();
            $temp['type'] = $component->getType();
            $temp['value'] = $component->getValue();
            $temp['pages_names'] = $component->getPagesNames();
            $temp['helpdesc'] = $component->getHelpdesc();
            $temp['theme'] = $component->getTheme();

            $comp[]=$temp;
        }
        foreach($dealerComponents as $dealerComponent){
            $temp = array();
            $temp['id'] = $dealerComponent->getId();
            $temp['name'] = $dealerComponent->getName();
            $temp['type'] = $dealerComponent->getType();
            $temp['value'] = $dealerComponent->getValue();
            $temp['pages_names'] = "All Pages";
            $temp['helpdesc'] = $dealerComponent->getHelpdesc();
            $temp['theme'] = $component->getTheme();
            $comp[]=$temp;
        }
//        dump(json_encode($comp));
////        dump($components);
////        dump($dealerComponents);
//        die();
        $response = new JsonResponse($comp); //$response->setData(array( 'data' => 123 ));
        return $response;
    }

}