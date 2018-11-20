<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;

use Doctrine\ORM\Mapping as ORM;

/**
 * Catalogrecords
 * @JMS\XmlRoot("dealer")
 * @JMS\ExclusionPolicy("ALL")
 *
 *
 */
class Catalogrecords implements UserInterface
{

    /**
     * @var integer
     * @Expose
     */
    protected $id;

    /**
     * @var string
     * @JMS\Expose
     * @JMS\SerializedName("name")
     */
    private $name;

    /**
     * @var string
     * @Expose
     * $Type("string")
     *
     */
    private $url;


    public static $maping = array(
        'DealerID' => 'DealerId',
        'DealerName' => 'Name',
        'Address1' => 'Address',
        'Address2' => 'Address2',
        'City' => 'City',
        'State' => 'State',
        'Zip' => 'Zip',
        'Phone' => 'Phone',
        'Fax' => 'Fax',
        'Email' => 'Email',
        'DealerContact' => 'Contact',
        'DealerWebsite' => 'Url',
        'ShowRoomHours' => 'ShowRoomHours',
        'ServiceHours' => 'ServiceHours',
        'PartsHours' => 'PartsHours',
        'AdminHours' => 'AdminHours'
    );

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
     * Set name
     *
     * @param string $name
     * @return Catalogrecords
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
     * Set url
     *
     * @param string $url
     * @return Catalogrecords
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
     * @ORM\PreRemove
     */
    public function doBeforeRemoved()
    {
        die("sssss");
    }


    /**
     * @var string
     * @Expose
     */
    private $description;

    /**
     * Set description
     *
     * @param string $description
     * @return Catalogrecords
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @var string
     * @Expose
     */
    private $address;

    /**
     * @var string
     * @Expose
     */
    private $phone;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $full;

    /**
     * Set address
     *
     * @param string $address
     * @return Catalogrecords
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
     * Set phone
     *
     * @param string $phone
     * @return Catalogrecords
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Catalogrecords
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Catalogrecords
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
     * Set full
     *
     * @param string $full
     * @return Catalogrecords
     */
    public function setFull($full)
    {
        $this->full = $full;

        return $this;
    }

    /**
     * Get full
     *
     * @return string
     */
    public function getFull()
    {
        return $this->full;
    }

    /**
     * @var string
     * @Expose
     */
    private $fax;

    /**
     * Set fax
     *
     * @param string $fax
     * @return Catalogrecords
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

    public function __toString()
    {
        return $this->getName();
    }

    public function getDisplayName()
    {
        return $this->getName()." (".$this->getUsername().")";
    }

    /**
     * @var string
     * @Expose
     */
    private $logo;

    /**
     * @var string
     * @Expose
     */
    private $logo_url;

    /**
     * Set logo
     *
     * @param string $logo
     * @return Catalogrecords
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

    /**
     * Set logo_url
     *
     * @param string $logoUrl
     * @return Catalogrecords
     */
    public function setLogoUrl($logoUrl)
    {

        $this->logo_url = $logoUrl;

        return $this;
    }

    /**
     * Get logo_url
     *
     * @return string
     */
    public function getLogoUrl()
    {
        if (!empty($this->getLogo())) {
            $this->logo_url = $this->getLogo();
        }
        return $this->logo_url;
    }

    /**
     * @var string
     */
    private $password;

