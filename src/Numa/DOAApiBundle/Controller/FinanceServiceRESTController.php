<?php

namespace Numa\DOAApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;

class FinanceServiceRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $partRequest = $this->getDoctrine()->getRepository('NumaDOADMSBundle:FinanceService')->findAll();
        return $partRequest;
    }

    /**
     * @Rest\View
     */
    public function byDealerAction($dealer_id)
    {
        $partRequest = $this->getDoctrine()->getRepository('NumaDOADMSBundle:FinanceService')->findBy(array('dealer_id'=>$dealer_id));
        return $partRequest;
    }

    /**
     * @Rest\View
     */
    public function byDealerPrincipalAction($dealer_group_id)
    {

        $customer = $this->getDoctrine()->getRepository('NumaDOADMSBundle:FinanceService')->findByDealerGroupId($dealer_group_id);
        //dump($customer);die();
        if (!$customer) {
            //throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        return $customer;
    }

}