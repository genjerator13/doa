<?php

namespace Numa\DOAAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Form\CatalogrecordsType;

/**
 * Catalogrecords controller.
 *
 */
class CatalogrecordsController extends Controller
{

    /**
     * Lists all Catalogrecords entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findAll();

        return $this->render('NumaDOAAdminBundle:Catalogrecords:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Catalogrecords entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Catalogrecords();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('catalogs_show', array('id' => $entity->getId())));
        }

        return $this->render('NumaDOAAdminBundle:Catalogrecords:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Catalogrecords entity.
    *
    * @param Catalogrecords $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Catalogrecords $entity)
    {
        $form = $this->createForm(new CatalogrecordsType(), $entity, array(
            'action' => $this->generateUrl('catalogs_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create','attr' => array('class' => 'btn',)));

        return $form;
    }

    /**
     * Displays a form to create a new Catalogrecords entity.
     *
     */
    public function newAction()
    {
        $entity = new Catalogrecords();
        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOAAdminBundle:Catalogrecords:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Catalogrecords entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogrecords entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Catalogrecords:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Catalogrecords entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogrecords entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Catalogrecords:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Catalogrecords entity.
    *
    * @param Catalogrecords $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Catalogrecords $entity)
    {
        $form = $this->createForm(new CatalogrecordsType(), $entity, array(
            'action' => $this->generateUrl('catalogs_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary left',)));

        return $form;
    }
    /**
     * Edits an existing Catalogrecords entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogrecords entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $em->flush();
            return $this->redirect($this->generateUrl('catalogs_edit', array('id' => $id)));
        }

        return $this->render('NumaDOAAdminBundle:Catalogrecords:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Catalogrecords entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Catalogrecords entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('catalogs'));
    }

    /**
     * Creates a form to delete a Catalogrecords entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('catalogs_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete','attr' => array('class' => 'btn btn-danger left',)))
            ->getForm()
        ;
    }
}
