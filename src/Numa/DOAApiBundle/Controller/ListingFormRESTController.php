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

        $postD = json_decode($post);
        $data =$request->request->get('numa_doadmsbundle_listingform');

        $em=$this->getDoctrine()->getManager();
        $type = "";
        if($request->query->get('form')=='offer' || $request->query->get('form')=='drive' || $request->query->get('form')=='eprice' || $request->query->get('form')=='contact'){
            $type = $request->query->get('form');
        }
        if(!empty($data['item_id'])){
            $item_id = $data['item_id'];
        }

        if(empty($item_id)){
            $item_id = intval($request->query->get('amp;item_id'));
        }

        //get customer by email ($data['email']
        //if the customer is not found create new one based by data
        //create new listingform
        //set type test drive
        $listingForm = new ListingForm();
        $listingForm->setType($type);
        $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($item_id);
        //dump($item);die();
        $listingForm->setItem($item);
        $email = $data['email'];

        //$dealer = $this->get("Numa.Dms.User")->getSignedDealer();
        $customer = $em->getRepository('NumaDOADMSBundle:Customer')->findOneBy(array('email'=>$email,'dealer_id'=>$this->dealer->getId()));

        if(empty($customer)){
            $customer = new Customer();
            $customer->setFirstName($data['cust_name']);
            $customer->setLastName($data['cust_last_name']);
            $customer->setEmail($email);
            $customer->setCatalogrecords($this->dealer);
            $customer->setHomePhone($data['phone']);
            $em->persist($customer);
        }
        if(!empty($data['date_drive'])) {
            $date = new \DateTime($data['date_drive']['year'] . "-" . $data['date_drive']['month'] . "-" . $data['date_drive']['day']);
            $listingForm->setDateDrive($date);
        }
        $listingForm->setCustName($data['cust_name']);
        $listingForm->setCustLastName($data['cust_last_name']);
        if(!empty($data['cust_officer'])) {
            $listingForm->setCustOfficer($data['cust_officer']);
        }
        $listingForm->setEmail($data['email']);
        $listingForm->setPhone($data['phone']);
        if(!empty($data['comment'])) {
            $listingForm->setComment($data['comment']);
        }
        if(!empty($data['contact_by'])) {
            $listingForm->setContactBy($data['contact_by']);
        }
        $listingForm->setDealer($this->dealer);
        $listingForm->setCustomer($customer);
        $em->persist($listingForm);
        $em->flush();

        //check if already inserted
        $response = new JsonResponse(
            array(
                'message' => 'Success',
                'action' => '',
                400));
        return $response;
    }
}