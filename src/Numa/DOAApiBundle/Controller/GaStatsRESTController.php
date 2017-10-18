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
        if($dealer instanceof Catalogrecords) {
            $stats = $this->getDoctrine()->getRepository('NumaDOAStatsBundle:GaStats')->getVisitorsByMonth($dealer->getId(), $todaysYear);
            $arr = array();
            foreach ($stats as $key => $value) {
                $arr[] = array(intval($value['month'] - 1), intval($value['sessions']));
            }
            return $arr;
        }
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

}