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

class PartRequestRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $partRequest = $this->getDoctrine()->getRepository('NumaDOADMSBundle:PartRequest')->findAll();
        return $partRequest;
    }

    /**
     * @Rest\View
     */
    public function byDealerAction($dealer_id)
    {
        $partRequest = $this->getDoctrine()->getRepository('NumaDOADMSBundle:PartRequest')->findBy(array('dealer_id'=>$dealer_id));
        return $partRequest;
    }

}