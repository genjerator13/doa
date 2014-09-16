<?php

namespace Numa\DOAAdminBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User implements UserInterface {

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $user_group_id;

    /**
     * @var \DateTime
     */
    private $registration_date;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var integer
     */
    private $contract_id;

    /**
     * @var string
     */
    private $activation_key;

    /**
     * @var string
     */
    private $verification_key;

    /**
     * @var boolean
     */
    private $trusted_user;

    /**
     * @var string
     */
    private $FirstName;

    /**
     * @var string
     */
    private $LastName;

    /**
     * @var string
     */
    private $DealershipName;

    /**
     * @var string
     */
    private $Address;

    /**
     * @var string
     */
    private $City;

    /**
     * @var string
     */
    private $PostalCode;

    /**
     * @var string
     */
    private $PhoneNumber;

    /**
     * @var string
     */
    private $DealershipWebsite;

    /**
     * @var boolean
     */
    private $DisplayEmail;

    /**
     * @var string
     */
    private $State;

    /**
     * @var string
     */
    private $DealershipLogo;

    /**
     * @var integer
     */
    private $third_party_id;

    /**
     * @var string
     */
    private $ServiceProviderContact;

    /**
     * @var string
     */
    private $ServiceProviderAddress;

    /**
     * @var string
     */
    private $ServiceProviderCity;

    /**
     * @var string
     */
    private $ServiceProviderPostal;

    /**
     * @var string
     */
    private $ServiceProviderWebsite;

    /**
     * @var string
     */
    private $ServiceProviderProv;

    /**
     * @var string
     */
    private $ServiceProviderFax;

    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var \DateTime
     */
    private $date_updated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Item;

    /**
     * @var \Numa\DOAAdminBundle\Entity\UserGroup
     */
    protected $UserGroup;

