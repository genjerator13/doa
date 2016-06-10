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

class NoteRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $customers = $this->getDoctrine()->getRepository('NumaDOADMSBundle:Note')->findAll();

        return $customers;
    }

    /**
     * @Rest\View
     */
    public function allByCustomerAction($customer_id)
    {
        $customers = $this->getDoctrine()->getRepository('NumaDOADMSBundle:Note')->findBy(array('customer_id'=>$customer_id),array('date_remind'=>'DESC'));
        return $customers;
    }

}