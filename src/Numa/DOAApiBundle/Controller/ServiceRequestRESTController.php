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

class ServiceRequestRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $serviceRequest = $this->getDoctrine()->getRepository('NumaDOADMSBundle:ServiceRequest')->findAll();
        return $serviceRequest;
    }

    /**
     * @Rest\View
     */
    public function byDealerAction($dealer_id)
    {
        $serviceRequest = $this->getDoctrine()->getRepository('NumaDOADMSBundle:ServiceRequest')->findBy(array('dealer_id'=>$dealer_id));
        return $serviceRequest;
    }

}