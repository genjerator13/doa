<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Item
 */
class Item
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $sid;

    /**
     * @var integer
     */
    private $feed_id;

    /**
     * @var integer
     */
    private $category_id;

    /**
     * @var integer
     */
    private $user_id;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var string
     */
    private $moderation_status;

    /**
     * @var string
     */
    private $keywords;

    /**
     * @var boolean
     */
    private $featured;

    /**
     * @var integer
     */
    private $views;

    /**
     * @var integer
     */
    private $pictures;

    /**
     * @var \DateTime
     */
    private $activation_date;

    /**
     * @var \DateTime
     */
    private $expiration_date;

    /**
     * @var \DateTime
     */
    private $featured_last_showed;

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
    private $auto_extend;

    /**
     * @var boolean
     */
    private $feature_highlighted;

    /**
     * @var boolean
     */
    private $feature_slideshow;

    /**
     * @var boolean
     */
    private $feature_youtube;

    /**
     * @var string
     */
    private $last_user_ip;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ItemField;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Category
     */
    private $Category;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Importfeed
     */
    private $Importfeed;

    /**
     * @var \Numa\DOAAdminBundle\Entity\User
     */
    private $User;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ItemField = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set sid
     *
     * @param string $sid
     * @return Item
     */
    public function setSid($sid)
    {
        $this->sid = $sid;
    
        return $this;
    }

    /**
     * Get sid
     *
     * @return string 
     */
    public function getSid()
    {
        return $this->sid;
    }

    /**
     * Set feed_id
     *
     * @param integer $feedId
     * @return Item
     */
    public function setFeedId($feedId)
    {
        $this->feed_id = $feedId;
    
        return $this;
    }

    /**
     * Get feed_id
     *
     * @return integer 
     */
    public function getFeedId()
    {
        return $this->feed_id;
    }

    /**
     * Set category_id
     *
     * @param integer $categoryId
     * @return Item
     */
    public function setCategoryId($categoryId)
    {
        $this->category_id = $categoryId;
    
        return $this;
    }

    /**
     * Get category_id
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return Item
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    
        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Item
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
     * Set moderation_status
     *
     * @param string $moderationStatus
     * @return Item
     */
    public function setModerationStatus($moderationStatus)
    {
        $this->moderation_status = $moderationStatus;
    
        return $this;
    }

    /**
     * Get moderation_status
     *
     * @return string 
     */
    public function getModerationStatus()
    {
        return $this->moderation_status;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     * @return Item
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    
        return $this;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set featured
     *
     * @param boolean $featured
     * @return Item
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;
    
        return $this;
    }

    /**
     * Get featured
     *
     * @return boolean 
     */
    public function getFeatured()
    {
        return $this->featured;
    }

    /**
     * Set views
     *
     * @param integer $views
     * @return Item
     */
    public function setViews($views)
    {
        $this->views = $views;
    
        return $this;
    }

    /**
     * Get views
     *
     * @return integer 
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set pictures
     *
     * @param integer $pictures
     * @return Item
     */
    public function setPictures($pictures)
    {
        $this->pictures = $pictures;
    
        return $this;
    }

    /**
     * Get pictures
     *
     * @return integer 
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Set activation_date
     *
     * @param \DateTime $activationDate
     * @return Item
     */
    public function setActivationDate($activationDate)
    {
        $this->activation_date = $activationDate;
    
        return $this;
    }

    /**
     * Get activation_date
     *
     * @return \DateTime 
     */
    public function getActivationDate()
    {
        return $this->activation_date;
    }

    /**
     * Set expiration_date
     *
     * @param \DateTime $expirationDate
     * @return Item
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expiration_date = $expirationDate;
    
        return $this;
    }

    /**
     * Get expiration_date
     *
     * @return \DateTime 
     */
    public function getExpirationDate()
    {
        return $this->expiration_date;
    }

    /**
     * Set featured_last_showed
     *
     * @param \DateTime $featuredLastShowed
     * @return Item
     */
    public function setFeaturedLastShowed($featuredLastShowed)
    {
        $this->featured_last_showed = $featuredLastShowed;
    
        return $this;
    }

    /**
     * Get featured_last_showed
     *
     * @return \DateTime 
     */
    public function getFeaturedLastShowed()
    {
        return $this->featured_last_showed;
    }

    /**
     * Set date_created
     *
     * @param \DateTime $dateCreated
     * @return Item
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
     * @return Item
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
     * Set auto_extend
     *
     * @param integer $autoExtend
     * @return Item
     */
    public function setAutoExtend($autoExtend)
    {
        $this->auto_extend = $autoExtend;
    
        return $this;
    }

    /**
     * Get auto_extend
     *
     * @return integer 
     */
    public function getAutoExtend()
    {
        return $this->auto_extend;
    }

    /**
     * Set feature_highlighted
     *
     * @param boolean $featureHighlighted
     * @return Item
     */
    public function setFeatureHighlighted($featureHighlighted)
    {
        $this->feature_highlighted = $featureHighlighted;
    
        return $this;
    }

    /**
     * Get feature_highlighted
     *
     * @return boolean 
     */
    public function getFeatureHighlighted()
    {
        return $this->feature_highlighted;
    }

    /**
     * Set feature_slideshow
     *
     * @param boolean $featureSlideshow
     * @return Item
     */
    public function setFeatureSlideshow($featureSlideshow)
    {
        $this->feature_slideshow = $featureSlideshow;
    
        return $this;
    }

    /**
     * Get feature_slideshow
     *
     * @return boolean 
     */
    public function getFeatureSlideshow()
    {
        return $this->feature_slideshow;
    }

    /**
     * Set feature_youtube
     *
     * @param boolean $featureYoutube
     * @return Item
     */
    public function setFeatureYoutube($featureYoutube)
    {
        $this->feature_youtube = $featureYoutube;
    
        return $this;
    }

    /**
     * Get feature_youtube
     *
     * @return boolean 
     */
    public function getFeatureYoutube()
    {
        return $this->feature_youtube;
    }

    /**
     * Set last_user_ip
     *
     * @param string $lastUserIp
     * @return Item
     */
    public function setLastUserIp($lastUserIp)
    {
        $this->last_user_ip = $lastUserIp;
    
        return $this;
    }

    /**
     * Get last_user_ip
     *
     * @return string 
     */
    public function getLastUserIp()
    {
        return $this->last_user_ip;
    }

    /**
     * Add ItemField
     *
     * @param \Numa\DOAAdminBundle\Entity\ItemField $itemField
     * @return Item
     */
    public function addItemField(\Numa\DOAAdminBundle\Entity\ItemField $itemField)
    {
        $this->ItemField->add($itemField);
        $itemField->setItem($this);
        return $this;
    }

    /**
     * Remove ItemField
     *
     * @param \Numa\DOAAdminBundle\Entity\ItemField $itemField
     */
    public function removeItemField(\Numa\DOAAdminBundle\Entity\ItemField $itemField)
    {
        $this->ItemField->removeElement($itemField);
    }

    /**
     * Remove ItemField
     *
     * @param \Numa\DOAAdminBundle\Entity\ItemField $itemField
     */
    public function removeAllItemField()
    {

        $this->ItemField = new \Doctrine\Common\Collections\ArrayCollection();

    }

    /**
     * Get ItemField
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItemField()
    {
        return $this->ItemField;
    }

    /**
     * Set Category
     *
     * @param \Numa\DOAAdminBundle\Entity\Category $category
     * @return Item
     */
    public function setCategory(\Numa\DOAAdminBundle\Entity\Category $category = null)
    {
        $this->Category = $category;
    
        return $this;
    }

    /**
     * Get Category
     *
     * @return \Numa\DOAAdminBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->Category;
    }

    /**
     * Set Importfeed
     *
     * @param \Numa\DOAAdminBundle\Entity\Importfeed $importfeed
     * @return Item
     */
    public function setImportfeed(\Numa\DOAAdminBundle\Entity\Importfeed $importfeed = null)
    {
        $this->Importfeed = $importfeed;
    
        return $this;
    }

    /**
     * Get Importfeed
     *
     * @return \Numa\DOAAdminBundle\Entity\Importfeed 
     */
    public function getImportfeed()
    {
        return $this->Importfeed;
    }

    /**
     * Set User
     *
     * @param \Numa\DOAAdminBundle\Entity\User $user
     * @return Item
     */
    public function setUser(\Numa\DOAAdminBundle\Entity\User $user = null)
    {
        $this->User = $user;
    
        return $this;
    }

    /**
     * Get User
     *
     * @return \Numa\DOAAdminBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->User;
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
     * @ORM\PreUpdate
     */
    public function __toString()
    {
        return "test";
    }
}