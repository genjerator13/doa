<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\DMSUser;
use Numa\DOADMSBundle\Form\DMSUserType;

/**
 * DMSUser controller.
 *
 */
class DMSUserController extends Controller
{

    /**
     * Lists all DMSUser entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user instanceof Catalogrecords){
            $entities = $em->getRepository('NumaDOADMSBundle:DMSUser')->findBy(array('Dealer'=>$user));
        }else {
            $entities = $em->getRepository('NumaDOADMSBundle:DMSUser')->findAll();
        }

        return $this->render('NumaDOADMSBundle:DMSUser:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new DMSUser entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DMSUser();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //get loged user

            $user = $this->get('security.token_storage')->getToken()->getUser();

            if($user instanceof Catalogrecords){
                $entity->setDealer($user);
            }


            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('dmsuser'));

        }

        return $this->render('NumaDOADMSBundle:DMSUser:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DMSUser entity.
     *
     * @param DMSUser $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DMSUser $entity)
    {
        $form = $this->createForm(new DMSUserType(), $entity, array(
            'action' => $this->generateUrl('dmsuser_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DMSUser entity.
     *
     */
    public function newAction()
    {
        $entity = new DMSUser();
        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:DMSUser:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DMSUser entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:DMSUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DMSUser entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:DMSUser:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DMSUser entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:DMSUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DMSUser entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:DMSUser:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a DMSUser entity.
    *
    * @param DMSUser $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DMSUser $entity)
    {
        $form = $this->createForm(new DMSUserType(), $entity, array(
            'action' => $this->generateUrl('dmsuser_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DMSUser entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:DMSUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DMSUser entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('dmsuser_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:DMSUser:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DMSUser entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:DMSUser')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DMSUser entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('dmsuser'));
    }

    /**
     * Creates a form to delete a DMSUser entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dmsuser_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
