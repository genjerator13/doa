<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Doctrine\Common\Collections\Criteria;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;
use Numa\DOAModuleBundle\Entity\Seo;


/**
 * @GRID\Source(columns ="id,sold,Category.name,make,model,stock_nr, Dealer.name,active,moderation_status,views,activation_date,expiration_date,date_created,featured" ,groupBy="id")
 * @JMS\XmlRoot("listing")
 * @JMS\ExclusionPolicy("ALL")
 */
class Item
{

    public static $fields = array(
        1 =>
            array('body_description' => 'bodyDescription', 'doors' => 'doors', 'exterior_color' => 'exteriorColor', 'interior_color' => 'interiorColor', 'engine' => 'engine', 'transmission' => 'transmission', 'fuel_type' => 'fuelType', 'drive_type' => 'driveType', 'Make Model' => 'make', 'model' => 'model'),
        2 =>
            array('Boat Type' => 'type', 'boat_weight' => 'weight', 'exterior_color' => 'exteriorColor', 'interior_color' => 'interiorColor', 'engine' => 'engine', 'transmission' => 'transmission', 'fuel type' => 'fuelType', 'drive type' => 'driveType'),
        3 =>
            array('Cooling System' => 'coolingSystem', 'make' => 'make', 'Type' => 'type', 'exterior_color' => 'exteriorColor', 'interior_color' => 'interiorColor', 'engine' => 'engine', 'transmission' => 'transmission', 'fuel_type' => 'fuelType', 'drive_type' => 'driveType'),
        4 =>
            array('Make Model' => 'make', 'model' => 'model', 'Type' => 'type', 'Chassis Type' => 'chassisType', 'sleeps' => 'sleeps', 'exterior_color' => 'exteriorColor', 'interior_color' => 'interiorColor', 'engine' => 'engine', 'transmission' => 'transmission', 'fuel_type' => 'fuelType', 'drive_type' => 'driveType', 'chassis_type' => 'ChassisType'),
        13 =>
            array('make' => 'make', 'model' => 'model', 'ag_application' => 'agApplication', 'steering' => 'steeringType', 'engine' => 'engine', 'transmission' => 'transmission', 'fuel_type' => 'fuelType', 'drive_type' => 'driveType', 'chassis_type' => 'ChassisType')
    );

    /**
     * @var integer
     * @GRID\Column(type="text", field="id", title="Id", filterable=true, operatorsVisible=false)
     * @JMS\Expose
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
     * @GRID\Column(type="text", field="active", title="active", selectFrom="values",values={"inactive","Active"},filter="select", filterable=true, defaultOperator="eq",operatorsVisible=false)
     */
    private $active;

    /**
     * @var string
     * @GRID\Column(type="text", field="moderation_status", title="Status", selectFrom="values",values={"Pending","Aproved","Rejected"},filter="select", filterable=true, defaultOperator="eq",operatorsVisible=false)
     */
    private $moderation_status;

    /**
     * @var string
     */
    private $keywords;

    /**
     * @var boolean
     * @GRID\Column(type="text", field="featured", title="featured", filterable=false, operatorsVisible=false,hidden=true)
     */
    private $featured;

    /**
     * @var integer
     * @GRID\Column(type="text", field="views", title="Views", filterable=false, operatorsVisible=false)
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
     * @GRID\Column(type="date", field="date_created", title="date_created", selectFrom="source", selectTo="source",sortable=true, filterable=true, defaultOperator="btw",operatorsVisible=false)
     */
    private $date_created;

    /**
     * @var \DateTime
     * @JMS\Expose
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
    public function __construct()
    {
        $this->ItemField = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ItemFieldArray = array();
        $this->dontupdate = false;

    }

    private $dontupdate;

    public function setDontUpdate()
    {
        $this->dontupdate = true;
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
        //$this->equalizeItemField($itemField);
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
//as
        $this->ItemField = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get ItemField
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItemField()
    {
        $this->getItemFieldsArray();

        return $this->ItemField;
    }

    public function sortItemFieldsBy($order = 'fieldName', $by = Criteria::ASC)
    {
        if (!empty($order)) {
            $sort = Criteria::create();
            $sort->orderBy(Array(
                $order => $by
            ));
            $ordered = $this->getItemField()->matching($sort);
            $this->ItemField = $ordered;
        }
    }


    /**
     * Get ItemFields
     *
     * @return array
     */
    public function getItemFieldsArray()
    {

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

    public function dumpItemFields()
    {
        $this->getItemFieldsArray();
        foreach ($this->ItemFieldArray as $key => $value) {
            if (!empty($value['stringvalue'])) {
                echo "<br>" . $key . ":::" . $value['stringvalue'];
            }
        }
    }

    public function getImages2()
    {
        $if = $this->getItemField();
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("fieldName", "Image List"));
        $images = $if->matching($criteria);

        // Collect an array iterator.
        $iterator = $images->getIterator();

// Do sort the new iterator.
        $iterator->uasort(function ($a, $b) {
            return ($a->getSortOrder() < $b->getSortOrder()) ? -1 : 1;
        });

// pass sorted array to a new ArrayCollection.
        $imagesSorted = new \Doctrine\Common\Collections\ArrayCollection(iterator_to_array($iterator));

        return $imagesSorted;
    }

    public function getImagesForApi()
    {
        $images = $this->getImages2();
        $res = array();
        foreach ($images as $image) {
            if ($image instanceof ItemField) {
                $res['image'][] = $image->getFieldStringValue();
            }

        }
        return $res;
    }

