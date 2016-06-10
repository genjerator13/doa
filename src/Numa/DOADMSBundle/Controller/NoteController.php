<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\Note;
use Numa\DOADMSBundle\Form\NoteType;

/**
 * Note controller.
 *
 */
class NoteController extends Controller
{

    /**
     * Lists all Note entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOADMSBundle:Note')->findAll();

        return $this->render('NumaDOADMSBundle:Note:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Note entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Note();
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

        return $this->render('NumaDOADMSBundle:Note:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Note entity.
     *
     * @param Note $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Note $entity)
    {
        $form = $this->createForm(new NoteType(), $entity, array(
            'action' => $this->generateUrl('note_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Note entity.
     *
     */
    public function newAction($id)
    {


        $entity = new Note();
        $entity->setCustomerId($id);


        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:Note:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Note entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Note')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Note entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Note:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Note entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Note')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Note entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Note:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Note entity.
    *
    * @param Note $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Note $entity)
    {
        $form = $this->createForm(new NoteType(), $entity, array(
            'action' => $this->generateUrl('note_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Note entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Note')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Note entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('note_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:Note:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Note entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:Note')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Note entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('note'));
    }

    /**
     * Creates a form to delete a Note entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('note_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Lists all Notes entities.
     *
     */
    public function notesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOADMSBundle:Note')->findAll();

        return $this->render('NumaDOADMSBundle:Customer:notes.html.twig', array(
            'entities' => $entities,
        ));
    }
}
