<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HomeTab
 */
class HomeTab
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $category_id;

    /**
     * @var string
     */
    private $category_name;

    /**
     * @var integer
     */
    private $listing_field_list_id;

    /**
     * @var string
     */
    private $listing_field_list_value;

    /**
     * @var integer
     */
    private $position;

    /**
     * @var string
     */
    private $location;

    /**
     * @var integer
     */
    private $count;

    /**
     * @var boolean
     */
    private $is_public;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var \Numa\DOAAdminBundle\Entity\ListingFieldLists
     */
    protected $ListingFieldLists;


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
     * Set category_id
     *
     * @param integer $categoryId
     * @return HomeTab
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
     * Set category_name
     *
     * @param string $categoryName
     * @return HomeTab
     */
    public function setCategoryName($categoryName)
    {
        $this->category_name = $categoryName;
    
        return $this;
    }

    /**
     * Get category_name
     *
     * @return string 
     */
    public function getCategoryName()
    {
        return $this->category_name;
    }

    /**
     * Set listing_field_list_id
     *
     * @param integer $listingFieldListId
     * @return HomeTab
     */
    public function setListingFieldListId($listingFieldListId)
    {
        $this->listing_field_list_id = $listingFieldListId;
    
        return $this;
    }

    /**
     * Get listing_field_list_id
     *
     * @return integer 
     */
    public function getListingFieldListId()
    {
        return $this->listing_field_list_id;
    }

    /**
     * Set listing_field_list_value
     *
     * @param string $listingFieldListValue
     * @return HomeTab
     */
    public function setListingFieldListValue($listingFieldListValue)
    {
        $this->listing_field_list_value = $listingFieldListValue;
    
        return $this;
    }

    /**
     * Get listing_field_list_value
     *
     * @return string 
     */
    public function getListingFieldListValue()
    {
        return $this->listing_field_list_value;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return HomeTab
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return HomeTab
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
     * Set count
     *
     * @param integer $count
     * @return HomeTab
     */
    public function setCount($count)
    {
        $this->count = $count;
    
        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set is_public
     *
     * @param boolean $isPublic
     * @return HomeTab
     */
    public function setIsPublic($isPublic)
    {
        $this->is_public = $isPublic;
    
        return $this;
    }

    /**
     * Get is_public
     *
     * @return boolean 
     */
    public function getIsPublic()
    {
        return $this->is_public;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return HomeTab
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return HomeTab
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set ListingFieldLists
     *
     * @param \Numa\DOAAdminBundle\Entity\ListingFieldLists $listingFieldLists
     * @return HomeTab
     */
    public function setListingFieldLists(\Numa\DOAAdminBundle\Entity\ListingFieldLists $listingFieldLists = null)
    {
        $this->ListingFieldLists = $listingFieldLists;
    
        return $this;
    }

    /**
     * Get ListingFieldLists
     *
     * @return \Numa\DOAAdminBundle\Entity\ListingFieldLists 
     */
    public function getListingFieldLists()
    {
        return $this->ListingFieldLists;
    }
    
        /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if(!$this->getCreatedAt()) {
            $this->created_at = new \DateTime();
        }
    }
 
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updated_at = new \DateTime();
    }
    /**
     * @var \Numa\DOAAdminBundle\Entity\Category
     */
    protected $Category;


    /**
     * Set Category
     *
     * @param \Numa\DOAAdminBundle\Entity\Category $category
     * @return HomeTab
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
     * @var string
     */
    protected $listing_field_list_slug;


    /**
     * Set listingFieldListSlug
     *
     * @param string $listingFieldListSlug
     *
     * @return HomeTab
     */
    public function setListingFieldListSlug($listingFieldListSlug)
    {
        $this->listing_field_list_slug = $listingFieldListSlug;

        return $this;
    }

    /**
     * Get listingFieldListSlug
     *
     * @return string
     */
    public function getListingFieldListSlug()
    {
        return $this->listing_field_list_slug;
    }
    /**
     * @var int
     */
    protected $dealer_id;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    protected $Dealer;


    /**
     * Set dealerId
     *
     * @param int $dealerId
     *
     * @return HomeTab
     */
    public function setDealerId($dealerId)
    {
        $this->dealer_id = $dealerId;

        return $this;
    }

    /**
     * Get dealerId
     *
     * @return int
     */
    public function getDealerId()
    {
        return $this->dealer_id;
    }

    /**
     * Set dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     *
     * @return HomeTab
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

    public function __sleep() {

        // these are field names to be serialized, others will be excluded
        // but note that you have to fill other field values by your own
        return array('id',
            'category_id',
            'category_name',
            'listing_field_list_id',
            'listing_field_list_value',
            'position',
            'location',
            'count',
            'listing_field_list_slug',
            'dealer_id',
        );
    }

}
