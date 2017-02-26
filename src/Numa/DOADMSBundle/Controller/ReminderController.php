<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\Reminder;
use Numa\DOADMSBundle\Form\ReminderType;

/**
 * Reminder controller.
 *
 */
class ReminderController extends Controller
{

    /**
     * Lists all Reminder entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $entities = $em->getRepository('NumaDOADMSBundle:Reminder')->findByCustomerDealer($dealer);

        return $this->render('NumaDOADMSBundle:Reminder:index_full.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Reminder entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Reminder();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $customer = $em->getRepository('NumaDOADMSBundle:Customer')->find($entity->getCustomerId());
            $entity->setCustomer($customer);

            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('customer_edit', array('id'=>$entity->getCustomerId())));

        }

        return $this->render('NumaDOADMSBundle:Reminder:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Reminder entity.
     *
     * @param Reminder $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Reminder $entity)
    {
        $form = $this->createForm(new ReminderType(), $entity, array(
            'action' => $this->generateUrl('reminder_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Reminder entity.
     *
     */
    public function newAction($id)
    {
        $entity = new Reminder();
        $entity->setCustomerId($id);


        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:Reminder:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Reminder entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Reminder')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reminder entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Reminder:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Reminder entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Reminder')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reminder entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Reminder:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Reminder entity.
    *
    * @param Reminder $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Reminder $entity)
    {
        $form = $this->createForm(new ReminderType(), $entity, array(
            'action' => $this->generateUrl('reminder_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Reminder entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Reminder')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reminder entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->addFlash("success", "Reminder: #" . $entity->getId() . " successfully updated.");

            return $this->redirect($this->generateUrl('reminder_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:Reminder:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Reminder entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOADMSBundle:Reminder')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reminder entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('reminder'));
    }

    /**
     * Creates a form to delete a Reminder entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reminder_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
