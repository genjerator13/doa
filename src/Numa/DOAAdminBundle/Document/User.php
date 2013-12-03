<?php

namespace Numa\DOAAdminBundle\Document;



/**
 * Numa\DOAAdminBundle\Document\User
 */
class User
{
    /**
     * @var MongoId $id
     */
    protected $id;

    /**
     * @var string $username
     */
    protected $username;

    /**
     * @var string $password
     */
    protected $password;

    /**
     * @var string $email
     */
    protected $email;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get username
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @var int $user_group_id
     */
    protected $user_group_id;

    /**
     * @var timestamp $registration_date
     */
    protected $registration_date;

    /**
     * @var boolean $active
     */
    protected $active;

    /**
     * @var int $contract_id
     */
    protected $contract_id;

    /**
     * @var string $activation_key
     */
    protected $activation_key;

    /**
     * @var string $verification_key
     */
    protected $verification_key;

    /**
     * @var boolean $trusted_user
     */
    protected $trusted_user;

    /**
     * @var string $FirstName
     */
    protected $FirstName;

    /**
     * @var string $LastName
     */
    protected $LastName;

    /**
     * @var string $DealershipName
     */
    protected $DealershipName;

    /**
     * @var string $Address
     */
    protected $Address;

    /**
     * @var string $City
     */
    protected $City;

    /**
     * @var string $PostalCode
     */
    protected $PostalCode;

    /**
     * @var string $PhoneNumber
     */
    protected $PhoneNumber;

    /**
     * @var string $DealershipWebsite
     */
    protected $DealershipWebsite;

    /**
     * @var boolean $DisplayEmail
     */
    protected $DisplayEmail;

    /**
     * @var string $State
     */
    protected $State;

    /**
     * @var string $DealershipLogo
     */
    protected $DealershipLogo;

    /**
     * @var int $third_party_id
     */
    protected $third_party_id;

    /**
     * @var string $ServiceProviderContact
     */
    protected $ServiceProviderContact;

    /**
     * @var string $ServiceProviderAddress
     */
    protected $ServiceProviderAddress;

    /**
     * @var string $ServiceProviderCity
     */
    protected $ServiceProviderCity;

    /**
     * @var string $ServiceProviderPostal
     */
    protected $ServiceProviderPostal;

    /**
     * @var string $ServiceProviderWebsite
     */
    protected $ServiceProviderWebsite;

    /**
     * @var string $ServiceProviderProv
     */
    protected $ServiceProviderProv;

    /**
     * @var string $ServiceProviderFax
     */
    protected $ServiceProviderFax;

    /**
     * @var timestamp $date_created
     */
    protected $date_created;

    /**
     * @var timestamp $date_updated
     */
    protected $date_updated;


    /**
     * Set userGroupId
     *
     * @param int $userGroupId
     * @return self
     */
    public function setUserGroupId($userGroupId)
    {
        $this->user_group_id = $userGroupId;
        return $this;
    }

    /**
     * Get userGroupId
     *
     * @return int $userGroupId
     */
    public function getUserGroupId()
    {
        return $this->user_group_id;
    }

