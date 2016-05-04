<?php

namespace Numa\DOADMSBundle\Entity;

/**
 * ReminderItem
 */
class ReminderItem
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $reminder_id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \Numa\DOADMSBundle\Entity\Reminder
     */
    private $Reminder;


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
     * Set reminderId
     *
     * @param int $reminderId
     *
     * @return ReminderItem
     */
    public function setReminderId($reminderId)
    {
        $this->reminder_id = $reminderId;

        return $this;
    }

    /**
     * Get reminderId
     *
     * @return int
     */
    public function getReminderId()
    {
        return $this->reminder_id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ReminderItem
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ReminderItem
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return ReminderItem
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
     * Set reminder
     *
     * @param \Numa\DOADMSBundle\Entity\Reminder $reminder
     *
     * @return ReminderItem
     */
    public function setReminder(\Numa\DOADMSBundle\Entity\Reminder $reminder = null)
    {
        $this->Reminder = $reminder;

        return $this;
    }

    /**
     * Get reminder
     *
     * @return \Numa\DOADMSBundle\Entity\Reminder
     */
    public function getReminder()
    {
        return $this->Reminder;
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

