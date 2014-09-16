<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Form\UserRegistrationType;
use Numa\DOAAdminBundle\Entity\User;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {

    public function registerAction(Request $request) {
        $user = new User();
        $form = $this->createForm(new UserRegistrationType(), $user, array(
            'action' => $this->generateUrl('buyer_create'),
        ));

        return $this->render(
                        'NumaDOASiteBundle:User:register.html.twig', array('form' => $form->createView())
        );
    }

    public function profileAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new UserRegistrationType(), $user);

        $form->add('password', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'The password fields must match.',
            'options' => array('attr' => array('class' => 'password-field')),
            'required' => false,
            'first_options' => array('label' => 'Password', 'required' => false),
            'second_options' => array('label' => 'Repeat Password', 'required' => false),
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $registration = $form->getData();
            //check if the pass field is empty
            $plainPassword = $form->get('password')->getData();
            if (!empty($plainPassword)) {
                //encode the password   
                $registration->setPassword($plainPassword);
            } else {
                $originalPassword = $registration->getPassword();
                $registration->setPassword($originalPassword);
            }
            $em->persist($registration);
            $validator = $this->get('validator');
            $errors = $validator->validate($registration);

            if (count($errors) > 0) {
                $errorsString = (string) $errors;
                return new Response($errorsString);
            }

            $em->flush();
            return $this->redirect($this->generateUrl('register_success'));
        }

        return $this->render(
                        'NumaDOASiteBundle:User:register.html.twig', array('form' => $form->createView())
        );
    }

    public function createAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        $form = $this->createForm(new UserRegistrationType(), new User());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();
            $userGroup = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:UserGroup')->find(2);

            $registration->setUserGroup($userGroup);
            $em->persist($registration);
            $validator = $this->get('validator');
            $errors = $validator->validate($registration);

            if (count($errors) > 0) {
                return new Response((string) $errors);
            }

            $em->flush();
            return $this->redirect($this->generateUrl('register_success'));
        }

        return $this->render(
                        'NumaDOASiteBundle:User:register.html.twig', array('form' => $form->createView())
        );
    }

    public function registerSuccessAction() {
        return $this->render(
                        'NumaDOASiteBundle:User:registerSuccess.html.twig'
        );
    }

    public function loginAction() {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('NumaDOASiteBundle:User:login.html.twig', array(
                    // last username entered by the user
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error,
        ));
    }

}
