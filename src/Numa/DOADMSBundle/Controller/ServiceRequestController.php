<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\ServiceRequest;
use Numa\DOADMSBundle\Form\ServiceRequestType;

/**
 * ServiceRequest controller.
 *
 */
class ServiceRequestController extends Controller
{

    /**
     * Lists all ServiceRequest entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOADMSBundle:ServiceRequest')->findAll();

        return $this->render('NumaDOADMSBundle:ServiceRequest:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ServiceRequest entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ServiceRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('servicerequest'));

        }

        return $this->render('NumaDOADMSBundle:ServiceRequest:new.html.twig', array(
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
            'action' => $this->generateUrl('servicerequest_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ServiceRequest entity.
     *
     */
    public function newAction()
    {
        $entity = new ServiceRequest();
        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:ServiceRequest:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ServiceRequest entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:ServiceRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ServiceRequest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:ServiceRequest:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ServiceRequest entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:ServiceRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ServiceRequest entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:ServiceRequest:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ServiceRequest entity.
    *
    * @param ServiceRequest $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ServiceRequest $entity)
    {
        $form = $this->createForm(new ServiceRequestType(), $entity, array(
            'action' => $this->generateUrl('servicerequest_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ServiceRequest entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:ServiceRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ServiceRequest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('servicerequest_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:ServiceRequest:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ServiceRequest entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:ServiceRequest')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ServiceRequest entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('servicerequest'));
    }

    /**
     * Creates a form to delete a ServiceRequest entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('servicerequest_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
