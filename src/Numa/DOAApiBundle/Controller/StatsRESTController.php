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
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class StatsRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $stats = $this->getDoctrine()->getRepository('NumaDOAStatsBundle:Stats')->getVisitors();
        return $stats;
    }

    public function testdataAction()
    {
        $data = array(array(1, 2),array(2, 3),array(3, 4),array(4, 5),array(5, 6),array(6, 7),array(7, 7),array(8, 7),array(9, 7),array(10, 7),array(11, 7),array(12, 7));
        //dump($data);die();
        return new JsonResponse($data);
    }

}