<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;

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

}