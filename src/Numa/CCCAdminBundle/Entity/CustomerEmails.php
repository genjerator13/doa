<?php

namespace Numa\CCCAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerEmails
 */
class CustomerEmails
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
     * @var string
     */
    private $email;

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
     * Set customer_id
     *
     * @param integer $customerId
     * @return CustomerEmails
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
     * Set email
     *
     * @param string $email
     * @return CustomerEmails
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
     * Set Customers
     *
     * @param \Numa\CCCAdminBundle\Entity\Customers $customers
     * @return CustomerEmails
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
    /**
     * @var boolean
     */
    private $selected;


    /**
     * Set selected
     *
     * @param boolean $selected
     * @return CustomerEmails
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;
    
        return $this;
    }

    /**
     * Get selected
     *
     * @return boolean 
     */
    public function getSelected()
    {
        return $this->selected;
    }
}
