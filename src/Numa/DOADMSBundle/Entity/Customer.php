<?php

namespace Numa\DOADMSBundle\Entity;

use Doctrine\Common\Collections\Criteria;
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
     * @JMS\Expose
     */
    private $home_phone;

    /**
     * @var string
     */
    private $work_phone;

    /**
     * @var string
     * @JMS\Expose
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
     * @JMS\Expose
     */
    private $notes;

    /**
     * @var \DateTime
     * @JMS\Expose
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
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
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
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $catalogrecords
     * @return Customer
     */
    public function setCatalogrecords(\Numa\DOAAdminBundle\Entity\Catalogrecords $catalogrecords = null)
    {
        $this->Catalogrecords = $catalogrecords;

        return $this;
    }

    /**
     * Get Catalogrecords
     *
     * @return \Numa\DOAAdminBundle\Entity\Catalogrecords
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

    /**
     * @var string
     * @JMS\Expose
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @var \DateTime
     * @JMS\Expose
     */
    private $followup_date;


    /**
     * Set followup_date
     *
     * @param \DateTime $followupDate
     * @return Customer
     */
    public function setFollowupDate($followupDate)
    {
        $this->followup_date = $followupDate;

        return $this;
    }

    /**
     * Get followup_date
     *
     * @return \DateTime
     */
    public function getFollowupDate()
    {
        return $this->followup_date;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getName()."";
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @JMS\Expose
     */
    private $Note;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->followup_date = new \DateTime();
        $this->Note = new \Doctrine\Common\Collections\ArrayCollection();
        $this->getLastnoteadded();
    }

    /**
     * Add Note
     *
     * @param \Numa\DOADMSBundle\Entity\Note $note
     * @return Customer
     */
    public function addNote(\Numa\DOADMSBundle\Entity\Note $note)
    {
        $this->Note[] = $note;

        return $this;
    }

    /**
     * Remove Note
     *
     * @param \Numa\DOADMSBundle\Entity\Note $note
     */
    public function removeNote(\Numa\DOADMSBundle\Entity\Note $note)
    {
        $this->Note->removeElement($note);
    }

    /**
     * Get Note
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNote()
    {
        return $this->Note;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @JMS\Expose
     */
    private $Billing;



    /**
     * Add Billing
     *
     * @param \Numa\DOADMSBundle\Entity\Billing $Billing
     * @return Customer
     */
    public function addBilling(\Numa\DOADMSBundle\Entity\Billing $billing)
    {
        $this->Billing[] = $billing;

        return $this;
    }

    /**
     * Remove Billing
     *
     * @param \Numa\DOADMSBundle\Entity\Billing $billing
     */
    public function removeBilling(\Numa\DOADMSBundle\Entity\Billing $billing)
    {
        $this->Billing->removeElement($billing);
    }

    /**
     * Get Billing
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBilling()
    {
        return $this->Billing;
    }

    /**
     * @var string
     * @JMS\Expose
     */
    private $anotes;


    /**
     * Set anotes
     *
     * @param string $anotes
     * @return Customer
     */
    public function setAnotes($anotes)
    {
        $this->anotes = $anotes;

        return $this;
    }

    /**
     * Get anotes
     *
     * @return string
     */
    public function getAnotes()
    {
        $criteria = Criteria::create()

            ->orderBy(array("date_remind" => "DESC"));

        $lastnoteadded = $this->getNote()->matching($criteria);
        $this->lastnoteadded = "";
        if(!empty($lastnoteadded->first())) {
            $this->anotes = $lastnoteadded->first()->getDateRemind();
        }

        return $this->anotes;
        return $this->anotes;
    }

    /**
     * @var string
     * @JMS\Expose
     * @JMS\Accessor(getter="getLastnoteadded",setter="setLastnoteadded")
     */
    private $lastnoteadded;


    /**
     * Set lastnoteadded
     *
     * @param string $lastnoteadded
     * @return Customer
     */
    public function setLastnoteadded($lastnoteadded)
    {
        $this->lastnoteadded = $lastnoteadded;

        return $this;
    }

    /**
     * Get $lastnoteadded
     *
     * @return string
     * @JMS\VirtualProperty
     */
    public function getLastnoteadded()
    {

        $criteria = Criteria::create()

            ->orderBy(array("date_remind" => "DESC"));

        $lastnoteadded = $this->getNote()->matching($criteria);
        $this->lastnoteadded = "No notes";
        if(!empty($lastnoteadded->first())) {
            $this->lastnoteadded = $lastnoteadded->first()->getDateRemind();
        }

        return $this->lastnoteadded;


    }


    /**
     * @var string
     * @JMS\Expose
     */
    private $sales_person;


    /**
     * Set sales_person
     *
     * @param string $salesPerson
     * @return Customer
     */
    public function setSalesPerson($salesPerson)
    {
        $this->sales_person = $salesPerson;

        return $this;
    }

    /**
     * Get sales_person
     *
     * @return string
     */
    public function getSalesPerson()
    {
        return $this->sales_person;
    }
}
