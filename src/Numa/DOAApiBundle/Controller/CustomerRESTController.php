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

class CustomerRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $customers = $this->getDoctrine()->getRepository('NumaDOADMSBundle:Customer')->findAllNotDeleted();
        return $customers;
    }

    /**
     * @Rest\View
     */
    public function singleAction($customer_id)
    {
        $customer = $this->getDoctrine()->getRepository('NumaDOADMSBundle:Customer')->find($customer_id);
        if (!$customer) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }
        return $customer;
    }
    /**
     * @Rest\View
     */
    public function byDealerAction($dealer_id)
    {

        $customer = $this->getDoctrine()->getRepository('NumaDOADMSBundle:Customer')->findByDealerId($dealer_id);
       // dump($customer);die();
        if (!$customer) {
            //throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        return $customer;
    }

    /**
     * @Rest\View
     */
    public function byDealerPrincipalAction($dealer_group_id)
    {

        $customer = $this->getDoctrine()->getRepository('NumaDOADMSBundle:Customer')->findByDealerGroupId($dealer_group_id);
         //dump($customer);die();
        if (!$customer) {
            //throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        return $customer;
    }
}