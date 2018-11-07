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
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Entity\Notification;
use Numa\DOADMSBundle\Entity\SaveSearch;

class CarfinderCustomerNotification extends CarfinderNotification
{
    public  $TYPE="CARFINDER_MATCH";
//    public function createNotificationEntity()
//    {
//        $notification = new Notification();
//        $notification->setStatus(1);
//        $notification->setCustomer($this->getSaveSearch()->getCustomer());
//        $notification->setContactBy($this->getSaveSearch()->getContactBy());
//        $notification->setDealer($this->getSaveSearch()->getDealer());
//        $notification->setSubject($this->getSubject());
//        $message = $this->getEmailBody();
//        $notification->setMessage($message);
//        $notification->setType("SaveSearchDealer");
//        $em = $this->getContainer()->get('doctrine')->getManager();
//        $this->sendNotificationEmail($notification);
//        $em->persist($notification);
//        $em->flush();
//    }

    public function getSubject(){
        $customer = $this->getSaveSearch()->getCustomer();
        if($customer instanceof Customer){
            return "Carfinder from ".$customer->getFullName();
        }
        return "Carfinder from no customer";

    }

    public function getMessageBody(){
        $templating = $this->container->get("templating");
        $customer = $this->getSaveSearch()->getCustomer();
        $dealer   = $this->getSaveSearch()->getDealer();

        $html = $templating->render('NumaDOADMSBundle:Emails:notificationCarfinderMatchCustomer.html.twig', array(
            'customer' => $customer,
            'dealer' => $dealer,
            'subject' => $dealer,
            'item' => $this->getItem(),
            'ss' => $this->getSaveSearch(),
        ));

        return $html;
    }


//    public function sendCarfinderCreated(SaveSearch $ss)
//    {
//        $this->setSaveSearch($ss);
//        $notification = new Notification();
//        $notification->setStatus(1);
//        $notification->setCustomer($this->getSaveSearch()->getCustomer());
//        $notification->setContactBy($this->getSaveSearch()->getContactBy());
//        $notification->setDealer($this->getSaveSearch()->getDealer());
//        $notification->setSubject($this->getSubjectCarfinderCreated());
//        $message = $this->getEmailBodyCarfinderCreated($notification);
//        $notification->setMessage($message);
//        $notification->setType("carfinder created");
//        $em = $this->getContainer()->get('doctrine')->getManager();
//        $this->sendNotificationEmail($notification);
//        $em->persist($notification);
//        $em->flush();
//    }
}