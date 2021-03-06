<?php

namespace Numa\DOADMSBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Finance
 * @JMS\ExclusionPolicy("ALL")
 */
class FinanceService
{
    /**
     * @var integer
     * @JMS\Expose
     */
    private $id;

    /**
     * @var integer
     * @JMS\Expose
     */
    private $dealer_id;

    /**
     * @var integer
     * @JMS\Expose
     */
    private $customer_id;

    /**
     * @var string
     * @JMS\Expose
     */
    private $cust_name;

    /**
     * @var string
     * @JMS\Expose
     */
    private $cust_last_name;

    /**
     * @var string
     * @JMS\Expose
     */
    private $preferred_contact;

    /**
     * @var string
     * @JMS\Expose
     */
    private $email;

    /**
     * @var string
     * @JMS\Expose
     */
    private $day_phone;

    /**
     * @var string
     * @JMS\Expose
     */
    private $cell_phone;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $zip_code;

    /**
     * @var string
     */
    private $ssn_sin_nr;

    /**
     * @var \DateTime
     */
    private $birth_date;

    /**
     * @var string
     */
    private $residence_type;

    /**
     * @var string
     */
    private $monthly_payment;

    /**
     * @var \DateTime
     */
    private $at_residence;

    /**
     * @var string
     */
    private $landlord_name;

    /**
     * @var string
     */
    private $landlord_phone;

    /**
     * @var string
     */
    private $employer_name;

    /**
     * @var string
     */
    private $employer_occupation;

    /**
     * @var string
     */
    private $employer_monthly_income;

    /**
     * @var \DateTime
     */
    private $employer_on_job;

    /**
     * @var string
     */
    private $employer_business_phone;

    /**
     * @var string
     */
    private $employer_address;

    /**
     * @var string
     */
    private $employer_city;

    /**
     * @var string
     */
    private $employer_state;

    /**
     * @var string
     */
    private $employer_zip;

    /**
     * @var string
     */
    private $supervisors_name;

    /**
     * @var string
     */
    private $other_name;

    /**
     * @var string
     */
    private $other_address;

    /**
     * @var string
     */
    private $other_city;

    /**
     * @var string
     */
    private $other_state;

    /**
     * @var string
     */
    private $other_zip;

    /**
     * @var string
     */
    private $other_home_phone;

    /**
     * @var string
     */
    private $other_work_phone;

    /**
     * @var string
     */
    private $make;

    /**
     * @var string
     */
    private $model;

    /**
     * @var string
     */
    private $year;

    /**
     * @var string
     */
    private $vehicle_type;

    /**
     * @var string
     */
    private $plate;

    /**
     * @var string
     */
    private $vin;

    /**
     * @var string
     */
    private $mileage;

    /**
     * @var string
     */
    private $financed_by;

    /**
     * @var string
     */
    private $message_text;

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
     * @return FinanceService
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
     * Set customerId
     *
     * @param integer $customerId
     *
     * @return FinanceService
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
     * Set custName
     *
     * @param string $custName
     *
     * @return FinanceService
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
     * @return FinanceService
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
     * Set preferredContact
     *
     * @param string $preferredContact
     *
     * @return FinanceService
     */
    public function setPreferredContact($preferredContact)
    {
        $this->preferred_contact = $preferredContact;

        return $this;
    }

