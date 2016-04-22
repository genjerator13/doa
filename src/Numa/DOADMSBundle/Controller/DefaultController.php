<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $stats = $this->get('Numa.Dashboard.Stats')->dashboardStats();
        return $this->render('NumaDOADMSBundle:Default:index.html.twig',
            $stats);
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

    /**
     * Show the page with all feeds api
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function feedsAction()
    {

        return $this->render('NumaDOADMSBundle:Default:feeds.html.twig');
    }
}
