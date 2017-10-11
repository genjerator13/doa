<?php

namespace Numa\CCCAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\CCCAdminBundle\Entity\User;
use Numa\CCCAdminBundle\Form\UserType;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('NumaCCCAdminBundle:User')->findAll();

        return $this->render('NumaCCCAdminBundle:user:index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new User entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if(!empty($user->getPassword())){
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $encodedPassword = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($encodedPassword);
            }
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_index', array('id' => $user->getId()));
        }

        return $this->render('NumaCCCAdminBundle:user:new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('NumaCCCAdminBundle:user:show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm(UserType::class, $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if(!empty($user->getPassword())){
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $encodedPassword = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($encodedPassword);
            }
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('NumaCCCAdminBundle:user:edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        //}

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * activate deactivate a Customers entity.
     *
     */
    public function activateAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(User::class)->find($id);
        $activate = $request->attributes->get('activate');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customers entity.');
        }
        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            throw $this->createAccessDeniedException('Unable to activate / deactivate the customer');
        }
        $entity->setActivate($activate);
        $em->flush();
        $text = "deactivated";
        if($activate){
            $text = "activated";
        }
        $this > $this->addFlash("success", "User " . $entity->getName() . " is ".$text);


        return $this->redirect($this->generateUrl('user_index'));
    }
}
