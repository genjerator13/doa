<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOADMSBundle\Form\FinanceType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\Finance;
use Numa\DOADMSBundle\Form\ServiceRequestType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FinanceController extends Controller implements DealerSiteControllerInterface
{

    public $dealer;

    public function initializeDealer($dealer)
    {
        $this->dealer = $dealer;

    }


    public function newAction(Request $request)
    {


        $entity = new Finance();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

//            if (empty($customer)) {
//                $customer = new Customer();
//                $customer->setFirstName($data->getCustName());
//                $customer->setLastName($data->getCustLastName());
//                $customer->setEmail($email);
//                $customer->setCatalogrecords($this->dealer);
//                $customer->setHomePhone($data->getPhone());
//                $em->persist($customer);
//
//            }
            $entities = array();

            $entity->setDealer($this->dealer);


            if (empty($entities)) {
//                $entity->setCustomer($customer);
                $em->persist($entity);
            }

            $em->flush();

            return $this->redirectToRoute('finance_success');
        }
        return $this->render('NumaDOADMSBundle:Finance:new.html.twig', array(
            'form' => $form->createView(),
            'dealer' => $this->dealer,
        ));
    }
    private function createCreateForm(Finance $entity)
    {
        $form = $this->createForm(new FinanceType(), $entity, array(
            'action' => $this->generateUrl('finance_form'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Send'));

        return $form;
    }
    public function successAction(){
        $message = "Success";

        return $this->render('NumaDOASiteBundle:Finance:finance_success.html.twig', array(
            'message'=>$message,
            'dealer' => $this->dealer,
        ));
    }
}
