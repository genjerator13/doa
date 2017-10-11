<?php

namespace Numa\CCCAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emails
 */
class Emails
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $started_at;

    /**
     * @var \DateTime
     */
    private $ended_at;

    /**
     * @var integer
     */
    private $customer_id;

    /**
     * @var integer
     */
    private $batch_id;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $attachment;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $email_from;

    /**
     * @var string
     */
    private $email_to;

    /**
     * @var \Numa\CCCAdminBundle\Entity\Customers
     */
    private $Customers;


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
     * Set started_at
     *
     * @param \DateTime $startedAt
     * @return Emails
     */
    public function setStartedAt($startedAt)
    {
        $this->started_at = $startedAt;
    
        return $this;
    }

    /**
     * Get started_at
     *
     * @return \DateTime 
     */
    public function getStartedAt()
    {
        return $this->started_at;
    }

    /**
     * Set ended_at
     *
     * @param \DateTime $endedAt
     * @return Emails
     */
    public function setEndedAt($endedAt)
    {
        $this->ended_at = $endedAt;
    
        return $this;
    }

    /**
     * Get ended_at
     *
     * @return \DateTime 
     */
    public function getEndedAt()
    {
        return $this->ended_at;
    }

    /**
     * Set customer_id
     *
     * @param integer $customerId
     * @return Emails
     */
    public function setCustomerId($customerId)
    {
        $this->customer_id = $customerId;
    
        return $this;
    }

    /**
     * Get customer_id
     *
     * @return integer 
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Set batch_id
     *
     * @param integer $batchId
     * @return Emails
     */
    public function setBatchId($batchId)
    {
        $this->batch_id = $batchId;
    
        return $this;
    }

    /**
     * Get batch_id
     *
     * @return integer 
     */
    public function getBatchId()
    {
        return $this->batch_id;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Emails
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
     * Set body
     *
     * @param string $body
     * @return Emails
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set attachment
     *
     * @param string $attachment
     * @return Emails
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
    
        return $this;
    }

    /**
     * Get attachment
     *
     * @return string 
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return Emails
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
     * Set email_from
     *
     * @param string $emailFrom
     * @return Emails
     */
    public function setEmailFrom($emailFrom)
    {
        $this->email_from = $emailFrom;
    
        return $this;
    }

    /**
     * Get email_from
     *
     * @return string 
     */
    public function getEmailFrom()
    {
        return $this->email_from;
    }

    /**
     * Set email_to
     *
     * @param string $emailTo
     * @return Emails
     */
    public function setEmailTo($emailTo)
    {
        $this->email_to = $emailTo;
    
        return $this;
    }

    /**
     * Get email_to
     *
     * @return string 
     */
    public function getEmailTo()
    {
        return $this->email_to;
    }

    /**
     * Set Customers
     *
     * @param \Numa\CCCAdminBundle\Entity\Customers $customers
     * @return Emails
     */
    public function setCustomers(\Numa\CCCAdminBundle\Entity\Customers $customers = null)
    {
        $this->Customers = $customers;
    
        return $this;
    }

    /**
     * Get Customers
     *
     * @return \Numa\CCCAdminBundle\Entity\Customers 
     */
    public function getCustomers()
    {
        return $this->Customers;
    }
}
