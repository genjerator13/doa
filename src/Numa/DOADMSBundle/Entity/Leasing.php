<?php

namespace Numa\DOADMSBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Leasing
 */
class Leasing
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $dealer_id;

    /**
     * @var integer
     */
    private $customer_id;

    /**
     * @var string
     */
    private $company_name;

    /**
     * @var string
     */
    private $company_contact;

    /**
     * @var string
     */
    private $company_preferred_contact;

    /**
     * @var string
     */
    private $company_email;

    /**
     * @var string
     */
    private $company_day_phone;

    /**
     * @var string
     */
    private $company_cell_phone;

    /**
     * @var string
     */
    private $company_fax;

    /**
     * @var string
     */
    private $company_address;

    /**
     * @var string
     */
    private $company_city;

    /**
     * @var string
     */
    private $company_zip_code;

    /**
     * @var string
     */
    private $company_type_of_business;

    /**
     * @var \DateTime
     */
    private $company_in_business_since;

    /**
     * @var string
     */
    private $company_legal_structure;

    /**
     * @var string
     */
    private $company_land;

    /**
     * @var string
     */
    private $cust_first_name;

    /**
     * @var string
     */
    private $cust_last_name;

    /**
     * @var string
     */
    private $preferred_contact;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $day_phone;

    /**
     * @var string
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
    private $material_status;

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
    private $real_estate;

    /**
     * @var string
     */
    private $landlord_phone;

    /**
     * @var string
     */
    private $mortgage_balance;

    /**
     * @var string
     */
    private $previous_bankruptcy;

    /**
     * @var string
     */
    private $employer_company;

    /**
     * @var string
     */
    private $employer_position;

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
    private $employer_previous_address;

    /**
     * @var string
     */
    private $employer_previous_city;

    /**
     * @var string
     */
    private $employer_previous_state;

    /**
     * @var string
     */
    private $employer_previous_zip;

    /**
     * @var string
     */
    private $vendor_company;

    /**
     * @var string
     */
    private $vendor_address;

    /**
     * @var string
     */
    private $vendor_city;

    /**
     * @var string
     */
    private $vendor_contact;

    /**
     * @var string
     */
    private $vendor_phone;

    /**
     * @var string
     */
    private $vendor_email;

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
    private $message_text;

    /**
     * @var \DateTime
     */
    private $date_updated;

    /**
     * @var \DateTime
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
     * @return Leasing
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
     * @return Leasing
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
     * Set companyName
     *
     * @param string $companyName
     *
     * @return Leasing
     */
    public function setCompanyName($companyName)
    {
        $this->company_name = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * Set companyContact
     *
     * @param string $companyContact
     *
     * @return Leasing
     */
    public function setCompanyContact($companyContact)
    {
        $this->company_contact = $companyContact;

        return $this;
    }

    /**
     * Get companyContact
     *
     * @return string
     */
    public function getCompanyContact()
    {
        return $this->company_contact;
    }

    /**
     * Set companyPreferredContact
     *
     * @param string $companyPreferredContact
     *
     * @return Leasing
     */
    public function setCompanyPreferredContact($companyPreferredContact)
    {
        $this->company_preferred_contact = $companyPreferredContact;

        return $this;
    }

    /**
     * Get companyPreferredContact
     *
     * @return string
     */
    public function getCompanyPreferredContact()
    {
        return $this->company_preferred_contact;
    }

    /**
     * Set companyEmail
     *
     * @param string $companyEmail
     *
     * @return Leasing
     */
    public function setCompanyEmail($companyEmail)
    {
        $this->company_email = $companyEmail;

        return $this;
    }

    /**
     * Get companyEmail
     *
     * @return string
     */
    public function getCompanyEmail()
    {
        return $this->company_email;
    }

    /**
     * Set companyDayPhone
     *
     * @param string $companyDayPhone
     *
     * @return Leasing
     */
    public function setCompanyDayPhone($companyDayPhone)
    {
        $this->company_day_phone = $companyDayPhone;

        return $this;
    }

    /**
     * Get companyDayPhone
     *
     * @return string
     */
    public function getCompanyDayPhone()
    {
        return $this->company_day_phone;
    }

    /**
     * Set companyCellPhone
     *
     * @param string $companyCellPhone
     *
     * @return Leasing
     */
    public function setCompanyCellPhone($companyCellPhone)
    {
        $this->company_cell_phone = $companyCellPhone;

        return $this;
    }

    /**
     * Get companyCellPhone
     *
     * @return string
     */
    public function getCompanyCellPhone()
    {
        return $this->company_cell_phone;
    }

    /**
     * Set companyFax
     *
     * @param string $companyFax
     *
     * @return Leasing
     */
    public function setCompanyFax($companyFax)
    {
        $this->company_fax = $companyFax;

        return $this;
    }

    /**
     * Get companyFax
     *
     * @return string
     */
    public function getCompanyFax()
    {
        return $this->company_fax;
    }

    /**
     * Set companyAddress
     *
     * @param string $companyAddress
     *
     * @return Leasing
     */
    public function setCompanyAddress($companyAddress)
    {
        $this->company_address = $companyAddress;

        return $this;
    }

    /**
     * Get companyAddress
     *
     * @return string
     */
    public function getCompanyAddress()
    {
        return $this->company_address;
    }

    /**
     * Set companyCity
     *
     * @param string $companyCity
     *
     * @return Leasing
     */
    public function setCompanyCity($companyCity)
    {
        $this->company_city = $companyCity;

        return $this;
    }

    /**
     * Get companyCity
     *
     * @return string
     */
    public function getCompanyCity()
    {
        return $this->company_city;
    }

    /**
     * Set companyZipCode
     *
     * @param string $companyZipCode
     *
     * @return Leasing
     */
    public function setCompanyZipCode($companyZipCode)
    {
        $this->company_zip_code = $companyZipCode;

        return $this;
    }

    /**
     * Get companyZipCode
     *
     * @return string
     */
    public function getCompanyZipCode()
    {
        return $this->company_zip_code;
    }

    /**
     * Set companyTypeOfBusiness
     *
     * @param string $companyTypeOfBusiness
     *
     * @return Leasing
     */
    public function setCompanyTypeOfBusiness($companyTypeOfBusiness)
    {
        $this->company_type_of_business = $companyTypeOfBusiness;

        return $this;
    }

    /**
     * Get companyTypeOfBusiness
     *
     * @return string
     */
    public function getCompanyTypeOfBusiness()
    {
        return $this->company_type_of_business;
    }

    /**
     * Set companyInBusinessSince
     *
     * @param \DateTime $companyInBusinessSince
     *
     * @return Leasing
     */
    public function setCompanyInBusinessSince($companyInBusinessSince)
    {
        $this->company_in_business_since = $companyInBusinessSince;

        return $this;
    }

    /**
     * Get companyInBusinessSince
     *
     * @return \DateTime
     */
    public function getCompanyInBusinessSince()
    {
        return $this->company_in_business_since;
    }

    /**
     * Set companyLegalStructure
     *
     * @param string $companyLegalStructure
     *
     * @return Leasing
     */
    public function setCompanyLegalStructure($companyLegalStructure)
    {
        $this->company_legal_structure = $companyLegalStructure;

        return $this;
    }

    /**
     * Get companyLegalStructure
     *
     * @return string
     */
    public function getCompanyLegalStructure()
    {
        return $this->company_legal_structure;
    }

    /**
     * Set companyLand
     *
     * @param string $companyLand
     *
     * @return Leasing
     */
    public function setCompanyLand($companyLand)
    {
        $this->company_land = $companyLand;

        return $this;
    }

    /**
     * Get companyLand
     *
     * @return string
     */
    public function getCompanyLand()
    {
        return $this->company_land;
    }

    /**
     * Set custFirstName
     *
     * @param string $custFirstName
     *
     * @return Leasing
     */
    public function setCustFirstName($custFirstName)
    {
        $this->cust_first_name = $custFirstName;

        return $this;
    }

    /**
     * Get custFirstName
     *
     * @return string
     */
    public function getCustFirstName()
    {
        return $this->cust_first_name;
    }

    /**
     * Set custLastName
     *
     * @param string $custLastName
     *
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * Set materialStatus
     *
     * @param string $materialStatus
     *
     * @return Leasing
     */
    public function setMaterialStatus($materialStatus)
    {
        $this->material_status = $materialStatus;

        return $this;
    }

    /**
     * Get materialStatus
     *
     * @return string
     */
    public function getMaterialStatus()
    {
        return $this->material_status;
    }

    /**
     * Set residenceType
     *
     * @param string $residenceType
     *
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * Set realEstate
     *
     * @param string $realEstate
     *
     * @return Leasing
     */
    public function setRealEstate($realEstate)
    {
        $this->real_estate = $realEstate;

        return $this;
    }

    /**
     * Get realEstate
     *
     * @return string
     */
    public function getRealEstate()
    {
        return $this->real_estate;
    }

    /**
     * Set landlordPhone
     *
     * @param string $landlordPhone
     *
     * @return Leasing
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
     * Set mortgageBalance
     *
     * @param string $mortgageBalance
     *
     * @return Leasing
     */
    public function setMortgageBalance($mortgageBalance)
    {
        $this->mortgage_balance = $mortgageBalance;

        return $this;
    }

    /**
     * Get mortgageBalance
     *
     * @return string
     */
    public function getMortgageBalance()
    {
        return $this->mortgage_balance;
    }

    /**
     * Set previousBankruptcy
     *
     * @param string $previousBankruptcy
     *
     * @return Leasing
     */
    public function setPreviousBankruptcy($previousBankruptcy)
    {
        $this->previous_bankruptcy = $previousBankruptcy;

        return $this;
    }

    /**
     * Get previousBankruptcy
     *
     * @return string
     */
    public function getPreviousBankruptcy()
    {
        return $this->previous_bankruptcy;
    }

    /**
     * Set employerCompany
     *
     * @param string $employerCompany
     *
     * @return Leasing
     */
    public function setEmployerCompany($employerCompany)
    {
        $this->employer_company = $employerCompany;

        return $this;
    }

    /**
     * Get employerCompany
     *
     * @return string
     */
    public function getEmployerCompany()
    {
        return $this->employer_company;
    }

    /**
     * Set employerPosition
     *
     * @param string $employerPosition
     *
     * @return Leasing
     */
    public function setEmployerPosition($employerPosition)
    {
        $this->employer_position = $employerPosition;

        return $this;
    }

    /**
     * Get employerPosition
     *
     * @return string
     */
    public function getEmployerPosition()
    {
        return $this->employer_position;
    }

    /**
     * Set employerOnJob
     *
     * @param \DateTime $employerOnJob
     *
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * Set employerPreviousAddress
     *
     * @param string $employerPreviousAddress
     *
     * @return Leasing
     */
    public function setEmployerPreviousAddress($employerPreviousAddress)
    {
        $this->employer_previous_address = $employerPreviousAddress;

        return $this;
    }

    /**
     * Get employerPreviousAddress
     *
     * @return string
     */
    public function getEmployerPreviousAddress()
    {
        return $this->employer_previous_address;
    }

    /**
     * Set employerPreviousCity
     *
     * @param string $employerPreviousCity
     *
     * @return Leasing
     */
    public function setEmployerPreviousCity($employerPreviousCity)
    {
        $this->employer_previous_city = $employerPreviousCity;

        return $this;
    }

    /**
     * Get employerPreviousCity
     *
     * @return string
     */
    public function getEmployerPreviousCity()
    {
        return $this->employer_previous_city;
    }

    /**
     * Set employerPreviousState
     *
     * @param string $employerPreviousState
     *
     * @return Leasing
     */
    public function setEmployerPreviousState($employerPreviousState)
    {
        $this->employer_previous_state = $employerPreviousState;

        return $this;
    }

    /**
     * Get employerPreviousState
     *
     * @return string
     */
    public function getEmployerPreviousState()
    {
        return $this->employer_previous_state;
    }

    /**
     * Set employerPreviousZip
     *
     * @param string $employerPreviousZip
     *
     * @return Leasing
     */
    public function setEmployerPreviousZip($employerPreviousZip)
    {
        $this->employer_previous_zip = $employerPreviousZip;

        return $this;
    }

    /**
     * Get employerPreviousZip
     *
     * @return string
     */
    public function getEmployerPreviousZip()
    {
        return $this->employer_previous_zip;
    }

    /**
     * Set vendorCompany
     *
     * @param string $vendorCompany
     *
     * @return Leasing
     */
    public function setVendorCompany($vendorCompany)
    {
        $this->vendor_company = $vendorCompany;

        return $this;
    }

    /**
     * Get vendorCompany
     *
     * @return string
     */
    public function getVendorCompany()
    {
        return $this->vendor_company;
    }

    /**
     * Set vendorAddress
     *
     * @param string $vendorAddress
     *
     * @return Leasing
     */
    public function setVendorAddress($vendorAddress)
    {
        $this->vendor_address = $vendorAddress;

        return $this;
    }

    /**
     * Get vendorAddress
     *
     * @return string
     */
    public function getVendorAddress()
    {
        return $this->vendor_address;
    }

    /**
     * Set vendorCity
     *
     * @param string $vendorCity
     *
     * @return Leasing
     */
    public function setVendorCity($vendorCity)
    {
        $this->vendor_city = $vendorCity;

        return $this;
    }

    /**
     * Get vendorCity
     *
     * @return string
     */
    public function getVendorCity()
    {
        return $this->vendor_city;
    }

    /**
     * Set vendorContact
     *
     * @param string $vendorContact
     *
     * @return Leasing
     */
    public function setVendorContact($vendorContact)
    {
        $this->vendor_contact = $vendorContact;

        return $this;
    }

    /**
     * Get vendorContact
     *
     * @return string
     */
    public function getVendorContact()
    {
        return $this->vendor_contact;
    }

    /**
     * Set vendorPhone
     *
     * @param string $vendorPhone
     *
     * @return Leasing
     */
    public function setVendorPhone($vendorPhone)
    {
        $this->vendor_phone = $vendorPhone;

        return $this;
    }

    /**
     * Get vendorPhone
     *
     * @return string
     */
    public function getVendorPhone()
    {
        return $this->vendor_phone;
    }

    /**
     * Set vendorEmail
     *
     * @param string $vendorEmail
     *
     * @return Leasing
     */
    public function setVendorEmail($vendorEmail)
    {
        $this->vendor_email = $vendorEmail;

        return $this;
    }

    /**
     * Get vendorEmail
     *
     * @return string
     */
    public function getVendorEmail()
    {
        return $this->vendor_email;
    }

    /**
     * Set make
     *
     * @param string $make
     *
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * Set messageText
     *
     * @param string $messageText
     *
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
     * @return Leasing
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
    /**
     * @var string
     */
    private $employer_type_of_business;


    /**
     * Set employerTypeOfBusiness
     *
     * @param string $employerTypeOfBusiness
     *
     * @return Leasing
     */
    public function setEmployerTypeOfBusiness($employerTypeOfBusiness)
    {
        $this->employer_type_of_business = $employerTypeOfBusiness;

        return $this;
    }

    /**
     * Get employerTypeOfBusiness
     *
     * @return string
     */
    public function getEmployerTypeOfBusiness()
    {
        return $this->employer_type_of_business;
    }
}
