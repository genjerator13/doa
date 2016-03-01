<?php

namespace Numa\DOADMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;

/**
 * Customer
 * @JMS\XmlRoot("customer")
 * @JMS\ExclusionPolicy("ALL")
 */
class Customer
{
    /**
     * @var integer
     * @JMS\Expose
     */
    private $id;

    /**
     * @var string
     * @JMS\Expose
     */
    private $first_name;

    /**
     * @var string
     * @JMS\Expose
     */
    private $last_name;

    /**
     * @var string
     * @JMS\Expose
     */
    private $city;

    /**
     * @var string
     * @JMS\Expose
     */
    private $state;

    /**
     * @var string
     * @JMS\Expose
     */
    private $zip;

    /**
     * @var string
     * @JMS\Expose
     */
    private $country;

    /**
     * @var string
     */
    private $home_phone;

    /**
     * @var string
     */
    private $work_phone;

    /**
     * @var string
     */
    private $mobile_phone;

    /**
     * @var string
     */
    private $fax;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $notes;

    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var \DateTime
     */
    private $date_updated;

    /**
     * @var integer
     */
    private $dealer_id;

    /**
     * @var \Numa\DOADMSBundle\Entity\Catalogrecords
     */
    private $Catalogrecords;


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
     * Set first_name
     *
     * @param string $firstName
     * @return Customer
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return Customer
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Customer
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
     * @return Customer
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
     * Set zip
     *
     * @param string $zip
     * @return Customer
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Customer
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set home_phone
     *
     * @param string $homePhone
     * @return Customer
     */
    public function setHomePhone($homePhone)
    {
        $this->home_phone = $homePhone;

        return $this;
    }

    /**
     * Get home_phone
     *
     * @return string 
     */
    public function getHomePhone()
    {
        return $this->home_phone;
    }

    /**
     * Set work_phone
     *
     * @param string $workPhone
     * @return Customer
     */
    public function setWorkPhone($workPhone)
    {
        $this->work_phone = $workPhone;

        return $this;
    }

    /**
     * Get work_phone
     *
     * @return string 
     */
    public function getWorkPhone()
    {
        return $this->work_phone;
    }

    /**
     * Set mobile_phone
     *
     * @param string $mobilePhone
     * @return Customer
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobile_phone = $mobilePhone;

        return $this;
    }

    /**
     * Get mobile_phone
     *
     * @return string 
     */
    public function getMobilePhone()
    {
        return $this->mobile_phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Customer
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Customer
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
     * Set notes
     *
     * @param string $notes
     * @return Customer
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set date_created
     *
     * @param \DateTime $dateCreated
     * @return Customer
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
     * @return Customer
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
     * Set dealer_id
     *
     * @param integer $dealerId
     * @return Customer
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
     * Set Catalogrecords
     *
     * @param \Numa\DOADMSBundle\Entity\Catalogrecords $catalogrecords
     * @return Customer
     */
    public function setCatalogrecords(\Numa\DOADMSBundle\Entity\Catalogrecords $catalogrecords = null)
    {
        $this->Catalogrecords = $catalogrecords;

        return $this;
    }

    /**
     * Get Catalogrecords
     *
     * @return \Numa\DOADMSBundle\Entity\Catalogrecords 
     */
    public function getCatalogrecords()
    {
        return $this->Catalogrecords;
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
}