    /**
     * Set registrationDate
     *
     * @param timestamp $registrationDate
     * @return self
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registration_date = $registrationDate;
        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return timestamp $registrationDate
     */
    public function getRegistrationDate()
    {
        return $this->registration_date;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return self
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean $active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set contractId
     *
     * @param int $contractId
     * @return self
     */
    public function setContractId($contractId)
    {
        $this->contract_id = $contractId;
        return $this;
    }

    /**
     * Get contractId
     *
     * @return int $contractId
     */
    public function getContractId()
    {
        return $this->contract_id;
    }

    /**
     * Set activationKey
     *
     * @param string $activationKey
     * @return self
     */
    public function setActivationKey($activationKey)
    {
        $this->activation_key = $activationKey;
        return $this;
    }

    /**
     * Get activationKey
     *
     * @return string $activationKey
     */
    public function getActivationKey()
    {
        return $this->activation_key;
    }

    /**
     * Set verificationKey
     *
     * @param string $verificationKey
     * @return self
     */
    public function setVerificationKey($verificationKey)
    {
        $this->verification_key = $verificationKey;
        return $this;
    }

    /**
     * Get verificationKey
     *
     * @return string $verificationKey
     */
    public function getVerificationKey()
    {
        return $this->verification_key;
    }

    /**
     * Set trustedUser
     *
     * @param boolean $trustedUser
     * @return self
     */
    public function setTrustedUser($trustedUser)
    {
        $this->trusted_user = $trustedUser;
        return $this;
    }

    /**
     * Get trustedUser
     *
     * @return boolean $trustedUser
     */
    public function getTrustedUser()
    {
        return $this->trusted_user;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return self
     */
    public function setFirstName($firstName)
    {
        $this->FirstName = $firstName;
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string $firstName
     */
    public function getFirstName()
    {
        return $this->FirstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return self
     */
    public function setLastName($lastName)
    {
        $this->LastName = $lastName;
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string $lastName
     */
    public function getLastName()
    {
        return $this->LastName;
    }

    /**
     * Set dealershipName
     *
     * @param string $dealershipName
     * @return self
     */
    public function setDealershipName($dealershipName)
    {
        $this->DealershipName = $dealershipName;
        return $this;
    }

    /**
     * Get dealershipName
     *
     * @return string $dealershipName
     */
    public function getDealershipName()
    {
        return $this->DealershipName;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return self
     */
    public function setAddress($address)
    {
        $this->Address = $address;
        return $this;
    }

    /**
     * Get address
     *
     * @return string $address
     */
    public function getAddress()
    {
        return $this->Address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return self
     */
    public function setCity($city)
    {
        $this->City = $city;
        return $this;
    }

    /**
     * Get city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->City;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return self
     */
    public function setPostalCode($postalCode)
    {
        $this->PostalCode = $postalCode;
        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string $postalCode
     */
    public function getPostalCode()
    {
        return $this->PostalCode;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return self
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->PhoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string $phoneNumber
     */
    public function getPhoneNumber()
    {
        return $this->PhoneNumber;
    }

    /**
     * Set dealershipWebsite
     *
     * @param string $dealershipWebsite
     * @return self
     */
    public function setDealershipWebsite($dealershipWebsite)
    {
        $this->DealershipWebsite = $dealershipWebsite;
        return $this;
    }

    /**
     * Get dealershipWebsite
     *
     * @return string $dealershipWebsite
     */
    public function getDealershipWebsite()
    {
        return $this->DealershipWebsite;
    }

    /**
     * Set displayEmail
     *
     * @param boolean $displayEmail
     * @return self
     */
    public function setDisplayEmail($displayEmail)
    {
        $this->DisplayEmail = $displayEmail;
        return $this;
    }

    /**
     * Get displayEmail
     *
     * @return boolean $displayEmail
     */
    public function getDisplayEmail()
    {
        return $this->DisplayEmail;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return self
     */
    public function setState($state)
    {
        $this->State = $state;
        return $this;
    }

    /**
     * Get state
     *
     * @return string $state
     */
    public function getState()
    {
        return $this->State;
    }

    /**
     * Set dealershipLogo
     *
     * @param string $dealershipLogo
     * @return self
     */
    public function setDealershipLogo($dealershipLogo)
    {
        $this->DealershipLogo = $dealershipLogo;
        return $this;
    }

    /**
     * Get dealershipLogo
     *
     * @return string $dealershipLogo
     */
    public function getDealershipLogo()
    {
        return $this->DealershipLogo;
    }

    /**
     * Set thirdPartyId
     *
     * @param int $thirdPartyId
     * @return self
     */
    public function setThirdPartyId($thirdPartyId)
    {
        $this->third_party_id = $thirdPartyId;
        return $this;
    }

    /**
     * Get thirdPartyId
     *
     * @return int $thirdPartyId
     */
    public function getThirdPartyId()
    {
        return $this->third_party_id;
    }

    /**
     * Set serviceProviderContact
     *
     * @param string $serviceProviderContact
     * @return self
     */
    public function setServiceProviderContact($serviceProviderContact)
    {
        $this->ServiceProviderContact = $serviceProviderContact;
        return $this;
    }

    /**
     * Get serviceProviderContact
     *
     * @return string $serviceProviderContact
     */
    public function getServiceProviderContact()
    {
        return $this->ServiceProviderContact;
    }

    /**
     * Set serviceProviderAddress
     *
     * @param string $serviceProviderAddress
     * @return self
     */
    public function setServiceProviderAddress($serviceProviderAddress)
    {
        $this->ServiceProviderAddress = $serviceProviderAddress;
        return $this;
    }

    /**
     * Get serviceProviderAddress
     *
     * @return string $serviceProviderAddress
     */
    public function getServiceProviderAddress()
    {
        return $this->ServiceProviderAddress;
    }

    /**
     * Set serviceProviderCity
     *
     * @param string $serviceProviderCity
     * @return self
     */
    public function setServiceProviderCity($serviceProviderCity)
    {
        $this->ServiceProviderCity = $serviceProviderCity;
        return $this;
    }

    /**
     * Get serviceProviderCity
     *
     * @return string $serviceProviderCity
     */
    public function getServiceProviderCity()
    {
        return $this->ServiceProviderCity;
    }

    /**
     * Set serviceProviderPostal
     *
     * @param string $serviceProviderPostal
     * @return self
     */
    public function setServiceProviderPostal($serviceProviderPostal)
    {
        $this->ServiceProviderPostal = $serviceProviderPostal;
        return $this;
    }

    /**
     * Get serviceProviderPostal
     *
     * @return string $serviceProviderPostal
     */
    public function getServiceProviderPostal()
    {
        return $this->ServiceProviderPostal;
    }

    /**
     * Set serviceProviderWebsite
     *
     * @param string $serviceProviderWebsite
     * @return self
     */
    public function setServiceProviderWebsite($serviceProviderWebsite)
    {
        $this->ServiceProviderWebsite = $serviceProviderWebsite;
        return $this;
    }

    /**
     * Get serviceProviderWebsite
     *
     * @return string $serviceProviderWebsite
     */
    public function getServiceProviderWebsite()
    {
        return $this->ServiceProviderWebsite;
    }

    /**
     * Set serviceProviderProv
     *
     * @param string $serviceProviderProv
     * @return self
     */
    public function setServiceProviderProv($serviceProviderProv)
    {
        $this->ServiceProviderProv = $serviceProviderProv;
        return $this;
    }

    /**
     * Get serviceProviderProv
     *
     * @return string $serviceProviderProv
     */
    public function getServiceProviderProv()
    {
        return $this->ServiceProviderProv;
    }

    /**
     * Set serviceProviderFax
     *
     * @param string $serviceProviderFax
     * @return self
     */
    public function setServiceProviderFax($serviceProviderFax)
    {
        $this->ServiceProviderFax = $serviceProviderFax;
        return $this;
    }

    /**
     * Get serviceProviderFax
     *
     * @return string $serviceProviderFax
     */
    public function getServiceProviderFax()
    {
        return $this->ServiceProviderFax;
    }

    /**
     * Set dateCreated
     *
     * @param timestamp $dateCreated
     * @return self
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return timestamp $dateCreated
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set dateUpdated
     *
     * @param timestamp $dateUpdated
     * @return self
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->date_updated = $dateUpdated;
        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return timestamp $dateUpdated
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }
}
