<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\DMSSetting;
use Numa\DOADMSBundle\Form\DMSSettingType;

/**
 * DMSSetting controller.
 *
 */
class DMSSettingController extends Controller
{

    /**
     * Lists all DMSSetting entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOADMSBundle:DMSSetting')->findAll();

        return $this->render('NumaDOADMSBundle:DMSSetting:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new DMSSetting entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DMSSetting();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('dmssetting'));

        }

        return $this->render('NumaDOADMSBundle:DMSSetting:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DMSSetting entity.
     *
     * @param DMSSetting $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DMSSetting $entity)
    {
        $form = $this->createForm(new DMSSettingType(), $entity, array(
            'action' => $this->generateUrl('dmssetting_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DMSSetting entity.
     *
     */
    public function newAction()
    {
        $entity = new DMSSetting();
        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:DMSSetting:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DMSSetting entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:DMSSetting')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DMSSetting entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:DMSSetting:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DMSSetting entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:DMSSetting')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DMSSetting entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:DMSSetting:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a DMSSetting entity.
    *
    * @param DMSSetting $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DMSSetting $entity)
    {
        $form = $this->createForm(new DMSSettingType(), $entity, array(
            'action' => $this->generateUrl('dmssetting_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DMSSetting entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:DMSSetting')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DMSSetting entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('dmssetting_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:DMSSetting:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DMSSetting entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:DMSSetting')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DMSSetting entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('dmssetting'));
    }

    /**
     * Creates a form to delete a DMSSetting entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dmssetting_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
