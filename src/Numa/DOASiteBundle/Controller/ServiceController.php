<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Entity\ServiceRequest;
use Numa\DOADMSBundle\Form\ServiceRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ServiceController extends Controller {

    public function serviceAction(Request $request) {

        $entity = new ServiceRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $session = $request->getSession();
            $dealer_id = $session->get('dealer_id');

            //check if customer exists based by its email
            $data = $form->getData();
            $email = $data->getEmail();

            $customer = $em->getRepository('NumaDOADMSBundle:Customer')->findOneBy(array('email'=>$email,'dealer_id'=>$dealer_id));

            $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($dealer_id);
            if(empty($customer)){
                $customer = new Customer();
                $customer->setFirstName($data->getCustName());
                $customer->setLastName($data->getCustLastName());
                $customer->setEmail($email);
                $customer->setCatalogrecords($dealer);
                $customer->setHomePhone($data->getPhone());
                $em->persist($customer);

            }

            $entity->setCustomer($customer);



            if(!empty($dealer_id)){
                $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($dealer_id);
                $entity->setDealer($dealer);
            }

            if(empty($entities)) {
                $em->persist($entity);
            }
            $em->flush();

            return $this->redirectToRoute('service_success');

        }

        return $this->render('NumaDOASiteBundle:Service:service_form.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
    public function successAction(){
        $message = "Success";

        return $this->render('NumaDOASiteBundle:Service:service_success.html.twig', array(
            'message'=>$message
        ));
    }
}

