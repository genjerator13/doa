<?php

namespace Numa\DOAAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\Importfeed;
use Numa\DOAAdminBundle\Form\ImportfeedType;

/**
 * Importfeed controller.
 *
 */
class ImportfeedController extends Controller {

    /**
     * Lists all Importfeed entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOAAdminBundle:Importfeed')->findAll();

        return $this->render('NumaDOAAdminBundle:Importfeed:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Importfeed entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Importfeed();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->upload();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('importfeed_show', array('id' => $entity->getId())));
        }

        return $this->render('NumaDOAAdminBundle:Importfeed:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Importfeed entity.
     *
     * @param Importfeed $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Importfeed $entity) {
        $form = $this->createForm(new ImportfeedType(), $entity, array(
            'action' => $this->generateUrl('importfeed_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Importfeed entity.
     *
     */
    public function newAction() {
        $entity = new Importfeed();
        $form = $this->createCreateForm($entity);

        return $this->render('NumaDOAAdminBundle:Importfeed:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Importfeed entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Importfeed')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Importfeed entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Importfeed:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Importfeed entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Importfeed')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Importfeed entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Importfeed:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Importfeed entity.
     *
     * @param Importfeed $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Importfeed $entity) {
        $form = $this->createForm(new ImportfeedType(), $entity, array(
            'action' => $this->generateUrl('importfeed_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary left',)));

        return $form;
    }

    /**
     * Edits an existing Importfeed entity.
     *
     */
    public function updateAction(Request $request, $id) {
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

            return $this->redirect($this->generateUrl('importfeed_edit', array('id' => $id)));
        }

        return $this->render('NumaDOAAdminBundle:Importfeed:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Importfeed entity.
     *
     */
    public function deleteAction(Request $request, $id) {
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

        return $this->redirect($this->generateUrl('importfeed'));
    }

    /**
     * Deletes all Importfeed listings.
     *
     */
    public function deleteItemsAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAAdminBundle:Importfeed')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Importfeed entity.');
        }
        $items = $em->getRepository('NumaDOAAdminBundle:Item')->findBy(array('feed_id'=>$entity->getId()));
        
        foreach($items as $item) {
            foreach($item->getItemField() as $itemField) {
                if(stripos($itemField->getFieldType(),"array")!==false && stripos($itemField->getFieldStringValue(), "http")===false){
                    $web_path = $this->container->getParameter('web_path');
                    $filename = $web_path.$itemField->getFieldStringValue();
                    if(file_exists($filename) && is_file($filename)){
                        unlink($filename);                                                
                    }
                    $em->remove($itemField);
                }            
            }
            $em->remove($item);
        }
        //$em->remove($entity);
        $em->flush();

        //$this->addFlash('success', 'All the listing from the feed '+$id+" are removed and the images are deleted.");
        $request->getSession()->getFlashBag()->add('success', 'All the listing from the feed '.$id." are removed and the images are deleted.");
    
        return $this->redirect($this->generateUrl('importfeed'));
    }

    /**
     * Creates a form to delete a Importfeed entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('importfeed_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
