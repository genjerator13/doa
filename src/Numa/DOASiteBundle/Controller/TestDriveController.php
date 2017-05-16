<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOADMSBundle\Form\ListingFormType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Proxies\__CG__\Numa\DOADMSBundle\Entity\ListingForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class TestDriveController extends Controller implements DealerSiteControllerInterface{

    public $dealer;

    public function initializeDealer($dealer){
        $this->dealer = $dealer;
    }


    public function testDriveAction(Request $request)
    {
        $entity = new ListingForm();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $form = $this->get('google.captcha')->proccessGoogleCaptcha($request, $form);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $this->get("Numa.DMSUtils")->attachCustomerByEmail($entity,$this->dealer,$entity->getEmail(),$entity->getCustName(),$entity->getCustLastName(),$entity->getPhone());

            $entity->setDealer($this->dealer);
            $entity->setType("TestDrive");

            if(empty($entities)) {
                $em->persist($entity);
            }
            $em->flush();
            return $this->redirectToRoute('testDrive_success');

        }

        return $this->render('NumaDOASiteBundle:siteForms/TestDrive:testDrive_form.html.twig', array(
            'entity' => $entity,
            'dealer' => $this->dealer,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ListingForm entity.
     *
     * @param ListingForm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ListingForm $entity)
    {
        $form = $this->createForm(new ListingFormType(), $entity, array(
            'action' => $this->generateUrl('testDrive_form'),
            'method' => 'POST',
        ));

        $form->add('date_drive', null, array('label'=>'Best Date *'));
        $form->add('make_onsite', null, array('label'=>'Make *', 'required'=>true));
        $form->add('model_onsite', null, array('label'=>'Model *', 'required'=>true));
        $form->add('year_onsite', null, array('label'=>'Year *', 'required'=>true));
        $form->add('submit', 'submit', array('label' => 'Send'));

        return $form;
    }

    public function successAction(){
        $message = "Success";

        return $this->render('NumaDOASiteBundle:siteForms:success.html.twig', array(
            'path'=>'testDrive_form',
            'message'=>$message,
            'dealer' => $this->dealer,
        ));
    }
}

