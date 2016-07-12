<?php

namespace Numa\DOADMSBundle\Entity;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserLoaderInterface;

/**
 * DMSUser
 */
class DMSUser  implements UserInterface
{
    /**
     * @var integer
     */
    private $id;

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
     * @var integer
     */
    private $balance;

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
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var \DateTime
     */
    private $date_updated;

    /**
     * @var \Numa\DOAAdminBundle\Entity\UserGroup
     */
    private $UserGroup;

    public function __construct()
    {
        $this->active=true;
        $this->trusted_user=true;
    }

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
     * Set username
     *
     * @param string $username
     * @return DMSUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return DMSUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return DMSUser
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
     * Set user_group_id
     *
     * @param integer $userGroupId
     * @return DMSUser
     */
    public function setUserGroupId($userGroupId)
    {
        $this->user_group_id = $userGroupId;

        return $this;
    }

    /**
     * Get user_group_id
     *
     * @return integer 
     */
    public function getUserGroupId()
    {
        return $this->user_group_id;
    }

    /**
     * Set registration_date
     *
     * @param \DateTime $registrationDate
     * @return DMSUser
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registration_date = $registrationDate;

        return $this;
    }

    /**
     * Get registration_date
     *
     * @return \DateTime 
     */
    public function getRegistrationDate()
    {
        return $this->registration_date;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return DMSUser
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set contract_id
     *
     * @param integer $contractId
     * @return DMSUser
     */
    public function setContractId($contractId)
    {
        $this->contract_id = $contractId;

        return $this;
    }

    /**
     * Get contract_id
     *
     * @return integer 
     */
    public function getContractId()
    {
        return $this->contract_id;
    }

    /**
     * Set activation_key
     *
     * @param string $activationKey
     * @return DMSUser
     */
    public function setActivationKey($activationKey)
    {
        $this->activation_key = $activationKey;

        return $this;
    }

    /**
     * Get activation_key
     *
     * @return string 
     */
    public function getActivationKey()
    {
        return $this->activation_key;
    }

    /**
     * Set verification_key
     *
     * @param string $verificationKey
     * @return DMSUser
     */
    public function setVerificationKey($verificationKey)
    {
        $this->verification_key = $verificationKey;

        return $this;
    }

    /**
     * Get verification_key
     *
     * @return string 
     */
    public function getVerificationKey()
    {
        return $this->verification_key;
    }

    /**
     * Set trusted_user
     *
     * @param boolean $trustedUser
     * @return DMSUser
     */
    public function setTrustedUser($trustedUser)
    {
        $this->trusted_user = $trustedUser;

        return $this;
    }

    /**
     * Get trusted_user
     *
     * @return boolean 
     */
    public function getTrustedUser()
    {
        return $this->trusted_user;
    }

    /**
     * Set balance
     *
     * @param integer $balance
     * @return DMSUser
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return integer 
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set FirstName
     *
     * @param string $firstName
     * @return DMSUser
     */
    public function setFirstName($firstName)
    {
        $this->FirstName = $firstName;

        return $this;
    }

    /**
     * Get FirstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->FirstName;
    }

    /**
     * Set LastName
     *
     * @param string $lastName
     * @return DMSUser
     */
    public function setLastName($lastName)
    {
        $this->LastName = $lastName;

        return $this;
    }

    /**
     * Get LastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->LastName;
    }

    /**
     * Set Address
     *
     * @param string $address
     * @return DMSUser
     */
    public function setAddress($address)
    {
        $this->Address = $address;

        return $this;
    }

    /**
     * Get Address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->Address;
    }

    /**
     * Set City
     *
     * @param string $city
     * @return DMSUser
     */
    public function setCity($city)
    {
        $this->City = $city;

        return $this;
    }

    /**
     * Get City
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->City;
    }

    /**
     * Set PostalCode
     *
     * @param string $postalCode
     * @return DMSUser
     */
    public function setPostalCode($postalCode)
    {
        $this->PostalCode = $postalCode;

        return $this;
    }

    /**
     * Get PostalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->PostalCode;
    }

    /**
     * Set PhoneNumber
     *
     * @param string $phoneNumber
     * @return DMSUser
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->PhoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get PhoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->PhoneNumber;
    }

    /**
     * Set DisplayEmail
     *
     * @param boolean $displayEmail
     * @return DMSUser
     */
    public function setDisplayEmail($displayEmail)
    {
        $this->DisplayEmail = $displayEmail;

        return $this;
    }

    /**
     * Get DisplayEmail
     *
     * @return boolean 
     */
    public function getDisplayEmail()
    {
        return $this->DisplayEmail;
    }

    /**
     * Set State
     *
     * @param string $state
     * @return DMSUser
     */
    public function setState($state)
    {
        $this->State = $state;

        return $this;
    }

    /**
     * Get State
     *
     * @return string 
     */
    public function getState()
    {
        return $this->State;
    }

    /**
     * Set DealershipLogo
     *
     * @param string $dealershipLogo
     * @return DMSUser
     */
    public function setDealershipLogo($dealershipLogo)
    {
        $this->DealershipLogo = $dealershipLogo;

        return $this;
    }

    /**
     * Get DealershipLogo
     *
     * @return string 
     */
    public function getDealershipLogo()
    {
        return $this->DealershipLogo;
    }

    /**
     * Set date_created
     *
     * @param \DateTime $dateCreated
     * @return DMSUser
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;

        return $this;
    }

    /**
     * Get date_created
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set date_updated
     *
     * @param \DateTime $dateUpdated
     * @return DMSUser
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->date_updated = $dateUpdated;

        return $this;
    }

    /**
     * Get date_updated
     *
     * @return \DateTime 
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }

    /**
     * Set UserGroup
     *
     * @param \Numa\DOAAdminBundle\Entity\UserGroup $userGroup
     * @return DMSUser
     */
    public function setUserGroup(\Numa\DOAAdminBundle\Entity\UserGroup $userGroup = null)
    {
        $this->UserGroup = $userGroup;

        return $this;
    }

    /**
     * Get UserGroup
     *
     * @return \Numa\DOADMSBundle\Entity\UserGroup 
     */
    public function getUserGroup()
    {
        return $this->UserGroup;
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
     * @var integer
     */
    private $dealer_id;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Dealer;


    /**
     * Set dealer_id
     *
     * @param integer $dealerId
     * @return DMSUser
     */
    public function setDealerId($dealerId)
    {
        $this->dealer_id = $dealerId;

        return $this;
    }

    /**
     * Get dealer_id
     *
     * @return integer 
     */
    public function getDealerId()
    {
        return $this->dealer_id;
    }

    /**
     * Set Dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     * @return DMSUser
     */
    public function setDealer(\Numa\DOAAdminBundle\Entity\Catalogrecords $dealer = null)
    {
        $this->Dealer = $dealer;

        return $this;
    }

    /**
     * Get Dealer
     *
     * @return \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    public function getDealer()
    {
        return $this->Dealer;
    }

    public function __toString() {
        return $this->getUsername();
    }

    public function getRoles() {
        if(!empty($this->getUserGroup())) {
            $groupName = strtolower($this->getUserGroup()->getName());

            if ($groupName == 'accounting') {
                return array('ROLE_ACCOUNTING');
            } elseif ($groupName == 'sales_user') {
                return array('ROLE_SALES');
            } elseif ($groupName == 'manager') {
                return array('ROLE_MANAGER');
            }elseif ($groupName == 'service_user') {
                return array('ROLE_SERVICE_DMS');
            }elseif ($groupName == 'parts_user') {
                return array('ROLE_PARTS_DMS');
            }elseif ($groupName == 'regular_admin') {
                return array('ROLE_REGULAR_ADMIN_DMS');
            }elseif ($groupName == 'super_admin') {
                return array('ROLE_ADMIN');
            }
        }
        return array('ROLE_USER');
    }

    public function getSalt() {
        return null;
    }

    public function eraseCredentials() {

    }

    public function equals(User $user) {
        return $user->getEmail() == $this->getEmail();
    }

    public function __sleep(){
        return array('id', 'username', 'email');
    }

    public function getName(){
        return $this->getFirstName()." ".$this->getLastName();
    }

    public function getLogoUrl(){
        $dealer=$this->getDealer();
        if($dealer instanceof Catalogrecords){
            return $dealer->getLogoUrl();
        }
        return "";
    }

    public function getUrl(){
        $dealer=$this->getDealer();
        if($dealer instanceof Catalogrecords){
            return $dealer->getUrl();
        }
        return "";
    }
}
