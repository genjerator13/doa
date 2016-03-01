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

class CustomerRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $ads = $this->getDoctrine()->getRepository('NumaDOADMSBundle:Customer')->findAll();

        return $ads;
    }

//    /**
//     * @Rest\View
//     */
//    public function byPageAction($pageid)
//    {
//        $page = $this->getDoctrine()->getRepository('NumaDOAModuleBundle:Page')->find($pageid);
//        $ads = $page->getAds();
//        return array('ads' => $ads);
//    }
}