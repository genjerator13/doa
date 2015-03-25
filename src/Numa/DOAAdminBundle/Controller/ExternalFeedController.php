<?php

namespace Numa\DOAAdminBundle\Controller;

use Guzzle\Http\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Lib\Autonet as Autonet;
use Symfony\Component\HttpFoundation\Response;

/**
 * Item controller.
 *
 */
class ExternalFeedController extends Controller {

    public function indexAction() {
        $dealerForm = $this->dealerForm();
        return $this->render('NumaDOAAdminBundle:ExternalFeeds:index.html.twig', array('dealerForm' => $dealerForm->createView()));
    }

    public function dealerForm($request = null) {
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
                ->add('dealer_id', 'text', array('label' => 'Please enter the dealer ID'))
                ->getForm();

        //if ($request->isMethod('POST')) {
        //$form->bind($request);
        // data is an array with "name", "email", and "message" keys
        //$data = $form->getData();
        //}
        return $form;
    }

    public function allDealersAction() {
        $autonet = new Autonet();
        //$autonet->allDealersList();
        $dealers = $autonet->parseAlldealers();
        return $this->render('NumaDOAAdminBundle:ExternalFeeds:allDealers.html.twig', array('dealers' => $dealers));
    }

    public function dealerAction($dealer_id) {
        $autonet = new Autonet();
        $xml = $autonet->parseDealerVehicles($dealer_id);
        $response = new Response();
        $response->setContent($this->renderView('NumaDOAAdminBundle:ExternalFeeds:dealer.html.twig', array('XML' => $xml)));
        $response->headers->set('Content-Type', 'text/xml');
        $response->headers->set('Content-Disposition', 'attachment; filename="dealerFeed'.$dealer_id.'.xml"');
        return $response;
    }

    // ... render the form
}
