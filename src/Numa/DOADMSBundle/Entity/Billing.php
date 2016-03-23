<?php

namespace Numa\DOADMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Billing
 */
class Billing
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
    private $totalAMT;

    /**
     * @var string
     */
    private $comments;

    /**
     * @var \Numa\DOADMSBundle\Entity\Customer
     */
    private $Customer;

    /**
     * @var \DateTime
     */
    private $date_billing;


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
     * @return Billing
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Billing
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
     * @return Billing
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
     * @return Billing
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
     * Set totalAMT
     *
     * @param string $totalAMT
     *
     * @return Billing
     */
    public function setTotalAMT($totalAMT)
    {
        $this->totalAMT = $totalAMT;

        return $this;
    }

    /**
     * Get totalAMT
     *
     * @return string
     */
    public function getTotalAMT()
    {
        return $this->totalAMT;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Billing
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set customer
     *
     * @param \Numa\DOADMSBundle\Entity\Customer $customer
     *
     * @return Billing
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
     * Set dateBilling
     *
     * @param \DateTime $dateBilling
     *
     * @return Billing
     */
    public function setDateBilling($dateBilling)
    {
        $this->date_billing = $dateBilling;

        return $this;
    }

    /**
     * Get dateBilling
     *
     * @return \DateTime
     */
    public function getDateBilling()
    {
        return $this->date_billing;
    }
}
