<?php

namespace Numa\DOAApiBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
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
        $day = new \DateTime();
        $arr=array();
        if($dealer instanceof Catalogrecords) {
            $stats = $this->getDoctrine()->getRepository('NumaDOAStatsBundle:GaStats')->getVisitorsByDay($dealer->getId(), $day, "-31days");
            $i = 1;
            foreach ($stats as $key => $value) {
                $arr[] = array(substr($value['date_stats'], 0, 10), intval($value['sessions']));
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