<?php

namespace Numa\DOADMSBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;

/**
 * ServiceRequest
 * @JMS\ExclusionPolicy("ALL")
 */
class ServiceRequest
{
    /**
     * @var int
     * @JMS\Expose
     */
    private $id;

    /**
     * @var string
     * @JMS\Expose
     */
    private $cust_name;

    /**
     * @var string
     * @JMS\Expose
     */
    private $cust_last_name;

    /**
     * @var string
     * @JMS\Expose
     */
    private $contact_by;

    /**
     * @var string
     * @JMS\Expose
     */
    private $email;

    /**
     * @var string
     * @JMS\Expose
     */
    private $phone;

    /**
     * @var \DateTime
     * @JMS\Expose
     */
    private $date_appointment;

    /**
     * @var \DateTime
     * @JMS\Expose
     */
    private $time_appointment;

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
     * @var int
     * @JMS\Expose
     */
    private $year;

    /**
     * @var string
     * @JMS\Expose
     */
    private $comment;

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
     */
    private $status;

    /**
     * @var int
     */
    private $dealer_id;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Dealer;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set custName
     *
     * @param string $custName
     *
     * @return ServiceRequest
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
     * Set custLastName
     *
     * @param string $custLastName
     *
     * @return ServiceRequest
     */
    public function setCustLastName($custLastName)
    {
        $this->cust_last_name = $custLastName;

        return $this;
    }

    /**
     * Get custLastName
     *
     * @return string
     */
    public function getCustLastName()
    {
        return $this->cust_last_name;
    }

    /**
     * Set contactBy
     *
     * @param string $contactBy
     *
     * @return ServiceRequest
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
     * Set email
     *
     * @param string $email
     *
     * @return ServiceRequest
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
     * @return ServiceRequest
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
     * Set dateAppointment
     *
     * @param \DateTime $dateAppointment
     *
     * @return ServiceRequest
     */
    public function setDateAppointment($dateAppointment)
    {
        $this->date_appointment = $dateAppointment;

        return $this;
    }

    /**
     * Get dateAppointment
     *
     * @return \DateTime
     */
    public function getDateAppointment()
    {
        return $this->date_appointment;
    }

    /**
     * Set timeAppointment
     *
     * @param \DateTime $timeAppointment
     *
     * @return ServiceRequest
     */
    public function setTimeAppointment($timeAppointment)
    {
        $this->time_appointment = $timeAppointment;

        return $this;
    }

    /**
     * Get timeAppointment
     *
     * @return \DateTime
     */
    public function getTimeAppointment()
    {
        return $this->time_appointment;
    }

    /**
     * Set make
     *
     * @param string $make
     *
     * @return ServiceRequest
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
     * @return ServiceRequest
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
     * Set year
     *
     * @param int $year
     *
     * @return ServiceRequest
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return ServiceRequest
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return ServiceRequest
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
     * @return ServiceRequest
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
     * @return ServiceRequest
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
     * Set dealerId
     *
     * @param int $dealerId
     *
     * @return ServiceRequest
     */
    public function setDealerId($dealerId)
    {
        $this->dealer_id = $dealerId;

        return $this;
    }

    /**
     * Get dealerId
     *
     * @return int
     */
    public function getDealerId()
    {
        return $this->dealer_id;
    }

    /**
     * Set dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     *
     * @return ServiceRequest
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
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if (!$this->getDateCreated()) {
            $this->date_created = new \DateTime();
            $this->date_updated = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        if(empty($this->dontupdate)){

            $this->date_updated = new \DateTime();
        }
    }
}

