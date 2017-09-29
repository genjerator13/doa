<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOADMSBundle\Entity\Leasing;
use Numa\DOADMSBundle\Form\LeasingType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class LeasingController extends Controller implements DealerSiteControllerInterface
{

    public $dealer;

    public function initializeDealer($dealer)
    {
        $this->dealer = $dealer;

    }


    public function newAction(Request $request)
    {
        $entity = new Leasing();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $form = $this->get('google.captcha')->proccessGoogleCaptcha($request, $form);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $this->get("Numa.DMSUtils")->attachCustomerByEmail($entity, $this->dealer, $entity->getEmail(), $entity->getCustFirstName(), $entity->getCustLastName(), $entity->getDayPhone());

            $entity->setDealer($this->dealer);


            if (empty($entities)) {
                $em->persist($entity);
            }

            $em->flush();

            return $this->redirectToRoute('leasing_success');
        }
        return $this->render('NumaDOASiteBundle:siteForms/Leasing:leasing_form.html.twig', array(
            'form' => $form->createView(),
            'dealer' => $this->dealer,
        ));
    }

    private function createCreateForm(Leasing $entity)
    {
        $form = $this->createForm(new LeasingType(), $entity, array(
            'action' => $this->generateUrl('leasing_form'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Send'));

        return $form;
    }

    public function successAction()
    {
        $message = "Success";

        return $this->render('NumaDOASiteBundle:siteForms:success.html.twig', array(
            'path' => 'leasing_form',
            'message' => $message,
            'dealer' => $this->dealer,
        ));
    }
}
