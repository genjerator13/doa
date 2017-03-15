<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\Vendor;
use Numa\DOADMSBundle\Form\VendorType;

/**
 * Vendor controller.
 *
 */
class VendorController extends Controller
{

    /**
     * Lists all Vendor entities.
     *
     */
    public function indexAction()
    {
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $dealerPrincipal = $this->get('Numa.Dms.User')->getSignedDealerPrincipal();
        //$qbo = $this->container->get("numa.quickbooks")->isConnected();

        return $this->render('NumaDOADMSBundle:Vendor:index.html.twig', array(
            'dealer'=>$dealer,
            'dealerPrincipal'=>$dealerPrincipal
        ));
    }
    /**
     * Creates a new Vendor entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Vendor();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->upload();

            $securityContext = $this->container->get('security.authorization_checker');
            if (!$securityContext->isGranted('ROLE_DEALER_PRINCIPAL')){
                $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
                $entity->setCatalogrecords($dealer);
            }

            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('vendor', array('id' => $entity->getId())));

        }

        return $this->render('NumaDOADMSBundle:Vendor:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Vendor entity.
     *
     * @param Vendor $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Vendor $entity)
    {
        $form = $this->createForm(new VendorType(), $entity, array(
            'action' => $this->generateUrl('vendor_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Vendor entity.
     *
     */
    public function newAction()
    {
        $entity = new Vendor();
        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:Vendor:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Vendor entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Vendor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vendor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Vendor:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Vendor entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Vendor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vendor entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Vendor:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Vendor entity.
    *
    * @param Vendor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Vendor $entity)
    {
        $form = $this->createForm(new VendorType(), $entity, array(
            'action' => $this->generateUrl('vendor_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Vendor entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Vendor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vendor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->upload();
            $em->flush();

            $this->addFlash("success","Vendor: #".$entity->getId()." successfully updated.");
            return $this->redirect($this->generateUrl('vendor', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:Vendor:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Vendor entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOADMSBundle:Vendor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vendor entity.');
        }

        $entity->setStatus('deleted');

        $em->flush();
        return new Response();
    }

    /**
     * Creates a form to delete a Vendor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vendor_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
