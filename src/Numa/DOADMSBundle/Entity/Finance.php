<?php

namespace Numa\DOADMSBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;

/**
 * Finance
 * @JMS\ExclusionPolicy("ALL")
 */
class Finance
{
    /**
     * @var integer
     * @JMS\Expose
     */
    protected $applicant_type;
    /**
     * @var string
     * @JMS\Expose
     */
    protected $amount_required;
    protected $down_payment;
    protected $loan_term;
    protected $trade_in;

    protected $message_text;
    protected $make;
    protected $model;
    protected $year;
    protected $vehicle_type;
    protected $interested_in;
    /**
     * @var string
     * @JMS\Expose
     */
    protected $cust_name;
    protected $cust_last_name;
    protected $preferred_contact;
    /**
     * @var string
     * @JMS\Expose
     */
    protected $email;
    protected $day_phone;
    protected $cell_phone;
    protected $address;
    protected $city;
    protected $state;
    protected $zip_code;

    protected $ssn_sin_nr;
    protected $birth_date;
    protected $residence_type;
    protected $monthly_payment;
    protected $at_residence;

    protected $employer;
    protected $occupation;
    protected $monthly_income;
    protected $on_job;
    protected $business_phone;
    protected $employer_address;
    protected $employer_city;
    protected $employer_state;
    protected $employer_zip;


    protected $source;
    protected $other_monthly_income;

    public function getApplicantType()
    {
        return $this->applicant_type;
    }

    public function setApplicantType($applicant_type)
    {
        $this->applicant_type = $applicant_type;
    }
    public function getAmountRequired()
    {
        return $this->amount_required;
    }

    public function setAmountRequired($amount_required)
    {
        $this->amount_required = $amount_required;
    }
    public function getLoanTerm()
    {
        return $this->loan_term;
    }

    public function setLoanTerm($loan_term)
    {
        $this->loan_term = $loan_term;
    }
    public function getDownPayment()
    {
        return $this->down_payment;
    }

    public function setDownPayment($down_payment)
    {
        $this->down_payment = $down_payment;
    }
    public function getTradeIn()
    {
        return $this->trade_in;
    }

    public function setTradeIn($trade_in)
    {
        $this->trade_in = $trade_in;
    }



    public function getMessageText()
    {
        return $this->message_text;
    }

    public function setMessageText($message_text)
    {
        $this->message_text = $message_text;
    }
    public function getMake()
    {
        return $this->make;
    }

    public function setMake($make)
    {
        $this->make = $make;
    }
    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }
    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }
    public function getVehicleType()
    {
        return $this->vehicle_type;
    }

    public function setVehicleType($vehicle_type)
    {
        $this->vehicle_type = $vehicle_type;
    }
    public function getInterestedIn()
    {
        return $this->interested_in;
    }

    public function setInterestedIn($interested_in)
    {
        $this->interested_in = $interested_in;
    }



    public function getCustName()
    {
        return $this->cust_name;
    }

    public function setCustName($cust_name)
    {
        $this->cust_name = $cust_name;
    }
    public function getCustLastName()
    {
        return $this->cust_last_name;
    }

    public function setCustLastName($cust_last_name)
    {
        $this->cust_last_name = $cust_last_name;
    }
    public function getPreferredContact()
    {
        return $this->preferred_contact;
    }

    public function setPreferredContact($preferred_contact)
    {
        $this->preferred_contact = $preferred_contact;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getDayPhone()
    {
        return $this->day_phone;
    }

    public function setDayPhone($day_phone)
    {
        $this->day_phone = $day_phone;
    }
    public function getCellPhone()
    {
        return $this->cell_phone;
    }

    public function setCellPhone($cell_phone)
    {
        $this->cell_phone = $cell_phone;
    }
    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }
    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }
    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }
    public function getZipCode()
    {
        return $this->zip_code;
    }

    public function setZipCode($zip_code)
    {
        $this->zip_code = $zip_code;
    }


    public function getSsnSinNr()
    {
        return $this->ssn_sin_nr;
    }

    public function setSsnSinNr($ssn_sin_nr)
    {
        $this->ssn_sin_nr = $ssn_sin_nr;
    }
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    public function setBirthDate($birth_date)
    {
        $this->birth_date = $birth_date;
    }
    public function getResidenceType()
    {
        return $this->residence_type;
    }

    public function setResidenceType($residence_type)
    {
        $this->residence_type = $residence_type;
    }
    public function getMonthlyPayment()
    {
        return $this->monthly_payment;
    }

    public function setMonthlyPayment($monthly_payment)
    {
        $this->monthly_payment = $monthly_payment;
    }
    public function getAtResidence()
    {
        return $this->at_residence;
    }

    public function setAtResidence($at_residence)
    {
        $this->at_residence = $at_residence;
    }
    public function getEmployer()
    {
        return $this->employer;
    }

    public function setEmployer($employer)
    {
        $this->employer = $employer;
    }
    public function getOccupation()
    {
        return $this->occupation;
    }

    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
    }
    public function getMonthlyIncome()
    {
        return $this->monthly_income;
    }

    public function setMonthlyIncome($monthly_income)
    {
        $this->monthly_income = $monthly_income;
    }
    public function getOnJob()
    {
        return $this->on_job;
    }

    public function setOnJob($on_job)
    {
        $this->on_job = $on_job;
    }
    public function getBusinessPhone()
    {
        return $this->business_phone;
    }

    public function setBusinessPhone($business_phone)
    {
        $this->business_phone = $business_phone;
    }
    public function getEmployerAddress()
    {
        return $this->employer_address;
    }

    public function setEmployerAddress($employer_address)
    {
        $this->employer_address = $employer_address;
    }
    public function getEmployerCity()
    {
        return $this->employer_city;
    }

    public function setEmployerCity($employer_city)
    {
        $this->employer_city = $employer_city;
    }
    public function getEmployerState()
    {
        return $this->employer_state;
    }

    public function setEmployerState($employer_state)
    {
        $this->employer_state = $employer_state;
    }
    public function getEmployerZip()
    {
        return $this->employer_zip;
    }

    public function setEmployerZip($employer_zip)
    {
        $this->employer_zip = $employer_zip;
    }


    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }
    public function getOtherMonthlyIncome()
    {
    return $this->other_monthly_income;
    }

    public function setOtherMonthlyIncome($other_monthly_income)
    {
        $this->other_monthly_income = $other_monthly_income;
    }
    /**
     * @var integer
     * @JMS\Expose
     */
    private $id;

    /**
     * @var integer
     */
    private $dealer_id;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Dealer;


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
     * Set dealerId
     *
     * @param integer $dealerId
     *
     * @return Finance
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
     * Set dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     *
     * @return Finance
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
    /**
     * @var integer
     */
    private $customer_id;

    /**
     * @var \Numa\DOADMSBundle\Entity\Customer
     */
    private $Customer;


    /**
     * Set customerId
     *
     * @param integer $customerId
     *
     * @return Finance
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
     * Set customer
     *
     * @param \Numa\DOADMSBundle\Entity\Customer $customer
     *
     * @return Finance
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
     * @var \DateTime
     */
    private $date_updated;

    /**
     * @var \DateTime
     * @JMS\Expose
     */
    private $date_created;

    /**
     * @var string
     */
    private $status;


    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return Finance
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Finance
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
     * Set status
     *
     * @param string $status
     *
     * @return Finance
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
}
