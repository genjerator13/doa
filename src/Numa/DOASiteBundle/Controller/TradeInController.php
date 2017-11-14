<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOADMSBundle\Form\ListingFormType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Proxies\__CG__\Numa\DOADMSBundle\Entity\ListingForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class TradeInController extends Controller implements DealerSiteControllerInterface
{

    public $dealer;

    public function initializeDealer($dealer)
    {
        $this->dealer = $dealer;
    }


    public function tradeInAction(Request $request)
    {
        $title = $request->attributes->get('title');

        $template = "NumaDOASiteBundle:siteForms/TradeIn:tradeIn_form.html.twig";
        //template:'trade_in_custom'
        $title = $request->attributes->get('template');
        if($title=="trade_in_custom"){
            $template = "NumaDOASiteBundle:siteForms/TradeIn:tradeIn_custom_form.html.twig";
        }
        $entity = new ListingForm();
        $form = $this->createCreateForm($entity,$title);
        $form->handleRequest($request);
        $form = $this->get('google.captcha')->proccessGoogleCaptcha($request, $form);
        $dealer = $this->get("numa.dms.user")->getDealerByHost();
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->upload($dealer);

            $this->get("Numa.DMSUtils")->attachCustomerByEmail($entity,$this->dealer,$entity->getEmail(),$entity->getCustName(),$entity->getCustLastName(),$entity->getPhone());

            $entity->setDealer($this->dealer);
            $entity->setType("TradeIn");
            if($title=="trade_in_custom"){
                $entity->setType("TradeIn custom");
            }

            if(empty($entities)) {
                $em->persist($entity);
            }
            $em->flush();
            return $this->redirectToRoute('tradeIn_success');

        }


        return $this->render($template, array(
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
    private function createCreateForm(ListingForm $entity,$title)
    {
        $action = $this->generateUrl('tradeIn_form');
        if($title=="trade_in_custom"){
            $action = $this->generateUrl('tradeIn_custom_form');
        }
        $form = $this->createForm(new ListingFormType(), $entity, array(
            'action' => $action,
            'method' => 'POST',
        ));

        $form->add('make_onsite', null, array('label'=>'Make *', 'required'=>true));
        $form->add('model_onsite', null, array('label'=>'Model *', 'required'=>true));
        $form->add('year_onsite', null, array('label'=>'Year *', 'required'=>true));
        $form->add('make', null, array('label'=>'Make *', 'required'=>true));
        $form->add('model', null, array('label'=>'Model *', 'required'=>true));
        $form->add('year', null, array('label'=>'Year *', 'required'=>true));
        $form->add('kilometers', null, array('label'=>'Kilometers *', 'required'=>true));
        $form->add('accessories', null, array('label'=>'Accessories *', 'required'=>true));
        $form->add('special', null, array('label'=>'Special Options', 'required'=>true));
        $form->add('image1', 'file', array('label'=>'Image 1', 'required'=>false));
        $form->add('image2', 'file', array('label'=>'Image 2', 'required'=>false));
        $form->add('image3', 'file', array('label'=>'Image 3', 'required'=>false));
        $form->add('submit', 'submit', array('label' => 'Send'));

        return $form;
    }

    public function successAction(){
        $message = "Success";

        return $this->render('NumaDOASiteBundle:siteForms:success.html.twig', array(
            'path'=>'tradeIn_form',
            'message'=>$message,
            'dealer' => $this->dealer,
        ));
    }
}

