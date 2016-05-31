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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListingFormRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $listingForm = $this->getDoctrine()->getRepository('NumaDOADMSBundle:ListingForm')->findAll();
        return $listingForm;
    }

    /**
     * @Rest\View
     */
    public function byDealerAction($dealer_id)
    {
        $listingForm = $this->getDoctrine()->getRepository('NumaDOADMSBundle:ListingForm')->findBy(array('dealer_id'=>$dealer_id));
        return $listingForm;
    }

    public function postListingFormAction(Request $request)
    {
        $post = $request->getContent();
        $postD = json_decode($post);
        $data =$request->request->get('numa_doadmsbundle_listingform');
        //get customer by email ($data['email']
        //if the customer is not found create new one based by data
        //create new listingform
        //set type test drive
        
        $em = $this->getDoctrine()->getManager();
        //check if already inserted
        $response = new JsonResponse(
            array(
                'message' => 'Success',
                'action' => '',
                400));



        return $response;
/*
 * array:7 [
  "cust_name" => ""
  "cust_last_name" => ""
  "contact_by" => "0"
  "email" => ""
  "phone" => ""
  "date_drive" => array:3 [
    "month" => "1"
    "day" => "1"
    "year" => "2011"
  ]
  "_token" => "BwQm4mcdOjWbZvSf9FHt9XXdzJyZsOqUzyRAI40PGeI"
]

 */

    }

}