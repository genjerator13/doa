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
        $em = $this->getDoctrine()->getManager();
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer()->getId();
        $entities = $em->getRepository('NumaDOADMSBundle:ListingForm')->getAllFormsByDealer($dealer,10,"read");
        $pages = $em->getRepository('NumaDOAModuleBundle:Page')->findBy(array('dealer_id' => $dealer));
        $customers = $em->getRepository('NumaDOADMSBundle:Customer')->findByDealerId($dealer);
        $components = $em->getRepository('NumaDOADMSBundle:DealerComponent')->findBy(array('dealer_id' => $dealer));

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {$dealer = $this->get('Numa.Dms.User')->getSignedUser()->getId();
            $pages = $em->getRepository('NumaDOAModuleBundle:Page')->findBy(array('dealer_id' => null));
            $customers = $em->getRepository('NumaDOADMSBundle:Customer')->findAllNotDeleted();
        }

        return $this->render('NumaDOADMSBundle:Default:index.html.twig', array(
            'entities' => $entities,
            'stats' => $stats,
            'pages' => count($pages),
            'customers' => count($customers)));
    }
    public function notificationsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $dealer = $this->get('Numa.Dms.User')->getSignedUser()->getId();
        $webForms = $em->getRepository('NumaDOADMSBundle:ListingForm')->getAllFormsByDealer($dealer,10,"read");

        $webFormsCount = $em->getRepository('NumaDOADMSBundle:ListingForm')->getAllFormsByDealer($dealer,10000,"read");

        return $this->render('NumaDOADMSBundle:Default:nortifications.html.twig', array('webforms' => $webForms,"count"=>count($webFormsCount)));

    }

    public function dealerChooserAction(Request $request)
    {
        $dealer_id = $request->get('dealer');
        if (!empty($dealer_id)) {
            $dealer = $this->get('doctrine.orm.entity_manager')->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($dealer_id);
            $session = $this->get('session');
            $session->remove('dms_dealer_id');
            $session->remove('dms_dealer_name');
            if ($dealer instanceof Catalogrecords) {
                $session->set('dms_dealer_id', $dealer->getId());
                $session->set('dms_dealer_name', $dealer->getName());
            }
            return $this->redirectToRoute('dms_home');

        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $dealers = $this->get('doctrine.orm.entity_manager')->getRepository('NumaDOAAdminBundle:Catalogrecords')->findAll();
            return $this->render('NumaDOADMSBundle::dealerChooser.html.twig', array('dealers' => $dealers));
        }
        return $this->render('NumaDOADMSBundle::dealerChooser.html.twig');
    }

    public function themesAction(Request $request){
        $ctheme="Default";

        $dealer = $this->get('Numa.Dms.User')->getSignedUser();

        if($dealer instanceof Catalogrecords && !empty($dealer->getSiteTheme())){
            $ctheme = $dealer->getSiteTheme();
        }

        return $this->render('NumaDOADMSBundle:Themes:themes.html.twig',array('theme'=>$ctheme,"dealer"=>$dealer));
    }
    public function changeThemeAction(Request $request){
        $theme = $request->get('theme');
        $dealer = $this->get('Numa.Dms.User')->getSignedUser();

        if($dealer instanceof Catalogrecords){
            $dealer->setSiteTheme($theme);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            //clear the cache
            $this->get('Numa.DMSUtils')->clearCache();
        }

        return $this->render('NumaDOADMSBundle:Themes:themes.html.twig',array('theme'=>$theme,"dealer"=>$dealer));
    }

    /**
     * Show the page with all feeds api
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function feedsAction()
    {
        $session = $this->get('session');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $dealer = null;
        if ($user instanceof Catalogrecords) {
            $dealer = $user;
        } elseif (!empty($session->get('dms_dealer_id'))) {
            $dealer_id = $session->get('dms_dealer_id');
            $em = $this->getDoctrine()->getManager();
            $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($dealer_id);
        }
        return $this->render('NumaDOADMSBundle:Default:feeds.html.twig', array('dealer' => $dealer));
    }
}
