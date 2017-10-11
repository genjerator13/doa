<?php

namespace Numa\CCCAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommandLog
 */
class CommandLog
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $command;

    /**
     * @var string
     */
    private $category;

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
    private $total_probills;

    /**
     * @var integer
     */
    private $currrent_probill;

    /**
     * @var integer
     */
    private $total_customers;

    /**
     * @var integer
     */
    private $currrent_customer;

    /**
     * @var integer
     */
    private $total_vehtypes;

    /**
     * @var integer
     */
    private $currrent_vehtype;

    /**
     * @var integer
     */
    private $total_drivers;

    /**
     * @var integer
     */
    private $currrent_driver;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $full_details;

    /**
     * @var \stdClass
     */
    private $full_details_object;


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
     * Set command
     *
     * @param string $command
     * @return CommandLog
     */
    public function setCommand($command)
    {
        $this->command = $command;
    
        return $this;
    }

    /**
     * Get command
     *
     * @return string 
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return CommandLog
     */
    public function setCategory($category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set started_at
     *
     * @param \DateTime $startedAt
     * @return CommandLog
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
     * @return CommandLog
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
     * Set total_probills
     *
     * @param integer $totalProbills
     * @return CommandLog
     */
    public function setTotalProbills($totalProbills)
    {
        $this->total_probills = $totalProbills;
    
        return $this;
    }

    /**
     * Get total_probills
     *
     * @return integer 
     */
    public function getTotalProbills()
    {
        return $this->total_probills;
    }

    /**
     * Set currrent_probill
     *
     * @param integer $currrentProbill
     * @return CommandLog
     */
    public function setCurrrentProbill($currrentProbill)
    {
        $this->currrent_probill = $currrentProbill;
    
        return $this;
    }

    /**
     * Get currrent_probill
     *
     * @return integer 
     */
    public function getCurrrentProbill()
    {
        return $this->currrent_probill;
    }

    /**
     * Set total_customers
     *
     * @param integer $totalCustomers
     * @return CommandLog
     */
    public function setTotalCustomers($totalCustomers)
    {
        $this->total_customers = $totalCustomers;
    
        return $this;
    }

    /**
     * Get total_customers
     *
     * @return integer 
     */
    public function getTotalCustomers()
    {
        return $this->total_customers;
    }

    /**
     * Set currrent_customer
     *
     * @param integer $currrentCustomer
     * @return CommandLog
     */
    public function setCurrrentCustomer($currrentCustomer)
    {
        $this->currrent_customer = $currrentCustomer;
    
        return $this;
    }

    /**
     * Get currrent_customer
     *
     * @return integer 
     */
    public function getCurrrentCustomer()
    {
        return $this->currrent_customer;
    }

    /**
     * Set total_vehtypes
     *
     * @param integer $totalVehtypes
     * @return CommandLog
     */
    public function setTotalVehtypes($totalVehtypes)
    {
        $this->total_vehtypes = $totalVehtypes;
    
        return $this;
    }

    /**
     * Get total_vehtypes
     *
     * @return integer 
     */
    public function getTotalVehtypes()
    {
        return $this->total_vehtypes;
    }

    /**
     * Set currrent_vehtype
     *
     * @param integer $currrentVehtype
     * @return CommandLog
     */
    public function setCurrrentVehtype($currrentVehtype)
    {
        $this->currrent_vehtype = $currrentVehtype;
    
        return $this;
    }

    /**
     * Get currrent_vehtype
     *
     * @return integer 
     */
    public function getCurrrentVehtype()
    {
        return $this->currrent_vehtype;
    }

    /**
     * Set total_drivers
     *
     * @param integer $totalDrivers
     * @return CommandLog
     */
    public function setTotalDrivers($totalDrivers)
    {
        $this->total_drivers = $totalDrivers;
    
        return $this;
    }

    /**
     * Get total_drivers
     *
     * @return integer 
     */
    public function getTotalDrivers()
    {
        return $this->total_drivers;
    }

    /**
     * Set currrent_driver
     *
     * @param integer $currrentDriver
     * @return CommandLog
     */
    public function setCurrrentDriver($currrentDriver)
    {
        $this->currrent_driver = $currrentDriver;
    
        return $this;
    }

    /**
     * Get currrent_driver
     *
     * @return integer 
     */
    public function getCurrrentDriver()
    {
        return $this->currrent_driver;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return CommandLog
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
     * Set full_details
     *
     * @param string $fullDetails
     * @return CommandLog
     */
    public function setFullDetails($fullDetails)
    {
        $this->full_details = $fullDetails;
    
        return $this;
    }

    /**
     * Get full_details
     *
     * @return string 
     */
    public function getFullDetails()
    {
        return $this->full_details;
    }

    /**
     * Set full_details_object
     *
     * @param \stdClass $fullDetailsObject
     * @return CommandLog
     */
    public function setFullDetailsObject($fullDetailsObject)
    {
        $this->full_details_object = $fullDetailsObject;
    
        return $this;
    }

    /**
     * Get full_details_object
     *
     * @return \stdClass 
     */
    public function getFullDetailsObject()
    {
        return $this->full_details_object;
    }
    /**
     * @ORM\PrePersist
     */
    public function setStartedAtValue()
    {
        // Add your code here
    }
    /**
     * @var integer
     */
    private $total_rates;

    /**
     * @var integer
     */
    private $currrent_rate;


    /**
     * Set total_rates
     *
     * @param integer $totalRates
     * @return CommandLog
     */
    public function setTotalRates($totalRates)
    {
        $this->total_rates = $totalRates;
    
        return $this;
    }

    /**
     * Get total_rates
     *
     * @return integer 
     */
    public function getTotalRates()
    {
        return $this->total_rates;
    }

    /**
     * Set currrent_rate
     *
     * @param integer $currrentRate
     * @return CommandLog
     */
    public function setCurrrentRate($currrentRate)
    {
        $this->currrent_rate = $currrentRate;
    
        return $this;
    }

    /**
     * Get currrent_rate
     *
     * @return integer 
     */
    public function getCurrrentRate()
    {
        return $this->currrent_rate;
    }
    
    public function isFinished(){
        
        return !empty($this->ended_at) && $this->status=='finished' ;
    }
    /**
     * @var integer
     */
    private $current_probill;

    /**
     * @var integer
     */
    private $current_customer;

    /**
     * @var integer
     */
    private $current_vehtype;

    /**
     * @var integer
     */
    private $current_driver;

    /**
     * @var integer
     */
    private $current_rate;


    /**
     * Set current_probill
     *
     * @param integer $currentProbill
     * @return CommandLog
     */
    public function setCurrentProbill($currentProbill)
    {
        $this->current_probill = $currentProbill;
    
        return $this;
    }

    /**
     * Get current_probill
     *
     * @return integer 
     */
    public function getCurrentProbill()
    {
        return $this->current_probill;
    }

    /**
     * Set current_customer
     *
     * @param integer $currentCustomer
     * @return CommandLog
     */
    public function setCurrentCustomer($currentCustomer)
    {
        $this->current_customer = $currentCustomer;
    
        return $this;
    }

    /**
     * Get current_customer
     *
     * @return integer 
     */
    public function getCurrentCustomer()
    {
        return $this->current_customer;
    }

    /**
     * Set current_vehtype
     *
     * @param integer $currentVehtype
     * @return CommandLog
     */
    public function setCurrentVehtype($currentVehtype)
    {
        $this->current_vehtype = $currentVehtype;
    
        return $this;
    }

    /**
     * Get current_vehtype
     *
     * @return integer 
     */
    public function getCurrentVehtype()
    {
        return $this->current_vehtype;
    }

    /**
     * Set current_driver
     *
     * @param integer $currentDriver
     * @return CommandLog
     */
    public function setCurrentDriver($currentDriver)
    {
        $this->current_driver = $currentDriver;
    
        return $this;
    }

    /**
     * Get current_driver
     *
     * @return integer 
     */
    public function getCurrentDriver()
    {
        return $this->current_driver;
    }

    /**
     * Set current_rate
     *
     * @param integer $currentRate
     * @return CommandLog
     */
    public function setCurrentRate($currentRate)
    {
        $this->current_rate = $currentRate;
    
        return $this;
    }

    /**
     * Get current_rate
     *
     * @return integer 
     */
    public function getCurrentRate()
    {
        return $this->current_rate;
    }
    /**
     * @var integer
     */
    private $total;

    /**
     * @var integer
     */
    private $current;


    /**
     * Set total
     *
     * @param integer $total
     * @return CommandLog
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set current
     *
     * @param integer $current
     * @return CommandLog
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    
        return $this;
    }

    /**
     * Get current
     *
     * @return integer 
     */
    public function getCurrent()
    {
        return $this->current;
    }
}
