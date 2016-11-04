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

class VendorRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $vendors = $this->getDoctrine()->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted();
        //dump($vendors);die();
        return $vendors;
    }

    /**
     * @Rest\View
     */
    public function singleAction($vendor_id)
    {
        $vendor = $this->getDoctrine()->getRepository('NumaDOADMSBundle:Vendor')->find($vendor_id);
        if (!$vendor) {
            throw $this->createNotFoundException('Unable to find Vendor entity.');
        }
        return $vendor;
    }
    /**
     * @Rest\View
     */
    public function byDealerAction($dealer_id)
    {

        $vendor = $this->getDoctrine()->getRepository('NumaDOADMSBundle:Vendor')->findByDealerId($dealer_id);
       // dump($vendor);die();
        if (!$vendor) {
            //throw $this->createNotFoundException('Unable to find Vendor entity.');
        }

        return $vendor;
    }

    /**
     * @Rest\View
     */
    public function byDealerPrincipalAction($dealer_group_id)
    {

        $vendor = $this->getDoctrine()->getRepository('NumaDOADMSBundle:Vendor')->findByDealerGroupId($dealer_group_id);
        //dump($customer);die();
        if (!$vendor) {
            //throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        return $vendor;
    }
}