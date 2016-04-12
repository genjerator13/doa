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
        $totalListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1,0,0,$dealer);
        $totalViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1,0,0,$dealer);

        $totalCarListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1,0,1,$dealer);
        $totalCarViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1,0,1,$dealer);

        $totalMarineListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1,0,2,$dealer);
        $totalMarineViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1,0,2,$dealer);

        $totalMotoListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1,0,3,$dealer);
        $totalMotoViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1,0,3,$dealer);

        $totalRvsListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1,0,4,$dealer);
        $totalRvsViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1,0,4,$dealer);

        $totalAgsListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1,0,13,$dealer);
        $totalAgsViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1,0,13,$dealer);

        return $this->render('NumaDOADMSBundle:Default:index.html.twig',
            array(
                'totalListings' => $totalListings,
                'totalViews' => $totalViews,
                'totalCarListings'=>$totalCarListings,
                'totalCarViews'=>$totalCarViews,
                'totalMotoListings'=>$totalMotoListings,
                'totalMotoViews'=>$totalMotoViews,
                'totalMarineListings'=>$totalMarineListings,
                'totalMarineViews'=>$totalMarineViews,
                'totalRvsListings'=>$totalRvsListings,
                'totalRvsViews'=>$totalRvsViews,
                'totalAgsListings'=>$totalAgsListings,
                'totalAgsViews'=>$totalAgsViews,
            ));
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
