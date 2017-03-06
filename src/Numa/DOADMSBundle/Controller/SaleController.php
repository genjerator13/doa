<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOADMSBundle\Entity\RelatedDoc;
use Numa\DOADMSBundle\Entity\SaleRelatedDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\Sale;
use Numa\DOADMSBundle\Form\SaleType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sale controller.
 *
 */
class SaleController extends Controller
{

    /**
     * Lists all Sale entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDealer($dealer);

        return $this->render('NumaDOADMSBundle:Sale:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Sale entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Sale();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('sale'));

        }

        return $this->render('NumaDOADMSBundle:Sale:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Sale entity.
     *
     * @param Sale $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Sale $entity)
    {
        $form = $this->createForm(new SaleType(), $entity, array(
            'action' => $this->generateUrl('sale_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Sale entity.
     *
     */
    public function newAction()
    {
        $entity = new Sale();
        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:Sale:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Sale entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Sale')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sale entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Sale:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Sale entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Sale')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sale entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Sale:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Sale entity.
    *
    * @param Sale $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Sale $entity)
    {
        $form = $this->createForm(new SaleType(), $entity, array(
            'action' => $this->generateUrl('sale_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Sale entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Sale')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sale entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('sale_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:Sale:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Sale entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:Sale')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Sale entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sale'));
    }

    /**
     * Creates a form to delete a Sale entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sale_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /***
     * @param Request $request
     * @param $id
     * @return Response
     */

    /**
     * Print a Sale entity.
     *
     */
    public function printInsideAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $listings = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);
        $saleId = $listings->getSaleId();
        $sale = $em->getRepository('NumaDOADMSBundle:Sale')->find($saleId);
        $html = $this->renderView(
            'NumaDOADMSBundle:Sale:view.html.twig',
            array('sale'=>$sale,
                'listing' => $listings,
                'id' => $sale->getId())
        );

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="Sale.pdf"'
            )
        );
    }

    public function uploadRelatedDocsAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        $file = $request->files->get('file');
        $relatedDocUrl = $this->getParameter('related_docs_url');
        $relatedDocPath = $this->getParameter('related_docs_path');
        if ($file instanceof \Symfony\Component\HttpFoundation\File\UploadedFile){
            $sale = $em->getRepository(Sale::class)->find(intval($id));
            $upladed = $this->get("numa.dms.sale")->uploadRelatedDocs($sale, $file,$relatedDocUrl,$relatedDocPath);
        }
        die();
    }

    public function refreshRelatedDocsAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $sale = $em->getRepository(Sale::class)->find(intval($id));
        if ($sale->hasRelatedDocs()){
            return $this->render("NumaDOADMSBundle:Sale:related_docs.html.twig",array('sale'=>$sale));
        }
        die();
    }

    public function deleteRelatedDocsAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $docid = $request->get('docid');
        $saledoc = $em->getRepository(SaleRelatedDoc::class)->find(intval($docid));

        $em->remove($saledoc);
        $em->flush();
        die();
    }
}
