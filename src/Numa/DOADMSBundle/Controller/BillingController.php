<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Form\BillingType;

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

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $customer = $em->getRepository('NumaDOADMSBundle:Customer')->find($entity->getCustomerId());
            $user = $this->get('security.token_storage')->getToken()->getUser();
            if($user instanceof Catalogrecords){
                $entity->setDealer($user);
            }

            $entity->setCustomer($customer);
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('customer_edit',array('id'=>$entity->getCustomerId())));
        }

        return $this->render('NumaDOADMSBundle:Billing:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
        $dealer = $customer->getDealer();
        $entity->setCustomerId($id);

        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:Billing:new.html.twig', array(
            'entity' => $entity,
            'customer' => $customer,
            'dealer' => $dealer,
            'form'   => $form->createView(),

        ));
    }

    /**
     * Finds and displays a Billing entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Billing')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Billing entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Billing:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
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
        $customer = $em->getRepository('NumaDOADMSBundle:Customer')->find($entity->getCustomerId());
        $dealer = $customer->getDealer();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Billing entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Billing:new.html.twig', array(
            'entity'      => $entity,
            'customer'    => $customer,
            'dealer'    => $dealer,
            'form'   => $editForm->createView(),
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

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $customer = $em->getRepository('NumaDOADMSBundle:Customer')->find($entity->getCustomerId());
        $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($entity->getItemId());

        $dealer = $customer->getDealer();

        if ($editForm->isValid()) {
            $em->flush();
            //return $this->redirect($this->generateUrl('customer_edit',array('id'=>$entity->getCustomerId())));
            return $this->redirect($this->generateUrl('billing_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:Billing:new.html.twig', array(
            'entity'      => $entity,
            'customer'      => $customer,
            'dealer'      => $dealer,
            'item'      => $item,
            'form'   => $editForm->createView(),

        ));
    }
    /**
     * Deletes a Billing entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:Billing')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Billing entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('billing'));
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
            ->getForm()
        ;
    }
}
