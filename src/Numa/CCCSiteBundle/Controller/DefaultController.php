<?php

namespace Numa\CCCSiteBundle\Controller;

use Numa\CCCAdminBundle\Entity\LtDispatch;
use Numa\CCCAdminBundle\Entity\Quote;
use Numa\CCCAdminBundle\Form\LtDispatchType;
use Numa\CCCAdminBundle\Form\QuoteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NumaCCCSiteBundle:Default:index.html.twig');
    }

    public function quoteAction(Request $request)
    {
        $quote = new Quote();
        $quoteForm = $this->createForm(new QuoteType(), $quote, array(
            'action' => $this->generateUrl('site_quote_form'),
            'method' => 'POST',
        ));
        $errors = array();
        $quoteForm->add('captcha', 'genemu_captcha',array('mapped' => false,));
        $quoteForm->add('submit', 'submit', array('label' => 'Create'));
        $quoteForm->handleRequest($request);
        if ($quoteForm->isValid() && $request->isMethod('POST')) {
            $entity= $quoteForm->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->addFlash('success', "Quote Form has been successfully submitted");
            return $this->redirect($this->generateUrl('site_form_success'));
        }else{
            $errors = $quoteForm->getErrors(true);
            if(!empty($quoteForm->getErrors()->count())) {
                $this->addFlash('danger', "Captcha code invalid, please try again to send email.");
            }

        }
        return $this->render('NumaCCCSiteBundle:Default:index.html.twig',array('quoteForm'=>$quoteForm->createView(),'errors'=>$errors));
    }

    public function dispatchAction(Request $request)
    {
        $ltdispatch = new LtDispatch();
        $ltdform = $this->createForm(new LtDispatchType(), $ltdispatch, array(
            'action' => $this->generateUrl('site_dispatch_form'),
            'method' => 'POST',
            //'attr'  => array('class'=>'form-inline'),
        ));
        $ltdform->add('captcha', 'genemu_captcha',array('mapped' => false,));
        $ltdform->add('submit', 'submit', array('label' => 'Submit Information'));
        $ltdform->handleRequest($request);
        $errors = array();
        if ($ltdform->isValid() && $request->isMethod('POST')) {
            $entity= $ltdform->getData();
            $em=$this->getDoctrine()->getManager();
            if($entity instanceof LtDispatch)
            $vehtypes = $entity->getVehicleTypes();
            $additional = $entity->getAdditional();
            $vt_list=array();
            $add_list=array();
            foreach($vehtypes as $veht){
                $vt_list[]=$veht->getVehdesc();
            }

            foreach($additional as $add){
                $add_list[]=$add->getName();
            }

            $entity->setVehtypesList(implode(",",$vt_list));
            $entity->setAdditionaReqList(implode(",",$add_list));
            if($entity instanceof LtDispatch){
                if(empty($entity->getVehtypeRequested())){
                    $entity->setVehicletype("");
                }

                if(empty($entity->getVehtypeRequested())){
                    $entity->setSemipowerUnit("");
                }
            }

            $em->persist($entity);
            $em->flush();
            $this->addFlash('success', "The Order has been successfully submitted");
            return $this->redirect($this->generateUrl('site_form_success'));
        }else{
            $errors = $ltdform->getErrors(true);
            if(!empty($ltdform->getErrors()->count())) {
                $this->addFlash('danger', "Captcha code invalid, please try again to send email.");
            }

        }
        return $this->render('NumaCCCSiteBundle:Default:ltdispatch.html.twig',array('ltdForm'=>$ltdform->createView(),'errors'=>$errors));
    }

    public function formSuccessAction(Request $request)
    {
        return $this->render('NumaCCCSiteBundle:Default:success.html.twig',array('message'=>'success'));
    }
}
