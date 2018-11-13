<?php

namespace Numa\DOADMSBundle\Entity;

use JMS\Serializer\Annotation as JMS;
use Numa\DOADMSBundle\Util\dateCreatedTrait;

/**
 * SaveSearch
 * @JMS\ExclusionPolicy("ALL")
 */
class SaveSearch
{
    use dateCreatedTrait;
    /**
     * @var integer
     * @JMS\Expose
     */
    private $id;

    /**
     * @var integer
     * @JMS\Expose
     */
    private $dealer_id;

    /**
     * @var integer
     * @JMS\Expose
     */
    private $customer_id;

    /**
     * @var string
     */
    private $cust_name;

    /**
     * @var string
     * @JMS\Expose
     */
    private $contact_by;

    /**
     * @var integer
     * @JMS\Expose
     */
    private $period;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     * @JMS\Expose
     */
    private $comment;

    /**
     * @var string
     * @JMS\Expose
     */
    private $body_style;

    /**
     * @var string
     * @JMS\Expose
     */
    private $make;

    /**
     * @var string
     * @JMS\Expose
     */
    private $model;

    /**
     * @var integer
     * @JMS\Expose
     */
    private $year_from;

    /**
     * @var integer
     * @JMS\Expose
     */
    private $year_to;

    /**
     * @var \DateTime
     * @JMS\Expose
     */
    private $date_created;

    /**
     * @var \DateTime
     */
    private $date_updated;

    /**
     * @var string
     * @JMS\Expose
     */
    private $status;

    /**
     * @var boolean
     */
    private $spam = false;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Dealer;

    /**
     * @var \Numa\DOADMSBundle\Entity\Customer
     */
    private $Customer;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dealerId
     *
     * @param integer $dealerId
     *
     * @return SaveSearch
     */
    public function setDealerId($dealerId)
    {
        $this->dealer_id = $dealerId;

        return $this;
    }

    /**
     * Get dealerId
     *
     * @return integer
     */
    public function getDealerId()
    {
        return $this->dealer_id;
    }

    /**
     * Set customerId
     *
     * @param integer $customerId
     *
     * @return SaveSearch
     */
    public function setCustomerId($customerId)
    {
        $this->customer_id = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return integer
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Set custName
     *
     * @param string $custName
     *
     * @return SaveSearch
     */
    public function setCustName($custName)
    {
        $this->cust_name = $custName;

        return $this;
    }

    /**
     * Get custName
     *
     * @return string
     */
    public function getCustName()
    {
        return $this->cust_name;
    }

    /**
     * Set contactBy
     *
     * @param string $contactBy
     *
     * @return SaveSearch
     */
    public function setContactBy($contactBy)
    {
        $this->contact_by = $contactBy;

        return $this;
    }

    /**
     * Get contactBy
     *
     * @return string
     */
    public function getContactBy()
    {
        return $this->contact_by;
    }

    /**
     * Set period
     *
     * @param integer $period
     *
     * @return SaveSearch
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return integer
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return SaveSearch
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return SaveSearch
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return SaveSearch
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set bodyStyle
     *
     * @param string $bodyStyle
     *
     * @return SaveSearch
     */
    public function setBodyStyle($bodyStyle)
    {
        $this->body_style = $bodyStyle;

        return $this;
    }

    /**
     * Get bodyStyle
     *
     * @return string
     */
    public function getBodyStyle()
    {
        return $this->body_style;
    }

    /**
     * Set make
     *
     * @param string $make
     *
     * @return SaveSearch
     */
    public function setMake($make)
    {
        $this->make = $make;

        return $this;
    }

    /**
     * Get make
     *
     * @return string
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return SaveSearch
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set yearFrom
     *
     * @param integer $yearFrom
     *
     * @return SaveSearch
     */
    public function setYearFrom($yearFrom)
    {
        $this->year_from = $yearFrom;

        return $this;
    }

    /**
     * Get yearFrom
     *
     * @return integer
     */
    public function getYearFrom()
    {
        return $this->year_from;
    }

    /**
     * Set yearTo
     *
     * @param integer $yearTo
     *
     * @return SaveSearch
     */
    public function setYearTo($yearTo)
    {
        $this->year_to = $yearTo;

        return $this;
    }

    /**
     * Get yearTo
     *
     * @return integer
     */
    public function getYearTo()
    {
        return $this->year_to;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return SaveSearch
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return SaveSearch
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->date_updated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return SaveSearch
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set spam
     *
     * @param boolean $spam
     *
     * @return SaveSearch
     */
    public function setSpam($spam)
    {
        $this->spam = $spam;

        return $this;
    }

    /**
     * Get spam
     *
     * @return boolean
     */
    public function getSpam()
    {
        return $this->spam;
    }

    /**
     * Set dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     *
     * @return SaveSearch
     */
    public function setDealer(\Numa\DOAAdminBundle\Entity\Catalogrecords $dealer = null)
    {
        $this->Dealer = $dealer;

        return $this;
    }

    /**
     * Get dealer
     *
     * @return \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    public function getDealer()
    {
        return $this->Dealer;
    }

    /**
     * Set customer
     *
     * @param \Numa\DOADMSBundle\Entity\Customer $customer
     *
     * @return SaveSearch
     */
    public function setCustomer(\Numa\DOADMSBundle\Entity\Customer $customer = null)
    {
        $this->Customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Numa\DOADMSBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->Customer;
    }

    /**
     * @return string
     * @JMS\VirtualProperty
     */
    public function getCustomerFullName(){
        return $this->getCustomer() instanceof Customer?$this->getCustomer()->getFullName():"";
    }

    /**
     * @return string
     * @JMS\VirtualProperty
     */
    public function getCustomerEmail(){
        return $this->getCustomer() instanceof Customer?$this->getCustomer()->getEmail():"";
    }

    /**
     * @return string
     * @JMS\VirtualProperty
     */
    public function getCustomerPhone(){
        return $this->getCustomer() instanceof Customer?$this->getCustomer()->getPhone():"";
    }

    public function endDate(){

        $dateCreate = $this->getDateCreated();
        $period     = "P".$this->period."W";
        $endDate    = $dateCreate->add(new \DateInterval($period));
        return $endDate;
    }
}
