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
use Numa\DOADMSBundle\Entity\Email;
use Numa\DOADMSBundle\Entity\Finance;
use Numa\DOADMSBundle\Entity\FinanceService;
use Numa\DOADMSBundle\Entity\Leasing;
use Numa\DOADMSBundle\Entity\ListingForm;
use Numa\DOADMSBundle\Entity\PartRequest;
use Numa\DOADMSBundle\Entity\ServiceRequest;
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
        $email_from = $this->container->getParameter("email_from");

        $globals = $twig->getGlobals();

        $subject = $globals['subject'];
        $title = $globals['title'];
        $subject = $subject . " " . $title;

        $mailer = $this->container->get('mailer');
        $message = $mailer->createMessage()
            ->setSubject($subject)
            ->setFrom($email_from)
            ->addBcc('jim@dealersonair.com')
            ->addBcc('e.medjesi@gmail.com')
            ->setCc($email)
            ->setTo($dealer->getEmail())
            //->setTo("genjerator@outlook.com")
            ->setBody($emailBody);
        if (empty($errors)) {
            $ok = $mailer->send($message);
            sleep(2);
        }

        $return['errors'] = $errors;
        $return['redirectto'] = $currentUrl;

        return $return;
    }

    public function sendNotificationEmail($entity, $dealer, $customer)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $email = new Email();

        $errors = array();
        $return = array();
        // $data is a simply array with your form fields
        // like "query" and "category" as defined above.
        if (filter_var($dealer->getEmail(), FILTER_VALIDATE_EMAIL)) {
            // Sanitize the e-mail to be extra safe.
            // I think Pear Mail will automatically do this for you
            $emailTo = filter_var($dealer->getEmail(), FILTER_SANITIZE_EMAIL);
        } else {

            $errors[] = "Invalid email!";
        }
        $emailTo = $dealer->getEmail();
        $email->setEmailTo($emailTo);

        $emailBody = $this->makeNotificationMessageBody($entity);
        $email->setBody($emailBody);

        $subject = "";
        if ($entity instanceof PartRequest) {
            $subject = "Part Request from " . $customer->getFullName();
        } elseif ($entity instanceof ServiceRequest) {
            $subject = "Service Request from " . $customer->getFullName();
        }elseif ($entity instanceof ListingForm) {

            $subject = ucfirst($entity->getType())." Request from " . $customer->getFullName();
            if($entity->getSpam()){
                return;
            }
        }elseif ($entity instanceof Finance) {
            $subject = "Finance Form Request from " . $customer->getFullName();
        }elseif ($entity instanceof FinanceService) {
            $subject = "Financing Service Request from ". $customer->getFullName()." customer" ;
        }elseif ($entity instanceof Leasing) {
            $subject = "Leasing Request from " . $customer->getFullName();
        }

        $email->setSubject($subject);

        $mailer = $this->container->get('mailer');
        $emailFrom = $this->container->getParameter("email_from");
        $message = $mailer->createMessage()
            ->setSubject($subject)
            ->setFrom($emailFrom)
            ->addBcc('jim@dealersonair.com')
            ->addBcc('e.medjesi@gmail.com')
            ->setTo($dealer->getEmail())
            ->setBody($emailBody, 'text/html');
        if (empty($errors)) {
            //$ok = $mailer->send($message);
            $email->setStatus('Sent');
            sleep(2);
        } else {
            $email->setStatus('Error');
        }

        $email->setEmailBcc('jim@dealersonair.com;e.medjesi@gmail.com');
        $em->persist($email);
        $em->flush();
        return $return;
    }

    public function makeMessageBody($currentUrl, $data, $emailFrom)
    {
        $body = "";
        $body .= "URL: " . $currentUrl . " \n";
        $body .= "EMAIL FROM: " . $emailFrom . " \n";
        $body .= "Name: " . $this->stripUserComment($data['first_name']) . " " . $this->stripUserComment($data['last_name']) . " \n";
        $body .= "User Comment: " . " \n" . $this->stripUserComment($data['comments']);
        return $body;
    }

    public function makeNotificationMessageBody($entity)
    {
        $templating = $this->container->get('templating');
        $html = "";
        if ($entity instanceof PartRequest) {

            $html = $templating->render('NumaDOADMSBundle:Emails:partRequestNotificationBody.html.twig', array(
                'entity' => $entity,

            ));
        } elseif ($entity instanceof ServiceRequest) {
            $html = $templating->render('NumaDOADMSBundle:Emails:serviceRequestNotificationBody.html.twig', array(
                'entity' => $entity,

            ));
        } elseif ($entity instanceof ListingForm) {
            $html = $templating->render('NumaDOADMSBundle:Emails:listingFormRequestNotificationBody.html.twig', array(
                'entity' => $entity,

            ));
        } elseif ($entity instanceof Finance) {
            $html = $templating->render('NumaDOADMSBundle:Emails:financeRequestNotificationBody.html.twig', array(
                'entity' => $entity,

            ));
        }elseif ($entity instanceof FinanceService) {
            $html = $templating->render('NumaDOADMSBundle:Emails:financeServiceRequestNotificationBody.html.twig', array(
                'entity' => $entity,

            ));
        }elseif ($entity instanceof Leasing) {
            $html = $templating->render('NumaDOADMSBundle:Emails:leasingRequestNotificationBody.html.twig', array(
                'entity' => $entity,

            ));
        }
        return $html;
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
            ->setFrom('dealerinquiries@dmscomplete.com')
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
            }
        }
        return false;
    }

    public function sendDmsActivateEmail($host, $dealer = "")
    {
        $templating = $this->container->get('templating');
        $em = $this->container->get('doctrine')->getManager();
        $text = "";
        if ($dealer instanceof Catalogrecords) {
            $name = $dealer->getName();
            $text = " by " . $name;
        }
        $subject = "DMS activation request";

        $emailBody = "DMS activation request" . $text . " for the site:" . $host;;
        $emailBody = $templating->render('NumaDOADMSBundle:Emails:activationEmail.html.twig', array('text'=>$text,$host=>$host
        ));
        $mailer = $this->container->get('mailer');
        $message = $mailer->createMessage()
            ->setSubject($subject)
            ->setFrom('dealerinquiries@dmscomplete.com')
            ->addCc('jim@dealersonair.com')
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

    public function sendErrorEmail($url,$status){

        $subject = "Error on ".$url;

        $emailBody = "Error ".$status." on: ".$url;

        $mailer = $this->container->get('mailer');
        $message = $mailer->createMessage()
            ->setSubject($subject)
            ->setFrom('dealerinquiries@dmscomplete.com')
            //->addCc('jim@dealersonair.com')
            ->addTo('e.medjesi@gmail.com')
            ->setBody($emailBody, 'text/html');


        $ok = $mailer->send($message);
        if ($ok) {
            return true;
        }
        return false;
    }
}

