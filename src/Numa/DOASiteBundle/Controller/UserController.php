<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Form\UserRegistrationType;
use Numa\DOAAdminBundle\Entity\User;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Pagerfanta,
    Pagerfanta\Adapter\DoctrineORMAdapter,
    Pagerfanta\Exception\NotValidCurrentPageException;

class UserController extends Controller implements DealerSiteControllerInterface
{

    public $dealer;

    public function initializeDealer($dealer)
    {
        $this->dealer = $dealer;

    }

    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserRegistrationType(), $user, array(
            'action' => $this->generateUrl('buyer_create'),
        ));

        return $this->render(
            'NumaDOASiteBundle:User:register.html.twig', array('form' => $form->createView())
        );
    }

    public function profileAction(Request $request)
    {
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
                $errorsString = (string)$errors;
                return new Response($errorsString);
            }

            $em->flush();
            return $this->redirect($this->generateUrl('register_success'));
        }

        return $this->render(
            'NumaDOASiteBundle:User:register.html.twig', array('form' => $form->createView())
        );
    }

    public function createAction(Request $request)
    {
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
                return new Response((string)$errors);
            }

            $em->flush();
            return $this->redirect($this->generateUrl('register_success'));
        }

        return $this->render(
            'NumaDOASiteBundle:User:register.html.twig', array('form' => $form->createView())
        );
    }

    public function registerSuccessAction()
    {
        return $this->render(
            'NumaDOASiteBundle:User:registerSuccess.html.twig'
        );
    }

    public function loginAction()
    {

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
            'dealer' => $this->dealer,
        ));
    }

    public function showSaveAdsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $param = array();
        if ($user instanceof User) {
            $items = $em->getRepository('NumaDOAAdminBundle:Item')->findSavedAds($user->getId());

            $searchController = $this->get('Numa.Controller.Search');
            $searchController->initSearchParams();
            $param = $searchController->showItems($items);
            //\Doctrine\Common\Util\Debug::dump($param);die();
        }
        return $this->render('NumaDOASiteBundle:Search:default.html.twig', $param);
    }

    public function savedSearchesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $userSearches = array();
        if ($user instanceof User) {
            $userSearches = $em->getRepository('NumaDOAAdminBundle:UserSearch')->findBy(array('User' => $user));
        }
        return $this->render('NumaDOASiteBundle:User:savedSearches.html.twig', array('userSearches' => $userSearches));
    }

    public function deleteSearchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $searchid = intval($request->query->get('searchid'));
        $userSearches = array();
        if ($user instanceof User) {
            if ($searchid > 0) {

                $userSearch = $em->getRepository('NumaDOAAdminBundle:UserSearch')->findOneBy(array('id' => $searchid));

                //\Doctrine\Common\Util\Debug::dump($userSearch);
                if (!empty($userSearch)) {

                    $em->remove($userSearch);
                    $em->flush();
                }

            }
        }
        //return $this->redirect($this->generateUrl('buyer_saved_searches'));

    }

    public function logindDealerAction(Request $request, $username)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('NumaDOAAdminBundle:Catalogrecords');
        $result = $repository->findOneBy(array('username' => $username));
        if (!$result) {
            throw $this->createNotFoundException("NOT FOUNd");
        }
        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
            'csrf_protection' => false,
        ))
            //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
            //->setMethod('GET')
            //->setAction($this->get('router')->generate('search_dispatch'))
            ->add('pss', 'password', array(
                'label' => 'pss',
                "required" => true
            ))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $pass = $this->getParameter('database_password');
            sleep(2);
            if ($data['pss'] != 'k3pass#') {
                return $this->redirectToRoute('homepage');
            }

            $session = $this->get('session');

            $firewall = 'secured_area';
            $token = new UsernamePasswordToken($result, $result->getPassword(), $firewall, array('ROLE_BUSINES', 'ROLE_DMS_USER'));
            $session->set('_security_' . $firewall, serialize($token));
            $session->save();

            $cookie = new Cookie($session->getName(), $session->getId());
            $response = new Response();
            $response->headers->setCookie($cookie);
            //dump($token);die();
            $this->get("security.token_storage")->setToken($token);

            return $this->redirectToRoute('homepage');
        }
        $response = $this->render('NumaDOASiteBundle:User:dealerlogin.html.twig', array('form' => $form->createView()));
        return $response;
    }

    public function lostpassAction(Request $request)
    {
        $error = array();
        $success = false;
        $form = $this->createFormBuilder()
            ->add('email', 'email')
            ->add('submit', 'submit', array('attr' => array('class' => 'btn btn-success')))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $email = $data['email'];
            $em = $this->getDoctrine()->getEntityManager();
            $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findOneByUsernameOrEmail($email);
            $dealeruser = null;
            if ($dealer instanceof Catalogrecords) {
                //generate new password
                //send it to dealer email
                //dump($dealer);
                $dealeruser = $dealer;
            } else {
                $user = $em->getRepository('NumaDOAAdminBundle:User')->findOneByUsernameOrEmail($email);
                if ($user instanceof User) {
                    //generate new password
                    //send it to user email
                    //dump($user);
                }
                $dealeruser = $user;
            }
            $generatePass = $this->generatePass(6);

            if ($dealeruser instanceof User || $dealeruser instanceof Catalogrecords) {
                $ok = $this->get('numa.emailer')->sendLostPassEmail($dealeruser, $generatePass);

                if ($ok) {
                    $this->addFlash('success', "Email with new password has been sent!");
                    $success = true;
                } else {
                    $error = array("error" => true);
                    $this->addFlash('danger', "Error sending new password!");
                }
            } else {
                $this->addFlash('danger', "The email does not exist in our database");
            }

        }

        //$uri = $this->get('router')->generate('buyer_register', array('' => $id);

        $response = $this->render('NumaDOASiteBundle:User:lostpass.html.twig', array('form' => $form->createView(), 'error' => $error, 'success' => $success));
        return $response;
    }

    private function generatePass($length)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }

    private function sendLostPassEmail()
    {

    }

}
