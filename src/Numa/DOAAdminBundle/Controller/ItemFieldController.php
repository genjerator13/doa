<?php

namespace Numa\DOAAdminBundle\Controller;

use Numa\DOAAdminBundle\Entity\Item;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\ItemField;
use Numa\DOAAdminBundle\Form\ItemFieldType;

/**
 * ItemField controller.
 *
 */
class ItemFieldController extends Controller
{

    /**
     * Lists all ItemField entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOAAdminBundle:ItemField')->findAll();

        return $this->render('NumaDOAAdminBundle:ItemField:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new ItemField entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ItemField();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('itemfield_show', array('id' => $entity->getId())));
        }

        return $this->render('NumaDOAAdminBundle:ItemField:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ItemField entity.
     *
     * @param ItemField $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ItemField $entity)
    {
        $form = $this->createForm(new ItemFieldType(), $entity, array(
            'action' => $this->generateUrl('itemfield_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ItemField entity.
     *
     */
    public function newAction()
    {
        $entity = new ItemField();
        $form = $this->createCreateForm($entity);

        return $this->render('NumaDOAAdminBundle:ItemField:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ItemField entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:ItemField')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ItemField entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:ItemField:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing ItemField entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:ItemField')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ItemField entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:ItemField:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a ItemField entity.
     *
     * @param ItemField $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ItemField $entity)
    {
        $form = $this->createForm(new ItemFieldType(), $entity, array(
            'action' => $this->generateUrl('itemfield_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing ItemField entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:ItemField')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ItemField entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('itemfield_edit', array('id' => $id)));
        }

        return $this->render('NumaDOAAdminBundle:ItemField:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ItemField entity.
     *
     */
    public function deleteAction(Request $request)
    {

        $rids = $request->request->all();
        $ids = array();
        foreach ($rids as $idx) {
            $ids[] = $idx;

        }

        $em = $this->getDoctrine()->getManager();
        foreach ($ids as $id) {
            $entity = $em->getRepository('NumaDOAAdminBundle:ItemField')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ItemField entity.');
            }
            $em->remove($entity);

        }

        $em->flush();

        if ($entity instanceof ItemField) {
            return false;
        }
        $item = $entity->getItem();
        if ($item instanceof Item) {
            //$item->setCoverPhoto($item->getCoverImageSrc());
            $em->getRepository('NumaDOAAdminBundle:Item')->generateCoverPhotos();
        }
        $em->flush();
        die();
    }

    /**
     * Creates a form to delete a ItemField entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    public function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('itemfield_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

}
