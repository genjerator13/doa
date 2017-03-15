<?php

namespace Numa\DOADMSBundle\Entity;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;

/**
 * Vendor
 * @JMS\XmlRoot("vendor")
 * @JMS\ExclusionPolicy("ALL")
 */
class Vendor
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
    private $company_name;

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
    private $address;

    /**
     * @var string
     * @JMS\Expose
     */
    private $address2;

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
    private $sales_person;

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
     * @JMS\Expose
     */
    private $anotes;

    /**
     * @JMS\Expose
     * @var \DateTime
     */
    private $followup_date;

    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var \DateTime
     */
    private $date_updated;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $dealer_id;

    /**
     * @var string
     * @JMS\Expose
     */
    private $logo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Note;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Billing;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Reminder;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Catalogrecords;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Note = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Billing = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Reminder = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set companyName
     *
     * @param string $companyName
     *
     * @return Vendor
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Vendor
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Vendor
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Vendor
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
     * Set address2
     *
     * @param string $address2
     *
     * @return Vendor
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
     * Set city
     *
     * @param string $city
     *
     * @return Vendor
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
     * @return Vendor
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
     *
     * @return Vendor
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
     *
     * @return Vendor
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
     * Set homePhone
     *
     * @param string $homePhone
     *
     * @return Vendor
     */
    public function setHomePhone($homePhone)
    {
        $this->home_phone = $homePhone;

        return $this;
    }

    /**
     * Get homePhone
     *
     * @return string
     */
    public function getHomePhone()
    {
        return $this->home_phone;
    }

    /**
     * Set workPhone
     *
     * @param string $workPhone
     *
     * @return Vendor
     */
    public function setWorkPhone($workPhone)
    {
        $this->work_phone = $workPhone;

        return $this;
    }

    /**
     * Get workPhone
     *
     * @return string
     */
    public function getWorkPhone()
    {
        return $this->work_phone;
    }

    /**
     * Set mobilePhone
     *
     * @param string $mobilePhone
     *
     * @return Vendor
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobile_phone = $mobilePhone;

        return $this;
    }

    /**
     * Get mobilePhone
     *
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->mobile_phone;
    }

    /**
     * Set salesPerson
     *
     * @param string $salesPerson
     *
     * @return Vendor
     */
    public function setSalesPerson($salesPerson)
    {
        $this->sales_person = $salesPerson;

        return $this;
    }

    /**
     * Get salesPerson
     *
     * @return string
     */
    public function getSalesPerson()
    {
        return $this->sales_person;
    }

    /**
     * Set fax
     *
     * @param string $fax
     *
     * @return Vendor
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
     *
     * @return Vendor
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
     * Set anotes
     *
     * @param string $anotes
     *
     * @return Vendor
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
        return $this->anotes;
    }

    /**
     * Set followupDate
     *
     * @param \DateTime $followupDate
     *
     * @return Vendor
     */
    public function setFollowupDate($followupDate)
    {
        $this->followup_date = $followupDate;

        return $this;
    }

    /**
     * Get followupDate
     *
     * @return \DateTime
     */
    public function getFollowupDate()
    {
        return $this->followup_date;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Vendor
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
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return Vendor
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
     * Set status
     *
     * @param string $status
     *
     * @return Vendor
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
     * Set dealerId
     *
     * @param integer $dealerId
     *
     * @return Vendor
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
     * Set logo
     *
     * @param string $logo
     *
     * @return Vendor
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
        return 'upload/vendor/' . $this->getId();
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
        //dump($this->logo );die();
        // clean up the file property as you won't need it anymore
        $this->file_import_source = null;
    }
    /**
     * Add note
     *
     * @param \Numa\DOADMSBundle\Entity\Note $note
     *
     * @return Vendor
     */
    public function addNote(\Numa\DOADMSBundle\Entity\Note $note)
    {
        $this->Note[] = $note;

        return $this;
    }

    /**
     * Remove note
     *
     * @param \Numa\DOADMSBundle\Entity\Note $note
     */
    public function removeNote(\Numa\DOADMSBundle\Entity\Note $note)
    {
        $this->Note->removeElement($note);
    }

    /**
     * Get note
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNote()
    {
        return $this->Note;
    }

    /**
     * Add billing
     *
     * @param \Numa\DOADMSBundle\Entity\Billing $billing
     *
     * @return Vendor
     */
    public function addBilling(\Numa\DOADMSBundle\Entity\Billing $billing)
    {
        $this->Billing[] = $billing;

        return $this;
    }

    /**
     * Remove billing
     *
     * @param \Numa\DOADMSBundle\Entity\Billing $billing
     */
    public function removeBilling(\Numa\DOADMSBundle\Entity\Billing $billing)
    {
        $this->Billing->removeElement($billing);
    }

    /**
     * Get billing
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBilling()
    {
        return $this->Billing;
    }

    /**
     * Add reminder
     *
     * @param \Numa\DOADMSBundle\Entity\Reminder $reminder
     *
     * @return Vendor
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
     */
    public function removeReminder(\Numa\DOADMSBundle\Entity\Reminder $reminder)
    {
        $this->Reminder->removeElement($reminder);
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

    /**
     * Set catalogrecords
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $catalogrecords
     *
     * @return Vendor
     */
    public function setCatalogrecords(\Numa\DOAAdminBundle\Entity\Catalogrecords $catalogrecords = null)
    {
        $this->Catalogrecords = $catalogrecords;

        return $this;
    }

    /**
     * Get catalogrecords
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

    public function __toString()
    {

        return empty($this->company_name)?$this->first_name." ".$this->last_name:$this->company_name;
    }
    /**
     * @var integer
     */
    private $qb_supplier_id;


    /**
     * Set qbSupplierId
     *
     * @param integer $qbSupplierId
     *
     * @return Vendor
     */
    public function setQbSupplierId($qbSupplierId)
    {
        $this->qb_supplier_id = $qbSupplierId;

        return $this;
    }

    /**
     * Get qbSupplierId
     *
     * @return integer
     */
    public function getQbSupplierId()
    {
        return $this->qb_supplier_id;
    }
}
