<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\Finance;
use Numa\DOADMSBundle\Form\FinanceType;

/**
 * Finance controller.
 *
 */
class FinanceController extends Controller
{

    /**
     * Lists all Finance entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOADMSBundle:Finance')->findAll();

        return $this->render('NumaDOADMSBundle:Finance:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Finance entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Finance();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('finance'));

        }

        return $this->render('NumaDOADMSBundle:Finance:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Finance entity.
     *
     * @param Finance $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Finance $entity)
    {
        $form = $this->createForm(new FinanceType(), $entity, array(
            'action' => $this->generateUrl('finance_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Send'));

        return $form;
    }

    /**
     * Displays a form to create a new Finance entity.
     *
     */
    public function newAction()
    {
        $entity = new Finance();
        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:Finance:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Finance entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Finance')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Finance entity.');
        }

        $entity->setStatus("Read");
        $em->flush();

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Finance:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Finance entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Finance')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Finance entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Finance:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Finance entity.
    *
    * @param Finance $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Finance $entity)
    {
        $form = $this->createForm(new FinanceType(), $entity, array(
            'action' => $this->generateUrl('finance_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Finance entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Finance')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Finance entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('finance_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:Finance:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Finance entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:Finance')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Finance entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('finance'));
    }

    /**
     * Creates a form to delete a Finance entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('finance_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * @param Request $request
     * Deactivates elected listings in datagrid on listing list page
     */
    public function massDelete2Action(Request $request) {

        $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);

        $em = $this->getDoctrine()->getManager();

        $qb = $em->getRepository("NumaDOADMSBundle:Finance")->delete($ids);
        die();
    }
}
