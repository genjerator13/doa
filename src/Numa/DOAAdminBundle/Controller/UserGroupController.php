<?php

namespace Numa\DOAAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOAAdminBundle\Entity\UserGroup;
use Numa\DOAAdminBundle\Form\UserGroupType;

/**
 * UserGroup controller.
 *
 */
class UserGroupController extends Controller
{

    /**
     * Lists all UserGroup entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dashboard = $request->get('_dashboard');

        $entities = $em->getRepository('NumaDOAAdminBundle:UserGroup')->findAll();

        return $this->render('NumaDOAAdminBundle:UserGroup:index.html.twig', array(
            'entities' => $entities,
            'dashboard' => $dashboard,

        ));
    }

    /**
     * Creates a new UserGroup entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new UserGroup();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_group_show', array('id' => $entity->getId())));
        }

        return $this->render('NumaDOAAdminBundle:UserGroup:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a UserGroup entity.
     *
     * @param UserGroup $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(UserGroup $entity, $dashboard = "")
    {
        $action = $this->generateUrl('user_group_create');
        if ($dashboard == 'DMS') {
            $action = $this->generateUrl('dms_user_group_create');
        }

        $form = $this->createForm(new UserGroupType(), $entity, array(
            'action' => $action,
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new UserGroup entity.
     *
     */
    public function newAction(Request $request)
    {
        $entity = new UserGroup();
        $form = $this->createCreateForm($entity);

        return $this->render('NumaDOAAdminBundle:UserGroup:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a UserGroup entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:UserGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:UserGroup:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing UserGroup entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dashboard = $request->get('_dashboard');

        $entity = $em->getRepository('NumaDOAAdminBundle:UserGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserGroup entity.');
        }

        $editForm = $this->createEditForm($entity, $dashboard);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:UserGroup:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a UserGroup entity.
     *
     * @param UserGroup $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(UserGroup $entity, $dashboard = "")
    {
        $action = $this->generateUrl('user_group_update', array('id' => $entity->getId()));
        if ($dashboard == 'DMS') {
            $action = $this->generateUrl('dms_user_group_update', array('id' => $entity->getId()));
        }
        dump($action);
        die();
        $form = $this->createForm(new UserGroupType(), $entity, array(
            'action' => $action,
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing UserGroup entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dashboard = $request->get('_dashboard');

        //dump($dashboard);die();
        $entity = $em->getRepository('NumaDOAAdminBundle:UserGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $redirect = $this->redirect($this->generateUrl('user_group_edit', array('id' => $id)));
        if ($dashboard = "DMS") {
            $redirect = $this->redirect($this->generateUrl('dms_user_group_edit', array('id' => $id)));
        }

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('user_group_edit', array('id' => $id)));
        }

        return $this->render('NumaDOAAdminBundle:UserGroup:edit.html.twig', array(
            'entity' => $entity,
            'dashboard' => $dashboard,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UserGroup entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOAAdminBundle:UserGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserGroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user_group'));
    }

    /**
     * Creates a form to delete a UserGroup entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_group_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
