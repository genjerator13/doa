<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * @GRID\Source(columns ="id,Category.name,User.UserGroup.name,User.username,active,moderation_status,views,activation_date,expiration_date,date_created" ,groupBy="id")
 */
class Item {

    /**
     * @var integer
     * @GRID\Column(type="text", field="id", title="Id", filterable=true, operatorsVisible=false)
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
     * @GRID\Column(type="text", field="active", title="active", selectFrom="values",values={"Active","inactive"},filter="select", filterable=true, defaultOperator="eq",operatorsVisible=false)

     */
    private $active;

    /**
     * @var string
     * @GRID\Column(type="text", field="moderation_status", title="moderation_status", selectFrom="values",values={"Pending","Aproved","Rejected"},filter="select", filterable=true, defaultOperator="eq",operatorsVisible=false)

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
     * @GRID\Column(type="date", field="activation_date", title="activation_date", selectFrom="source", selectTo="source", filterable=true, defaultOperator="btw",operatorsVisible=false)
     */
    private $activation_date;

    /**
     * @var \DateTime
     * @GRID\Column(type="date", field="expiration_date", title="expiration_date", filterable=true, operatorsVisible=false, defaultOperator="btw")
     */
    private $expiration_date;

    /**
     * @var \DateTime
     */
    private $featured_last_showed;

    /**
     * @var \DateTime
     * @GRID\Column(type="date", field="date_created", title="date_created", selectFrom="source", selectTo="source", filterable=true, defaultOperator="btw",operatorsVisible=false)
     */
    private $date_created;

    /**
     * @var \DateTime
     * 
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
     * 
     */
    private $ItemField;
    public $ItemFieldArray;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Category
     * @GRID\Column(type="text", field="Category.name", title="Category", filter="select", operatorsVisible=false, selectMulti=true, sortable=true)
     */
    private $Category;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Importfeed
     */
    private $Importfeed;

    /**
     * @var \Numa\DOAAdminBundle\Entity\User
     * @GRID\Column(type="text", field="User.UserGroup.name", title="Group", operatorsVisible=false,filter="select")
     * @GRID\Column(type="text", field="User.username", title="Username", operatorsVisible=false)
     */
    private $User;

