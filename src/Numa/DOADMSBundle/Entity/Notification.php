<?php

namespace Numa\DOADMSBundle\Entity;

/**
 * Notification
 */
class Notification
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $customer_id;

    /**
     * @var integer
     */
    private $dealer_id;

    /**
     * @var string
     */
    private $contact_by;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \DateTime
     */
    private $date_sent;

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
     * @var string
     */
    private $type;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $SaveSearch;

    /**
     * @var \Numa\DOADMSBundle\Entity\Customer
     */
    private $Customer;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Dealer;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->SaveSearch = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set customerId
     *
     * @param integer $customerId
     *
     * @return Notification
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
     * Set dealerId
     *
     * @param integer $dealerId
     *
     * @return Notification
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
     * Set contactBy
     *
     * @param string $contactBy
     *
     * @return Notification
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
     * Set subject
     *
     * @param string $subject
     *
     * @return Notification
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Notification
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set dateSent
     *
     * @param \DateTime $dateSent
     *
     * @return Notification
     */
    public function setDateSent($dateSent)
    {
        $this->date_sent = $dateSent;

        return $this;
    }

    /**
     * Get dateSent
     *
     * @return \DateTime
     */
    public function getDateSent()
    {
        return $this->date_sent;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Notification
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
     * @return Notification
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
     * @return Notification
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
     * Set type
     *
     * @param string $type
     *
     * @return Notification
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
     * Add saveSearch
     *
     * @param \Numa\DOADMSBundle\Entity\SaveSearch $saveSearch
     *
     * @return Notification
     */
    public function addSaveSearch(\Numa\DOADMSBundle\Entity\SaveSearch $saveSearch)
    {
        $this->SaveSearch[] = $saveSearch;

        return $this;
    }

    /**
     * Remove saveSearch
     *
     * @param \Numa\DOADMSBundle\Entity\SaveSearch $saveSearch
     */
    public function removeSaveSearch(\Numa\DOADMSBundle\Entity\SaveSearch $saveSearch)
    {
        $this->SaveSearch->removeElement($saveSearch);
    }

    /**
     * Get saveSearch
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSaveSearch()
    {
        return $this->SaveSearch;
    }

    /**
     * Set customer
     *
     * @param \Numa\DOADMSBundle\Entity\Customer $customer
     *
     * @return Notification
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
     * Set dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     *
     * @return Notification
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
        // Add your code here
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        // Add your code here
    }
}

