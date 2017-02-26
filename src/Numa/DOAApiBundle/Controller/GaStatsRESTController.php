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
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $todaysYear = intval(date_format(new \DateTime(), "Y"));

        $stats = $this->getDoctrine()->getRepository('NumaDOAStatsBundle:GaStats')->getVisitorsByMonth($dealer->getId(), $todaysYear);

        foreach ($stats as $key => $value) {
            $arr[] = array(intval($value['month'] - 1), intval($value['sessions']));
        }
        return $arr;
    }

    public function dayAction()
    {
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $todaysYear = intval(date_format(new \DateTime(), "Y"));
        $todaysMonth = intval(date_format(new \DateTime(), "n"));

        $stats = $this->getDoctrine()->getRepository('NumaDOAStatsBundle:GaStats')->getVisitorsByDay($dealer->getId(), $todaysYear, $todaysMonth);

        foreach ($stats as $key => $value) {
            $arr[] = array(intval($value['day']), intval($value['sessions']));
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