<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Form\BillingType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Billing controller.
 *
 */
class BillingController extends Controller
{

    /**
     * Lists all Billing entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findAll();

        return $this->render('NumaDOADMSBundle:Billing:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Billing entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Billing();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

//        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
//        $entity->setDealer($dealer);

        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('NumaDOADMSBundle:Customer')->find($entity->getCustomerId());

        $dealer = $customer->getDealer();
        $entity->setDealer($dealer);
        if ($form->isValid()) {

            if (!empty($entity->getItemId())) {
                $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($entity->getItemId());
                $entity->setItem($item);
            }


            $entity->setCustomer($customer);
            $em->persist($entity);
            $em->flush();
            if ($form->getClickedButton()->getName() == "submitAndPrint") {
                return $this->redirect($this->generateUrl('billing_print', array('id' => $entity->getId())));
            }
            return $this->redirect($this->generateUrl('customer_edit', array('id' => $entity->getCustomerId())));
        }

        return $this->render('NumaDOADMSBundle:Billing:new.html.twig', array(
            'entity' => $entity,
            'dealer' => $dealer,
            'customer' => $customer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Billing entity.
     *
     * @param Billing $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Billing $entity)
    {
        $form = $this->createForm(new BillingType(), $entity, array(
            'action' => $this->generateUrl('billing_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to get listing by VIN or Stock #
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function tttt()
    {
        $form = $this->createForm(new BillingType(), $entity, array(
            'action' => $this->generateUrl('billing_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Billing entity.
     *
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Billing();

        $customer = $em->getRepository('NumaDOADMSBundle:Customer')->find($id);
//        $dealer = $this->get("Numa.Dms.User")->getSignedDealer();
        $dealer = $customer->getDealer();
        $entity->setCustomerId($id);
        $maxInvoiceNr = $em->getRepository('NumaDOADMSBundle:Billing')->maxInvoiceNr($entity->getDealerId());

        if ($dealer instanceof Catalogrecords) {
            $entity->setDealer($dealer);
        }

        $form = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:Billing:new.html.twig', array(
            'entity' => $entity,
            'customer' => $customer,
            'dealer' => $dealer,
            'form' => $form->createView(),
            'max_invoive_nr' => $maxInvoiceNr,
        ));
    }

    /**
     * Displays a form to edit an existing Billing entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Billing')->find($id);
        $customer = null;

        $dealer = null;
        if (!empty($entity->getCustomerId())) {
            $customer = $em->getRepository('NumaDOADMSBundle:Customer')->find($entity->getCustomerId());
            $dealer = $customer->getDealer();
        }
//        dump($customer);
//        dump($dealer);
//        dump($entity->getItemId());
//        die();


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Billing entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('NumaDOADMSBundle:Billing:new.html.twig', array(
            'entity' => $entity,
            'customer' => $customer,
            'dealer' => $dealer,
            'item' => $entity->getItem(),
            'id' => $id,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Billing entity.
     *
     * @param Billing $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Billing $entity)
    {
        $form = $this->createForm(new BillingType(), $entity, array(
            'action' => $this->generateUrl('billing_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Billing entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Billing')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Billing entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        $customer = null;


        if ($editForm->isValid()) {
            $em->flush();
            //return $this->redirect($this->generateUrl('customer_edit',array('id'=>$entity->getCustomerId())));

            if ($editForm->getClickedButton()->getName() == "submitAndPrint") {
                return $this->redirect($this->generateUrl('billing_print', array('id' => $id)));
            }
            return $this->redirect($this->generateUrl('billing_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:Billing:new.html.twig', array(
            'entity' => $entity,
            'id' => $entity->getId(),
            'customer' => $entity->getCustomer(),
            'dealer' => $entity->getDealer(),
            'item' => $entity->getItem(),
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Billing entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        $redirect = $request->query->get('redirect');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOADMSBundle:Billing')->find($id);
        $dealer = $this->get("numa.dms.user")->getSignedDealer();
        if ((!$securityContext->isGranted('ROLE_ADMIN') && !$securityContext->isGranted('ROLE_DMS_USER')) ||
            ($securityContext->isGranted('ROLE_DMS_USER') && $dealer instanceof Catalogrecords && $entity->getDealerId() != $dealer->getId())
        ) {
            throw $this->createAccessDeniedException("Only administrator may delete this Billing.");
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Billing entity.');
        }
        if(!empty($entity->getItem())){
            $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($entity->getItem());
            if(!empty($entity->getItem()->getSaleId())){
                $sale = $em->getRepository('NumaDOADMSBundle:Sale')->find($entity->getItem()->getSaleId());
                $item->setSaleId(null);
                $em->remove($sale);
            }
        }
        $em->remove($entity);
        $em->flush();

        if ($redirect == "reports") {
            return $this->redirect($this->generateUrl('reports'));
        }
        return $this->redirect($this->generateUrl('customer'));
    }

    /**
     * Print a Billing entity.
     *
     */
    public function printAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $billing = $em->getRepository('NumaDOADMSBundle:Billing')->find($id);
        $html = $this->renderView(
            'NumaDOADMSBundle:Billing:view.html.twig',
            array('billing' => $billing,
                'id' => $billing->getId(),
                'customer' => $billing->getCustomer(),
                'dealer' => $billing->getDealer(),
                'item' => $billing->getItem())
        );

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="Billing.pdf"'
            )
        );
    }

    /**
     * Print Inside a Billing entity.
     *
     */
    public function printInsideAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $billing = $em->getRepository('NumaDOADMSBundle:Billing')->find($id);
        $html = $this->renderView(
            'NumaDOADMSBundle:Billing:view.html.twig',
            array('billing' => $billing,
                'id' => $billing->getId(),
                'customer' => $billing->getCustomer(),
                'dealer' => $billing->getDealer(),
                'item' => $billing->getItem())
        );

        $response = new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
            )
        );
        $response->headers->set('Content-Type', 'application/pdf');
        return $response;
    }


    /**
     * Creates a form to delete a Billing entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('billing_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
