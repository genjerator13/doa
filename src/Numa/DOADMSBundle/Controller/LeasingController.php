<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\Leasing;
use Numa\DOADMSBundle\Form\LeasingType;

/**
 * Leasing controller.
 *
 */
class LeasingController extends Controller
{

    /**
     * Lists all Leasing entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOADMSBundle:Leasing')->findAll();

        return $this->render('NumaDOADMSBundle:Leasing:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Leasing entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Leasing();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('leasing'));

        }

        return $this->render('NumaDOADMSBundle:Leasing:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Leasing entity.
     *
     * @param Leasing $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Leasing $entity)
    {
        $form = $this->createForm(new LeasingType(), $entity, array(
            'action' => $this->generateUrl('leasing_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Leasing entity.
     *
     */
    public function newAction()
    {
        $entity = new Leasing();
        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:Leasing:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Leasing entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Leasing')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Leasing entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Leasing:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Leasing entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Leasing')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Leasing entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Leasing:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Leasing entity.
    *
    * @param Leasing $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Leasing $entity)
    {
        $form = $this->createForm(new LeasingType(), $entity, array(
            'action' => $this->generateUrl('leasing_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Leasing entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Leasing')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Leasing entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('leasing_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:Leasing:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Leasing entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:Leasing')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Leasing entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('leasing'));
    }

    /**
     * Creates a form to delete a Leasing entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('leasing_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
