<?php

namespace Numa\DOAApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;

class GaStatsRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function monthAction()
    {
        $stats = $this->getDoctrine()->getRepository('NumaDOAStatsBundle:GaStats')->getVisitorsByMonth();
        $todaysDate = new \DateTime();
        foreach ($stats as $key => $value) {
            if (intval($value['year']) === intval(date_format($todaysDate, "Y"))) {
                $arr[] = array(intval($value['month']), intval($value['sessions']));
            }
        }
        return $arr;
    }

    public function dayAction()
    {
        $stats = $this->getDoctrine()->getRepository('NumaDOAStatsBundle:GaStats')->getVisitorsByDay();
        $todaysDate = new \DateTime();
        foreach ($stats as $key => $value) {
            if ((intval($value['month']) === intval(date_format($todaysDate, "n"))) && (intval($value['year']) === intval(date_format($todaysDate, "Y")))) {
                $arr[] = array(intval($value['day']), intval($value['sessions']));
            }
        }
        return $arr;
    }

    public function testdataAction()
    {
        $data = array(array(0, 2), array(1, 2), array(2, 3), array(3, 4), array(4, 15), array(5, 6), array(6, 7), array(7, 24), array(8, 17), array(9, 11), array(10, 7), array(11, 7));
        //dump($data);die();
        return new JsonResponse($data);
    }

}