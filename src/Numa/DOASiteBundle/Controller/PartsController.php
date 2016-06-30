<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Entity\PartRequest;
use Numa\DOADMSBundle\Form\PartRequestType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class PartsController extends Controller implements DealerSiteControllerInterface{

    public $dealer;
    public $components;
    public function initializeDealer($dealer){
        $this->dealer = $dealer;
    }

    public function initializePageComponents($components){
        $this->components = $components;
    }
    public function partAction(Request $request) {

        $entity = new PartRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $parts = explode(",",$entity->getPartNum());
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
            $entities = array();
            if($parts>1){
                $c=0;
                foreach ($parts as $part){
                    $entities[$c] = clone $entity;
                    $entities[$c]->setPartNum($part);

                        $entities[$c]->setDealer($this->dealer);

                    $entities[$c]->setCustomer($customer);
                    $em->persist($entities[$c]);
                    $c++;
                }
            }

                $entity->setDealer($this->dealer);


            if(empty($entities)) {
                $entity->setCustomer($customer);
                $em->persist($entity);
            }

            $em->flush();

            return $this->redirectToRoute('part_success');

        }

        return $this->render('NumaDOASiteBundle:Parts:parts_form.html.twig', array(
            'entity' => $entity,
            'components' => $this->components,
            'dealer' => $this->dealer,
            'form'   => $form->createView(),
        ));
    }



//    public function createAction(Request $request)
//    {
//        $entity = new PartRequest();
//        $form = $this->createCreateForm($entity);
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($entity);
//            $em->flush();
//            return $this->redirect($this->generateUrl('partrequest'));
//
//        }
//
//        return $this->render('NumaDOADMSBundle:PartRequest:new.html.twig', array(
//            'entity' => $entity,
//            'form'   => $form->createView(),
//        ));
//    }

    /**
     * Creates a form to create a PartRequest entity.
     *
     * @param PartRequest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PartRequest $entity)
    {
        $form = $this->createForm(new PartRequestType(), $entity, array(
            'action' => $this->generateUrl('part_form'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Send'));

        return $form;
    }
    public function successAction(){
        $message = "Success";

        return $this->render('NumaDOASiteBundle:Parts:parts_success.html.twig', array(
            'message'=>$message,
            'components' => $this->components,
            'dealer' => $this->dealer,
        ));
    }
}

