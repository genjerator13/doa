<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\PartRequest;
use Numa\DOADMSBundle\Form\PartRequestType;

/**
 * PartRequest controller.
 *
 */
class PartRequestController extends Controller
{

    /**
     * Lists all PartRequest entities.
     *
     */
    public function indexAction()
    {
        return $this->render('NumaDOADMSBundle:PartRequest:index.html.twig');
    }
    /**
     * Creates a new PartRequest entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new PartRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('partrequest'));

        }

        return $this->render('NumaDOADMSBundle:PartRequest:new.html.twig', array(
            'entity' => $entity,
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
            'action' => $this->generateUrl('partrequest_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PartRequest entity.
     *
     */
    public function newAction()
    {
        $entity = new PartRequest();
        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:PartRequest:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PartRequest entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:PartRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PartRequest entity.');
        }
        $entity->setStatus("Read");
        $em->flush();
//        dump($entity);die();

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:PartRequest:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PartRequest entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:PartRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PartRequest entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:PartRequest:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a PartRequest entity.
    *
    * @param PartRequest $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PartRequest $entity)
    {
        $form = $this->createForm(new PartRequestType(), $entity, array(
            'action' => $this->generateUrl('partrequest_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PartRequest entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:PartRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PartRequest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('partrequest_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:PartRequest:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a PartRequest entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:PartRequest')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PartRequest entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('partrequest'));
    }

    /**
     * Creates a form to delete a PartRequest entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partrequest_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * @param Request $request
     * Deactivates elected listings in datagrid on listing list page
     */
    public function massDelete2Action(Request $request) {

        $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);

        $em = $this->getDoctrine()->getManager();

        $qb = $em->getRepository("NumaDOADMSBundle:PartRequest")->delete($ids);
        die();
    }
}