    /**
     * Constructor
     */
    public function __construct() {
        $this->ItemField = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ItemFieldArray = array();
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
     * Set sid
     *
     * @param string $sid
     * @return Item
     */
    public function setSid($sid) {
        $this->sid = $sid;

        return $this;
    }

    /**
     * Get sid
     *
     * @return string 
     */
    public function getSid() {
        return $this->sid;
    }

    /**
     * Set feed_id
     *
     * @param integer $feedId
     * @return Item
     */
    public function setFeedId($feedId) {
        $this->feed_id = $feedId;

        return $this;
    }

    /**
     * Get feed_id
     *
     * @return integer 
     */
    public function getFeedId() {
        return $this->feed_id;
    }

    /**
     * Set category_id
     *
     * @param integer $categoryId
     * @return Item
     */
    public function setCategoryId($categoryId) {
        $this->category_id = $categoryId;

        return $this;
    }

    /**
     * Get category_id
     *
     * @return integer 
     */
    public function getCategoryId() {
        return $this->category_id;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return Item
     */
    public function setUserId($userId) {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Item
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
     * Set moderation_status
     *
     * @param string $moderationStatus
     * @return Item
     */
    public function setModerationStatus($moderationStatus) {
        $this->moderation_status = $moderationStatus;

        return $this;
    }

    /**
     * Get moderation_status
     *
     * @return string 
     */
    public function getModerationStatus() {
        return $this->moderation_status;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     * @return Item
     */
    public function setKeywords($keywords) {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords() {
        return $this->keywords;
    }

    /**
     * Set featured
     *
     * @param boolean $featured
     * @return Item
     */
    public function setFeatured($featured) {
        $this->featured = $featured;

        return $this;
    }

    /**
     * Get featured
     *
     * @return boolean 
     */
    public function getFeatured() {
        return $this->featured;
    }

    /**
     * Set views
     *
     * @param integer $views
     * @return Item
     */
    public function setViews($views) {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer 
     */
    public function getViews() {
        return $this->views;
    }

    /**
     * Set pictures
     *
     * @param integer $pictures
     * @return Item
     */
    public function setPictures($pictures) {
        $this->pictures = $pictures;

        return $this;
    }

    /**
     * Get pictures
     *
     * @return integer 
     */
    public function getPictures() {
        return $this->pictures;
    }

    /**
     * Set activation_date
     *
     * @param \DateTime $activationDate
     * @return Item
     */
    public function setActivationDate($activationDate) {
        $this->activation_date = $activationDate;

        return $this;
    }

    /**
     * Get activation_date
     *
     * @return \DateTime 
     */
    public function getActivationDate() {
        return $this->activation_date;
    }

    /**
     * Set expiration_date
     *
     * @param \DateTime $expirationDate
     * @return Item
     */
    public function setExpirationDate($expirationDate) {
        $this->expiration_date = $expirationDate;

        return $this;
    }

    /**
     * Get expiration_date
     *
     * @return \DateTime 
     */
    public function getExpirationDate() {
        return $this->expiration_date;
    }

    /**
     * Set featured_last_showed
     *
     * @param \DateTime $featuredLastShowed
     * @return Item
     */
    public function setFeaturedLastShowed($featuredLastShowed) {
        $this->featured_last_showed = $featuredLastShowed;

        return $this;
    }

    /**
     * Get featured_last_showed
     *
     * @return \DateTime 
     */
    public function getFeaturedLastShowed() {
        return $this->featured_last_showed;
    }

    /**
     * Set date_created
     *
     * @param \DateTime $dateCreated
     * @return Item
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
     * @return Item
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
     * Set auto_extend
     *
     * @param integer $autoExtend
     * @return Item
     */
    public function setAutoExtend($autoExtend) {
        $this->auto_extend = $autoExtend;

        return $this;
    }

    /**
     * Get auto_extend
     *
     * @return integer 
     */
    public function getAutoExtend() {
        return $this->auto_extend;
    }

    /**
     * Set feature_highlighted
     *
     * @param boolean $featureHighlighted
     * @return Item
     */
    public function setFeatureHighlighted($featureHighlighted) {
        $this->feature_highlighted = $featureHighlighted;

        return $this;
    }

    /**
     * Get feature_highlighted
     *
     * @return boolean 
     */
    public function getFeatureHighlighted() {
        return $this->feature_highlighted;
    }

    /**
     * Set feature_slideshow
     *
     * @param boolean $featureSlideshow
     * @return Item
     */
    public function setFeatureSlideshow($featureSlideshow) {
        $this->feature_slideshow = $featureSlideshow;

        return $this;
    }

    /**
     * Get feature_slideshow
     *
     * @return boolean 
     */
    public function getFeatureSlideshow() {
        return $this->feature_slideshow;
    }

    /**
     * Set feature_youtube
     *
     * @param boolean $featureYoutube
     * @return Item
     */
    public function setFeatureYoutube($featureYoutube) {
        $this->feature_youtube = $featureYoutube;

        return $this;
    }

    /**
     * Get feature_youtube
     *
     * @return boolean 
     */
    public function getFeatureYoutube() {
        return $this->feature_youtube;
    }

    /**
     * Set last_user_ip
     *
     * @param string $lastUserIp
     * @return Item
     */
    public function setLastUserIp($lastUserIp) {
        $this->last_user_ip = $lastUserIp;

        return $this;
    }

    /**
     * Get last_user_ip
     *
     * @return string 
     */
    public function getLastUserIp() {
        return $this->last_user_ip;
    }

    /**
     * Add ItemField
     *
     * @param \Numa\DOAAdminBundle\Entity\ItemField $itemField
     * @return Item
     */
    public function addItemField(\Numa\DOAAdminBundle\Entity\ItemField $itemField) {
        $this->ItemField->add($itemField);
        $itemField->setItem($this);
        return $this;
    }

    /**
     * Remove ItemField
     *
     * @param \Numa\DOAAdminBundle\Entity\ItemField $itemField
     */
    public function removeItemField(\Numa\DOAAdminBundle\Entity\ItemField $itemField) {
        $this->ItemField->removeElement($itemField);
    }

    /**
     * Remove ItemField
     *
     * @param \Numa\DOAAdminBundle\Entity\ItemField $itemField
     */
    public function removeAllItemField() {

        $this->ItemField = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get ItemField
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItemField() {
        $this->getItemFieldsArray();
        return $this->ItemField;
    }

    /**
     * Get ItemFields
     *
     * @return array
     */
    public function getItemFieldsArray() {

        if (empty($this->ItemFieldArray)) {
            foreach ($this->ItemField as $itemField) {
                $type = $itemField->getFieldType();
                $index = strtolower($itemField->getFieldName());
                if (strtolower($type) != "array") {
                    $this->ItemFieldArray[$index]['object'] = $itemField;
                    $this->ItemFieldArray[$index]['type'] = $itemField->getFieldType();
                    $this->ItemFieldArray[$index]['fieldname'] = $itemField->getFieldName();
                    $this->ItemFieldArray[$index]['stringvalue'] = $itemField->getFieldStringValue();
                } else {
                    $this->ItemFieldArray[$index][$itemField->getId()]['object'] = $itemField;
                    $this->ItemFieldArray[$index][$itemField->getId()]['type'] = $itemField->getFieldType();
                    $this->ItemFieldArray[$index][$itemField->getId()]['fieldname'] = $itemField->getFieldName();
                    $this->ItemFieldArray[$index][$itemField->getId()]['stringvalue'] = $itemField->getFieldStringValue();
                }
            }
        }

        return $this->ItemFieldArray;
    }

    public function dumpItemFields() {
        $this->getItemFieldsArray();
        foreach ($this->ItemFieldArray as $key => $value) {
            if (!empty($value['stringvalue'])) {
                echo "<br>" . $key . ":::" . $value['stringvalue'];
            }
        }
    }

    public function getImage($num = 0) {
        $images = $this->getImages();
        //      
        if (!empty($images)) {
            $val = array_values($images);
            unset($val[0]['object']);
            $ret = array('image' => $val[0]);
            //\Doctrine\Common\Util\Debug::dump($ret);//die();  
            return $ret;
        }
        return false;
    }

    public function getImages() {
        $this->getItemFieldsArray();

        if (!empty($this->ItemFieldArray['image list'])) {
            return $this->ItemFieldArray['image list'];
        }
        return array();
    }

    public function getCountImages() {
        $this->getItemFieldsArray();

        if (!empty($this->ItemFieldArray['image list'])) {
            return count($this->ItemFieldArray['image list']);
        }
        return 0;
    }

    public function getModel() {
        $this->getItemFieldsArray();
        //\Doctrine\Common\Util\Debug::dump($this->ItemFieldArray);
        //die();
        $model = "";
        if ($this->Category instanceof \Numa\DOAAdminBundle\Entity\Category) {
            if ($this->Category->getName() == "Marine") {

                $model = $this->ItemFieldArray['model']['stringvalue'];
            }if ($this->Category->getName() == "Marine") {
                $model = $this->ItemFieldArray['model']['stringvalue'];
            }
        }
        return $model;
    }

    public function getMake() {
        $this->getItemFieldsArray();
        //\Doctrine\Common\Util\Debug::dump($this->ItemFieldArray);
        if ($this->Category instanceof \Numa\DOAAdminBundle\Entity\Category) {
            if ($this->Category->getName() == "Marine") {
                if (isset($this->ItemFieldArray['boat make'])) {
                    return $this->ItemFieldArray['boat make']['stringvalue'];
                }
            } elseif ($this->Category->getName() == "Car") {
                if (isset($this->ItemFieldArray['make model'])) {
                    return $this->ItemFieldArray['make model']['stringvalue'] . " ";
                }
            }
        }
        return "";
    }

    public function getItemFieldByName($name) {
        $this->getItemFieldsArray();


        if (property_exists(get_class($this), $name)) {
            $name = strtolower($name);
            return $this->$name;
        } elseif ($name == 'image') {
            return $this->getImage();
        }

        if (!empty($this->ItemFieldArray[$name])) {

            return $this->ItemFieldArray[$name]['stringvalue'];
        };
        return "";
    }

    /**
     * Set Category
     *
     * @param \Numa\DOAAdminBundle\Entity\Category $category
     * @return Item
     */
    public function setCategory(\Numa\DOAAdminBundle\Entity\Category $category = null) {
        $this->Category = $category;

        return $this;
    }

    /**
     * Get Category
     *
     * @return \Numa\DOAAdminBundle\Entity\Category 
     */
    public function getCategory() {
        return $this->Category;
    }

    /**
     * Set Importfeed
     *
     * @param \Numa\DOAAdminBundle\Entity\Importfeed $importfeed
     * @return Item
     */
    public function setImportfeed(\Numa\DOAAdminBundle\Entity\Importfeed $importfeed = null) {
        if (!empty($importfeed)) {
            $this->Importfeed = $importfeed;
            $isFeatured = $importfeed->getMakeFeatured();
            $isActivated = $importfeed->getActivateListing();
            $isHighlighted = $importfeed->getMakeHighlighted();
            $isExpired = $importfeed->getExpirationAfter();
            $this->setDealer($importfeed->getDealer());
            $this->setCategory($importfeed->getCategory());
        }
        if (!empty($isFeatured)) {
            $this->setFeatured(true);
        }

        if (!empty($isActivated)) {
            $this->setActive(true);
            $this->setActivationDate(new \DateTime());
        }

        if (!empty($isHighlighted)) {
            $this->setFeatureHighlighted(true);
        }

        if (!empty($isExpired)) {
            $days = $importfeed->getExpirationAfter();
            $isDateCreated = $this->getDateCreated();
            if (empty($isDateCreated)) {
                $this->setCreatedAtValue();
            }
            $date_created = $this->getDateCreated();

            $test = new \DateTime();
            $test = $test->setDate($this->getDateCreated()->format("Y"), $this->getDateCreated()->format('m'), $this->getDateCreated()->format('d'));
            $this->setExpirationDate($test->add(new \DateInterval('P' . $days . 'D')));
        }



        if (!empty($dealer)) {
            $itemField = new ItemField();
            $itemField->setFieldBooleanValue(true);
            $itemField->setFieldIntegerValue($dealer);

            $itemField->setFieldStringValue($dealer);
            $itemField->setFieldName('dealer');

            $this->addItemField($itemField);
        }

        return $this;
    }

    /**
     * Get Importfeed
     *
     * @return \Numa\DOAAdminBundle\Entity\Importfeed 
     */
    public function getImportfeed() {
        return $this->Importfeed;
    }

    /**
     * Set User
     *
     * @param \Numa\DOAAdminBundle\Entity\User $user
     * @return Item
     */
    public function setUser(\Numa\DOAAdminBundle\Entity\User $user = null) {
        $this->User = $user;

        return $this;
    }

    /**
     * Get User
     *
     * @return \Numa\DOAAdminBundle\Entity\User 
     */
    public function getUser() {
        return $this->User;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        if (!$this->getDateCreated()) {
            $this->date_created = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->date_updated = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function __toString() {
        return "test";
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $UserItems;

    /**
     * Add UserItems
     *
     * @param \Numa\DOAAdminBundle\Entity\UserItem $userItems
     * @return Item
     */
    public function addUserItem(\Numa\DOAAdminBundle\Entity\UserItem $userItems) {
        $this->UserItems[] = $userItems;

        return $this;
    }

    /**
     * Remove UserItems
     *
     * @param \Numa\DOAAdminBundle\Entity\UserItem $userItems
     */
    public function removeUserItem(\Numa\DOAAdminBundle\Entity\UserItem $userItems) {
        $this->UserItems->removeElement($userItems);
    }

    /**
     * Get UserItems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserItems() {
        return $this->UserItems;
    }

    /**
     * @var integer
     */
    private $dealer_id;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     * @GRID\Column(type="text", field="Dealer.name", title="Dealer", filter="select", operatorsVisible=false, selectMulti=true, sortable=true)
     */
    private $Dealer;

    /**
     * Set dealer_id
     *
     * @param integer $dealerId
     * @return Item
     */
    public function setDealerId($dealerId) {
        $this->dealer_id = $dealerId;

        return $this;
    }

    /**
     * Get dealer_id
     *
     * @return integer 
     */
    public function getDealerId() {
        return $this->dealer_id;
    }

    /**
     * Set Dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     * @return Item
     */
    public function setDealer(\Numa\DOAAdminBundle\Entity\Catalogrecords $dealer = null) {
        $this->Dealer = $dealer;

        return $this;
    }

    /**
     * Get Dealer
     *
     * @return \Numa\DOAAdminBundle\Entity\Catalogrecords 
     */
    public function getDealer() {
        return $this->Dealer;
    }

    public function proccessOptionsList($stringvalue, $separator) {
        $optionsArray = explode($separator, $stringvalue);
        $order = 1;
        foreach ($optionsArray as $key => $option) {
            $itemField = new ItemField();
            $itemField->setAllValues(true);
            $itemField->setFeedId($this->getFeedId());
            $itemField->setFieldName($option);
            $itemField->setFieldType('boolean');
            $itemField->setSortOrder($order);
            $this->addItemField($itemField);
            $order++;
        }
    }

    public function proccessImagesFromRemote($imageString, $maprow, $feed, $upload_path, $upload_url,$em) {
        $listingFields = $maprow->getListingFields();
        $localy = $feed->getPicturesSaveLocaly();
        
        if (is_array($imageString)) {
            $order = 0;
            foreach ($imageString as $key => $value) {
                $itemField = new ItemField();

                $itemField->setAllValues($value);
                $itemField->setFeedId($feed->getId());
                $itemField->setListingfield($listingFields);
                
                $itemField->handleImage($value, $upload_path, $upload_url,$this->getFeedId(), $order, $localy);
                $this->addItemField($itemField);
                $order++;
            }
        } else {
            $pictureSeparator = $feed->getPicturesSeparator();

            if (empty($pictureSeparator)) {
                $pictureSeparator = ";";
            }
            $picturesArray = explode($pictureSeparator, $imageString);

            $order = 0;

            if (count($picturesArray) > 1) {
                $order = 1;
            }

            foreach ($picturesArray as $picture) {
                $itemField = new ItemField();

                $itemField->setAllValues($picture);
                $itemField->setListingfield($listingFields);
                $itemField->setFeedId($feed->getId());
                $itemField->setItem($this);
                $itemField->handleImage($picture,  $upload_path, $upload_url, $this->getFeedId(), $order, $localy);
                $this->addItemField($itemField);
                $order++;

            }

        }
    }

    public function getItemFieldObjectByName($field_name) {

        foreach ($this->getItemField() as $key => $itemfield) {
            if (strtolower($itemfield->getFieldName()) == strtolower($field_name)) {
                return $itemfield;
            }
        }
        return null;
    }

}