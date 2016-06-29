<?php

namespace Numa\DOADMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;
/**
 * Reminder
 * @JMS\ExclusionPolicy("ALL")
 */
class Reminder
{
    /**
     * @var int
     * @JMS\Expose
     */
    private $id;

    /**
     * @var int
     * @JMS\Expose
     */
    private $customer_id;

    /**
     * @var \DateTime
     * @JMS\Expose
     */
    private $date;

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
     * @return Reminder
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Reminder
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Reminder
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
     * @return Reminder
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
     * @return Reminder
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
     * @return Reminder
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
     * @var int
     */
    private $reminderItem_id;


    /**
     * Set reminderItemId
     *
     * @param int $reminderItemId
     *
     * @return Reminder
     */
    public function setReminderItemId($reminderItemId)
    {
        $this->reminderItem_id = $reminderItemId;

        return $this;
    }

    /**
     * Get reminderItemId
     *
     * @return int
     */
    public function getReminderItemId()
    {
        return $this->reminderItem_id;
    }
    /**
     * @var \Numa\DOADMSBundle\Entity\ReminderItem
     */
    private $ReminderItem;


    /**
     * Set reminderItem
     *
     * @param \Numa\DOADMSBundle\Entity\ReminderItem $reminderItem
     *
     * @return Reminder
     */
    public function setReminderItem(\Numa\DOADMSBundle\Entity\ReminderItem $reminderItem = null)
    {
        $this->ReminderItem = $reminderItem;

        return $this;
    }

    /**
     * Get reminderItem
     *
     * @return \Numa\DOADMSBundle\Entity\ReminderItem
     */
    public function getReminderItem()
    {
        return $this->ReminderItem;
    }
    /**
     * @var string
     */
    private $comment;


    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Reminder
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
}
