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
use Numa\DOADMSBundle\Entity\FillablePdf;
use Numa\DOADMSBundle\Entity\FillablePdfField;
use Numa\DOADMSBundle\Entity\Media;
use Numa\DOADMSBundle\Entity\Notification;
use Numa\DOADMSBundle\Entity\SaveSearch;
use Numa\DOADMSBundle\Util\containerTrait;
use Numa\Util\searchESParameters;
use Numa\Util\SearchItem;

class CarfinderNotification extends NotificationClass
{
    private $item;
    private $saveSearch;
    private $customer;
    public  $TYPE="CARFINDER";

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param mixed $item
     */
    public function setItem(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @return mixed
     */
    public function getDealer()
    {
        return $this->dealer;
    }

    /**
     * @param mixed $dealer
     */
    public function setDealer(Catalogrecords $dealer)
    {
        $this->dealer = $dealer;
    }

    /**
     * @return mixed
     */
    public function getSaveSearch()
    {
        return $this->saveSearch;
    }

    /**
     * @param mixed $saveSearch
     */
    public function setSaveSearch(SaveSearch $saveSearch)
    {
        $this->saveSearch = $saveSearch;
        $this->setDealer($saveSearch->getDealer());
        $this->setCustomer($saveSearch->getCustomer());
    }

    public function createNotificationEntity()
    {
        $notification = new Notification();
        $notification->setStatus(1);
        $notification->setCustomer($this->getSaveSearch()->getCustomer());
        $notification->setContactBy($this->getSaveSearch()->getContactBy());
        $notification->setDealer($this->getSaveSearch()->getDealer());
        $notification->setSubject($this->getSubject());
        $message = $this->getMessageBody();
        $notification->setMessage($message);
        $notification->setType($this->TYPE);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $this->sendNotificationEmail($notification);
        $em->persist($notification);
        $em->flush();
    }

//    public function getSubjectForMatch(){
//        $customer = $this->getSaveSearch()->getCustomer();
//        if($customer instanceof Customer){
//            return "A vihecle is found on ".$this->getDealer()->getSiteUrl();
//        }
//        return "";
//    }

    public function getSubject(){
        return "subject";
    }

    public function getMessageBody(){
        return "message";
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

//    public function getSubjectCarfinderCreated(){
//        $customer = $this->getSaveSearch()->getCustomer();
//        if($customer instanceof Customer){
//            return "Carfinder from ".$customer->getFullName();
//        }
//        return "Carfinder from no customer";
//    }



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