<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Form\UserRegistrationType;
use Numa\DOAAdminBundle\Entity\User;
use Symfony\Component\Security\Core\SecurityContext;

class UserController extends Controller {

    public function registerAction() {
        $user = new User();
        $form = $this->createForm(new UserRegistrationType(), $user, array(
            'action' => $this->generateUrl('buyer_create'),
        ));

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

            $em->persist($registration->getUser());
            $em->flush();

            //return $this->redirect(...);
        }

        return $this->render(
                        'NumaDOASiteBundle:User:register.html.twig', array('form' => $form->createView())
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
            'error'         => $error,
        ));
    }

}
