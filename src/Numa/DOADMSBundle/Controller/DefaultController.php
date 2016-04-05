<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NumaDOADMSBundle:Default:index.html.twig');
    }

    public function dealerChooserAction(Request $request){
        $dealers=array();
        $dealer_id = $request->get('dealer');
        if(!empty($dealer_id)){
            $dealer = $this->get('doctrine.orm.entity_manager')->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($dealer_id);
            $session = $this->get('session');
            $session->set('dealer',$dealer);

            return $this->redirectToRoute('dms_home');

        }
        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $dealers = $this->get('doctrine.orm.entity_manager')->getRepository('NumaDOAAdminBundle:Catalogrecords')->findAll();
            return $this->render('NumaDOADMSBundle::dealerChooser.html.twig',array('dealers'=>$dealers));
        }
        return $this->render('NumaDOADMSBundle::dealerChooser.html.twig');
    }
}
