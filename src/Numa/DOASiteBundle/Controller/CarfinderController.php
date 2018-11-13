<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Entity\PartRequest;
use Numa\DOADMSBundle\Entity\SaveSearch;
use Numa\DOADMSBundle\Form\PartRequestType;
use Numa\DOADMSBundle\Form\SaveSearchType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CarfinderController extends Controller implements DealerSiteControllerInterface
{

    public $dealer;

    public function initializeDealer($dealer)
    {
        $this->dealer = $dealer;
    }

    private
    function createSaveSearchForm(SaveSearch $entity)
    {
        $form = $this->createForm(new SaveSearchType(), $entity, array(
            'method' => 'POST',
            'attr' => array('id' => "contasavesearch_form"),
        ));
        $form->add('submit', 'submit', array('label' => 'Send'));
        return $form;
    }

    public function saveSearchAction(Request $request)
    {
        $savesearch = new SaveSearch();
        $form = $this->createSaveSearchForm($savesearch);
        $form->handleRequest($request);
        $form = $this->get('google.captcha')->proccessGoogleCaptcha($request, $form);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $savesearch = $form->getData();
            if ($savesearch instanceof SaveSearch) {

            }
            $savesearch->setDealer($this->dealer);
            $this->container->get('Numa.DMSUtils')->attachCustomerByEmail($savesearch, $savesearch->getDealer(), $savesearch->getEmail(), $savesearch->getCustName(), "", $savesearch->getPhone());

            $em->persist($savesearch);
            $em->flush();
            return $this->redirectToRoute("carfinder_success", array('carfinder' => $savesearch->getId()));

        }

        $response = $this->render('NumaDOASiteBundle:Carfinder:saveSearch.html.twig', array(
            'form' => $form->createView(),
            'dealer' => $this->dealer,
        ));
        return $response;
        //return $this->render('NumaDOASiteBundle:Default:contactus.html.twig', array('dealer'=>$this->dealer ));
    }

    public function carfinderSuccessAction(SaveSearch $carfinder)
    {

        $response = $this->render('NumaDOASiteBundle:Carfinder:success.html.twig', array(
            'carfinder' => $carfinder,
            'dealer' => $this->dealer,
        ));
        return $response;
    }
}

