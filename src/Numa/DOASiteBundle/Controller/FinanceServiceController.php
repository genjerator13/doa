<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOADMSBundle\Entity\FinanceService;
use Numa\DOADMSBundle\Form\FinanceServiceType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class FinanceServiceController extends Controller implements DealerSiteControllerInterface
{

    public $dealer;

    public function initializeDealer($dealer)
    {
        $this->dealer = $dealer;

    }


    public function newAction(Request $request)
    {


        $entity = new FinanceService();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $form = $this->get('google.captcha')->proccessGoogleCaptcha($request, $form);

        if ($form->isValid()) {

            $em   = $this->getDoctrine()->getManager();

            $this->get("Numa.DMSUtils")->attachCustomerByEmail($entity,$this->dealer,$entity->getEmail(),$entity->getCustName(),$entity->getCustLastName(),$entity->getDayPhone());

            $entity->setDealer($this->dealer);


            if (empty($entities)) {
                $em->persist($entity);
            }

            $em->flush();

            return $this->redirectToRoute('finance_service_success');
        }
        return $this->render('NumaDOASiteBundle:siteForms/FinanceService:finance_service_form.html.twig', array(
            'form' => $form->createView(),
            'dealer' => $this->dealer,
        ));
    }
    private function createCreateForm(FinanceService $entity)
    {
        $form = $this->createForm(new FinanceServiceType(), $entity, array(
            'action' => $this->generateUrl('finance_service_form'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Send'));

        return $form;
    }
    public function successAction(){
        $message = "Success";

        return $this->render('NumaDOASiteBundle:siteForms:success.html.twig', array(
            'path'=>'finance_service_form',
            'message'=>$message,
            'dealer' => $this->dealer,
        ));
    }
}
