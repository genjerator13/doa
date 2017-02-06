<?php

namespace Numa\DOADMSBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ListingForm
 * @JMS\ExclusionPolicy("ALL")
 */
class ListingForm
{
    /**
     * @var int
     * @JMS\Expose
     */
    private $id;

    /**
     * @var string
     * @JMS\Expose
     * @Assert\Length(max=60)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern     = "/^[a-z A-Z1-9]+$/i",
     *     htmlPattern = "^[a-z A-Z1-9]+$"
     * )
     */
    private $cust_name;

    /**
     * @var string
     * @JMS\Expose
     * @Assert\Length(max=60)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern     = "/^[a-z A-Z1-9]+$/i",
     *     htmlPattern = "^[a-z A-Z1-9]+$"
     * )
     */
    private $cust_last_name;

    /**
     * @var string
     * @JMS\Expose
     * @Assert\Length(max=60)
     * @Assert\Regex(
     *     pattern     = "/^[a-z A-Z1-9]+$/i",
     *     htmlPattern = "^[a-z A-Z1-9]+$"
     * )
     */
    private $cust_officer;

    /**
     * @var string
     * @JMS\Expose
     */
    private $contact_by;

    /**
     * @var string
     * @JMS\Expose
     * @Assert\Email()
     * @Assert\NotBlank()
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
    private $date;

    /**
     * @var string
     * @JMS\Expose
     */
    private $comment;

    /**
     * @var int
     * @JMS\Expose
     */
    private $dealer_id;

    /**
     * @var int
     * @JMS\Expose
     */
    private $customer_id;

    /**
     * @var int
     * @JMS\Expose
     */
    private $item_id;

    /**
     * @var \DateTime
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
     * @return ListingForm
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
     * @return ListingForm
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
     * Set custOfficer
     *
     * @param string $custOfficer
     *
     * @return ListingForm
     */
    public function setCustOfficer($custOfficer)
    {
        $this->cust_officer = $custOfficer;

        return $this;
    }

    /**
     * Get custOfficer
     *
     * @return string
     */
    public function getCustOfficer()
    {
        return $this->cust_officer;
    }

    /**
     * Set contactBy
     *
     * @param string $contactBy
     *
     * @return ListingForm
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
     * @return ListingForm
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
     * @return ListingForm
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ListingForm
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return ListingForm
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
     * Set dealerId
     *
     * @param int $dealerId
     *
     * @return ListingForm
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
     * Set customerId
     *
     * @param int $customerId
     *
     * @return ListingForm
     */
    public function setCustomerId($customerId)
    {
        $this->customer_id = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Set itemId
     *
     * @param int $itemId
     *
     * @return ListingForm
     */
    public function setItemId($itemId)
    {
        $this->item_id = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return int
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return ListingForm
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
     * @return ListingForm
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
     * @return ListingForm
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
     * Set dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     *
     * @return ListingForm
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
     * @return ListingForm
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
    /**
     * @var \Numa\DOAAdminBundle\Entity\Item
     */
    private $Item;


    /**
     * Set item
     *
     * @param \Numa\DOAAdminBundle\Entity\Item $item
     *
     * @return ListingForm
     */
    public function setItem(\Numa\DOAAdminBundle\Entity\Item $item = null)
    {
        $this->Item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \Numa\DOAAdminBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->Item;
    }
    /**
     * @var \DateTime
     * @JMS\Expose
     */
    private $date_drive;


    /**
     * Set dateDrive
     *
     * @param \DateTime $dateDrive
     *
     * @return ListingForm
     */
    public function setDateDrive($dateDrive)
    {
        $this->date_drive = $dateDrive;

        return $this;
    }

    /**
     * Get dateDrive
     *
     * @return \DateTime
     */
    public function getDateDrive()
    {
        return $this->date_drive;
    }
    /**
     * @var string
     * @JMS\Expose
     */
    private $type;


    /**
     * Set type
     *
     * @param string $type
     *
     * @return ListingForm
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @var integer
     */
    private $trade_in;

    /**
     * @var string
     */
    private $make;

    /**
     * @var string
     */
    private $model;

    /**
     * @var integer
     */
    private $year;

    /**
     * @var integer
     */
    private $kilometers;

    /**
     * Set tradeIn
     *
     * @param integer $tradeIn
     *
     * @return ListingForm
     */
    public function setTradeIn($tradeIn)
    {
        $this->trade_in = $tradeIn;

        return $this;
    }

    /**
     * Get tradeIn
     *
     * @return integer
     */
    public function getTradeIn()
    {
        return $this->trade_in;
    }

    /**
     * Set make
     *
     * @param string $make
     *
     * @return ListingForm
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
     * @return ListingForm
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
     * @param integer $year
     *
     * @return ListingForm
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set kilometers
     *
     * @param integer $kilometers
     *
     * @return ListingForm
     */
    public function setKilometers($kilometers)
    {
        $this->kilometers = $kilometers;

        return $this;
    }

    /**
     * Get kilometers
     *
     * @return integer
     */
    public function getKilometers()
    {
        return $this->kilometers;
    }


    /**
     * @var string
     */
    private $offer_amt;


    /**
     * Set offerAmt
     *
     * @param string $offerAmt
     *
     * @return ListingForm
     */
    public function setOfferAmt($offerAmt)
    {
        $this->offer_amt = $offerAmt;

        return $this;
    }

    /**
     * Get offerAmt
     *
     * @return string
     */
    public function getOfferAmt()
    {
        return $this->offer_amt;
    }
    /**
     * @var string
     */
    private $make_onsite;

    /**
     * @var string
     */
    private $model_onsite;

    /**
     * @var integer
     */
    private $year_onsite;


    /**
     * Set makeOnsite
     *
     * @param string $makeOnsite
     *
     * @return ListingForm
     */
    public function setMakeOnsite($makeOnsite)
    {
        $this->make_onsite = $makeOnsite;

        return $this;
    }

    /**
     * Get makeOnsite
     *
     * @return string
     */
    public function getMakeOnsite()
    {
        return $this->make_onsite;
    }

    /**
     * Set modelOnsite
     *
     * @param string $modelOnsite
     *
     * @return ListingForm
     */
    public function setModelOnsite($modelOnsite)
    {
        $this->model_onsite = $modelOnsite;

        return $this;
    }

    /**
     * Get modelOnsite
     *
     * @return string
     */
    public function getModelOnsite()
    {
        return $this->model_onsite;
    }

    /**
     * Set yearOnsite
     *
     * @param integer $yearOnsite
     *
     * @return ListingForm
     */
    public function setYearOnsite($yearOnsite)
    {
        $this->year_onsite = $yearOnsite;

        return $this;
    }

    /**
     * Get yearOnsite
     *
     * @return integer
     */
    public function getYearOnsite()
    {
        return $this->year_onsite;
    }
    /**
     * @var string
     */
    private $accessories;


    /**
     * Set accessories
     *
     * @param string $accessories
     *
     * @return ListingForm
     */
    public function setAccessories($accessories)
    {
        $this->accessories = $accessories;

        return $this;
    }

    /**
     * Get accessories
     *
     * @return string
     */
    public function getAccessories()
    {
        return $this->accessories;
    }
}
