<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAApiBundle\Controller;

use Numa\DOADMSBundle\Entity\ListingForm;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Form\ListingFormEpriceType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListingFormRESTController extends Controller implements DealerSiteControllerInterface{

    public $dealer;
    public $components;
    public function initializeDealer($dealer){
        $this->dealer = $dealer;
    }

    public function initializePageComponents($components){
        $this->components = $components;
    }


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

        $data =$request->request->get('numa_doadmsbundle_listingform');

        $form = new ListingFormEpriceType();
        $entity = new ListingForm();
        $form = $this->createForm(new ListingFormEpriceType(), $entity, array(
            'csrf_protection' => false,
            'method' => 'POST',
            'attr' => array('id'=>"contact_form"),
        ));

        $form->submit($data);

        //dump($form->getData());die();
        if($form->isValid()){
            dump("aaaaa");
        }else{
            dump($form->getErrorsAsString(true));
        }
       
        $this->get("Numa.ListingForms")->handleListingForm($form);

        $response = new JsonResponse(
            array(
                'message' => 'Success',
                'action' => '',
                400));
        return $response;
    }
}