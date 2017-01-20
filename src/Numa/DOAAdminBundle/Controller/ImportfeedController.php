<?php

namespace Numa\DOAAdminBundle\Controller;

use Numa\DOADMSBundle\Lib\DashboardDMSControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\Importfeed;
use Numa\DOAAdminBundle\Form\ImportfeedType;

/**
 * Importfeed controller.
 *
 */
class ImportfeedController extends Controller implements DashboardDMSControllerInterface
{

    public $dashboard;

    public function initializeDashboard($dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     * Lists all Importfeed entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOAAdminBundle:Importfeed')->findAll();

        return $this->render('NumaDOAAdminBundle:Importfeed:index.html.twig', array(
            'entities' => $entities,
            'dashboard' => $this->dashboard,
        ));
    }

    /**
     * Creates a new Importfeed entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Importfeed();
        $dashboard = $request->get('_dashboard');
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->upload();
            $em->persist($entity);
            $em->flush();
            $this->addFlash("success", "Feed #" . $entity->getId() . " successfully created.");
            $redirect = 'importfeed';
            if ($dashboard == 'DMS') {
                $redirect = 'dms_importfeed';
            }
            return $this->redirect($this->generateUrl($redirect));
        }

        return $this->render('NumaDOAAdminBundle:Importfeed:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'dashboard' => $this->dashboard,
        ));
    }

    /**
     * Creates a form to create a Importfeed entity.
     *
     * @param Importfeed $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Importfeed $entity)
    {
        $action = 'importfeed_create';
        if (!empty($this->dashboard)) {
            $action = 'dms_importfeed_create';
        }
        $form = $this->createForm(new ImportfeedType(), $entity, array(
            'action' => $this->generateUrl($action),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary left',)));

        return $form;
    }

    /**
     * Displays a form to create a new Importfeed entity.
     *
     */
    public function newAction(Request $request)
    {
        $entity = new Importfeed();
        $dashboard = $request->get('_dashboard');
        $form = $this->createCreateForm($entity);

        return $this->render('NumaDOAAdminBundle:Importfeed:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'dashboard' => $dashboard,
        ));
    }

    /**
     * Finds and displays a Importfeed entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Importfeed')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Importfeed entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Importfeed:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Importfeed entity.
     *
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Importfeed')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Importfeed entity.');
        }

        $editForm = $this->createEditForm($entity, $this->dashboard);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Importfeed:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'dashboard' => $this->dashboard,
        ));
    }

    /**
     * Creates a form to edit a Importfeed entity.
     *
     * @param Importfeed $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Importfeed $entity)
    {
        $action = 'importfeed_update';

        if (strtoupper($this->dashboard) == 'DMS') {
            $action = 'dms_importfeed_update';
        }

        $form = $this->createForm(new ImportfeedType(), $entity, array(
            'action' => $this->generateUrl($action, array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary left',)));

        return $form;
    }

    /**
     * Edits an existing Importfeed entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Importfeed')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Importfeed entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $is = $entity->getImportSourceFile();
            //if($is instanceof \Symfony\Component\HttpFoundation\File\UploadedFile  && $is->getImportSourceFile()!=$is->getClientOriginalName() ){
            //&& !file_exists($entity->getAbsolutePath())){
            $entity->upload();
            //}

            $em->flush();
            $this->addFlash("success", $entity->getSid() . " is seccesfully updated.");
            $redirect = 'importfeed';
            if (strtoupper($this->dashboard) == 'DMS') {
                $redirect = 'dms_importfeed';
            }
            return $this->redirect($this->generateUrl($redirect));
        }

        return $this->render('NumaDOAAdminBundle:Importfeed:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'dashboard' => $this->dashboard,
        ));
    }

    /**
     * Deletes a Importfeed entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOAAdminBundle:Importfeed')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Importfeed entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        $redirect = 'importfeed';
        if (strtoupper($this->dashboard) == 'DMS') {
            $redirect = 'dms_importfeed';
        }
        return $this->redirect($this->generateUrl($redirect));
    }

    /**
     * Deletes all Importfeed listings.
     *
     */
    public function deleteItemsAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAAdminBundle:Importfeed')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Importfeed entity.');
        }

        $items = $em->getRepository('NumaDOAAdminBundle:Item')->findBy(array('feed_id' => $entity->getId()));

        $this->get("numa.dms.listing")->deleteItems($items);
        $this->get("numa.dms.utils")->populateElasticSearch();
        //$this->addFlash('success', 'All the listing from the feed '+$id+" are removed and the images are deleted.");
        $request->getSession()->getFlashBag()->add('success', 'All the listing from the feed ' . $id . " are removed and the images are deleted.");

        return $this->redirect($this->generateUrl('dms_importfeed'));
    }

    /**
     * Creates a form to delete a Importfeed entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('importfeed_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

}
