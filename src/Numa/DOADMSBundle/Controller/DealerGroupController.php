<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\DealerGroup;
use Numa\DOADMSBundle\Form\DealerGroupType;

/**
 * DealerGroup controller.
 *
 */
class DealerGroupController extends Controller
{

    /**
     * Lists all DealerGroup entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOADMSBundle:DealerGroup')->findBy(array(),array("id"=>"desc"));

        return $this->render('NumaDOADMSBundle:DealerGroup:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new DealerGroup entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DealerGroup();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach($entity->getDealer() as $dealer)
            {
                $dealer->setDealerGroup($entity);
            }
            $em->persist($entity);
            $rq = $request->get("numa_doadmsbundle_dealergroup");
            $pass= $rq["password"];
            if (!empty($pass)) {
                $factory = $this->container->get('security.encoder_factory');
                $encoder = $factory->getEncoder($entity);
                $plainPassword = $entity->getPassword();
                $encodedPassword = $encoder->encodePassword($plainPassword, $entity->getSalt());
                $entity->setPassword($encodedPassword);
            }
            $em->flush();
            return $this->redirect($this->generateUrl('dealergroup'));

        }

        return $this->render('NumaDOADMSBundle:DealerGroup:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DealerGroup entity.
     *
     * @param DealerGroup $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DealerGroup $entity)
    {
        $form = $this->createForm(new DealerGroupType(), $entity, array(
            'action' => $this->generateUrl('dealergroup_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DealerGroup entity.
     *
     */
    public function newAction()
    {
        $entity = new DealerGroup();
        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:DealerGroup:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DealerGroup entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:DealerGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DealerGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:DealerGroup:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DealerGroup entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:DealerGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DealerGroup entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:DealerGroup:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a DealerGroup entity.
    *
    * @param DealerGroup $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DealerGroup $entity)
    {
        $form = $this->createForm(new DealerGroupType(), $entity, array(
            'action' => $this->generateUrl('dealergroup_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DealerGroup entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:DealerGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DealerGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $olddealers = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findBy(array('dealer_group_id'=>$id));
            foreach($olddealers as $dealer){
                $dealer->setDealerGroup(null);
            }

            foreach($entity->getDealer() as $dealer)
            {
                $dealer->setDealerGroup($entity);
            }

            $this->addFlash("success","Dealer Group: ".$entity->getUsername()." successfully updated.");
            $rq = $request->get("numa_doadmsbundle_dealergroup");
            $pass= $rq["password"];
            if (!empty($pass)) {
                $factory = $this->container->get('security.encoder_factory');
                $encoder = $factory->getEncoder($entity);
                $plainPassword = $entity->getPassword();
                $encodedPassword = $encoder->encodePassword($plainPassword, $entity->getSalt());
                $entity->setPassword($encodedPassword);
            }
            $em->flush();

            $securityContext = $this->container->get('security.authorization_checker');
            if ($securityContext->isGranted('ROLE_DEALER_PRINCIPAL')) {
                return $this->redirect($this->generateUrl('dealergroup_edit', array('id' => $id)));
            }
            else{
                return $this->redirect($this->generateUrl('dealergroup', array('id' => $id)));
            }
        }

        return $this->render('NumaDOADMSBundle:DealerGroup:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DealerGroup entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException("Only administrator may delete this DealerGroup.");
        }
            $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:DealerGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DealerGroup entity.');
            }



            foreach($entity->getDealer() as $dealer)
            {
                $dealer->setDealerGroup(null);
            }

            $em->remove($entity);
            $em->flush();
        //}

        return $this->redirect($this->generateUrl('dealergroup'));
    }

    /**
     * Creates a form to delete a DealerGroup entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dealergroup_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
