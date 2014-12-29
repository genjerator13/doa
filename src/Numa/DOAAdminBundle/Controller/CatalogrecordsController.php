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
class CatalogrecordsController extends Controller {

    /**
     * Lists all Catalogrecords entities.
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findAll();
        $uploadForm = $this->createImportCSVForm();


        return $this->render('NumaDOAAdminBundle:Catalogrecords:index.html.twig', array(
                    'entities' => $entities,
                    'uploadForm' => $uploadForm->createView(),
        ));
    }

    /**
     * Creates a new Catalogrecords entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Catalogrecords();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($entity);
            
            $em->flush();
            $entity->upload();
            $em->flush();
            return $this->redirect($this->generateUrl('catalogs_show', array('id' => $entity->getId())));
        }

        return $this->render('NumaDOAAdminBundle:Catalogrecords:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Catalogrecords entity.
     *
     * @param Catalogrecords $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Catalogrecords $entity) {
        $form = $this->createForm(new CatalogrecordsType(), $entity, array(
            'action' => $this->generateUrl('catalogs_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn',)));

        return $form;
    }

    /**
     * Creates a form to create a Catalogrecords entity.
     *
     * @param Catalogrecords $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createImportCSVForm() {
        $data = array();
        $form = $this->createFormBuilder($data)
                ->setAction($this->generateUrl('catalog_import_csv'))
                ->add('upload', 'file', array('label' => 'CSV File to Submit'))
                ->add('ImportCSV', 'submit', array('label' => 'Import CSV'))
                ->getForm();

        return $form;
    }

    /**
     * Displays a form to create a new Catalogrecords entity.
     *
     */
    public function newAction() {
        $entity = new Catalogrecords();
        $form = $this->createCreateForm($entity);

        return $this->render('NumaDOAAdminBundle:Catalogrecords:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Catalogrecords entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogrecords entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Catalogrecords:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Catalogrecords entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('ROLE_BUSINES') && $this->getUser()->getId() != $id) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogrecords entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Catalogrecords:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
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
    private function createEditForm(Catalogrecords $entity) {
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
    public function updateAction(Request $request, $id) {
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
            $entity->upload();
            return $this->redirect($this->generateUrl('catalogs_edit', array('id' => $id)));
        }

        return $this->render('NumaDOAAdminBundle:Catalogrecords:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Catalogrecords entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Catalogrecords entity.');
            }
            //remove the dealer and all the listings he created
            $listings = $em->getRepository('NumaDOAAdminBundle:Item')->findBy(array('Dealer'=>$entity));
            foreach ($listings as $key => $listing) {
                $em->remove($listing);
            }
            //remove the dealer and all the import feed he created
            $feeds = $em->getRepository('NumaDOAAdminBundle:Importfeed')->findBy(array('Dealer'=>$entity));
            foreach ($listings as $key => $listing) {
                $feeds->setDealer(null);
            }
            $em->remove($entity);
            $em->flush();
        //}

        return $this->redirect($this->generateUrl('catalogs'));
    }

    /**
     * Creates a form to delete a Catalogrecords entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('catalogs_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-danger left',)))
                        ->getForm()
        ;
    }

    public function proccessImportCSVAction(Request $request) {
        // Check if we are posting stuff
        $uploadForm = $this->createImportCSVForm();
        $uploadForm->handleRequest($request);

        if ($uploadForm->isValid()) {
            // If form is valid
            // Get file
            $file = $request->files->get('form');
            $fileUpload = $file['upload'];
            $res = array();
            if ($fileUpload->getMimeType() == 'text/plain' &&
                    (strtolower(($fileUpload->guessExtension()) == 'csv' || strtolower($fileUpload->guessExtension()) == 'txt'))) {
                $file = $fileUpload->move($this->container->getParameter('upload_feed'), $fileUpload->getClientOriginalName());

                if (($handle = fopen($file->getRealPath(), "r")) !== FALSE) {
                    $rowCount = 0;

                    while (($row = fgetcsv($handle)) !== FALSE) {
                        //var_dump($row); // process the row.
                        if ($rowCount > 0) {
                            foreach ($header as $key => $value) {
                                $tmp[$value] = $row[$key];
                            }
                            $res[] = $tmp;
                        } else {
                            $header = $row;
                        }
                        $rowCount++;
                    }
                }
            } else {
                
            }

            $em = $this->getDoctrine()->getManager();
            $updated =0;
            $new =0;
            foreach ($res as $key => $row) {
                $fields = Catalogrecords::$maping;
                $newDealer = new Catalogrecords();
                foreach ($fields as $key => $fieldDB) {
                    $fn = 'set' . $fieldDB;
                    var_dump($fn);
                    if(is_callable(array($newDealer,$fn)) && !empty($row[$key])){
                        $newDealer->$fn($row[$key]);
                    }
                }
                if($newDealer->getEmail()){
                    $existing = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findOneBy(array('email'=>$newDealer->getEmail()));
                    if(!empty($existing)){
                        $existing = $newDealer;
                        $updated++;
                    }else{
                        $new++;
                        $em->persist($newDealer);
                    }
                }else{
                    $this->addFlash('warning', 'CSV not correct format(no email in fields)');
                    return $this->redirectToRoute('catalogs');
                }
            }

            $em->flush();

           
        }
        $this->addFlash('success', 'CSV imported: '.$updated.' :updated   '.$new.' :new');
        return $this->redirectToRoute('catalogs');
    }

}
