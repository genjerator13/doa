<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Importfeed
 */
class Importfeed
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
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $import_format;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var string
     */
    private $import_method;

    /**
     * @var string
     */
    private $import_source;

    /**
     * @var string
     */
    private $root_node;

    /**
     * @var integer
     */
    private $listing_type;

    /**
     * @var string
     */
    private $default_user;

    /**
     * @var boolean
     */
    private $notify_on_user_registration;

    /**
     * @var string
     */
    private $options_key;

    /**
     * @var string
     */
    private $options_separator;

    /**
     * @var string
     */
    private $default_package;

    /**
     * @var string
     */
    private $pictures_key;

    /**
     * @var string
     */
    private $pictures_separator;

    /**
     * @var boolean
     */
    private $activate_listing;

    /**
     * @var boolean
     */
    private $make_featured;

    /**
     * @var boolean
     */
    private $make_highlighted;

    /**
     * @var boolean
     */
    private $make_slideshow;

    /**
     * @var boolean
     */
    private $make_youtubevideo;

    /**
     * @var boolean
     */
    private $add_options;

    /**
     * @var boolean
     */
    private $add_list_values;

    /**
     * @var boolean
     */
    private $add_tree_values;

    /**
     * @var string
     */
    private $unique_field;

    /**
     * @var boolean
     */
    private $update_on_match;

    /**
     * @var integer
     */
    private $expiration_after;

    /**
     * @var \DateTime
     */
    private $updated_on;

    /**
     * @var string
     */
    private $user_type;

    /**
     * @var string
     */
    private $user_unique_field;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Category
     */
    private $Category;


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
     * @return Importfeed
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
     * Set description
     *
     * @param string $description
     * @return Importfeed
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
     * Set import_format
     *
     * @param string $importFormat
     * @return Importfeed
     */
    public function setImportFormat($importFormat)
    {
        $this->import_format = $importFormat;
    
        return $this;
    }

    /**
     * Get import_format
     *
     * @return string 
     */
    public function getImportFormat()
    {
        return $this->import_format;
    }

    /**
     * Set delimiter
     *
     * @param string $delimiter
     * @return Importfeed
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
    
        return $this;
    }

    /**
     * Get delimiter
     *
     * @return string 
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * Set import_method
     *
     * @param string $importMethod
     * @return Importfeed
     */
    public function setImportMethod($importMethod)
    {
        $this->import_method = $importMethod;
    
        return $this;
    }

    /**
     * Get import_method
     *
     * @return string 
     */
    public function getImportMethod()
    {
        return $this->import_method;
    }

    /**
     * Set import_source
     *
     * @param string $importSource
     * @return Importfeed
     */
    public function setImportSource($importSource)
    {
        $this->import_source = $importSource;
    
        return $this;
    }

    /**
     * Get import_source
     *
     * @return string 
     */
    public function getImportSource()
    {
        return $this->import_source;
    }

    /**
     * Set root_node
     *
     * @param string $rootNode
     * @return Importfeed
     */
    public function setRootNode($rootNode)
    {
        $this->root_node = $rootNode;
    
        return $this;
    }

    /**
     * Get root_node
     *
     * @return string 
     */
    public function getRootNode()
    {
        return $this->root_node;
    }

    /**
     * Set listing_type
     *
     * @param integer $listingType
     * @return Importfeed
     */
    public function setListingType($listingType)
    {
        $this->listing_type = $listingType;
    
        return $this;
    }

    /**
     * Get listing_type
     *
     * @return integer 
     */
    public function getListingType()
    {
        return $this->listing_type;
    }

    /**
     * Set default_user
     *
     * @param string $defaultUser
     * @return Importfeed
     */
    public function setDefaultUser($defaultUser)
    {
        $this->default_user = $defaultUser;
    
        return $this;
    }

    /**
     * Get default_user
     *
     * @return string 
     */
    public function getDefaultUser()
    {
        return $this->default_user;
    }

    /**
     * Set notify_on_user_registration
     *
     * @param boolean $notifyOnUserRegistration
     * @return Importfeed
     */
    public function setNotifyOnUserRegistration($notifyOnUserRegistration)
    {
        $this->notify_on_user_registration = $notifyOnUserRegistration;
    
        return $this;
    }

    /**
     * Get notify_on_user_registration
     *
     * @return boolean 
     */
    public function getNotifyOnUserRegistration()
    {
        return $this->notify_on_user_registration;
    }

    /**
     * Set options_key
     *
     * @param string $optionsKey
     * @return Importfeed
     */
    public function setOptionsKey($optionsKey)
    {
        $this->options_key = $optionsKey;
    
        return $this;
    }

    /**
     * Get options_key
     *
     * @return string 
     */
    public function getOptionsKey()
    {
        return $this->options_key;
    }

    /**
     * Set options_separator
     *
     * @param string $optionsSeparator
     * @return Importfeed
     */
    public function setOptionsSeparator($optionsSeparator)
    {
        $this->options_separator = $optionsSeparator;
    
        return $this;
    }

    /**
     * Get options_separator
     *
     * @return string 
     */
    public function getOptionsSeparator()
    {
        return $this->options_separator;
    }

    /**
     * Set default_package
     *
     * @param string $defaultPackage
     * @return Importfeed
     */
    public function setDefaultPackage($defaultPackage)
    {
        $this->default_package = $defaultPackage;
    
        return $this;
    }

    /**
     * Get default_package
     *
     * @return string 
     */
    public function getDefaultPackage()
    {
        return $this->default_package;
    }

    /**
     * Set pictures_key
     *
     * @param string $picturesKey
     * @return Importfeed
     */
    public function setPicturesKey($picturesKey)
    {
        $this->pictures_key = $picturesKey;
    
        return $this;
    }

    /**
     * Get pictures_key
     *
     * @return string 
     */
    public function getPicturesKey()
    {
        return $this->pictures_key;
    }

    /**
     * Set pictures_separator
     *
     * @param string $picturesSeparator
     * @return Importfeed
     */
    public function setPicturesSeparator($picturesSeparator)
    {
        $this->pictures_separator = $picturesSeparator;
    
        return $this;
    }

    /**
     * Get pictures_separator
     *
     * @return string 
     */
    public function getPicturesSeparator()
    {
        return $this->pictures_separator;
    }

    /**
     * Set activate_listing
     *
     * @param boolean $activateListing
     * @return Importfeed
     */
    public function setActivateListing($activateListing)
    {
        $this->activate_listing = $activateListing;
    
        return $this;
    }

    /**
     * Get activate_listing
     *
     * @return boolean 
     */
    public function getActivateListing()
    {
        return $this->activate_listing;
    }

    /**
     * Set make_featured
     *
     * @param boolean $makeFeatured
     * @return Importfeed
     */
    public function setMakeFeatured($makeFeatured)
    {
        $this->make_featured = $makeFeatured;
    
        return $this;
    }

    /**
     * Get make_featured
     *
     * @return boolean 
     */
    public function getMakeFeatured()
    {
        return $this->make_featured;
    }

    /**
     * Set make_highlighted
     *
     * @param boolean $makeHighlighted
     * @return Importfeed
     */
    public function setMakeHighlighted($makeHighlighted)
    {
        $this->make_highlighted = $makeHighlighted;
    
        return $this;
    }

    /**
     * Get make_highlighted
     *
     * @return boolean 
     */
    public function getMakeHighlighted()
    {
        return $this->make_highlighted;
    }

    /**
     * Set make_slideshow
     *
     * @param boolean $makeSlideshow
     * @return Importfeed
     */
    public function setMakeSlideshow($makeSlideshow)
    {
        $this->make_slideshow = $makeSlideshow;
    
        return $this;
    }

    /**
     * Get make_slideshow
     *
     * @return boolean 
     */
    public function getMakeSlideshow()
    {
        return $this->make_slideshow;
    }

    /**
     * Set make_youtubevideo
     *
     * @param boolean $makeYoutubevideo
     * @return Importfeed
     */
    public function setMakeYoutubevideo($makeYoutubevideo)
    {
        $this->make_youtubevideo = $makeYoutubevideo;
    
        return $this;
    }

    /**
     * Get make_youtubevideo
     *
     * @return boolean 
     */
    public function getMakeYoutubevideo()
    {
        return $this->make_youtubevideo;
    }

    /**
     * Set add_options
     *
     * @param boolean $addOptions
     * @return Importfeed
     */
    public function setAddOptions($addOptions)
    {
        $this->add_options = $addOptions;
    
        return $this;
    }

    /**
     * Get add_options
     *
     * @return boolean 
     */
    public function getAddOptions()
    {
        return $this->add_options;
    }

    /**
     * Set add_list_values
     *
     * @param boolean $addListValues
     * @return Importfeed
     */
    public function setAddListValues($addListValues)
    {
        $this->add_list_values = $addListValues;
    
        return $this;
    }

    /**
     * Get add_list_values
     *
     * @return boolean 
     */
    public function getAddListValues()
    {
        return $this->add_list_values;
    }

    /**
     * Set add_tree_values
     *
     * @param boolean $addTreeValues
     * @return Importfeed
     */
    public function setAddTreeValues($addTreeValues)
    {
        $this->add_tree_values = $addTreeValues;
    
        return $this;
    }

    /**
     * Get add_tree_values
     *
     * @return boolean 
     */
    public function getAddTreeValues()
    {
        return $this->add_tree_values;
    }

    /**
     * Set unique_field
     *
     * @param string $uniqueField
     * @return Importfeed
     */
    public function setUniqueField($uniqueField)
    {
        $this->unique_field = $uniqueField;
    
        return $this;
    }

    /**
     * Get unique_field
     *
     * @return string 
     */
    public function getUniqueField()
    {
        return $this->unique_field;
    }

    /**
     * Set update_on_match
     *
     * @param boolean $updateOnMatch
     * @return Importfeed
     */
    public function setUpdateOnMatch($updateOnMatch)
    {
        $this->update_on_match = $updateOnMatch;
    
        return $this;
    }

    /**
     * Get update_on_match
     *
     * @return boolean 
     */
    public function getUpdateOnMatch()
    {
        return $this->update_on_match;
    }

    /**
     * Set expiration_after
     *
     * @param integer $expirationAfter
     * @return Importfeed
     */
    public function setExpirationAfter($expirationAfter)
    {
        $this->expiration_after = $expirationAfter;
    
        return $this;
    }

    /**
     * Get expiration_after
     *
     * @return integer 
     */
    public function getExpirationAfter()
    {
        return $this->expiration_after;
    }

    /**
     * Set updated_on
     *
     * @param \DateTime $updatedOn
     * @return Importfeed
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updated_on = $updatedOn;
    
        return $this;
    }

    /**
     * Get updated_on
     *
     * @return \DateTime 
     */
    public function getUpdatedOn()
    {
        return $this->updated_on;
    }

    /**
     * Set user_type
     *
     * @param string $userType
     * @return Importfeed
     */
    public function setUserType($userType)
    {
        $this->user_type = $userType;
    
        return $this;
    }

    /**
     * Get user_type
     *
     * @return string 
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * Set user_unique_field
     *
     * @param string $userUniqueField
     * @return Importfeed
     */
    public function setUserUniqueField($userUniqueField)
    {
        $this->user_unique_field = $userUniqueField;
    
        return $this;
    }

    /**
     * Get user_unique_field
     *
     * @return string 
     */
    public function getUserUniqueField()
    {
        return $this->user_unique_field;
    }

    /**
     * Set Category
     *
     * @param \Numa\DOAAdminBundle\Entity\Category $category
     * @return Importfeed
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
