<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOADMSBundle\Entity\DMSUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\SupportForm;
use Numa\DOADMSBundle\Form\SupportFormType;

/**
 * SupportForm controller.
 *
 */
class SupportFormController extends Controller
{

    /**
     * Lists all SupportForm entities.
     *
     */
    public function indexAction()
    {
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();

        return $this->render('NumaDOADMSBundle:SupportForm:index.html.twig', array(
            'dealer'=>$dealer
        ));
    }
    /**
     * Creates a new SupportForm entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new SupportForm();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $dmsUser = $this->get('Numa.Dms.User')->getSignedUser();
        $entity->setDealer($dealer);
        if($dmsUser instanceof DMSUser){
            $entity->setDMSUser($dmsUser);
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->addFlash("success","Successfully Send Support Form.");
            return $this->redirect($this->generateUrl('supportform_new'));

        }

        return $this->render('NumaDOADMSBundle:SupportForm:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a SupportForm entity.
     *
     * @param SupportForm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SupportForm $entity)
    {
        $form = $this->createForm(new SupportFormType(), $entity, array(
            'action' => $this->generateUrl('supportform_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Send'));

        return $form;
    }

    /**
     * Displays a form to create a new SupportForm entity.
     *
     */
    public function newAction()
    {
        $entity = new SupportForm();
        $form   = $this->createCreateForm($entity);
        return $this->render('NumaDOADMSBundle:SupportForm:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SupportForm entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:SupportForm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SupportForm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:SupportForm:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SupportForm entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:SupportForm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SupportForm entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:SupportForm:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a SupportForm entity.
    *
    * @param SupportForm $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SupportForm $entity)
    {
        $form = $this->createForm(new SupportFormType(), $entity, array(
            'action' => $this->generateUrl('supportform_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SupportForm entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:SupportForm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SupportForm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('supportform_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:SupportForm:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a SupportForm entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:SupportForm')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SupportForm entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('supportform'));
    }

    /**
     * Creates a form to delete a SupportForm entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('supportform_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * @param Request $request
     * Deactivates elected listings in datagrid on listing list page
     */
    public function massDeleteAction(Request $request) {

        $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);
        dump($ids);die();
        $em = $this->getDoctrine()->getManager();

        $qb = $em->getRepository("NumaDOADMSBundle:SupportForm")->delete($ids);
        die();
    }
}
