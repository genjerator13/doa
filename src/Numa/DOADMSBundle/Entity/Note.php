<?php

namespace Numa\DOADMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 */
class Note
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $customer_id;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $notes;

    /**
     * @var \DateTime
     */
    private $date_remind;

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
     * Set customerId
     *
     * @param int $customerId
     *
     * @return Note
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
     * Set subject
     *
     * @param string $subject
     *
     * @return Note
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
     * Set notes
     *
     * @param string $notes
     *
     * @return Note
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set dateRemind
     *
     * @param \DateTime $dateRemind
     *
     * @return Note
     */
    public function setDateRemind($dateRemind)
    {
        $this->date_remind = $dateRemind;

        return $this;
    }

    /**
     * Get dateRemind
     *
     * @return \DateTime
     */
    public function getDateRemind()
    {
        return $this->date_remind;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Note
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
     * @return Note
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
     * @return Note
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
     * Set customer
     *
     * @param \Numa\DOADMSBundle\Entity\Customer $customer
     *
     * @return Note
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