    /**
     * Set password
     *
     * @param string $password
     * @return Catalogrecords
     */
    public function setPassword($password)
    {
        if (!empty($password)) {
            $this->password = $password;
        }

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


    public function getRoles()
    {
        if (strtolower($this->getDmsStatus()) == 'activated') {
            return array('ROLE_DMS_USER', 'ROLE_BUSINES');
        } else {
            return array('ROLE_NODMS_USER', 'ROLE_BUSINES');
        }
        if ($this->getAdmindealer()) {
            return array('ROLE_DEALER_ADMIN', 'ROLE_BUSINES');
        }

        return array('ROLE_BUSINES');
    }

    public function isDMSActivated(){
        return strtolower($this->getDmsStatus()) == 'activated';
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {

    }

    public function equals(User $user)
    {
        return $user->getUsername() == $this->getUsername();
    }

    /**
     * Get username
     *
     * @return string
     */
    private $username;

    public function getUsername()
    {
        return $this->username;
    }

    public function setUserame($username)
    {
        $this->username = $username;
    }

    /**
     * @var integer
     */
    private $dealer_id;

    /**
     * @var string
     */
    private $address2;

    /**
     * @var string
     * @Expose
     */
    private $city;

    /**
     * @var string
     * @Expose
     */
    private $zip;

    /**
     * @var string
     * @Expose
     */
    private $state;

    /**
     * @var string
     * @Expose
     */
    private $ShowRoomHours;

    /**
     * @var string
     * @Expose
     */
    private $ServiceHours;

    /**
     * @var string
     * @Expose
     */
    private $PartsHours;

    /**
     * @var string
     * @Expose
     */
    private $AdminHours;


    /**
     * Set dealer_id
     *
     * @param integer $dealerId
     * @return Catalogrecords
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
     * Set address2
     *
     * @param string $address2
     * @return Catalogrecords
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
     * @return Catalogrecords
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
     * Set zip
     *
     * @param string $zip
     * @return Catalogrecords
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
     * Set state
     *
     * @param string $state
     * @return Catalogrecords
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
     * Set ShowRoomHours
     *
     * @param string $showRoomHours
     * @return Catalogrecords
     */
    public function setShowRoomHours($showRoomHours)
    {
        $this->ShowRoomHours = $showRoomHours;

        return $this;
    }

    /**
     * Get ShowRoomHours
     *
     * @return string
     */
    public function getShowRoomHours()
    {
        return $this->ShowRoomHours;
    }

    /**
     * Set ServiceHours
     *
     * @param string $serviceHours
     * @return Catalogrecords
     */
    public function setServiceHours($serviceHours)
    {
        $this->ServiceHours = $serviceHours;

        return $this;
    }

    /**
     * Get ServiceHours
     *
     * @return string
     */
    public function getServiceHours()
    {
        return $this->ServiceHours;
    }

    /**
     * Set PartsHours
     *
     * @param string $partsHours
     * @return Catalogrecords
     */
    public function setPartsHours($partsHours)
    {
        $this->PartsHours = $partsHours;

        return $this;
    }

    /**
     * Get PartsHours
     *
     * @return string
     */
    public function getPartsHours()
    {
        return $this->PartsHours;
    }

    /**
     * Set AdminHours
     *
     * @param string $adminHours
     * @return Catalogrecords
     */
    public function setAdminHours($adminHours)
    {
        $this->AdminHours = $adminHours;

        return $this;
    }

    /**
     * Get AdminHours
     *
     * @return string
     */
    public function getAdminHours()
    {
        return $this->AdminHours;
    }

    /**
     * @var string
     * @Expose
     */
    private $contact;


    /**
     * Set contact
     *
     * @param string $contact
     * @return Catalogrecords
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
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
        return 'upload/dealers/' . $this->getId();
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
        $this->logo_url = $this->logo;
//        dump($this->logo);die();
        // clean up the file property as you won't need it anymore
        $this->file_import_source = null;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Catalogrecords
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @var integer
     */
    private $category_id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $DealerCategories;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogcategory
     */
    private $Catalogcategory;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->DealerCategories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Coupon = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return Catalogrecords
     */
    public function setCategoryId($categoryId)
    {
        $this->category_id = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Add dealerCategory
     *
     * @param \Numa\DOAAdminBundle\Entity\DealerCategories $dealerCategory
     *
     * @return Catalogrecords
     */
    public function addDealerCategory(\Numa\DOAAdminBundle\Entity\DealerCategories $dealerCategory)
    {
        $this->DealerCategories[] = $dealerCategory;

        return $this;
    }

    /**
     * Remove dealerCategory
     *
     * @param \Numa\DOAAdminBundle\Entity\DealerCategories $dealerCategory
     */
    public function removeDealerCategory(\Numa\DOAAdminBundle\Entity\DealerCategories $dealerCategory)
    {
        $this->DealerCategories->removeElement($dealerCategory);
    }

    /**
     * Get dealerCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDealerCategories()
    {
        return $this->DealerCategories;
    }

    /**
     * Set catalogcategory
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogcategory $catalogcategory
     *
     * @return Catalogrecords
     */
    public function setCatalogcategory(\Numa\DOAAdminBundle\Entity\Catalogcategory $catalogcategory = null)
    {
        $this->Catalogcategory = $catalogcategory;

        return $this;
    }

    /**
     * Get catalogcategory
     *
     * @return \Numa\DOAAdminBundle\Entity\Catalogcategory
     */
    public function getCatalogcategory()
    {
        return $this->Catalogcategory;
    }

    // Important
    public function getDcategory()
    {
        $dcategories = new ArrayCollection();
        if (!empty($this->getDealerCategories()) && !$this->getDealerCategories()->isEmpty()) {
            foreach ($this->getDealerCategories() as $dc) {
                if ($dc instanceof DealerCategories) {
                    $dcategories[] = $dc->getDcategory();
                }
            }
        }
        return $dcategories;
    }

    // Important
    public function setDcategory($dcategories)
    {
        foreach ($dcategories as $dcategory) {
            $dc = new DealerCategories();

            $dc->setCatalogrecords($this);
            $dc->setDcategory($dcategory);

            $this->addDealerCategory($dc);
        }

    }

    public function getDcategoryNames()
    {
        $res = array();
        if (!empty($this->getDealerCategories()) && !$this->getDealerCategories()->isEmpty()) {

            foreach ($this->getDealerCategories() as $dc) {
                if ($dc instanceof DealerCategories) {
                    $res[] = $dc->getDcategory()->getName() . " ";
                }
            }
        }
        return implode(',', $res);
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Coupon;


    /**
     * Add coupon
     *
     * @param \Numa\DOAAdminBundle\Entity\Coupon $coupon
     *
     * @return Catalogrecords
     */
    public function addCoupon(\Numa\DOAAdminBundle\Entity\Coupon $coupon)
    {
        $this->Coupon[] = $coupon;

        return $this;
    }

    /**
     * Remove coupon
     *
     * @param \Numa\DOAAdminBundle\Entity\Coupon $coupon
     */
    public function removeCoupon(\Numa\DOAAdminBundle\Entity\Coupon $coupon)
    {
        $this->Coupon->removeElement($coupon);
    }

    /**
     * Get coupon
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCoupon()
    {
        return $this->Coupon;
    }

    public function hasCoupons()
    {
        foreach ($this->getCoupon() as $coupon) {
            if (!$coupon->isEmpty()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @var bool
     */
    private $Admindealer;


    /**
     * Set admindealer
     *
     * @param bool $admindealer
     *
     * @return Catalogrecords
     */
    public function setAdmindealer($admindealer)
    {
        $this->Admindealer = $admindealer;

        return $this;
    }

    /**
     * Get admindealer
     *
     * @return bool
     */
    public function getAdmindealer()
    {
        return $this->Admindealer;
    }

    /**
     * @var string
     */
    private $dms_status;


    /**
     * Set dms_status
     *
     * @param string $dmsStatus
     * @return Catalogrecords
     */
    public function setDmsStatus($dmsStatus)
    {
        $this->dms_status = $dmsStatus;

        return $this;
    }

    /**
     * Get dms_status
     *
     * @return string
     */
    public function getDmsStatus()
    {
        return $this->dms_status;
    }


    /**
     * @var string
     * @Expose
     */
    private $gst;


    /**
     * Set gst
     *
     * @param string $gst
     *
     * @return Catalogrecords
     */
    public function setGst($gst)
    {
        $this->gst = $gst;

        return $this;
    }

    /**
     * Get gst
     *
     * @return string
     */
    public function getGst()
    {
        return $this->gst;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $HomeTab;


    /**
     * Add homeTab
     *
     * @param \Numa\DOAAdminBundle\Entity\HomeTab $homeTab
     *
     * @return Catalogrecords
     */
    public function addHomeTab(\Numa\DOAAdminBundle\Entity\HomeTab $homeTab)
    {
        $this->HomeTab[] = $homeTab;

        return $this;
    }

    /**
     * Remove homeTab
     *
     * @param \Numa\DOAAdminBundle\Entity\HomeTab $homeTab
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeHomeTab(\Numa\DOAAdminBundle\Entity\HomeTab $homeTab)
    {
        return $this->HomeTab->removeElement($homeTab);
    }

    /**
     * Get homeTab
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHomeTab()
    {
        return $this->HomeTab;
    }

    public function __sleep()
    {

        // these are field names to be serialized, others will be excluded
        // but note that you have to fill other field values by your own
        return array('id',
            'category_id',
            'name',
            'description',
            'url',
            'address',
            'phone',
            'location',
            'email',
            'fax',
            'full',
            'logo',
            'logo_url',
            'password',
            'contact',
            'dealer_id',
            'address2',
            'city',
            'zip',
            'state',
            'username',
            'Admindealer',
            'dms_status',
            'gst',
        );
    }

    /**
     * @var string
     * @Expose
     */
    private $site_url;

    /**
     * @var string
     * @expose
     */
    private $site_theme;


    /**
     * Set siteUrl
     *
     * @param string $siteUrl
     * @return Catalogrecords
     */
    public function setSiteUrl($siteUrl)
    {
        $this->site_url = $siteUrl;

        return $this;
    }

    /**
     * Get siteUrl
     *
     * @return string
     */
    public function getSiteUrl()
    {
        return $this->site_url;
    }

    /**
     * Get siteUrl
     *
     * @return string
     */
    public function getAbsoluteSiteUrl()
    {
        $res = $this->site_url;
        if(strpos($this->site_url,"http://")===false){
            $res= "http://".$res;
        }

        return $res;
    }

    /**
     * Set siteTheme
     *
     * @param string $siteTheme
     *
     * @return Catalogrecords
     */
    public function setSiteTheme($siteTheme)
    {
        $this->site_theme = $siteTheme;

        return $this;
    }

    /**
     * Get siteTheme
     *
     * @return string
     */
    public function getSiteTheme()
    {
        return $this->site_theme;
    }

    /**
     * @var string
     * @Expose
     */
    private $country;


    /**
     * Set country
     *
     * @param string $country
     *
     * @return Catalogrecords
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
     * @var string
     * @Expose
     */
    private $site_facebook;

    /**
     * @var string
     * @Expose
     */
    private $site_youtube;

    /**
     * @var string
     * @Expose
     */
    private $site_google;

    /**
     * @var string
     * @Expose
     */
    private $site_twiter;

    /**
     * @var string
     * @Expose
     */
    private $site_instagram;


    /**
     * Set siteFacebook
     *
     * @param string $siteFacebook
     *
     * @return Catalogrecords
     */
    public function setSiteFacebook($siteFacebook)
    {
        $this->site_facebook = $siteFacebook;

        return $this;
    }

    /**
     * Get siteFacebook
     *
     * @return string
     */
    public function getSiteFacebook()
    {
        return $this->site_facebook;
    }

    /**
     * Set siteYoutube
     *
     * @param string $siteYoutube
     *
     * @return Catalogrecords
     */
    public function setSiteYoutube($siteYoutube)
    {
        $this->site_youtube = $siteYoutube;

        return $this;
    }

    /**
     * Get siteYoutube
     *
     * @return string
     */
    public function getSiteYoutube()
    {
        return $this->site_youtube;
    }

    /**
     * Set siteGoogle
     *
     * @param string $siteGoogle
     *
     * @return Catalogrecords
     */
    public function setSiteGoogle($siteGoogle)
    {
        $this->site_google = $siteGoogle;

        return $this;
    }

    /**
     * Get siteGoogle
     *
     * @return string
     */
    public function getSiteGoogle()
    {
        return $this->site_google;
    }

    /**
     * Set siteTwiter
     *
     * @param string $siteTwiter
     *
     * @return Catalogrecords
     */
    public function setSiteTwiter($siteTwiter)
    {
        $this->site_twiter = $siteTwiter;

        return $this;
    }

    /**
     * Get siteTwiter
     *
     * @return string
     */
    public function getSiteTwiter()
    {
        return $this->site_twiter;
    }

    /**
     * Set siteInstagram
     *
     * @param string $siteInstagram
     *
     * @return Catalogrecords
     */
    public function setSiteInstagram($siteInstagram)
    {
        $this->site_instagram = $siteInstagram;

        return $this;
    }

    /**
     * Get siteInstagram
     *
     * @return string
     */
    public function getSiteInstagram()
    {
        return $this->site_instagram;
    }

    /**
     * @var string
     */
    private $site_twitter;


    /**
     * Set siteTwitter
     *
     * @param string $siteTwitter
     *
     * @return Catalogrecords
     */
    public function setSiteTwitter($siteTwitter)
    {
        $this->site_twitter = $siteTwitter;

        return $this;
    }

    /**
     * Get siteTwitter
     *
     * @return string
     */
    public function getSiteTwitter()
    {
        return $this->site_twitter;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Expose
     */
    private $Component;


    /**
     * Add component
     *
     * @param \Numa\DOADMSBundle\Entity\DealerComponent $component
     *
     * @return Catalogrecords
     */
    public function addComponent(\Numa\DOADMSBundle\Entity\DealerComponent $component)
    {
        $this->Component[] = $component;

        return $this;
    }

    /**
     * Remove component
     *
     * @param \Numa\DOADMSBundle\Entity\DealerComponent $component
     */
    public function removeComponent(\Numa\DOADMSBundle\Entity\DealerComponent $component)
    {
        $this->Component->removeElement($component);
    }

    /**
     * Get component
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComponent()
    {
        return $this->Component;
    }

    /**
     * @var string
     */
    private $terms_upload;

    /**
     * @var string
     */
    private $terms_text;


    /**
     * Set termsUpload
     *
     * @param string $termsUpload
     *
     * @return Catalogrecords
     */
    public function setTermsUpload($termsUpload)
    {
        $this->terms_upload = $termsUpload;

        return $this;
    }

    /**
     * Get termsUpload
     *
     * @return string
     */
    public function getTermsUpload()
    {
        return $this->terms_upload;
    }

    /**
     * Set termsText
     *
     * @param string $termsText
     *
     * @return Catalogrecords
     */
    public function setTermsText($termsText)
    {
        $this->terms_text = $termsText;

        return $this;
    }

    /**
     * Get termsText
     *
     * @return string
     */
    public function getTermsText()
    {
        return $this->terms_text;
    }

    /**
     * @var string
     */
    private $finance_email;


    /**
     * Set financeEmail
     *
     * @param string $financeEmail
     *
     * @return Catalogrecords
     */
    public function setFinanceEmail($financeEmail)
    {
        $this->finance_email = $financeEmail;

        return $this;
    }

    /**
     * Get financeEmail
     *
     * @return string
     */
    public function getFinanceEmail()
    {
        return $this->finance_email;
    }

    public function isCarDealer()
    {
        return $this->dealerType(1);
    }

    public function isMotoDealer()
    {
        return $this->dealerType(5);
    }

    public function isRVsDealer()
    {
        return $this->dealerType(7);
    }

    public function isAgDealer()
    {
        return $this->dealerType(3);
    }

    public function dealerType($cid)
    {

        foreach ($this->getDcategory() as $category) {
            if ($category->getId() == $cid) {
                return true;
            }
        }
        return false;
    }

    /**
     * @var string
     */
    private $default_listing_comment;


    /**
     * Set defaultListingComment
     *
     * @param string $defaultListingComment
     *
     * @return Catalogrecords
     */
    public function setDefaultListingComment($defaultListingComment)
    {
        $this->default_listing_comment = $defaultListingComment;

        return $this;
    }

    /**
     * Get defaultListingComment
     *
     * @return string
     */
    public function getDefaultListingComment()
    {
        return $this->default_listing_comment;
    }

    /**
     * @var integer
     * @Expose
     */
    private $dealer_group_id;

    /**
     * @var \Numa\DOAAdminBundle\Entity\DealerGroup
     */
    private $DealerGroup;


    /**
     * Set dealerGroupId
     *
     * @param integer $dealerGroupId
     *
     * @return Catalogrecords
     */
    public function setDealerGroupId($dealerGroupId)
    {
        $this->dealer_group_id = $dealerGroupId;

        return $this;
    }

    /**
     * Get dealerGroupId
     *
     * @return integer
     */
    public function getDealerGroupId()
    {
        return $this->dealer_group_id;
    }

    /**
     * Set dealerGroup
     *
     * @param \Numa\DOAAdminBundle\Entity\DealerGroup $dealerGroup
     *
     * @return Catalogrecords
     */
    public function setDealerGroup(\Numa\DOADMSBundle\Entity\DealerGroup $dealerGroup = null)
    {
        $this->DealerGroup = $dealerGroup;

        return $this;
    }

    /**
     * Get dealerGroup
     *
     * @return \Numa\DOAAdminBundle\Entity\DealerGroup
     */
    public function getDealerGroup()
    {
        return $this->DealerGroup;
    }
    /**
     * @var string
     */
    private $feul_economy;


    /**
     * Set feulEconomy
     *
     * @param string $feulEconomy
     *
     * @return Catalogrecords
     */
    public function setFeulEconomy($feulEconomy)
    {
        $this->feul_economy = $feulEconomy;

        return $this;
    }

    /**
     * Get feulEconomy
     *
     * @return string
     */
    public function getFeulEconomy()
    {
        return $this->feul_economy;
    }
    /**
     * @var string
     */
    private $fuel_economy;


    /**
     * Set fuelEconomy
     *
     * @param string $fuelEconomy
     *
     * @return Catalogrecords
     */
    public function setFuelEconomy($fuelEconomy)
    {
        $this->fuel_economy = $fuelEconomy;

        return $this;
    }

    /**
     * Get fuelEconomy
     *
     * @return string
     */
    public function getFuelEconomy()
    {
        return $this->fuel_economy;
    }
    /**
     * @var string
     */
    private $feed_kijiji_url;

    /**
     * @var string
     */
    private $feed_kijiji_username;

    /**
     * @var string
     */
    private $feed_kijiji_password;


    /**
     * Set feedKijijiUrl
     *
     * @param string $feedKijijiUrl
     *
     * @return Catalogrecords
     */
    public function setFeedKijijiUrl($feedKijijiUrl)
    {
        $this->feed_kijiji_url = $feedKijijiUrl;

        return $this;
    }

    /**
     * Get feedKijijiUrl
     *
     * @return string
     */
    public function getFeedKijijiUrl()
    {
        return $this->feed_kijiji_url;
    }

    public function getRfeedUrl($rfeedName='kijiji'){
        if($rfeedName=='kijiji') {
            return $this->getFeedKijijiUrl();
        }elseif($rfeedName=='autotrader'){
            return $this->getFeedAutotraderUrl();
        }elseif($rfeedName=='cargurus'){
            return $this->getFeedCargurusUrl();
        }
        elseif($rfeedName=='vauto'){
            return $this->getFeedVautoUrl();
        }
        elseif($rfeedName=='siriusxm'){
            return $this->getFeedSiriusxmUrl();
        }
    }
    public function getRfeedFunction($rfeedName='kijiji',$function){
        $rfeed = ucfirst($rfeedName);
        $rfeedFunction = "getFeed".$rfeed.ucfirst($function);
        return $this->$rfeedFunction();
    }
    public function getRfeedManual($rfeedName='kijiji'){

        if($rfeedName=='kijiji') {
            return $this->getFeedKijijiManual();
        }elseif($rfeedName=='autotrader'){
            return $this->getFeedAutotraderManual();
        }elseif($rfeedName=='cargurus'){
            return $this->getFeedAutotraderManual();
        }
        elseif($rfeedName=='vauto'){
            return $this->getFeedVautoManual();
        }
        elseif($rfeedName=='siriusxm'){
            return $this->getFeedSiriusxmManual();
        }
    }

    public function setRfeedManual($feedKijijiManual,$rfeedName)
    {
        if($rfeedName=='kijiji') {
            return $this->setFeedKijijiManual($feedKijijiManual);
        }elseif($rfeedName=='autotrader'){
            return $this->setFeedAutotraderManual($feedKijijiManual);
        }elseif($rfeedName=='vauto'){
            return $this->setFeedVautoManual();
        }
        elseif($rfeedName=='siriusxm'){
            return $this->getFeedSiriusxmManual($feedKijijiManual);
        }

        return $this;
    }

    /**
     * Set feedKijijiUsername
     *
     * @param string $feedKijijiUsername
     *
     * @return Catalogrecords
     */
    public function setFeedKijijiUsername($feedKijijiUsername)
    {
        $this->feed_kijiji_username = $feedKijijiUsername;

        return $this;
    }



    /**
     * Get feedKijijiUsername
     *
     * @return string
     */
    public function getFeedKijijiUsername()
    {
        return $this->feed_kijiji_username;
    }

    public function getRfeedUsername($rfeedName='kijiji')
    {
        if($rfeedName=='kijiji') {
            return $this->getFeedKijijiUsername();
        }elseif($rfeedName=='autotrader'){
            return $this->getFeedAutotraderUsername();
        }elseif($rfeedName=='vauto'){
            return $this->getFeedVautoUsername();
        }
        elseif($rfeedName=='siriusxm'){
            return $this->getFeedSiriusxmUsername();
        }
    }

    public function getRfeedPassword($rfeedName='kijiji')
    {
        if($rfeedName=='kijiji') {
            return $this->getFeedKijijiPassword();
        }elseif($rfeedName=='autotrader'){
            return $this->getFeedAutotraderPassword();
        }elseif($rfeedName=='vauto'){
            return $this->getFeedVautoPassword();
        }
        elseif($rfeedName=='siriusxm'){
            return $this->getFeedSiriusxmPassword();
        }
    }

    /**
     * Set feedKijijiPassword
     *
     * @param string $feedKijijiPassword
     *
     * @return Catalogrecords
     */
    public function setFeedKijijiPassword($feedKijijiPassword)
    {
        $this->feed_kijiji_password = $feedKijijiPassword;

        return $this;
    }

    /**
     * Get feedKijijiPassword
     *
     * @return string
     */
    public function getFeedKijijiPassword()
    {
        return $this->feed_kijiji_password;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $DealerSetting;


    /**
     * Add dealerSetting
     *
     * @param \Numa\DOADMSBundle\Entity\DealerSetting $dealerSetting
     *
     * @return Catalogrecords
     */
    public function addDealerSetting(\Numa\DOADMSBundle\Entity\DealerSetting $dealerSetting)
    {
        $this->DealerSetting[] = $dealerSetting;

        return $this;
    }

    /**
     * Remove dealerSetting
     *
     * @param \Numa\DOADMSBundle\Entity\DealerSetting $dealerSetting
     */
    public function removeDealerSetting(\Numa\DOADMSBundle\Entity\DealerSetting $dealerSetting)
    {
        $this->DealerSetting->removeElement($dealerSetting);
    }

    /**
     * Get dealerSetting
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDealerSetting()
    {
        return $this->DealerSetting;
    }
    /**
     * @var string
     */
    private $setting_purechat;


    /**
     * Set settingPurechat
     *
     * @param string $settingPurechat
     *
     * @return Catalogrecords
     */
    public function setSettingPurechat($settingPurechat)
    {
        $this->setting_purechat = $settingPurechat;

        return $this;
    }

    /**
     * Get settingPurechat
     *
     * @return string
     */
    public function getSettingPurechat()
    {
        return $this->setting_purechat;
    }
    /**
     * @var string
     */
    private $setting_ga;


    /**
     * Set settingGa
     *
     * @param string $settingGa
     *
     * @return Catalogrecords
     */
    public function setSettingGa($settingGa)
    {
        $this->setting_ga = $settingGa;

        return $this;
    }

    /**
     * Get settingGa
     *
     * @return string
     */
    public function getSettingGa()
    {
        return $this->setting_ga;
    }
    /**
     * @var string
     */
    private $qb_realm_id;

    /**
     * @var string
     */
    private $qb_identifier;

    /**
     * @var string
     */
    private $qb_token_credential;


    /**
     * Set qbRealmId
     *
     * @param string $qbRealmId
     *
     * @return Catalogrecords
     */
    public function setQbRealmId($qbRealmId)
    {
        $this->qb_realm_id = $qbRealmId;

        return $this;
    }

    /**
     * Get qbRealmId
     *
     * @return string
     */
    public function getQbRealmId()
    {
        return $this->qb_realm_id;
    }

    /**
     * Set qbIdentifier
     *
     * @param string $qbIdentifier
     *
     * @return Catalogrecords
     */
    public function setQbIdentifier($qbIdentifier)
    {
        $this->qb_identifier = $qbIdentifier;

        return $this;
    }

    /**
     * Get qbIdentifier
     *
     * @return string
     */
    public function getQbIdentifier()
    {
        return $this->qb_identifier;
    }

    /**
     * Set qbTokenCredential
     *
     * @param string $qbTokenCredential
     *
     * @return Catalogrecords
     */
    public function setQbTokenCredential($qbTokenCredential)
    {
        $this->qb_token_credential = $qbTokenCredential;

        return $this;
    }

    /**
     * Get qbTokenCredential
     *
     * @return string
     */
    public function getQbTokenCredential()
    {
        return $this->qb_token_credential;
    }
    /**
     * @var string
     */
    private $qb_server;


    /**
     * Set qbServer
     *
     * @param string $qbServer
     *
     * @return Catalogrecords
     */
    public function setQbServer($qbServer)
    {
        $this->qb_server = $qbServer;

        return $this;
    }

    /**
     * Get qbServer
     *
     * @return string
     */
    public function getQbServer()
    {
        return $this->qb_server;
    }
    /**
     * @var string
     */
    private $qb_temp_token;


    /**
     * Set qbTempToken
     *
     * @param string $qbTempToken
     *
     * @return Catalogrecords
     */
    public function setQbTempToken($qbTempToken)
    {
        $this->qb_temp_token = $qbTempToken;

        return $this;
    }

    /**
     * Get qbTempToken
     *
     * @return string
     */
    public function getQbTempToken()
    {
        return $this->qb_temp_token;
    }
    /**
     * @var string
     */
    private $setting_ga_view;


    /**
     * Set settingGaView
     *
     * @param string $settingGaView
     *
     * @return Catalogrecords
     */
    public function setSettingGaView($settingGaView)
    {
        $this->setting_ga_view = $settingGaView;

        return $this;
    }

    /**
     * Get settingGaView
     *
     * @return string
     */
    public function getSettingGaView()
    {
        return $this->setting_ga_view;
    }
    /**
     * @var string
     */
    private $site_googlemap;


    /**
     * Set siteGooglemap
     *
     * @param string $siteGooglemap
     *
     * @return Catalogrecords
     */
    public function setSiteGooglemap($siteGooglemap)
    {
        $this->site_googlemap = $siteGooglemap;

        return $this;
    }

    /**
     * Get siteGooglemap
     *
     * @return string
     */
    public function getSiteGooglemap()
    {
        return $this->site_googlemap;
    }
    /**
     * @var boolean
     */
    private $feed_kijiji_manual;


    /**
     * Set feedKijijiManual
     *
     * @param boolean $feedKijijiManual
     *
     * @return Catalogrecords
     */
    public function setFeedKijijiManual($feedKijijiManual)
    {
        $this->feed_kijiji_manual = $feedKijijiManual;

        return $this;
    }

    /**
     * Get feedKijijiManual
     *
     * @return boolean
     */
    public function getFeedKijijiManual()
    {
        return $this->feed_kijiji_manual;
    }
    /**
     * @var string
     */
    private $site_google_tag;


    /**
     * Set siteGoogleTag
     *
     * @param string $siteGoogleTag
     *
     * @return Catalogrecords
     */
    public function setSiteGoogleTag($siteGoogleTag)
    {
        $this->site_google_tag = $siteGoogleTag;

        return $this;
    }

    /**
     * Get siteGoogleTag
     *
     * @return string
     */
    public function getSiteGoogleTag()
    {
        return $this->site_google_tag;
    }
    /**
     * @var string
     */
    private $dealer_number;


    /**
     * Set dealerNumber
     *
     * @param string $dealerNumber
     *
     * @return Catalogrecords
     */
    public function setDealerNumber($dealerNumber)
    {
        $this->dealer_number = $dealerNumber;

        return $this;
    }

    /**
     * Get dealerNumber
     *
     * @return string
     */
    public function getDealerNumber()
    {
        return $this->dealer_number;
    }
    /**
     * @var string
     */
    private $site_facebook_pixel_id;


    /**
     * Set siteFacebookPixelId
     *
     * @param string $siteFacebookPixelId
     *
     * @return Catalogrecords
     */
    public function setSiteFacebookPixelId($siteFacebookPixelId)
    {
        $this->site_facebook_pixel_id = $siteFacebookPixelId;

        return $this;
    }

    /**
     * Get siteFacebookPixelId
     *
     * @return string
     */
    public function getSiteFacebookPixelId()
    {
        return $this->site_facebook_pixel_id;
    }
    /**
     * @var string
     */
    private $legal_trade_name;


    /**
     * Set legalTradeName
     *
     * @param string $legalTradeName
     *
     * @return Catalogrecords
     */
    public function setLegalTradeName($legalTradeName)
    {
        $this->legal_trade_name = $legalTradeName;

        return $this;
    }

    /**
     * Get legalTradeName
     *
     * @return string
     */
    public function getLegalTradeName()
    {
        return $this->legal_trade_name;
    }
    /**
     * @var string
     * @Expose
     */
    private $biweekly_url;


    /**
     * Set biweeklyUrl
     *
     * @param string $biweeklyUrl
     *
     * @return Catalogrecords
     */
    public function setBiweeklyUrl($biweeklyUrl)
    {
        $this->biweekly_url = $biweeklyUrl;

        return $this;
    }

    /**
     * Get biweeklyUrl
     *
     * @return string
     */
    public function getBiweeklyUrl()
    {
        return $this->biweekly_url;
    }
    /**
     * @var string
     * @Expose
     */
    private $service_phone;


    /**
     * Set servicePhone
     *
     * @param string $servicePhone
     *
     * @return Catalogrecords
     */
    public function setServicePhone($servicePhone)
    {
        $this->service_phone = $servicePhone;

        return $this;
    }

    /**
     * Get servicePhone
     *
     * @return string
     */
    public function getServicePhone()
    {
        return $this->service_phone;
    }
    /**
     * @var string
     * @Expose
     */
    private $billing_url;


    /**
     * Set billingUrl
     *
     * @param string $billingUrl
     *
     * @return Catalogrecords
     */
    public function setBillingUrl($billingUrl)
    {
        $this->billing_url = $billingUrl;

        return $this;
    }

    /**
     * Get billingUrl
     *
     * @return string
     */
    public function getBillingUrl()
    {
        return $this->billing_url;
    }

    public function getUrlForBilling()
    {
        return !empty($this->billing_url)?$this->billing_url:$this->site_url;
    }
    /**
     * @var string
     */
    private $business_contact;


    /**
     * Set businessContact
     *
     * @param string $businessContact
     *
     * @return Catalogrecords
     */
    public function setBusinessContact($businessContact)
    {
        $this->business_contact = $businessContact;

        return $this;
    }

    /**
     * Get businessContact
     *
     * @return string
     */
    public function getBusinessContact()
    {
        return $this->business_contact;
    }
    /**
     * @var string
     */
    private $feed_autotrader_url;

    /**
     * @var string
     */
    private $feed_autotrader_username;

    /**
     * @var string
     */
    private $feed_autotrader_password;

    /**
     * @var boolean
     */
    private $feed_autotrader_manual;


    /**
     * Set feedAutotraderUrl
     *
     * @param string $feedAutotraderUrl
     *
     * @return Catalogrecords
     */
    public function setFeedAutotraderUrl($feedAutotraderUrl)
    {
        $this->feed_autotrader_url = $feedAutotraderUrl;

        return $this;
    }

    /**
     * Get feedAutotraderUrl
     *
     * @return string
     */
    public function getFeedAutotraderUrl()
    {
        return $this->feed_autotrader_url;
    }

    /**
     * Set feedAutotraderUsername
     *
     * @param string $feedAutotraderUsername
     *
     * @return Catalogrecords
     */
    public function setFeedAutotraderUsername($feedAutotraderUsername)
    {
        $this->feed_autotrader_username = $feedAutotraderUsername;

        return $this;
    }

    /**
     * Get feedAutotraderUsername
     *
     * @return string
     */
    public function getFeedAutotraderUsername()
    {
        return $this->feed_autotrader_username;
    }

    /**
     * Set feedAutotraderPassword
     *
     * @param string $feedAutotraderPassword
     *
     * @return Catalogrecords
     */
    public function setFeedAutotraderPassword($feedAutotraderPassword)
    {
        $this->feed_autotrader_password = $feedAutotraderPassword;

        return $this;
    }

    /**
     * Get feedAutotraderPassword
     *
     * @return string
     */
    public function getFeedAutotraderPassword()
    {
        return $this->feed_autotrader_password;
    }

    /**
     * Set feedAutotraderManual
     *
     * @param boolean $feedAutotraderManual
     *
     * @return Catalogrecords
     */
    public function setFeedAutotraderManual($feedAutotraderManual)
    {
        $this->feed_autotrader_manual = $feedAutotraderManual;

        return $this;
    }

    /**
     * Get feedAutotraderManual
     *
     * @return boolean
     */
    public function getFeedAutotraderManual()
    {
        return $this->feed_autotrader_manual;
    }
    /**
     * @var string
     */
    private $biweekly_interest_rate = '0.00';

    /**
     * @var string
     */
    private $biweekly_pmts = '0.00';


    /**
     * Set biweeklyInterestRate
     *
     * @param string $biweeklyInterestRate
     *
     * @return Catalogrecords
     */
    public function setBiweeklyInterestRate($biweeklyInterestRate)
    {
        $this->biweekly_interest_rate = $biweeklyInterestRate;

        return $this;
    }

    /**
     * Get biweeklyInterestRate
     *
     * @return string
     */
    public function getBiweeklyInterestRate()
    {
        return $this->biweekly_interest_rate;
    }

    /**
     * Set biweeklyPmts
     *
     * @param string $biweeklyPmts
     *
     * @return Catalogrecords
     */
    public function setBiweeklyPmts($biweeklyPmts)
    {
        $this->biweekly_pmts = $biweeklyPmts;

        return $this;
    }

    /**
     * Get biweeklyPmts
     *
     * @return string
     */
    public function getBiweeklyPmts()
    {
        return $this->biweekly_pmts;
    }
    /**
     * @var string
     */
    private $feed_siriusxm_url;

    /**
     * @var string
     */
    private $feed_siriusxm_username;

    /**
     * @var string
     */
    private $feed_siriusxm_password;


    /**
     * Set feedSiriusxmUrl
     *
     * @param string $feedSiriusxmUrl
     *
     * @return Catalogrecords
     */
    public function setFeedSiriusxmUrl($feedSiriusxmUrl)
    {
        $this->feed_siriusxm_url = $feedSiriusxmUrl;

        return $this;
    }

    /**
     * Get feedSiriusxmUrl
     *
     * @return string
     */
    public function getFeedSiriusxmUrl()
    {
        return $this->feed_siriusxm_url;
    }

    /**
     * Set feedSiriusxmUsername
     *
     * @param string $feedSiriusxmUsername
     *
     * @return Catalogrecords
     */
    public function setFeedSiriusxmUsername($feedSiriusxmUsername)
    {
        $this->feed_siriusxm_username = $feedSiriusxmUsername;

        return $this;
    }

    /**
     * Get feedSiriusxmUsername
     *
     * @return string
     */
    public function getFeedSiriusxmUsername()
    {
        return $this->feed_siriusxm_username;
    }

    /**
     * Set feedSiriusxmPassword
     *
     * @param string $feedSiriusxmPassword
     *
     * @return Catalogrecords
     */
    public function setFeedSiriusxmPassword($feedSiriusxmPassword)
    {
        $this->feed_siriusxm_password = $feedSiriusxmPassword;

        return $this;
    }

    /**
     * Get feedSiriusxmPassword
     *
     * @return string
     */
    public function getFeedSiriusxmPassword()
    {
        return $this->feed_siriusxm_password;
    }
    /**
     * @var boolean
     */
    private $feed_siriusxm_manual;


    /**
     * Set feedSiriusxmManual
     *
     * @param boolean $feedSiriusxmManual
     *
     * @return Catalogrecords
     */
    public function setFeedSiriusxmManual($feedSiriusxmManual)
    {
        $this->feed_siriusxm_manual = $feedSiriusxmManual;

        return $this;
    }

    /**
     * Get feedSiriusxmManual
     *
     * @return boolean
     */
    public function getFeedSiriusxmManual()
    {
        return $this->feed_siriusxm_manual;
    }
    /**
     * @var string
     */
    private $feed_vauto_url;

    /**
     * @var string
     */
    private $feed_vauto_username;

    /**
     * @var string
     */
    private $feed_vauto_password;

    /**
     * @var boolean
     */
    private $feed_vauto_manual;


    /**
     * Set feedVautoUrl
     *
     * @param string $feedVautoUrl
     *
     * @return Catalogrecords
     */
    public function setFeedVautoUrl($feedVautoUrl)
    {
        $this->feed_vauto_url = $feedVautoUrl;

        return $this;
    }

    /**
     * Get feedVautoUrl
     *
     * @return string
     */
    public function getFeedVautoUrl()
    {
        return $this->feed_vauto_url;
    }

    /**
     * Set feedVautoUsername
     *
     * @param string $feedVautoUsername
     *
     * @return Catalogrecords
     */
    public function setFeedVautoUsername($feedVautoUsername)
    {
        $this->feed_vauto_username = $feedVautoUsername;

        return $this;
    }

    /**
     * Get feedVautoUsername
     *
     * @return string
     */
    public function getFeedVautoUsername()
    {
        return $this->feed_vauto_username;
    }

    /**
     * Set feedVautoPassword
     *
     * @param string $feedVautoPassword
     *
     * @return Catalogrecords
     */
    public function setFeedVautoPassword($feedVautoPassword)
    {
        $this->feed_vauto_password = $feedVautoPassword;

        return $this;
    }

    /**
     * Get feedVautoPassword
     *
     * @return string
     */
    public function getFeedVautoPassword()
    {
        return $this->feed_vauto_password;
    }

    /**
     * Set feedVautoManual
     *
     * @param boolean $feedVautoManual
     *
     * @return Catalogrecords
     */
    public function setFeedVautoManual($feedVautoManual)
    {
        $this->feed_vauto_manual = $feedVautoManual;

        return $this;
    }

    /**
     * Get feedVautoManual
     *
     * @return boolean
     */
    public function getFeedVautoManual()
    {
        return $this->feed_vauto_manual;
    }
    /**
     * @var string
     */
    private $feed_cargurus_url;

    /**
     * @var string
     */
    private $feed_cargurus_username;

    /**
     * @var string
     */
    private $feed_cargurus_password;

    /**
     * @var boolean
     */
    private $feed_cargurus_manual;


    /**
     * Set feedCargurusUrl
     *
     * @param string $feedCargurusUrl
     *
     * @return Catalogrecords
     */
    public function setFeedCargurusUrl($feedCargurusUrl)
    {
        $this->feed_cargurus_url = $feedCargurusUrl;

        return $this;
    }

    /**
     * Get feedCargurusUrl
     *
     * @return string
     */
    public function getFeedCargurusUrl()
    {
        return $this->feed_cargurus_url;
    }

    /**
     * Set feedCargurusUsername
     *
     * @param string $feedCargurusUsername
     *
     * @return Catalogrecords
     */
    public function setFeedCargurusUsername($feedCargurusUsername)
    {
        $this->feed_cargurus_username = $feedCargurusUsername;

        return $this;
    }

    /**
     * Get feedCargurusUsername
     *
     * @return string
     */
    public function getFeedCargurusUsername()
    {
        return $this->feed_cargurus_username;
    }

    /**
     * Set feedCargurusPassword
     *
     * @param string $feedCargurusPassword
     *
     * @return Catalogrecords
     */
    public function setFeedCargurusPassword($feedCargurusPassword)
    {
        $this->feed_cargurus_password = $feedCargurusPassword;

        return $this;
    }

    /**
     * Get feedCargurusPassword
     *
     * @return string
     */
    public function getFeedCargurusPassword()
    {
        return $this->feed_cargurus_password;
    }

    /**
     * Set feedCargurusManual
     *
     * @param boolean $feedCargurusManual
     *
     * @return Catalogrecords
     */
    public function setFeedCargurusManual($feedCargurusManual)
    {
        $this->feed_cargurus_manual = $feedCargurusManual;

        return $this;
    }

    /**
     * Get feedCargurusManual
     *
     * @return boolean
     */
    public function getFeedCargurusManual()
    {
        return $this->feed_cargurus_manual;
    }

    public function getAddressCityStateZip(){
        return $this->getAddressCityState()." ".$this->getZip();
    }
    public function getAddressCityState(){
        return $this->getAddress()." ".$this->getState()." ".$this->getCity();
    }
    /**
     * @var string
     */
    private $meta_js;

    /**
     * @var string
     */
    private $meta_css;


    /**
     * Set metaJs
     *
     * @param string $metaJs
     *
     * @return Catalogrecords
     */
    public function setMetaJs($metaJs)
    {
        $this->meta_js = $metaJs;

        return $this;
    }

    /**
     * Get metaJs
     *
     * @return string
     */
    public function getMetaJs()
    {
        return $this->meta_js;
    }

    /**
     * Set metaCss
     *
     * @param string $metaCss
     *
     * @return Catalogrecords
     */
    public function setMetaCss($metaCss)
    {
        $this->meta_css = $metaCss;

        return $this;
    }

    /**
     * Get metaCss
     *
     * @return string
     */
    public function getMetaCss()
    {
        return $this->meta_css;
    }
    /**
     * @var string
     */
    private $email2;


    /**
     * Set email2
     *
     * @param string $email2
     *
     * @return Catalogrecords
     */
    public function setEmail2($email2)
    {
        $this->email2 = $email2;

        return $this;
    }

    /**
     * Get email2
     *
     * @return string
     */
    public function getEmail2()
    {
        return $this->email2;
    }
}
