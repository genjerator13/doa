<?php

namespace Numa\DOAAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\Importfeed;
use Numa\DOAAdminBundle\Form\ImportfeedType;
use Numa\DOAAdminBundle\Entity\Item;

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
        $host = $this->get('router')->getContext()->getHost();
        $mailer = $this->get('Numa.Emailer');
        $ok = $mailer->sendDmsActivateEmail($host);
        $message = "Thank-you for your request, someone will be in contact with you shortly.";
        if(!$ok){
            $message = "Error";
        }
        return $this->render('NumaDOAAdminBundle:Dms:index.html.twig', array(
            'message'=>$message
        ));
    }


}
