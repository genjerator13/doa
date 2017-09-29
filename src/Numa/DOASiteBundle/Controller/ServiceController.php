<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Entity\ServiceRequest;
use Numa\DOADMSBundle\Form\ServiceRequestType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ServiceController extends Controller implements DealerSiteControllerInterface
{

    public $dealer;

    public function initializeDealer($dealer)
    {
        $this->dealer = $dealer;
    }


    public function serviceAction(Request $request)
    {
        $entity = new ServiceRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $form = $this->get('google.captcha')->proccessGoogleCaptcha($request, $form);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $this->get("Numa.DMSUtils")->attachCustomerByEmail($entity, $this->dealer, $entity->getEmail(), $entity->getCustName(), $entity->getCustLastName(), $entity->getPhone());

            $entity->setDealer($this->dealer);

            if (empty($entities)) {
                $em->persist($entity);
            }

            $em->flush();
            return $this->redirectToRoute('service_success');

        }

        return $this->render('NumaDOASiteBundle:siteForms/Service:service_form.html.twig', array(
            'entity' => $entity,
            'dealer' => $this->dealer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ServiceRequest entity.
     *
     * @param ServiceRequest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ServiceRequest $entity)
    {
        $form = $this->createForm(new ServiceRequestType(), $entity, array(
            'action' => $this->generateUrl('service_form'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Send'));

        return $form;
    }

    public function successAction()
    {
        $message = "Success";

        return $this->render('NumaDOASiteBundle:siteForms:success.html.twig', array(
            'path' => 'service_form',
            'message' => $message,
            'dealer' => $this->dealer,
        ));
    }
}

