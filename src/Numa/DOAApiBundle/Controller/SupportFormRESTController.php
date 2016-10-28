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

class SupportFormRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $supportForm = $this->getDoctrine()->getRepository('NumaDOADMSBundle:SupportForm')->findAll();
        return $supportForm;
    }

    /**
     * @Rest\View
     */
    public function byDealerAction($dealer_id)
    {
        $supportForm = $this->getDoctrine()->getRepository('NumaDOADMSBundle:SupportForm')->findBy(array('dealer_id'=>$dealer_id));
        return $supportForm;
    }

}