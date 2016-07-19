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

class DealerComponentRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $dealerComponent = $this->getDoctrine()->getRepository('NumaDOADMSBundle:DealerComponent')->findAll();
        return $dealerComponent;
    }

    /**
     * @Rest\View
     */
    public function byDealerAction($dealer_id)
    {
        $dealerComponent = $this->getDoctrine()->getRepository('NumaDOADMSBundle:DealerComponent')->findBy(array('dealer_id'=>$dealer_id));
        return $dealerComponent;
    }

}