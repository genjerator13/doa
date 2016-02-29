<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Dms controller.
 *
 */
class DmsController extends Controller {


    public function indexAction() {

        return $this->render('NumaDOAAdminBundle:Dms:index.html.twig', array(

        ));
    }

    public function activateAction(Request $request) {
        //get the dealer
        //get the site
        //send email to dms@dealersonair.com
        $user = $this->get('security.token_storage')->getToken()->getUser();


        $host = $this->get('router')->getContext()->getHost();
        $mailer = $this->get('Numa.Emailer');
        $ok = $mailer->sendDmsActivateEmail($host,$user);
        $message = "Thank-you for your request, someone will be in contact with you shortly.";

        if(!$ok){
            $message = "Error";
        }

        return $this->render('NumaDOADMSBundle:Dms:index.html.twig', array(
            'message'=>$message
        ));
    }

    public function customersAction() {

        return $this->render('NumaDOAAdminBundle:Dms:index.html.twig', array(

        ));
    }


}
