<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAApiBundle\Controller;

use Numa\DOADMSBundle\Entity\ListingForm;

use Numa\DOADMSBundle\Form\ListingFormContactType;
use Numa\DOADMSBundle\Form\ListingFormDriveType;
use Numa\DOADMSBundle\Form\ListingFormEpriceType;
use Numa\DOADMSBundle\Form\ListingFormFinanceType;
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
        $error=true;

        if(!empty($request->request->get('eprice'))) {
            $data = $request->request->get('eprice');
            $form = new ListingFormEpriceType();
            $id = "eprice_form";
        }
        if(!empty($request->request->get('finance'))) {
            $data = $request->request->get('finance');
            $form = new ListingFormFinanceType();
            $id = "finance_form";
        }
        if(empty($request->request->get('contact'))) {
            $data = $request->request->get('contact');
            $form = new ListingFormContactType();
            $id = "conatact_form";
        }
        if(empty($request->request->get('drive'))){
           $data = $request->request->get('drive');
           $form = new ListingFormDriveType();
            $id = "drive_form";
        }



        $entity = new ListingForm();
        $form = $this->createForm($form, $entity, array(
            'csrf_protection' => false,
            'method' => 'POST',
            'attr' => array('id'=>$id),
        ));

        $form->submit($data);

        if($form->isValid()){
            $error=false;
        }

        $this->get("Numa.ListingForms")->handleListingForm($form->getData(),$this->dealer);

        if($error){
            $response = new JsonResponse(
                array(
                    'message' => 'error',
                    'action' => $form->getErrorsAsString(),
                    400));
            return $response;
        }
        $response = new JsonResponse(
            array(
                'message' => 'Success',
                'action' => '',
                400));
        return $response;
    }
}