    /**
     *
     * @return typeget Attributes
     */
    public function getOptions()
    {
        $if = $this->getItemField();
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->contains("fieldType", "boolean"))
            ->andWhere(Criteria::expr()->contains("fieldBooleanValue", "1"))
            ->orderBy(array("fieldName" => "ASC"));

        return $if->matching($criteria);
    }

    public function getOptionsForApi()
    {
        $images = $this->getOptions();
        $res = array();
        foreach ($images as $image) {
            if ($image instanceof ItemField) {
                //dump($image);
                $res['option'][] = $image->getFieldName();
            }

        }
        return $res;
    }

    public function getImage2($num = 0)
    {
        $images = $this->getImages2();
        foreach ($images as $image) {
            return $image;
        }
    }

    public function getImage($num = 0)
    {
        $images = $this->getImages();
        //
        if (!empty($images)) {
            $val = array_values($images);
            unset($val[0]['object']);
            $ret = array('image' => $val[0]);

            return $ret;
        }
        return false;
    }

    public function getImages()
    {
        $this->getItemFieldsArray();

        if (!empty($this->ItemFieldArray['image list'])) {
            return $this->ItemFieldArray['image list'];
        }
        return array();
    }

    public function getCountImages()
    {
        $this->getItemFieldsArray();

        if (!empty($this->ItemFieldArray['image list'])) {
            return count($this->ItemFieldArray['image list']);
        }
        return 0;
    }

    public function getModel2()
    {
        $this->getItemFieldsArray();
        //\Doctrine\Common\Util\Debug::dump($this->ItemFieldArray);
        //die();
        $model = "";
        if ($this->Category instanceof \Numa\DOAAdminBundle\Entity\Category) {
            if ($this->Category->getName() == "Car") {

                $model = $this->ItemFieldArray['model']['stringvalue'];
            }
            if ($this->Category->getName() == "Marine") {
                $model = $this->ItemFieldArray['model']['stringvalue'];
            }
            if ($this->Category->getName() == "RVs") {

                $model = $this->ItemFieldArray['model']['stringvalue'];
            }
        }
        return $model;
    }

    public function getMake2()
    {
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
            } elseif ($this->Category->getName() == "RVs") {
                if (isset($this->ItemFieldArray['make model'])) {
                    return $this->ItemFieldArray['make model']['stringvalue'] . " ";
                }
            }
        }
        return "";
    }

    public function getItemFieldByName($name)
    {
        $this->getItemFieldsArray();
        //FIX ME FIX ME FIX ME
        if (property_exists(get_class($this), strtolower($name))) {

            $name = strtolower($name);
            return $this->$name;
        } elseif ($name == 'image') {
            return $this->getImage();
        }
        //\Doctrine\Common\Util\Debug::dump($this->ItemFieldArray);
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

        if (!empty($importfeed)) {
            //die(get_class($importfeed));
            $this->Importfeed = $importfeed;
            $isFeatured = $importfeed->getMakeFeatured();
            $isActivated = $importfeed->getActivateListing();
            $isHighlighted = $importfeed->getMakeHighlighted();
            $isExpired = $importfeed->getExpirationAfter();


            if ($importfeed->getDealer() instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords) {

                $this->setDealer($importfeed->getDealer());
            }

            if ($importfeed->getCategory() instanceof \Numa\DOAAdminBundle\Entity\Category) {

                $this->setCategory($importfeed->getCategory());
            }
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
        if (empty($this->dontupdate)) {

            $this->date_updated = new \DateTime();
        }
    }

    public function __toString()
    {
        return $this->getModel() . " " . $this->getVIN();
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
     * @return Item
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

    public function processOptionsList($stringvalue, $separator)
    {

        if (empty($separator)) {
            $separator = "|";
        }
        $optionsArray = explode($separator, $stringvalue);
        if(strtolower($separator)=="{newline}") {
            $optionsArray = preg_split('/\n|\r\n?/', $stringvalue);
        }

        $order = 1;

        $proccessed = false;
        $optionsDecorator = new \Numa\DOAAdminBundle\Lib\OptionsDecorator();

        $optionsDecorator->processOptionsFrom($stringvalue);
        $optionsList = $optionsDecorator->getOptions();

        if ($optionsList instanceof \Doctrine\Common\Collections\ArrayCollection && !$optionsList->isEmpty()) {
            foreach ($optionsList as $key => $option) {

                $itemField = new ItemField();
                $itemField->setAllValues($option->getValue());
                $itemField->setFieldType('boolean');
                $itemField->setFieldName($option->getName());
                if ($this->getImportfeed() instanceof Importfeed) {
                    $itemField->setFeedId($this->getImportfeed()->getId());
                }
                $itemField->setSortOrder($option->getOrder());
                $this->addItemField($itemField);
                $proccessed = true;
            }
        } else {

            //ugly hack
            if (is_string($stringvalue)) {
                $test = json_decode($stringvalue, true);

                if (is_array($test)) {
                    if (!empty($test['option'])) {
                        $optionsArray = $test['option'];
                    }
                }
            }

            if (is_array($optionsArray)) {
                if (!empty($optionsArray[0])) {
                    $json = json_decode($optionsArray[0], true);
                }
                if (!empty($json) && !empty($json['option']) && is_array($json['option'])) {
                    $optionsArray = array();
                    foreach ($json['option'] as $key => $value) {
                        $itemField = new ItemField();

                        if (!empty($value['value'])) {
                            if (empty($value['label'])) {
                                //if label is not defined, set as true
                                $itemField->setAllValues(true);
                                $itemField->setFieldType('boolean');
                                $itemField->setFieldName($value['value']);
                            } else {
                                $itemField->setAllValues($value['value']);
                                $itemField->setFieldType('string');
                                $itemField->setFieldName($value['label']);
                            }

                            $itemField->setFeedId($this->getFeedId());
                            $itemField->setSortOrder($order);
                            $this->addItemField($itemField);
                            $order++;
                            $proccessed = true;
                        }
                    }
                }
            }

            if (!$proccessed) {

                if (is_string($optionsArray)) {
                    $optionsArray = array($optionsArray);
                }

                foreach ($optionsArray as $key => $option) {
                    $option = trim($option);
                    if (!empty($option)) {
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
            }
        }
        unset($optionsArray);
        unset($order);
    }

    public function proccessImagesFromRemote($imageString, $maprow, $feed, $upload_path, $upload_url, $em, $uniqueValue = null)
    {
        $listingFields = $maprow->getListingField();

        $localy = $feed->getPicturesSaveLocaly();

        if (is_array($imageString) && !empty($imageString['photo'])) {
            $imageString = $imageString['photo'];
        }
        if (is_array($imageString) && !empty($imageString['imageurl'])) {
            $imageString = $imageString['imageurl'];
        }

        if (is_array($imageString)) {
            $order = 0;
            foreach ($imageString as $key => $value) {
                $itemField = new ItemField();
                $itemField->setAllValues($value);
                if ($listingFields instanceof \Numa\DOAAdminBundle\Entity\Listingfield) {
                    $test = $em->getRepository('NumaDOAAdminBundle:Listingfield')->find($maprow->getListingField()->getId());
                    $itemField->setListingfield($test);
                }
                $itemField->setFeedId($feed->getId());

                $itemField->handleImage($value, $upload_path, $upload_url, $feed, $order, $localy, $uniqueValue);

                $this->addItemField($itemField);
                $em->persist($itemField);
                $order++;
            }
        } else {
            $pictureSeparator = $feed->getPicturesSeparator();
            if ($pictureSeparator == "{space}") {
                $pictureSeparator = " ";
            } elseif (empty($pictureSeparator)) {
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
//                //$itemField->setListingfield($listingFields);
                if ($listingFields instanceof \Numa\DOAAdminBundle\Entity\Listingfield) {

                    $test = $em->getRepository('NumaDOAAdminBundle:Listingfield')->find($maprow->getListingField()->getId());

                    $itemField->setListingfield($test);
                    ///\Doctrine\Common\Util\Debug::dump($listingFields);die();
                }
                $itemField->setFeedId($feed->getId());
                //$itemField->setItem($this);
                $itemField->handleImage($picture, $upload_path, $upload_url, $this->getImportfeed(), $order, $localy, $uniqueValue);
                $em->persist($itemField);
                $this->addItemField($itemField);
                //unset($itemField);
                $order++;
            }
            unset($picturesArray);
        }
    }

    public function getItemFieldObjectByName($field_name)
    {

        foreach ($this->getItemField() as $key => $itemfield) {
            if (strtolower($itemfield->getFieldName()) == strtolower($field_name)) {
                return $itemfield;
            }
        }
        return null;
    }

    /**
     * @var string
     */
    private $body_style;

    /**
     * @var string
     * @GRID\Column(type="text", field="model", title="Model", filterable=true, defaultOperator="eq",operatorsVisible=false)
     * @JMS\Expose
     */
    private $model;

    /**
     * @var integer
     * @JMS\Expose
     */
    private $price;

    /**
     * @var integer
     * @JMS\Expose
     */
    private $year;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $flor_pane;

    /**
     * @var string
     */
    private $ag_application;

    /**
     * @var string
     */
    private $postal;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     * @GRID\Column(type="text", field="stock_nr", title="Stock #", filterable=true, operatorsVisible=false)
     */
    private $stock_nr;

    /**
     * @var string
     */
    private $mileage;

    /**
     * @var string
     */
    private $VIN;

    /**
     * @var string
     */
    private $transmission;

    /**
     * Set body_style
     *
     * @param string $bodyStyle
     * @return Item
     */
    public function setBodyStyle($bodyStyle)
    {
        $this->body_style = $bodyStyle;

        return $this;
    }

    /**
     * Get body_style
     *
     * @return string
     */
    public function getBodyStyle()
    {
        return $this->body_style;
    }

    /**
     * Set model
     *
     * @param string $model
     * @return Item
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Item
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Item
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Item
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set flor_pane
     *
     * @param string $florPane
     * @return Item
     */
    public function setFlorPane($florPane)
    {
        $this->flor_pane = $florPane;

        return $this;
    }

    /**
     * Get flor_pane
     *
     * @return string
     */
    public function getFlorPane()
    {
        return $this->flor_pane;
    }

    /**
     * Set ag_application
     *
     * @param string $agApplication
     * @return Item
     */
    public function setAgApplication($agApplication)
    {
        $this->ag_application = $agApplication;

        return $this;
    }

    /**
     * Get ag_application
     *
     * @return string
     */
    public function getAgApplication()
    {
        return $this->ag_application;
    }

    /**
     * Set postal
     *
     * @param string $postal
     * @return Item
     */
    public function setPostal($postal)
    {
        $this->postal = $postal;

        return $this;
    }

    /**
     * Get postal
     *
     * @return string
     */
    public function getPostal()
    {
        return $this->postal;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Item
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
     * Set address
     *
     * @param string $address
     * @return Item
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
     * Set status
     *
     * @param string $status
     * @return Item
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
     * Set stock_nr
     *
     * @param string $stockNr
     * @return Item
     */
    public function setStockNr($stockNr)
    {
        $this->stock_nr = $stockNr;

        return $this;
    }

    /**
     * Get stock_nr
     *
     * @return string
     */
    public function getStockNr()
    {
        return $this->stock_nr;
    }

    /**
     * Set mileage
     *
     * @param string $mileage
     * @return Item
     */
    public function setMileage($mileage)
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * Get mileage
     *
     * @return string
     */
    public function getMileage()
    {
        return $this->mileage;
    }

    /**
     * Set VIN
     *
     * @param string $vIN
     * @return Item
     */
    public function setVIN($vIN)
    {
        $this->VIN = $vIN;

        return $this;
    }

    /**
     * Get VIN
     *
     * @return string
     */
    public function getVIN()
    {
        return $this->VIN;
    }

    /**
     * Set transmission
     *
     * @param string $transmission
     * @return Item
     */
    public function setTransmission($transmission)
    {
        $this->transmission = $transmission;

        return $this;
    }

    /**
     * Get transmission
     *
     * @return string
     */
    public function getTransmission()
    {
        return $this->transmission;
    }

    public function equalizeItemField(ItemField $itemField)
    {
        if (strtolower($itemField->getFieldName()) == 'year') {
            $this->setYear($itemField->getFieldIntegerValue());
        } elseif (strtolower($itemField->getFieldName()) == 'mileage') {
            $this->setMileage($itemField->getFieldIntegerValue());
        } elseif (strtolower($itemField->getFieldName()) == 'price') {
            $this->setPrice($itemField->getFieldIntegerValue());
        } elseif (strtolower($itemField->getFieldName()) == 'model' || strtolower($itemField->getFieldName()) == 'boat model') {
            $this->setModel($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'make' || strtolower($itemField->getFieldName()) == 'boat make' || strtolower($itemField->getFieldName()) == 'make model') {
            $this->setMake($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'vin') {
            $this->setVin($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'body style') {
            $this->setBodyStyle($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'body description') {
            $this->setBodyDescription($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'transmission') {
            $this->setTransmission($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'type' || strtolower($itemField->getFieldName()) == 'boat type') {
            $this->setType($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'engine' || strtolower($itemField->getFieldName()) == 'engine type') {
            $this->setEngine($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'exterior color') {
            $this->setExteriorColor($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'interior color') {
            $this->setInteriorColor($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'fuel type') {
            $this->setFuelType($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'drive type') {
            $this->setDriveType($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'doors') {
            $this->setDoors($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'trim') {
            $this->setTrim($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'status') {
            $this->setStatus($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'seller comment') {
            $this->setSellerComment($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'beam') {
            $this->setBeam($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'length' || strtolower($itemField->getFieldName()) == 'length(ft)') {
            $this->setLength($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'hull design') {
            $this->setHullDesign($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'steering type') {
            $this->setSteeringType($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'fuel capacity') {
            $this->setFuelCapacity($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'of hours') {
            $this->setOfHours($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'passengers') {
            $this->setPassenger($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'battery') {
            $this->setBattery($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'trailer') {
            $this->setTrailer($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'ignition') {
            $this->setIgnition($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'gears') {
            $this->setgears($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'width') {
            $this->setWidth($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'displacement') {
            $this->setDisplacement($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'chassis type') {
            $this->setChassisType($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'slide outs') {
            $this->setSlideOuts($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'flooring') {
            $this->setFlooring($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'floor plan' || strtolower($itemField->getFieldName()) == 'floor plan model') {
            $this->setFloorPlan($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'class') {
            $this->setClass($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'weight') {
            $this->setWeight($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'engine type') {
            $this->setEngineType($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'fuel system') {
            $this->setFuelSystem($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'fuel capacity') {
            $this->setFuelCapacity($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'cooling system') {
            $this->setCoolingSystem($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'cutting width') {
            $this->setCoolingSystem($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'tire equipment') {
            $this->setTireEquipment($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'tire size') {
            $this->setTireSize($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'speed reverse') {
            $this->setSpeedReverse($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'speed forward') {
            $this->setSpeedForward($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'operator station') {
            $this->setOperatorStation($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'stock number') {
            $this->setStockNr($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'other details') {
            $this->setOther($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'ag application') {
            $this->setAgApplication($itemField->getFieldStringValue());
            $this->setType($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'dealerid') {

            //$this->setDealerId($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'iw_no') {
            $this->setIwNo($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'mpg - city') {
            $this->setMpgCity($itemField->getFieldStringValue());
        } elseif (strtolower($itemField->getFieldName()) == 'mpg - highway') {
            $this->setMpgHighway($itemField->getFieldStringValue());
        }

    }

    public function equalizeItemFields()
    {
        foreach ($this->getItemField() as $key => $itemField) {
            if ($itemField instanceof ItemField) {
                $this->equalizeItemField($itemField);
            }
        }
        return $this;
    }

    /**
     * @var integer
     */
    private $photos;

    /**
     * @var string
     * @GRID\Column(type="text", field="make", title="Make")
     */
    private $make;

    /**
     * Set photos
     *
     * @param integer $photos
     * @return Item
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;

        return $this;
    }

    /**
     * Get photos
     *
     * @return integer
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set make
     *
     * @param string $make
     * @return Item
     */
    public function setMake($make)
    {
        $this->make = $make;
        return $this;
    }

    /**
     * @var string
     */
    private $floor_plan;

    /**
     * Set floor_plan
     *
     * @param string $floorPlan
     * @return Item
     */
    public function setFloorPlan($floorPlan)
    {
        $this->floor_plan = $floorPlan;

        return $this;
    }

    /**
     * Get floor_plan
     *
     * @return string
     */
    public function getFloorPlan()
    {
        return $this->floor_plan;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get make
     *
     * @return string
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * @var string
     */
    private $engine;

    /**
     * @var string
     */
    private $fuel_type;

    /**
     * @var string
     */
    private $interior_color;

    /**
     * @var string
     */
    private $exterior_color;

    /**
     * Set engine
     *
     * @param string $engine
     *
     * @return Item
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * Get engine
     *
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Set fuelType
     *
     * @param string $fuelType
     *
     * @return Item
     */
    public function setFuelType($fuelType)
    {
        $this->fuel_type = $fuelType;

        return $this;
    }

    /**
     * Get fuelType
     *
     * @return string
     */
    public function getFuelType()
    {
        return $this->fuel_type;
    }

    /**
     * Set interiorColor
     *
     * @param string $interiorColor
     *
     * @return Item
     */
    public function setInteriorColor($interiorColor)
    {
        $this->interior_color = $interiorColor;

        return $this;
    }

    /**
     * Get interiorColor
     *
     * @return string
     */
    public function getInteriorColor()
    {
        return $this->interior_color;
    }

    /**
     * Set exteriorColor
     *
     * @param string $exteriorColor
     *
     * @return Item
     */
    public function setExteriorColor($exteriorColor)
    {
        $this->exterior_color = $exteriorColor;

        return $this;
    }

    /**
     * Get exteriorColor
     *
     * @return string
     */
    public function getExteriorColor()
    {
        return $this->exterior_color;
    }

    /**
     * @var boolean
     * @GRID\Column(type="boolean", field="sold", title="Sold", filterable=true, operatorsVisible=false)
     */
    private $sold;

    /**
     * @var string
     */
    private $body_description;

    /**
     * @var string
     */
    private $videoId;

    /**
     * Set sold
     *
     * @param boolean $sold
     *
     * @return Item
     */
    public function setSold($sold)
    {
        $this->sold = $sold;

        return $this;
    }

    /**
     * Get sold
     *
     * @return boolean
     */
    public function getSold()
    {
        return $this->sold;
    }

    /**
     * Set bodyDescription
     *
     * @param string $bodyDescription
     *
     * @return Item
     */
    public function setBodyDescription($bodyDescription)
    {
        $this->body_description = $bodyDescription;

        return $this;
    }

    /**
     * Get bodyDescription
     *
     * @return string
     */
    public function getBodyDescription()
    {
        return $this->body_description;
    }

    /**
     * Set videoId
     *
     * @param string $videoId
     *
     * @return Item
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;

        return $this;
    }

    /**
     * Get videoId
     *
     * @return string
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * @var string
     */
    private $trim;

    /**
     * Set trim
     *
     * @param string $trim
     *
     * @return Item
     */
    public function setTrim($trim)
    {
        $this->trim = $trim;

        return $this;
    }

    /**
     * Get trim
     *
     * @return string
     */
    public function getTrim()
    {
        return $this->trim;
    }

    /**
     * @var string
     */
    private $doors;

    /**
     * Set doors
     *
     * @param string $doors
     *
     * @return Item
     */
    public function setDoors($doors)
    {
        $this->doors = $doors;

        return $this;
    }

    /**
     * Get doors
     *
     * @return string
     */
    public function getDoors()
    {
        return $this->doors;
    }

    /**
     * @var string
     */
    private $drive_type;

    /**
     * Set driveType
     *
     * @param string $driveType
     *
     * @return Item
     */
    public function setDriveType($driveType)
    {
        $this->drive_type = $driveType;

        return $this;
    }

    /**
     * Get driveType
     *
     * @return string
     */
    public function getDriveType()
    {
        return $this->drive_type;
    }

    /**
     * @var string
     */
    private $seller_comment;

    /**
     * Set sellerComment
     *
     * @param string $sellerComment
     *
     * @return Item
     */
    public function setSellerComment($sellerComment)
    {
        $this->seller_comment = $sellerComment;

        return $this;
    }

    /**
     * Get sellerComment
     *
     * @return string
     */
    public function getSellerComment()
    {
        return $this->seller_comment;
    }

    /**
     * @var float
     */
    private $length;

    /**
     * @var float
     */
    private $boat_weight;

    /**
     * @var string
     */
    private $hull_design;

    /**
     * @var string
     */
    private $steering_type;

    /**
     * @var string
     */
    private $of_hours;

    /**
     * @var string
     */
    private $passengers;

    /**
     * @var string
     */
    private $trailer;

    /**
     * @var string
     */
    private $battery;

    /**
     * @var string
     */
    private $fuel_capacity;

    /**
     * @var integer
     */
    private $horsepower;

    /**
     * Set length
     *
     * @param float $length
     *
     * @return Item
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return float
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set boatWeight
     *
     * @param float $boatWeight
     *
     * @return Item
     */
    public function setBoatWeight($boatWeight)
    {
        $this->boat_weight = $boatWeight;

        return $this;
    }

    /**
     * Get boatWeight
     *
     * @return float
     */
    public function getBoatWeight()
    {
        return $this->boat_weight;
    }

    /**
     * Set hullDesign
     *
     * @param string $hullDesign
     *
     * @return Item
     */
    public function setHullDesign($hullDesign)
    {
        $this->hull_design = $hullDesign;

        return $this;
    }

    /**
     * Get hullDesign
     *
     * @return string
     */
    public function getHullDesign()
    {
        return $this->hull_design;
    }

    /**
     * Set steeringType
     *
     * @param string $steeringType
     *
     * @return Item
     */
    public function setSteeringType($steeringType)
    {
        $this->steering_type = $steeringType;

        return $this;
    }

    /**
     * Get steeringType
     *
     * @return string
     */
    public function getSteeringType()
    {
        return $this->steering_type;
    }

    /**
     * Set ofHours
     *
     * @param string $ofHours
     *
     * @return Item
     */
    public function setOfHours($ofHours)
    {
        $this->of_hours = $ofHours;

        return $this;
    }

    /**
     * Get ofHours
     *
     * @return string
     */
    public function getOfHours()
    {
        return $this->of_hours;
    }

    /**
     * Set passengers
     *
     * @param string $passengers
     *
     * @return Item
     */
    public function setPassengers($passengers)
    {
        $this->passengers = $passengers;

        return $this;
    }

    /**
     * Get passengers
     *
     * @return string
     */
    public function getPassengers()
    {
        return $this->passengers;
    }

    /**
     * Set trailer
     *
     * @param string $trailer
     *
     * @return Item
     */
    public function setTrailer($trailer)
    {
        $this->trailer = $trailer;

        return $this;
    }

    /**
     * Get trailer
     *
     * @return string
     */
    public function getTrailer()
    {
        return $this->trailer;
    }

    /**
     * Set battery
     *
     * @param string $battery
     *
     * @return Item
     */
    public function setBattery($battery)
    {
        $this->battery = $battery;

        return $this;
    }

    /**
     * Get battery
     *
     * @return string
     */
    public function getBattery()
    {
        return $this->battery;
    }

    /**
     * Set fuelCapacity
     *
     * @param string $fuelCapacity
     *
     * @return Item
     */
    public function setFuelCapacity($fuelCapacity)
    {
        $this->fuel_capacity = $fuelCapacity;

        return $this;
    }

    /**
     * Get fuelCapacity
     *
     * @return string
     */
    public function getFuelCapacity()
    {
        return $this->fuel_capacity;
    }

    /**
     * Set horsepower
     *
     * @param integer $horsepower
     *
     * @return Item
     */
    public function setHorsepower($horsepower)
    {
        $this->horsepower = $horsepower;

        return $this;
    }

    /**
     * Get horsepower
     *
     * @return integer
     */
    public function getHorsepower()
    {
        return $this->horsepower;
    }

    /**
     * @var string
     */
    private $beam;

    /**
     * Set beam
     *
     * @param string $beam
     *
     * @return Item
     */
    public function setBeam($beam)
    {
        $this->beam = $beam;

        return $this;
    }

    /**
     * Get beam
     *
     * @return string
     */
    public function getBeam()
    {
        return $this->beam;
    }

    /**
     * @var string
     */
    private $passenger;

    /**
     * Set passenger
     *
     * @param string $passenger
     *
     * @return Item
     */
    public function setPassenger($passenger)
    {
        $this->passenger = $passenger;

        return $this;
    }

    /**
     * Get passenger
     *
     * @return string
     */
    public function getPassenger()
    {
        return $this->passenger;
    }

    /**
     * @var string
     */
    private $fuel_system;

    /**
     * @var string
     */
    private $ignition;

    /**
     * @var string
     */
    private $gears;

    /**
     * @var float
     */
    private $width;

    /**
     * Set fuelSystem
     *
     * @param string $fuelSystem
     *
     * @return Item
     */
    public function setFuelSystem($fuelSystem)
    {
        $this->fuel_system = $fuelSystem;

        return $this;
    }

    /**
     * Get fuelSystem
     *
     * @return string
     */
    public function getFuelSystem()
    {
        return $this->fuel_system;
    }

    /**
     * Set ignition
     *
     * @param string $ignition
     *
     * @return Item
     */
    public function setIgnition($ignition)
    {
        $this->ignition = $ignition;

        return $this;
    }

    /**
     * Get ignition
     *
     * @return string
     */
    public function getIgnition()
    {
        return $this->ignition;
    }

    /**
     * Set gears
     *
     * @param string $gears
     *
     * @return Item
     */
    public function setGears($gears)
    {
        $this->gears = $gears;

        return $this;
    }

    /**
     * Get gears
     *
     * @return string
     */
    public function getGears()
    {
        return $this->gears;
    }

    /**
     * Set width
     *
     * @param float $width
     *
     * @return Item
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @var string
     */
    private $engine_type;

    /**
     * Set engineType
     *
     * @param string $engineType
     *
     * @return Item
     */
    public function setEngineType($engineType)
    {
        $this->engine_type = $engineType;

        return $this;
    }

    /**
     * Get engineType
     *
     * @return string
     */
    public function getEngineType()
    {
        return $this->engine_type;
    }

    /**
     * @var string
     */
    private $displacement;

    /**
     * Set displacement
     *
     * @param string $displacement
     *
     * @return Item
     */
    public function setDisplacement($displacement)
    {
        $this->displacement = $displacement;

        return $this;
    }

    /**
     * Get displacement
     *
     * @return string
     */
    public function getDisplacement()
    {
        return $this->displacement;
    }

    /**
     * @var string
     */
    private $chassis_type;

    /**
     * @var string
     */
    private $sleeps;

    /**
     * @var string
     */
    private $slide_outs;

    /**
     * @var string
     */
    private $flooring;

    /**
     * Set chassisType
     *
     * @param string $chassisType
     *
     * @return Item
     */
    public function setChassisType($chassisType)
    {
        $this->chassis_type = $chassisType;

        return $this;
    }

    /**
     * Get chassisType
     *
     * @return string
     */
    public function getChassisType()
    {
        return $this->chassis_type;
    }

    /**
     * Set sleeps
     *
     * @param string $sleeps
     *
     * @return Item
     */
    public function setSleeps($sleeps)
    {
        $this->sleeps = $sleeps;

        return $this;
    }

    /**
     * Get sleeps
     *
     * @return string
     */
    public function getSleeps()
    {
        return $this->sleeps;
    }

    /**
     * Set slideOuts
     *
     * @param string $slideOuts
     *
     * @return Item
     */
    public function setSlideOuts($slideOuts)
    {
        $this->slide_outs = $slideOuts;

        return $this;
    }

    /**
     * Get slideOuts
     *
     * @return string
     */
    public function getSlideOuts()
    {
        return $this->slide_outs;
    }

    /**
     * Set flooring
     *
     * @param string $flooring
     *
     * @return Item
     */
    public function setFlooring($flooring)
    {
        $this->flooring = $flooring;

        return $this;
    }

    /**
     * Get flooring
     *
     * @return string
     */
    public function getFlooring()
    {
        return $this->flooring;
    }

    /**
     * @var string
     */
    private $flor_plan;

    /**
     * Set florPlan
     *
     * @param string $florPlan
     *
     * @return Item
     */
    public function setFlorPlan($florPlan)
    {
        $this->flor_plan = $florPlan;

        return $this;
    }

    /**
     * Get florPlan
     *
     * @return string
     */
    public function getFlorPlan()
    {
        return $this->flor_plan;
    }

    /**
     * @var string
     */
    private $class;

    /**
     * Set class
     *
     * @param string $class
     *
     * @return Item
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @var float
     */
    private $weight;

    /**
     * Set weight
     *
     * @param float $weight
     *
     * @return Item
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @var string
     */
    private $operator_station;

    /**
     * @var string
     */
    private $speed_forward;

    /**
     * @var string
     */
    private $speed_reverse;

    /**
     * @var string
     */
    private $tire_size;

    /**
     * @var string
     */
    private $tire_equipment;

    /**
     * @var string
     */
    private $cutting_width;

    /**
     * Set operatorStation
     *
     * @param string $operatorStation
     *
     * @return Item
     */
    public function setOperatorStation($operatorStation)
    {
        $this->operator_station = $operatorStation;

        return $this;
    }

    /**
     * Get operatorStation
     *
     * @return string
     */
    public function getOperatorStation()
    {
        return $this->operator_station;
    }

    /**
     * Set speedForward
     *
     * @param string $speedForward
     *
     * @return Item
     */
    public function setSpeedForward($speedForward)
    {
        $this->speed_forward = $speedForward;

        return $this;
    }

    /**
     * Get speedForward
     *
     * @return string
     */
    public function getSpeedForward()
    {
        return $this->speed_forward;
    }

    /**
     * Set speedReverse
     *
     * @param string $speedReverse
     *
     * @return Item
     */
    public function setSpeedReverse($speedReverse)
    {
        $this->speed_reverse = $speedReverse;

        return $this;
    }

    /**
     * Get speedReverse
     *
     * @return string
     */
    public function getSpeedReverse()
    {
        return $this->speed_reverse;
    }

    /**
     * Set tireSize
     *
     * @param string $tireSize
     *
     * @return Item
     */
    public function setTireSize($tireSize)
    {
        $this->tire_size = $tireSize;

        return $this;
    }

    /**
     * Get tireSize
     *
     * @return string
     */
    public function getTireSize()
    {
        return $this->tire_size;
    }

    /**
     * Set tireEquipment
     *
     * @param string $tireEquipment
     *
     * @return Item
     */
    public function setTireEquipment($tireEquipment)
    {
        $this->tire_equipment = $tireEquipment;

        return $this;
    }

    /**
     * Get tireEquipment
     *
     * @return string
     */
    public function getTireEquipment()
    {
        return $this->tire_equipment;
    }

    /**
     * Set cuttingWidth
     *
     * @param string $cuttingWidth
     *
     * @return Item
     */
    public function setCuttingWidth($cuttingWidth)
    {
        $this->cutting_width = $cuttingWidth;

        return $this;
    }

    /**
     * Get cuttingWidth
     *
     * @return string
     */
    public function getCuttingWidth()
    {
        return $this->cutting_width;
    }

    /**
     * @var string
     */
    private $cooling_system;

    /**
     * Set coolingSystem
     *
     * @param string $coolingSystem
     *
     * @return Item
     */
    public function setCoolingSystem($coolingSystem)
    {
        $this->cooling_system = $coolingSystem;

        return $this;
    }

    /**
     * Get coolingSystem
     *
     * @return string
     */
    public function getCoolingSystem()
    {
        return $this->cooling_system;
    }

    /**
     * @var string
     */
    private $chassis;

    /**
     * Set chassis
     *
     * @param string $chassis
     *
     * @return Item
     */
    public function setChassis($chassis)
    {
        $this->chassis = $chassis;

        return $this;
    }

    /**
     * Get chassis
     *
     * @return string
     */
    public function getChassis()
    {
        return $this->chassis;
    }

    /**
     * @var string
     */
    private $steering;

    /**
     * Set steering
     *
     * @param string $steering
     *
     * @return Item
     */
    public function setSteering($steering)
    {
        $this->steering = $steering;

        return $this;
    }

    /**
     * Get steering
     *
     * @return string
     */
    public function getSteering()
    {
        return $this->steering;
    }

    /**
     * @var float
     */
    private $mpgCity;

    /**
     * @var float
     */
    private $mpgHighway;

    /**
     * Set mpgCity
     *
     * @param float $mpgCity
     *
     * @return Item
     */
    public function setMpgCity($mpgCity)
    {
        $this->mpgCity = $mpgCity;

        return $this;
    }

    /**
     * Get mpgCity
     *
     * @return float
     */
    public function getMpgCity()
    {
        return $this->mpgCity;
    }

    /**
     * Set mpgHighway
     *
     * @param float $mpgHighway
     *
     * @return Item
     */
    public function setMpgHighway($mpgHighway)
    {
        $this->mpgHighway = $mpgHighway;

        return $this;
    }

    /**
     * Get mpgHighway
     *
     * @return float
     */
    public function getMpgHighway()
    {
        return $this->mpgHighway;
    }

    /**
     * @var string
     */
    private $iw_no;

    /**
     * Set iw_no
     *
     * @param string $iwNo
     * @return Item
     */
    public function setIwNo($iwNo)
    {
        $this->iw_no = $iwNo;

        return $this;
    }

    /**
     * Get iw_no
     *
     * @return string
     */
    public function getIwNo()
    {
        return $this->iw_no;
    }

    public function setField($name, $value)
    {
        $methodName = "set" . ucfirst($name);
        if (method_exists($this, $methodName)) {
            $value = preg_replace("/[\r\n]+/", "", $value);
            $value = preg_replace('/[\x00-\x1F\x7F]/', '', $value);
            $value = trim(preg_replace('/\s\s+/', '', $value));
            //$value = str_replace(" </h4>", "aaaaaa", $value);
            call_user_method($methodName, $this, $value);
        } else {
            //dump($methodName);
        }
    }

    public function makeDetailsLog($createdItems)
    {
        $output = "";

        foreach ($createdItems as $key => $item) {

            $output .= "<strong>" . $key . ":" . $item->getId() . "</strong>";
            $output .= "<br>";
            foreach ($item->getItemFieldsArray() as $key2 => $field) {
                $output .= "<div>" . $key2 . ":";
                if (!empty($field['stringvalue'])) {
                    $output .= $field['stringvalue'];
                }
                $output .= "</div>";
            }
        }
        return $output;
    }

    public function computeETag()
    {
        $etag = "listing:" . $this->getId();
        return $etag;
    }

    public function lastUpdated()
    {
        $updated = $this->getDateUpdated();
        $created = $this->getDateCreated();

        if (!empty($updated)) {
            return $updated;

        }
        if (!empty($created)) {
            return $created;
        }
        $date = new \DateTime();
        $date->setDate(2000, 1, 1);

        return $date;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $UserItem;


    /**
     * Add userItem
     *
     * @param \Numa\DOAAdminBundle\Entity\UserItem $userItem
     *
     * @return Item
     */
    public function addUserItem(\Numa\DOAAdminBundle\Entity\UserItem $userItem)
    {
        $this->UserItem[] = $userItem;

        return $this;
    }

    /**
     * Remove userItem
     *
     * @param \Numa\DOAAdminBundle\Entity\UserItem $userItem
     */
    public function removeUserItem(\Numa\DOAAdminBundle\Entity\UserItem $userItem)
    {
        $this->UserItem->removeElement($userItem);
    }

    /**
     * Get userItem
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserItem()
    {
        return $this->UserItem;
    }

    public function get($property)
    {
        $mappedProperty="";
        if(!empty(self::$fields[$this->category_id][$property])) {
            $mappedProperty = self::$fields[$this->category_id][$property];
        }
        if (!empty($mappedProperty)) {
            $property = $mappedProperty;
        }
        $function = 'get' . str_ireplace(array(" ", "_"), '', ucfirst($property));

        if (method_exists($this, $function)) {
            return $this->{$function}();
        }
    }

    public function getUrlDescription()
    {
        $url = str_ireplace(" ", "-", $this->getTitle());
        $url = str_ireplace("--", "-", $url);
        $url = trim($url, " -");
        if(empty($url)){
            $url="details";
        }
        return $url;
    }


    public function getTitle()
    {
        $desc = $this->getYear() . " " . $this->getMake() . " " . $this->slug($this->getModel());
        if ($this->getCategoryId() == 4) {
            $desc = $desc . " " . $this->getFloorPlan();
        } elseif ($this->getCategoryId() == 1) {
            if (!empty($this->getTrim())) {
                $desc .= " " . $this->slug($this->getTrim());
            }
        }
        return $desc;

    }

    function Slug($string)
    {
        return trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-');
    }

    public function getImageList()
    {
        return $this->getImages2();
    }

    /**
     * @var string
     */
    private $other;


    /**
     * Set other
     *
     * @param string $other
     *
     * @return Item
     */
    public function setOther($other)
    {
        $this->other = $other;

        return $this;
    }

    /**
     * Get other
     *
     * @return string
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * @var int
     */
    private $seo_id;

    /**
     * @var \Numa\DOAModuleBundle\Entity\Seo
     */
    private $Seo;


    /**
     * Set seoId
     *
     * @param int $seoId
     *
     * @return Item
     */
    public function setSeoId($seoId)
    {
        $this->seo_id = $seoId;

        return $this;
    }

    /**
     * Get seoId
     *
     * @return int
     */
    public function getSeoId()
    {
        return $this->seo_id;
    }

    /**
     * Set seo
     *
     * @param \Numa\DOAModuleBundle\Entity\Seo $seo
     *
     * @return Item
     */
    public function setSeo(\Numa\DOAModuleBundle\Entity\Seo $seo = null)
    {
        $this->Seo = $seo;

        return $this;
    }

    /**
     * Get seo
     *
     * @return \Numa\DOAModuleBundle\Entity\Seo
     */
    public function getSeo()
    {
        return $this->Seo;
    }
}
