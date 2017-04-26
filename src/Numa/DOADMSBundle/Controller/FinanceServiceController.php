<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\FinanceService;
use Numa\DOADMSBundle\Form\FinanceServiceType;

/**
 * FinanceService controller.
 *
 */
class FinanceServiceController extends Controller
{

    /**
     * Lists all FinanceService entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOADMSBundle:FinanceService')->findAll();

        return $this->render('NumaDOADMSBundle:FinanceService:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new FinanceService entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new FinanceService();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('financeservice'));

        }

        return $this->render('NumaDOADMSBundle:FinanceService:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a FinanceService entity.
     *
     * @param FinanceService $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(FinanceService $entity)
    {
        $form = $this->createForm(new FinanceServiceType(), $entity, array(
            'action' => $this->generateUrl('financeservice_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FinanceService entity.
     *
     */
    public function newAction()
    {
        $entity = new FinanceService();
        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:FinanceService:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FinanceService entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:FinanceService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FinanceService entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:FinanceService:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FinanceService entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:FinanceService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FinanceService entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:FinanceService:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a FinanceService entity.
    *
    * @param FinanceService $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FinanceService $entity)
    {
        $form = $this->createForm(new FinanceServiceType(), $entity, array(
            'action' => $this->generateUrl('financeservice_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing FinanceService entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:FinanceService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FinanceService entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('financeservice_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:FinanceService:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a FinanceService entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:FinanceService')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FinanceService entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('financeservice'));
    }

    /**
     * Creates a form to delete a FinanceService entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('financeservice_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