    /**
     * Constructor
     */
    public function __construct() {
        $this->Item = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set user_group_id
     *
     * @param integer $userGroupId
     * @return User
     */
    public function setUserGroupId($userGroupId) {
        $this->user_group_id = $userGroupId;

        return $this;
    }

    /**
     * Get user_group_id
     *
     * @return integer 
     */
    public function getUserGroupId() {
        return $this->user_group_id;
    }

    /**
     * Set registration_date
     *
     * @param \DateTime $registrationDate
     * @return User
     */
    public function setRegistrationDate($registrationDate) {
        $this->registration_date = $registrationDate;

        return $this;
    }

    /**
     * Get registration_date
     *
     * @return \DateTime 
     */
    public function getRegistrationDate() {
        return $this->registration_date;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return User
     */
    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set contract_id
     *
     * @param integer $contractId
     * @return User
     */
    public function setContractId($contractId) {
        $this->contract_id = $contractId;

        return $this;
    }

    /**
     * Get contract_id
     *
     * @return integer 
     */
    public function getContractId() {
        return $this->contract_id;
    }

    /**
     * Set activation_key
     *
     * @param string $activationKey
     * @return User
     */
    public function setActivationKey($activationKey) {
        $this->activation_key = $activationKey;

        return $this;
    }

    /**
     * Get activation_key
     *
     * @return string 
     */
    public function getActivationKey() {
        return $this->activation_key;
    }

    /**
     * Set verification_key
     *
     * @param string $verificationKey
     * @return User
     */
    public function setVerificationKey($verificationKey) {
        $this->verification_key = $verificationKey;

        return $this;
    }

    /**
     * Get verification_key
     *
     * @return string 
     */
    public function getVerificationKey() {
        return $this->verification_key;
    }

    /**
     * Set trusted_user
     *
     * @param boolean $trustedUser
     * @return User
     */
    public function setTrustedUser($trustedUser) {
        $this->trusted_user = $trustedUser;

        return $this;
    }

    /**
     * Get trusted_user
     *
     * @return boolean 
     */
    public function getTrustedUser() {
        return $this->trusted_user;
    }

    /**
     * Set FirstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName) {
        $this->FirstName = $firstName;

        return $this;
    }

    /**
     * Get FirstName
     *
     * @return string 
     */
    public function getFirstName() {
        return $this->FirstName;
    }

    /**
     * Set LastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName) {
        $this->LastName = $lastName;

        return $this;
    }

    /**
     * Get LastName
     *
     * @return string 
     */
    public function getLastName() {
        return $this->LastName;
    }

    /**
     * Set DealershipName
     *
     * @param string $dealershipName
     * @return User
     */
    public function setDealershipName($dealershipName) {
        $this->DealershipName = $dealershipName;

        return $this;
    }

    /**
     * Get DealershipName
     *
     * @return string 
     */
    public function getDealershipName() {
        return $this->DealershipName;
    }

    /**
     * Set Address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address) {
        $this->Address = $address;

        return $this;
    }

    /**
     * Get Address
     *
     * @return string 
     */
    public function getAddress() {
        return $this->Address;
    }

    /**
     * Set City
     *
     * @param string $city
     * @return User
     */
    public function setCity($city) {
        $this->City = $city;

        return $this;
    }

    /**
     * Get City
     *
     * @return string 
     */
    public function getCity() {
        return $this->City;
    }

    /**
     * Set PostalCode
     *
     * @param string $postalCode
     * @return User
     */
    public function setPostalCode($postalCode) {
        $this->PostalCode = $postalCode;

        return $this;
    }

    /**
     * Get PostalCode
     *
     * @return string 
     */
    public function getPostalCode() {
        return $this->PostalCode;
    }

    /**
     * Set PhoneNumber
     *
     * @param string $phoneNumber
     * @return User
     */
    public function setPhoneNumber($phoneNumber) {
        $this->PhoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get PhoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber() {
        return $this->PhoneNumber;
    }

    /**
     * Set DealershipWebsite
     *
     * @param string $dealershipWebsite
     * @return User
     */
    public function setDealershipWebsite($dealershipWebsite) {
        $this->DealershipWebsite = $dealershipWebsite;

        return $this;
    }

    /**
     * Get DealershipWebsite
     *
     * @return string 
     */
    public function getDealershipWebsite() {
        return $this->DealershipWebsite;
    }

    /**
     * Set DisplayEmail
     *
     * @param boolean $displayEmail
     * @return User
     */
    public function setDisplayEmail($displayEmail) {
        $this->DisplayEmail = $displayEmail;

        return $this;
    }

    /**
     * Get DisplayEmail
     *
     * @return boolean 
     */
    public function getDisplayEmail() {
        return $this->DisplayEmail;
    }

    /**
     * Set State
     *
     * @param string $state
     * @return User
     */
    public function setState($state) {
        $this->State = $state;

        return $this;
    }

    /**
     * Get State
     *
     * @return string 
     */
    public function getState() {
        return $this->State;
    }

    /**
     * Set DealershipLogo
     *
     * @param string $dealershipLogo
     * @return User
     */
    public function setDealershipLogo($dealershipLogo) {
        $this->DealershipLogo = $dealershipLogo;

        return $this;
    }

    /**
     * Get DealershipLogo
     *
     * @return string 
     */
    public function getDealershipLogo() {
        return $this->DealershipLogo;
    }

    /**
     * Set third_party_id
     *
     * @param integer $thirdPartyId
     * @return User
     */
    public function setThirdPartyId($thirdPartyId) {
        $this->third_party_id = $thirdPartyId;

        return $this;
    }

    /**
     * Get third_party_id
     *
     * @return integer 
     */
    public function getThirdPartyId() {
        return $this->third_party_id;
    }

    /**
     * Set ServiceProviderContact
     *
     * @param string $serviceProviderContact
     * @return User
     */
    public function setServiceProviderContact($serviceProviderContact) {
        $this->ServiceProviderContact = $serviceProviderContact;

        return $this;
    }

    /**
     * Get ServiceProviderContact
     *
     * @return string 
     */
    public function getServiceProviderContact() {
        return $this->ServiceProviderContact;
    }

    /**
     * Set ServiceProviderAddress
     *
     * @param string $serviceProviderAddress
     * @return User
     */
    public function setServiceProviderAddress($serviceProviderAddress) {
        $this->ServiceProviderAddress = $serviceProviderAddress;

        return $this;
    }

    /**
     * Get ServiceProviderAddress
     *
     * @return string 
     */
    public function getServiceProviderAddress() {
        return $this->ServiceProviderAddress;
    }

    /**
     * Set ServiceProviderCity
     *
     * @param string $serviceProviderCity
     * @return User
     */
    public function setServiceProviderCity($serviceProviderCity) {
        $this->ServiceProviderCity = $serviceProviderCity;

        return $this;
    }

    /**
     * Get ServiceProviderCity
     *
     * @return string 
     */
    public function getServiceProviderCity() {
        return $this->ServiceProviderCity;
    }

    /**
     * Set ServiceProviderPostal
     *
     * @param string $serviceProviderPostal
     * @return User
     */
    public function setServiceProviderPostal($serviceProviderPostal) {
        $this->ServiceProviderPostal = $serviceProviderPostal;

        return $this;
    }

    /**
     * Get ServiceProviderPostal
     *
     * @return string 
     */
    public function getServiceProviderPostal() {
        return $this->ServiceProviderPostal;
    }

    /**
     * Set ServiceProviderWebsite
     *
     * @param string $serviceProviderWebsite
     * @return User
     */
    public function setServiceProviderWebsite($serviceProviderWebsite) {
        $this->ServiceProviderWebsite = $serviceProviderWebsite;

        return $this;
    }

    /**
     * Get ServiceProviderWebsite
     *
     * @return string 
     */
    public function getServiceProviderWebsite() {
        return $this->ServiceProviderWebsite;
    }

    /**
     * Set ServiceProviderProv
     *
     * @param string $serviceProviderProv
     * @return User
     */
    public function setServiceProviderProv($serviceProviderProv) {
        $this->ServiceProviderProv = $serviceProviderProv;

        return $this;
    }

    /**
     * Get ServiceProviderProv
     *
     * @return string 
     */
    public function getServiceProviderProv() {
        return $this->ServiceProviderProv;
    }

    /**
     * Set ServiceProviderFax
     *
     * @param string $serviceProviderFax
     * @return User
     */
    public function setServiceProviderFax($serviceProviderFax) {
        $this->ServiceProviderFax = $serviceProviderFax;

        return $this;
    }

    /**
     * Get ServiceProviderFax
     *
     * @return string 
     */
    public function getServiceProviderFax() {
        return $this->ServiceProviderFax;
    }

    /**
     * Set date_created
     *
     * @param \DateTime $dateCreated
     * @return User
     */
    public function setDateCreated($dateCreated) {
        $this->date_created = $dateCreated;

        return $this;
    }

    /**
     * Get date_created
     *
     * @return \DateTime 
     */
    public function getDateCreated() {
        return $this->date_created;
    }

    /**
     * Set date_updated
     *
     * @param \DateTime $dateUpdated
     * @return User
     */
    public function setDateUpdated($dateUpdated) {
        $this->date_updated = $dateUpdated;

        return $this;
    }

    /**
     * Get date_updated
     *
     * @return \DateTime 
     */
    public function getDateUpdated() {
        return $this->date_updated;
    }

    /**
     * Add Item
     *
     * @param \Numa\DOAAdminBundle\Entity\Item $item
     * @return User
     */
    public function addItem(\Numa\DOAAdminBundle\Entity\Item $item) {
        $this->Item[] = $item;

        return $this;
    }

    /**
     * Remove Item
     *
     * @param \Numa\DOAAdminBundle\Entity\Item $item
     */
    public function removeItem(\Numa\DOAAdminBundle\Entity\Item $item) {
        $this->Item->removeElement($item);
    }

    /**
     * Get Item
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItem() {
        return $this->Item;
    }

    /**
     * Set UserGroup
     *
     * @param \Numa\DOAAdminBundle\Entity\UserGroup $userGroup
     * @return User
     */
    public function setUserGroup(\Numa\DOAAdminBundle\Entity\UserGroup $userGroup = null) {
        $this->UserGroup = $userGroup;

        return $this;
    }

    /**
     * Get UserGroup
     *
     * @return \Numa\DOAAdminBundle\Entity\UserGroup 
     */
    public function getUserGroup() {
        return $this->UserGroup;
    }

    /**
     * Get User
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function __toString() {
        return $this->getUsername();
    }

    public function getRoles() {
        $groupName = strtolower($this->getUserGroup()->getName());
        if($groupName=='admin') {
            return array('ROLE_ADMIN');
        }elseif($groupName=='regular_user'){
            return array('ROLE_USER');
        }
    }

    public function getSalt() {
        return null;
    }

    public function eraseCredentials() {
        
    }

    public function equals(User $user) {
        return $user->getUsername() == $this->getUsername();
    }

    /**
     * @var integer
     */
    private $balance;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Importfeed;

    /**
     * Set balance
     *
     * @param integer $balance
     * @return User
     */
    public function setBalance($balance) {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return integer 
     */
    public function getBalance() {
        return $this->balance;
    }

    /**
     * Add Importfeed
     *
     * @param \Numa\DOAAdminBundle\Entity\Importfeed $importfeed
     * @return User
     */
    public function addImportfeed(\Numa\DOAAdminBundle\Entity\Importfeed $importfeed) {
        $this->Importfeed[] = $importfeed;

        return $this;
    }

    /**
     * Remove Importfeed
     *
     * @param \Numa\DOAAdminBundle\Entity\Importfeed $importfeed
     */
    public function removeImportfeed(\Numa\DOAAdminBundle\Entity\Importfeed $importfeed) {
        $this->Importfeed->removeElement($importfeed);
    }

    /**
     * Get Importfeed
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImportfeed() {
        return $this->Importfeed;
    }
    
    public function __sleep(){
	   return array('id', 'username', 'email');

    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Items;


    /**
     * Get Items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->Items;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $UserItems;


    /**
     * Add UserItems
     *
     * @param \Numa\DOAAdminBundle\Entity\UserItem $userItems
     * @return User
     */
    public function addUserItem(\Numa\DOAAdminBundle\Entity\UserItem $userItems)
    {
        $this->UserItems[] = $userItems;
    
        return $this;
    }

    /**
     * Remove UserItems
     *
     * @param \Numa\DOAAdminBundle\Entity\UserItem $userItems
     */
    public function removeUserItem(\Numa\DOAAdminBundle\Entity\UserItem $userItems)
    {
        $this->UserItems->removeElement($userItems);
    }

    /**
     * Get UserItems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserItems()
    {
        return $this->UserItems;
    }
}