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

class BillingRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function singleAction($id)
    {
        $billing = $this->getDoctrine()->getRepository('NumaDOADMSBundle:Billing')->find($id);
        return $billing;
    }

}