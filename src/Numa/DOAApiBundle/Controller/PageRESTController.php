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

class PageRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $page = $this->getDoctrine()->getRepository('NumaDOAModuleBundle:Page')->findAll();
        return $page;
    }

}