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
     * @JMS\Expose
     */
    private $work_phone;

    /**
     * @var string
     * @JMS\Expose
     */
    private $mobile_phone;

    /**
     * @var string
     * @JMS\Expose
     */
    private $fax;

    /**
     * @var string
     * @JMS\Expose
     */
    private $email;

    /**
     * @var string
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

    public function setId($id)
    {
        $this->id=$id;
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

    public function getDealer(){
        return $this->getCatalogrecords();
    }

    public function setDealer(\Numa\DOAAdminBundle\Entity\Catalogrecords $catalogrecords = null){
        return $this->setCatalogrecords($catalogrecords);
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
        if(empty($this->name)){
            return $this->first_name." ".$this->last_name;
        }
        return $this->name;

    }

    /**
     * @return string
     * @JMS\VirtualProperty
     */
    public function getFullName()
    {
        
        if(empty($this->getFirstName()) && (empty($this->getLastName()))){

            return $this->getName();
        }

        return ucfirst($this->getFirstName())." ".ucfirst($this->getLastName());
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
        return $this->getName()."";
    }


    /**
     * @var \Doctrine\Common\Collections\Collection
     * @JMS\Accessor(getter="getNote",setter="setNote")
     * @JMS\Type("ArrayCollection<Numa\DOADMSBundle\Entity\Note>")
     * @JMS\EXPOSE
     */
    private $Note;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->followup_date = new \DateTime();
        $this->Note = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Billing = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @JMS\VirtualProperty
     */
    public function getNote()
    {
        $criteria = Criteria::create()

            ->orderBy(array("date_remind" => "DESC"));
        $notes=null;
        if($this->Note) {
            $notes = $this->Note->matching($criteria);
        }
        return $notes;
    }

    public function setNote($note)
    {
        $this->Note = $note;

        return $this;
    }


    /**
     * @var \Doctrine\Common\Collections\Collection


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

    public function setBilling($billing)
    {
        $this->Billing=$billing;
    }

    /**
     * @var string

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

    }

    /**
     * @var DateTime
     * @JMS\Expose
     * @JMS\Type("DateTime")
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
        //
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
        $lastnoteadded="";
        $criteria = Criteria::create()
            ->orderBy(array("date_created" => "DESC"));
        if($this->getNote()) {
            $lastnoteadded = $this->getNote()->matching($criteria);
        }
        $this->lastnoteadded = null;
        if(!empty($lastnoteadded) && !empty($lastnoteadded->first())) {
            $this->lastnoteadded = $lastnoteadded->first()->getDateCreated();
        }

        return $this->lastnoteadded;
    }

    /**
     * Get $followup_date
     *
     * @return string
     * @JMS\VirtualProperty
     */
    public function getFirstFollowUpDate()
    {
        $lastnoteadded="";
        $criteria = Criteria::create()
            ->orderBy(array("date_remind" => "ASC"));
        if($this->getNote()) {
            $lastnoteadded = $this->getNote()->matching($criteria);
        }
        $this->followup_date = null;
        if(!empty($lastnoteadded) && !empty($lastnoteadded->first())) {
            $this->followup_date = $lastnoteadded->first()->getDateRemind();
        }

        return $this->followup_date;
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
     * @return string
     */
    public function getSalesPerson()
    {
        return $this->sales_person;
    }
    /**
     * @var string
     * @JMS\Expose
     */
    private $logo;


    /**
     * Set logo
     *
     * @param string $logo
     * @return Customer
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    public function getAbsolutePath()
    {
        return null === $this->logo ? null : $this->getUploadRootDir() . '/' . $this->logo;
    }

    public function getLogoImage()
    {
        return null === $this->logo ? null : '/' . $this->getUploadDir() . '/' . $this->logo;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'upload/customer/' . $this->getId();
    }

    public $file_import_source;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFileImportSource(\Symfony\Component\HttpFoundation\File\UploadedFile $file_import_source = null)
    {
        $this->file_import_source = $file_import_source;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFileImportSource()
    {
        return $this->file_import_source;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required

        if (null === $this->getFileImportSource()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the
        // target filename to move to
        $this->getFileImportSource()->move(
            $this->getUploadRootDir(), $this->getFileImportSource()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->logo = $this->getUploadDir() . "/" . $this->getFileImportSource()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file_import_source = null;
    }

    /**
     * @var string
     * @JMS\Expose
     */
    private $address;


    /**
     * Set address
     *
     * @param string $address
     * @return Customer
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
     * @var string
     * @JMS\Expose
     */
    private $address2;


    /**
     * Set address2
     *
     * @param string $address2
     *
     * @return Customer
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @JMS\Expose
     */
    private $Reminder;


    /**
     * Add reminder
     *
     * @param \Numa\DOADMSBundle\Entity\Reminder $reminder
     *
     * @return Customer
     */
    public function addReminder(\Numa\DOADMSBundle\Entity\Reminder $reminder)
    {
        $this->Reminder[] = $reminder;

        return $this;
    }

    /**
     * Remove reminder
     *
     * @param \Numa\DOADMSBundle\Entity\Reminder $reminder
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeReminder(\Numa\DOADMSBundle\Entity\Reminder $reminder)
    {
        return $this->Reminder->removeElement($reminder);
    }

    /**
     * Get reminder
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReminder()
    {
        return $this->Reminder;
    }

    public function setReminder($reminder)
    {
        $this->Reminder = $reminder;

        return $this;
    }

    /**
     * @var string
     */
    private $status;


    /**
     * Set status
     *
     * @param string $status
     *
     * @return Customer
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
     * @var integer
     */
    private $qb_id;


    /**
     * Set qbId
     *
     * @param integer $qbId
     *
     * @return Customer
     */
    public function setQbId($qbId)
    {
        $this->qb_id = $qbId;

        return $this;
    }

    /**
     * Get qbId
     *
     * @return integer
     */
    public function getQbId()
    {
        return $this->qb_id;
    }
}
