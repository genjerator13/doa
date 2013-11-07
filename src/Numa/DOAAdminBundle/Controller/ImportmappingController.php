<?php

namespace Numa\DOAAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\Importmapping;
use Numa\DOAAdminBundle\Entity\Importmappings;
use Numa\DOAAdminBundle\Form\ImportmappingType;
use Numa\DOAAdminBundle\Form\ImportmappingRowType;

/**
 * Importmapping controller.
 *
 */
class ImportmappingController extends Controller {

    /**
     * Lists all Importmapping entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOAAdminBundle:Importmapping')->findAll();

        return $this->render('NumaDOAAdminBundle:Importmapping:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Importmapping entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Importmapping();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('import_mapping_show', array('id' => $entity->getId())));
        }

        return $this->render('NumaDOAAdminBundle:Importmapping:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Importmapping entity.
     *
     * @param Importmapping $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Importmapping $entity) {
        $form = $this->createForm(new ImportmappingType(), $entity, array(
            'action' => $this->generateUrl('import_mapping_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Importmapping entity.
     *
     */
    public function newAction() {
        $entity = new Importmapping();
        $form = $this->createCreateForm($entity);

        return $this->render('NumaDOAAdminBundle:Importmapping:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Importmapping entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Importmapping')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Importmapping entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Importmapping:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Importmapping entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Importmapping')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Importmapping entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Importmapping:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Importmapping entity.
     *
     * @param Importmapping $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Importmapping $entity) {
        $form = $this->createForm(new ImportmappingType(), $entity, array(
            'action' => $this->generateUrl('import_mapping_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Importmapping entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Importmapping')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Importmapping entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('import_mapping_edit', array('id' => $id)));
        }

        return $this->render('NumaDOAAdminBundle:Importmapping:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Importmapping entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOAAdminBundle:Importmapping')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Importmapping entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('import_mapping'));
    }

    /**
     * Creates a form to delete a Importmapping entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('import_mapping_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    public function feedAction(Request $request = null, $id) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOAAdminBundle:Importmapping')->findBy(array('feed_sid' => $id));
        $feed = $em->getRepository('NumaDOAAdminBundle:Importfeed')->findOneById($id);

        $importmappingCollection = new Importmappings();

        foreach ($entities as $entity) {
            $importmappingCollection->addImportmappingRow($entity);
        }

        $collection = $this->createForm(new ImportmappingRowType(), $importmappingCollection);
        $collection->add('feed_sid', 'hidden', array(
            'data' => $id));
        $collection->handleRequest($request);

        if ($collection->isValid()) {

            foreach ($collection->getData()->getImportmappingRow() as $entity) {
                $entity->setFeedSid($id);
                $em->persist($entity);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('importfeed'));
        }

        return $this->render('NumaDOAAdminBundle:Importmapping:feed.html.twig', array(
                    'form' => $collection->createView(),
                    'feed' => $feed,
        ));
    }
    
    public function fetchAction(Request $request = null, $id) {
        return $this->render('NumaDOAAdminBundle:Importmapping:fetch.html.twig', array(

        ));
    }

}
