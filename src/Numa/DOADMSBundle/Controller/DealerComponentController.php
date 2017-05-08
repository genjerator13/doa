<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\DealerComponent;
use Numa\DOADMSBundle\Form\DealerComponentType;
use Numa\DOAModuleBundle\Entity\Component;

/**
 * DealerComponent controller.
 *
 */
class DealerComponentController extends Controller
{

    /**
     * Lists all DealerComponent entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('NumaDOADMSBundle:DealerComponent:index.html.twig');
    }

    /**
     * Creates a new DealerComponent entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DealerComponent();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('dealercomponent'));

        }

        return $this->render('NumaDOADMSBundle:DealerComponent:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DealerComponent entity.
     *
     * @param DealerComponent $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DealerComponent $entity)
    {
        $form = $this->createForm(new DealerComponentType(), $entity, array(
            'action' => $this->generateUrl('dealercomponent_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DealerComponent entity.
     *
     */
    public function newAction()
    {
        $entity = new DealerComponent();
        $form = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:DealerComponent:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DealerComponent entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:DealerComponent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DealerComponent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:DealerComponent:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DealerComponent entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:DealerComponent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DealerComponent entity.');
        }

        $editForm = $this->createEditForm($entity);

        $deleteForm = $this->createDeleteForm($id);
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $dealer_id = 0;
        if ($dealer instanceof Catalogrecords) {
            $dealer_id = $dealer->getId();
        }
        $uploadDir = Component::getUploadDir($dealer_id, $id);
        //clear the cache
        $this->get('Numa.DMSUtils')->clearCache();
        $template = "NumaDOAModuleBundle:Component:carousel_edit.html.twig";

        if (strtolower($entity->getType()) == "image") {
            $template = "NumaDOAModuleBundle:Component:image_edit.html.twig";
        }
        if (strtolower($entity->getType()) == "image" || (strtolower($entity->getType()) == "carousel") ) {
            $dc = $em->getRepository(DealerComponent::class)->find($id);
            $entities = $em->getRepository("NumaDOAAdminBundle:ImageCarousel")->findByComponent($dc);
            return $this->render($template, array(
                'uploadDir' => $uploadDir,
                'dealerComponent' => true,
                'entity' => $entity,
                'entities' => $entities,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }


        return $this->render('NumaDOADMSBundle:DealerComponent:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));


    }

    /**
     * Creates a form to edit a DealerComponent entity.
     *
     * @param DealerComponent $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DealerComponent $entity)
    {
        $securityContext = $this->get('security.authorization_checker');
        $dealerType = new DealerComponentType($securityContext);
        $dealerType->setSecurityContext($securityContext);
        $form = $this->createForm($dealerType, $entity, array(
            'action' => $this->generateUrl('dealercomponent_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing DealerComponent entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:DealerComponent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DealerComponent entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('dealercomponent_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:DealerComponent:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a DealerComponent entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:DealerComponent')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DealerComponent entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('dealercomponent'));
    }

    /**
     * Creates a form to delete a DealerComponent entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dealercomponent_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
