<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\DealerGroup;
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
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $dealerPrincipal = $this->get('Numa.Dms.User')->getSignedDealerPrincipal();

        return $this->render('NumaDOADMSBundle:DMSUser:index.html.twig', array(
            'dealer' => $dealer,
            'dealerPrincipal' => $dealerPrincipal
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

            $dealer = $this->get("Numa.Dms.User")->getSignedDealer();

            if ($dealer instanceof Catalogrecords) {
                $entity->setDealer($dealer);
            }

            $em->persist($entity);
            $rq = $request->get("numa_doadmsbundle_dmsuser");
            $pass = $rq["password"];

            if (!empty($pass)) {
                $factory = $this->container->get('security.encoder_factory');
                $encoder = $factory->getEncoder($entity);
                $plainPassword = $entity->getPassword();
                $encodedPassword = $encoder->encodePassword($plainPassword, $entity->getSalt());
                $entity->setPassword($encodedPassword);
            }
            $em->flush();
            return $this->redirect($this->generateUrl('dmsuser'));

        }

        return $this->render('NumaDOADMSBundle:DMSUser:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
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
        $form = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:DMSUser:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
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
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DMSUser entity.
     *
     */
    public function editAction($id)
    {
        $ok = $this->checkDMSUserPermission($id);

        if ($ok) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('NumaDOADMSBundle:DMSUser')->find($id);
            $securityContext = $this->container->get('security.authorization_checker');


            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('NumaDOADMSBundle:DMSUser:edit.html.twig', array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }
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
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_PARTS_DMS') ||
            $securityContext->isGranted('ROLE_SERVICE_DMS') ||
            $securityContext->isGranted('ROLE_FINANCE_DMS') ||
            $securityContext->isGranted('ROLE_WHOLESALE_DMS') ||
            $securityContext->isGranted('ROLE_SALES') ||
            $securityContext->isGranted('ROLE_REGULAR_ADMIN_DMS')
        ) {

            $form = $this->createForm(new DMSUserType(), $entity, array(
                'action' => $this->generateUrl('userprofile_update', array('id' => $entity->getId())),
                'method' => 'POST',
            ));
        } else {
            $form = $this->createForm(new DMSUserType(), $entity, array(
                'action' => $this->generateUrl('dmsuser_update', array('id' => $entity->getId())),
                'method' => 'POST',
            ));

        }

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing DMSUser entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $ok = $this->checkDMSUserPermission($id);
        if ($ok) {
            $em = $this->getDoctrine()->getManager();
            $redirectRoute = "dmsuser_edit";
            $entity = $em->getRepository('NumaDOADMSBundle:DMSUser')->find($id);
            $securityContext = $this->container->get('security.authorization_checker');
            if (($securityContext->isGranted('ROLE_PARTS_DMS') ||
                $securityContext->isGranted('ROLE_SERVICE_DMS') ||
                $securityContext->isGranted('ROLE_FINANCE_DMS') ||
                $securityContext->isGranted('ROLE_WHOLESALE_DMS') ||
                $securityContext->isGranted('ROLE_SALES') ||
                $securityContext->isGranted('ROLE_REGULAR_ADMIN_DMS'))
            ) {
                $redirectRoute = "userprofile_edit";
            }
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DMSUser entity.');
            }

            $deleteForm = $this->createDeleteForm($id);
            $editForm = $this->createEditForm($entity);
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                //dump($request);die();
                $rq = $request->get("numa_doadmsbundle_dmsuser");
                $pass = $rq["password"];

                if (!empty($pass)) {
                    $factory = $this->container->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($entity);
                    $plainPassword =$pass;
                    $encodedPassword = $encoder->encodePassword($plainPassword, $entity->getSalt());
                    $entity->setPassword($encodedPassword);
                }
                $em->flush();
                $this->addFlash("success", "User: " . $entity->getUsername() . " successfully updated.");
                
                return $this->redirect($this->generateUrl($redirectRoute, array('id' => $id)));
            }

            return $this->render('NumaDOADMSBundle:DMSUser:edit.html.twig', array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }
    }

    /**
     * Deletes a DMSUser entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('ROLE_ADMIN') && !$securityContext->isGranted('ROLE_DMS_USER')) {
            throw $this->createAccessDeniedException("Only administrator and user owner may delete this User.");
        }


        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOADMSBundle:DMSUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DMSUser entity.');
        }
        $dealer = $this->get("numa.dms.user")->getSignedDealer();
            if (($dealer instanceof Catalogrecords && $entity->getDealer() instanceof Catalogrecords) && $dealer->getId() != $entity->getDealer()->getId()) {
                throw $this->createAccessDeniedException("Only User owner may delete this user.");
            }

        $em->remove($entity);
        $em->flush();
        //}

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
            ->getForm();
    }

    public function checkDMSUserPermission($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOADMSBundle:DMSUser')->find($id);
//        dump($entity);
        $securityContext = $this->container->get('security.authorization_checker');
//        dump($securityContext);die();
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $user = $this->getUser();

        if ($securityContext->isGranted('ROLE_ADMIN')) {
            return true;
        } elseif ($securityContext->isGranted('ROLE_BUSINES') && ($dealer instanceof Catalogrecords && $entity instanceof DMSUser && $dealer->getId() == $entity->getDealerId())) {
            return true;
        } elseif ($securityContext->isGranted('ROLE_DEALER_PRINCIPAL') && ($entity instanceof DMSUser)) {
            $dealerGroup = $this->get('Numa.Dms.User')->getSignedDealerOrPrincipal();
            $dealers = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->getDealersByDealerGroup($dealerGroup->getId());
            foreach ($dealers as $dealer) {
                if ($dealer->getId() == $entity->getDealerId()) {
                    return true;
                }
            }
            throw $this->createAccessDeniedException("You cannot edit this page!");
        } elseif (($securityContext->isGranted('ROLE_PARTS_DMS') ||
                $securityContext->isGranted('ROLE_SERVICE_DMS') ||
                $securityContext->isGranted('ROLE_FINANCE_DMS') ||
                $securityContext->isGranted('ROLE_WHOLESALE_DMS') ||
                $securityContext->isGranted('ROLE_SALES') ||
                $securityContext->isGranted('ROLE_REGULAR_ADMIN_DMS') ||
                $securityContext->isGranted('ROLE_SALE2_DMS') ||
                $securityContext->isGranted('ROLE_SALE3_DMS') ||
                $securityContext->isGranted('ROLE_SALE4_DMS') ||
                $securityContext->isGranted('ROLE_SALE2_DEALER_GROUP_DMS')
            )
            && $this->getUser()->getId() == $id
        ) {
            //ok
            return true;
        } else {
            throw $this->createAccessDeniedException("You cannot edit this page!");
        }
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DMSUser entity.');
        }
        return false;
    }
}