    /**
     * Get preferredContact
     *
     * @return string
     */
    public function getPreferredContact()
    {
        return $this->preferred_contact;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return FinanceService
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
     * Set dayPhone
     *
     * @param string $dayPhone
     *
     * @return FinanceService
     */
    public function setDayPhone($dayPhone)
    {
        $this->day_phone = $dayPhone;

        return $this;
    }

    /**
     * Get dayPhone
     *
     * @return string
     */
    public function getDayPhone()
    {
        return $this->day_phone;
    }

    /**
     * Set cellPhone
     *
     * @param string $cellPhone
     *
     * @return FinanceService
     */
    public function setCellPhone($cellPhone)
    {
        $this->cell_phone = $cellPhone;

        return $this;
    }

    /**
     * Get cellPhone
     *
     * @return string
     */
    public function getCellPhone()
    {
        return $this->cell_phone;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return FinanceService
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return FinanceService
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return FinanceService
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return FinanceService
     */
    public function setZipCode($zipCode)
    {
        $this->zip_code = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }

    /**
     * Set ssnSinNr
     *
     * @param string $ssnSinNr
     *
     * @return FinanceService
     */
    public function setSsnSinNr($ssnSinNr)
    {
        $this->ssn_sin_nr = $ssnSinNr;

        return $this;
    }

    /**
     * Get ssnSinNr
     *
     * @return string
     */
    public function getSsnSinNr()
    {
        return $this->ssn_sin_nr;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return FinanceService
     */
    public function setBirthDate($birthDate)
    {
        $this->birth_date = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * Set residenceType
     *
     * @param string $residenceType
     *
     * @return FinanceService
     */
    public function setResidenceType($residenceType)
    {
        $this->residence_type = $residenceType;

        return $this;
    }

    /**
     * Get residenceType
     *
     * @return string
     */
    public function getResidenceType()
    {
        return $this->residence_type;
    }

    /**
     * Set monthlyPayment
     *
     * @param string $monthlyPayment
     *
     * @return FinanceService
     */
    public function setMonthlyPayment($monthlyPayment)
    {
        $this->monthly_payment = $monthlyPayment;

        return $this;
    }

    /**
     * Get monthlyPayment
     *
     * @return string
     */
    public function getMonthlyPayment()
    {
        return $this->monthly_payment;
    }

    /**
     * Set atResidence
     *
     * @param \DateTime $atResidence
     *
     * @return FinanceService
     */
    public function setAtResidence($atResidence)
    {
        $this->at_residence = $atResidence;

        return $this;
    }

    /**
     * Get atResidence
     *
     * @return \DateTime
     */
    public function getAtResidence()
    {
        return $this->at_residence;
    }

    /**
     * Set landlordName
     *
     * @param string $landlordName
     *
     * @return FinanceService
     */
    public function setLandlordName($landlordName)
    {
        $this->landlord_name = $landlordName;

        return $this;
    }

    /**
     * Get landlordName
     *
     * @return string
     */
    public function getLandlordName()
    {
        return $this->landlord_name;
    }

    /**
     * Set landlordPhone
     *
     * @param string $landlordPhone
     *
     * @return FinanceService
     */
    public function setLandlordPhone($landlordPhone)
    {
        $this->landlord_phone = $landlordPhone;

        return $this;
    }

    /**
     * Get landlordPhone
     *
     * @return string
     */
    public function getLandlordPhone()
    {
        return $this->landlord_phone;
    }

    /**
     * Set employerName
     *
     * @param string $employerName
     *
     * @return FinanceService
     */
    public function setEmployerName($employerName)
    {
        $this->employer_name = $employerName;

        return $this;
    }

    /**
     * Get employerName
     *
     * @return string
     */
    public function getEmployerName()
    {
        return $this->employer_name;
    }

    /**
     * Set employerOccupation
     *
     * @param string $employerOccupation
     *
     * @return FinanceService
     */
    public function setEmployerOccupation($employerOccupation)
    {
        $this->employer_occupation = $employerOccupation;

        return $this;
    }

    /**
     * Get employerOccupation
     *
     * @return string
     */
    public function getEmployerOccupation()
    {
        return $this->employer_occupation;
    }

    /**
     * Set employerMonthlyIncome
     *
     * @param string $employerMonthlyIncome
     *
     * @return FinanceService
     */
    public function setEmployerMonthlyIncome($employerMonthlyIncome)
    {
        $this->employer_monthly_income = $employerMonthlyIncome;

        return $this;
    }

    /**
     * Get employerMonthlyIncome
     *
     * @return string
     */
    public function getEmployerMonthlyIncome()
    {
        return $this->employer_monthly_income;
    }

    /**
     * Set employerOnJob
     *
     * @param \DateTime $employerOnJob
     *
     * @return FinanceService
     */
    public function setEmployerOnJob($employerOnJob)
    {
        $this->employer_on_job = $employerOnJob;

        return $this;
    }

    /**
     * Get employerOnJob
     *
     * @return \DateTime
     */
    public function getEmployerOnJob()
    {
        return $this->employer_on_job;
    }

    /**
     * Set employerBusinessPhone
     *
     * @param string $employerBusinessPhone
     *
     * @return FinanceService
     */
    public function setEmployerBusinessPhone($employerBusinessPhone)
    {
        $this->employer_business_phone = $employerBusinessPhone;

        return $this;
    }

    /**
     * Get employerBusinessPhone
     *
     * @return string
     */
    public function getEmployerBusinessPhone()
    {
        return $this->employer_business_phone;
    }

    /**
     * Set employerAddress
     *
     * @param string $employerAddress
     *
     * @return FinanceService
     */
    public function setEmployerAddress($employerAddress)
    {
        $this->employer_address = $employerAddress;

        return $this;
    }

    /**
     * Get employerAddress
     *
     * @return string
     */
    public function getEmployerAddress()
    {
        return $this->employer_address;
    }

    /**
     * Set employerCity
     *
     * @param string $employerCity
     *
     * @return FinanceService
     */
    public function setEmployerCity($employerCity)
    {
        $this->employer_city = $employerCity;

        return $this;
    }

    /**
     * Get employerCity
     *
     * @return string
     */
    public function getEmployerCity()
    {
        return $this->employer_city;
    }

    /**
     * Set employerState
     *
     * @param string $employerState
     *
     * @return FinanceService
     */
    public function setEmployerState($employerState)
    {
        $this->employer_state = $employerState;

        return $this;
    }

    /**
     * Get employerState
     *
     * @return string
     */
    public function getEmployerState()
    {
        return $this->employer_state;
    }

    /**
     * Set employerZip
     *
     * @param string $employerZip
     *
     * @return FinanceService
     */
    public function setEmployerZip($employerZip)
    {
        $this->employer_zip = $employerZip;

        return $this;
    }

    /**
     * Get employerZip
     *
     * @return string
     */
    public function getEmployerZip()
    {
        return $this->employer_zip;
    }

    /**
     * Set supervisorsName
     *
     * @param string $supervisorsName
     *
     * @return FinanceService
     */
    public function setSupervisorsName($supervisorsName)
    {
        $this->supervisors_name = $supervisorsName;

        return $this;
    }

    /**
     * Get supervisorsName
     *
     * @return string
     */
    public function getSupervisorsName()
    {
        return $this->supervisors_name;
    }

    /**
     * Set otherName
     *
     * @param string $otherName
     *
     * @return FinanceService
     */
    public function setOtherName($otherName)
    {
        $this->other_name = $otherName;

        return $this;
    }

    /**
     * Get otherName
     *
     * @return string
     */
    public function getOtherName()
    {
        return $this->other_name;
    }

    /**
     * Set otherAddress
     *
     * @param string $otherAddress
     *
     * @return FinanceService
     */
    public function setOtherAddress($otherAddress)
    {
        $this->other_address = $otherAddress;

        return $this;
    }

    /**
     * Get otherAddress
     *
     * @return string
     */
    public function getOtherAddress()
    {
        return $this->other_address;
    }

    /**
     * Set otherCity
     *
     * @param string $otherCity
     *
     * @return FinanceService
     */
    public function setOtherCity($otherCity)
    {
        $this->other_city = $otherCity;

        return $this;
    }

    /**
     * Get otherCity
     *
     * @return string
     */
    public function getOtherCity()
    {
        return $this->other_city;
    }

    /**
     * Set otherState
     *
     * @param string $otherState
     *
     * @return FinanceService
     */
    public function setOtherState($otherState)
    {
        $this->other_state = $otherState;

        return $this;
    }

    /**
     * Get otherState
     *
     * @return string
     */
    public function getOtherState()
    {
        return $this->other_state;
    }

    /**
     * Set otherZip
     *
     * @param string $otherZip
     *
     * @return FinanceService
     */
    public function setOtherZip($otherZip)
    {
        $this->other_zip = $otherZip;

        return $this;
    }

    /**
     * Get otherZip
     *
     * @return string
     */
    public function getOtherZip()
    {
        return $this->other_zip;
    }

    /**
     * Set otherHomePhone
     *
     * @param string $otherHomePhone
     *
     * @return FinanceService
     */
    public function setOtherHomePhone($otherHomePhone)
    {
        $this->other_home_phone = $otherHomePhone;

        return $this;
    }

    /**
     * Get otherHomePhone
     *
     * @return string
     */
    public function getOtherHomePhone()
    {
        return $this->other_home_phone;
    }

    /**
     * Set otherWorkPhone
     *
     * @param string $otherWorkPhone
     *
     * @return FinanceService
     */
    public function setOtherWorkPhone($otherWorkPhone)
    {
        $this->other_work_phone = $otherWorkPhone;

        return $this;
    }

    /**
     * Get otherWorkPhone
     *
     * @return string
     */
    public function getOtherWorkPhone()
    {
        return $this->other_work_phone;
    }

    /**
     * Set make
     *
     * @param string $make
     *
     * @return FinanceService
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
     * @return FinanceService
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
     * @param string $year
     *
     * @return FinanceService
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set vehicleType
     *
     * @param string $vehicleType
     *
     * @return FinanceService
     */
    public function setVehicleType($vehicleType)
    {
        $this->vehicle_type = $vehicleType;

        return $this;
    }

    /**
     * Get vehicleType
     *
     * @return string
     */
    public function getVehicleType()
    {
        return $this->vehicle_type;
    }

    /**
     * Set plate
     *
     * @param string $plate
     *
     * @return FinanceService
     */
    public function setPlate($plate)
    {
        $this->plate = $plate;

        return $this;
    }

    /**
     * Get plate
     *
     * @return string
     */
    public function getPlate()
    {
        return $this->plate;
    }

    /**
     * Set vin
     *
     * @param string $vin
     *
     * @return FinanceService
     */
    public function setVin($vin)
    {
        $this->vin = $vin;

        return $this;
    }

    /**
     * Get vin
     *
     * @return string
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * Set mileage
     *
     * @param string $mileage
     *
     * @return FinanceService
     */
    public function setMileage($mileage)
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * Get mileage
     *
     * @return string
     */
    public function getMileage()
    {
        return $this->mileage;
    }

    /**
     * Set financedBy
     *
     * @param string $financedBy
     *
     * @return FinanceService
     */
    public function setFinancedBy($financedBy)
    {
        $this->financed_by = $financedBy;

        return $this;
    }

    /**
     * Get financedBy
     *
     * @return string
     */
    public function getFinancedBy()
    {
        return $this->financed_by;
    }

    /**
     * Set messageText
     *
     * @param string $messageText
     *
     * @return FinanceService
     */
    public function setMessageText($messageText)
    {
        $this->message_text = $messageText;

        return $this;
    }

    /**
     * Get messageText
     *
     * @return string
     */
    public function getMessageText()
    {
        return $this->message_text;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return FinanceService
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
     * @return FinanceService
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
     * @return FinanceService
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
     * @return FinanceService
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
     * @return FinanceService
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
}
