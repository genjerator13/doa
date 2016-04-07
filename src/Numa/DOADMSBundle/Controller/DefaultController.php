<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $dealer=false;

        if ($user instanceof Catalogrecords) {
            $dealer = $user;

        }
        $totalListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1,0,$dealer);
        $totalViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1,0,$dealer);

        return $this->render('NumaDOADMSBundle:Default:index.html.twig',
            array('totalListings' => $totalListings, 'totalViews' => $totalViews));
    }

    public function dealerChooserAction(Request $request)
    {
        $dealers = array();
        $dealer_id = $request->get('dealer');
        if (!empty($dealer_id)) {
            $dealer = $this->get('doctrine.orm.entity_manager')->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($dealer_id);
            $session = $this->get('session');
            $session->set('dealer', $dealer);

            return $this->redirectToRoute('dms_home');

        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $dealers = $this->get('doctrine.orm.entity_manager')->getRepository('NumaDOAAdminBundle:Catalogrecords')->findAll();
            return $this->render('NumaDOADMSBundle::dealerChooser.html.twig', array('dealers' => $dealers));
        }
        return $this->render('NumaDOADMSBundle::dealerChooser.html.twig');
    }
}
