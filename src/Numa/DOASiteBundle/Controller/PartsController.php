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

    public function initializeDealer($dealer){
        $this->dealer = $dealer;
    }

    public function partAction(Request $request) {

        $entity = new PartRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $form = $this->get('google.captcha')->proccessGoogleCaptcha($request, $form);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $parts = explode(",",$entity->getPartNum());

            $this->get("Numa.DMSUtils")->attachCustomerByEmail($entity,$this->dealer,$entity->getEmail(),$entity->getCustName(),$entity->getCustLastName(),$entity->getPhone());

            $entities = array();
            if($parts>1){
                $c=0;
                foreach ($parts as $part){
                    $entities[$c] = clone $entity;
                    $entities[$c]->setPartNum($part);

                        $entities[$c]->setDealer($this->dealer);

                    $em->persist($entities[$c]);
                    $c++;
                }
            }

                $entity->setDealer($this->dealer);


            if(empty($entities)) {
                $em->persist($entity);
            }

            $em->flush();

            return $this->redirectToRoute('part_success');

        }

        return $this->render('NumaDOASiteBundle:siteForms/Parts:parts_form.html.twig', array(
            'entity' => $entity,
            'dealer' => $this->dealer,
            'form'   => $form->createView(),
        ));
    }

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

        return $this->render('NumaDOASiteBundle:siteForms:success.html.twig', array(
            'path'=>'part_form',
            'message'=>$message,
            'dealer' => $this->dealer,
        ));
    }
}

