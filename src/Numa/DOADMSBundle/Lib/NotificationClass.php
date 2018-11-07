<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.18
 */

namespace Numa\DOADMSBundle\Lib;


use mikehaertl\pdftk\Pdf;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\BillingDoc;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Entity\Email;
use Numa\DOADMSBundle\Entity\FillablePdf;
use Numa\DOADMSBundle\Entity\FillablePdfField;
use Numa\DOADMSBundle\Entity\Media;
use Numa\DOADMSBundle\Entity\Notification;
use Numa\DOADMSBundle\Entity\SaveSearch;
use Numa\DOADMSBundle\Util\containerTrait;
use Numa\Util\searchESParameters;
use Numa\Util\SearchItem;

class NotificationClass
{
    use containerTrait;

    public function sendNotificationEmail(Notification $notification)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $email = new Email();
        $dealer = $notification->getDealer();
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
        $emailTo2 = $dealer->getEmail2();

        $email->setEmailTo($emailTo);


        $subject = "Subject";

        $emailBody = $notification->getMessage();

        $email->setBody($emailBody);
        $email->setSubject( $notification->getSubject());

        $mailer = $this->container->get('mailer');
        $emailFrom = $this->container->getParameter("email_from");
        $message = $mailer->createMessage()
            ->setSubject($subject)
            ->setFrom($emailFrom)
            ->addBcc('jim@dealersonair.com')
            ->addBcc('e.medjesi@gmail.com')
            ->setTo($dealer->getEmail())
            ->setBody($emailBody, 'text/html');
        if (!empty($emailTo2) && $emailTo != $emailTo2) {
            $message->setTo(array($dealer->getEmail(), $dealer->getEmail2()));
        }
        if (empty($errors)) {
            $ok = $mailer->send($message);

            $email->setStatus('Sent');
            $notification->setStatus(2);
            sleep(2);
        } else {
            $email->setStatus('Error');
        }

        $email->setEmailBcc('jim@dealersonair.com;e.medjesi@gmail.com');

        $em->persist($email);
        $em->flush();
        return $return;
    }
}