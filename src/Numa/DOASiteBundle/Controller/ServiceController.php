<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Entity\ServiceRequest;
use Numa\DOADMSBundle\Form\ServiceRequestType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class ServiceController extends Controller implements DealerSiteControllerInterface{

    public $dealer;
    public $components;
    public function initializeDealer($dealer){
        $this->dealer = $dealer;
    }

    public function initializePageComponents($components){
        $this->components = $components;

    }

    public function serviceAction(Request $request) {
        $entity = new ServiceRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //check if customer exists based by its email
            $data = $form->getData();
            $email = $data->getEmail();
            $customer = $em->getRepository('NumaDOADMSBundle:Customer')->findOneBy(array('email'=>$email,'dealer_id'=>$this->dealer->getId()));

            if(empty($customer)){
                $customer = new Customer();
                $customer->setFirstName($data->getCustName());
                $customer->setLastName($data->getCustLastName());
                $customer->setEmail($email);
                $customer->setCatalogrecords($this->dealer);
                $customer->setHomePhone($data->getPhone());
                $em->persist($customer);
            }
            $entity->setCustomer($customer);
            //if($this->dealer instanceof Catalogrecords){
                $entity->setDealer($this->dealer);
            //}

            if(empty($entities)) {
                $em->persist($entity);
            }

            $em->flush();
            return $this->redirectToRoute('service_success');

        }

        return $this->render('NumaDOASiteBundle:Service:service_form.html.twig', array(
            'entity' => $entity,
            'dealer' => $this->dealer,
            'components'=>$this->components,
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
            'message'=>$message,
            'components' => $this->components,
            'dealer' => $this->dealer,
        ));
    }
}

