<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of services
 *
 * @author genjerator
 */
namespace Numa\Lib;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAware;

class Emailer extends ContainerAware
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }


    public function sendEmail($request, $data, $dealer)
    {
        $errors = array();
        $return = array();
        $currentRoute = $request->attributes->get('_route');
        $currentRouteParams = $request->attributes->get('_route_params');

        $currentUrl = $this->container->get('router')
            ->generate($currentRoute, $currentRouteParams, true);

        // $data is a simply array with your form fields
        // like "query" and "category" as defined above.
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            // Sanitize the e-mail to be extra safe.
            // I think Pear Mail will automatically do this for you
            $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        } else {
            $errors[] = "Invalid email!";
        }

        $emailFrom = $email;
        $emailTo = $dealer->getEmail();

        $emailBody = $this->makeMessageBody($currentUrl, $data, $emailFrom);

        $twig = $this->container->get('twig');
        $globals = $twig->getGlobals();

        $subject = $globals['subject'];
        $title = $globals['title'];
        $subject = $subject . " " . $title;

        $mailer = $this->container->get('mailer');
        $message = $mailer->createMessage()
            ->setSubject($subject)
            ->setFrom('general@dealersonair.com')
            ->addBcc('jim@dealersonair.com')
            ->addBcc('e.medjesi@gmail.com')
            ->setCc($email)
            ->setTo($dealer->getEmail())
            //->setTo("genjerator@outlook.com")
            ->setBody($emailBody);
        if (empty($errors)) {
            $ok = $mailer->send($message);

            //dump($emailFrom);
            //dump($message);die();
            sleep(2);
        }

        $return['errors'] = $errors;
        $return['redirectto'] = $currentUrl;

        return $return;
    }

    public function makeMessageBody($currentUrl, $data, $emailFrom)
    {
        $body = "";
        //dump($data);die();
        $body .= "URL: " . $currentUrl . " \n";
        $body .= "EMAIL FROM: " . $emailFrom . " \n";
        $body .= "Name: " . $this->stripUserComment($data['first_name']) . " " . $this->stripUserComment($data['last_name']) . " \n";
        $body .= "User Comment: " . " \n" . $this->stripUserComment($data['comments']);
        return $body;
    }

    public function stripUserComment($userComment)
    {
        $res = filter_var($userComment, FILTER_SANITIZE_STRING);
        return $res;
    }

    public function sendLostPassEmail($dealeruser, $password)
    {
        $email = "";
        if ($dealeruser instanceof Catalogrecords) {
            $name = $dealeruser->getName();
            $email = $dealeruser->getEmail();
            $uri = $this->container->get('router')->generate('catalogs_edit', array('id' => $dealeruser->getId()), true);
        } elseif ($dealeruser instanceof User) {
            $name = $dealeruser->getFirstName() . " " . $dealeruser->getLastName();
            $email = $dealeruser->getEmail();
            $uri = $this->container->get('router')->generate('profile', array(), true);
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Sanitize the e-mail to be extra safe.
            // I think Pear Mail will automatically do this for you
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        } else {
            $errors[] = "Invalid email!";
        }
        $link = "<a href='" . $uri . "' >Edit profile</a>";


        $twig = $this->container->get('twig');
        $settings = $this->container->get('numa.settings');//
        $globals = $twig->getGlobals();

        $subject = $settings->get('lost_password_subject', array('sitename' => $this->container->get('router')->getContext()->getHost()));

        $emailBody = $settings->get('Lost password Body', array('customer.name' => $name, 'newpassword' => $password, 'profilepage' => $link));

        $mailer = $this->container->get('mailer');
        $message = $mailer->createMessage()
            ->setSubject($subject)
            ->setFrom('general@dealersonair.com')
            ->addCc('jim@dealersonair.com')
            ->addCc('e.medjesi@gmail.com')
            ->setTo($email)
            ->setBody($emailBody, 'text/html');

        if (empty($errors)) {
            $ok = $mailer->send($message);
            if ($ok) {
                $em = $this->container->get('doctrine')->getManager();
                if ($dealeruser instanceof Catalogrecords) {
                    $repo = $em->getRepository("NumaDOAAdminBundle:Catalogrecords");
                    $repo->setContainer($this->container);
                    $repo->updatePassword($dealeruser, $password);

                } elseif ($dealeruser instanceof User) {
                    $repo = $em->getRepository("NumaDOAAdminBundle:User");
                    $repo->setContainer($this->container);
                    $repo->updatePassword($dealeruser, $password);
                }
                return true;
                //dump($message);die();

                //dump($emailFrom);
                //dump($message);die();
                //sleep(2);
            }
        }
        return false;
    }

    public function sendDmsActivateEmail($host, $dealer="")
    {
        $em = $this->container->get('doctrine')->getManager();

        $subject = "DMS activation request";
        $emailBody = "text";
        $mailer = $this->container->get('mailer');
        $message = $mailer->createMessage()
            ->setSubject($subject)
            ->setFrom('general@dealersonair.com')
            //->addCc('jim@dealersonair.com')
            //->addCc('e.medjesi@gmail.com')
            ->addTo('e.medjesi@gmail.com')
            //->setTo('dms@dealersonair.com')
            ->setBody($emailBody, 'text/html');


        $ok = $mailer->send($message);
        if ($ok) {

            return true;

        }

        return false;
    }
}

