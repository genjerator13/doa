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
use Symfony\Component\DependencyInjection\ContainerAware;

class Emailer extends ContainerAware
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }



    public function sendEmail($request, $data, $dealer){
        $errors = array();
        $return = array();
        $currentRoute = $request->attributes->get('_route');
        $currentRouteParams = $request->attributes->get('_route_params');

        $currentUrl = $this->container->get('router')
            ->generate($currentRoute, $currentRouteParams, true);

        // $data is a simply array with your form fields
        // like "query" and "category" as defined above.
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL))
        {
            // Sanitize the e-mail to be extra safe.
            // I think Pear Mail will automatically do this for you
            $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        }else{
            $errors[] = "Invalid email!";
        }

        $emailFrom = $email;
        $emailTo = $dealer->getEmail();

        $emailBody = $this->makeMessageBody($currentUrl, $data,$emailFrom);

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
             //->setTo($dealer->getEmail())
             ->setTo("genjerator@outlook.com")
            ->setBody($emailBody);
        if(empty($errors)) {
            $ok = $mailer->send($message);

            //dump($emailFrom);
            //dump($message);die();
            sleep(2);
        }

        $return['errors']=$errors;
        $return['redirectto']=$currentUrl;

        return $return;
    }

    public function makeMessageBody($currentUrl,$data,$emailFrom){
        $body = "";
        //dump($data);die();
        $body .= "URL: ".$currentUrl." \n";
        $body .= "EMAIL FROM: ".$emailFrom." \n";
        $body .= "Name: ".$this->stripUserComment($data['first_name'])." ".$this->stripUserComment($data['last_name'])." \n";
        $body .= "User Comment: "." \n".$this->stripUserComment($data['comments']);
        return $body;
    }

    public function stripUserComment($userComment){
        $res = filter_var($userComment, FILTER_SANITIZE_STRING);
        return $res;
    }

}

