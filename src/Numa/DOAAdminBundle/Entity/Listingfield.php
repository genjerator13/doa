<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Listingfield
 */
class Listingfield
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
    private $category_sid;

    /**
     * @var integer
     */
    private $order;

    /**
     * @var string
     */
    private $caption;

    /**
     * @var string
     */
    private $type;

    /**
     * @var boolean
     */
    private $is_required;

    /**
     * @var string
     */
    private $minimum;

    /**
     * @var string
     */
    private $maximum;

    /**
     * @var integer
     */
    private $signs_num;

    /**
     * @var string
     */
    private $maxlength;

    /**
     * @var string
     */
    private $max_file_size;

    /**
     * @var string
     */
    private $levels_ids;

    /**
     * @var string
     */
    private $levels_captions;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ImportMapping;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ImportMapping = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Listingfield
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
     * Set category_sid
     *
     * @param integer $categorySid
     * @return Listingfield
     */
    public function setCategorySid($categorySid)
    {
        $this->category_sid = $categorySid;

        return $this;
    }

    /**
     * Get category_sid
     *
     * @return integer
     */
    public function getCategorySid()
    {
        return $this->category_sid;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return Listingfield
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set caption
     *
     * @param string $caption
     * @return Listingfield
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Listingfield
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
     * Set is_required
     *
     * @param boolean $isRequired
     * @return Listingfield
     */
    public function setIsRequired($isRequired)
    {
        $this->is_required = $isRequired;

        return $this;
    }

    /**
     * Get is_required
     *
     * @return boolean
     */
    public function getIsRequired()
    {
        return $this->is_required;
    }

    /**
     * Set minimum
     *
     * @param string $minimum
     * @return Listingfield
     */
    public function setMinimum($minimum)
    {
        $this->minimum = $minimum;

        return $this;
    }

    /**
     * Get minimum
     *
     * @return string
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * Set maximum
     *
     * @param string $maximum
     * @return Listingfield
     */
    public function setMaximum($maximum)
    {
        $this->maximum = $maximum;

        return $this;
    }

    /**
     * Get maximum
     *
     * @return string
     */
    public function getMaximum()
    {
        return $this->maximum;
    }

    /**
     * Set signs_num
     *
     * @param integer $signsNum
     * @return Listingfield
     */
    public function setSignsNum($signsNum)
    {
        $this->signs_num = $signsNum;

        return $this;
    }

    /**
     * Get signs_num
     *
     * @return integer
     */
    public function getSignsNum()
    {
        return $this->signs_num;
    }

    /**
     * Set maxlength
     *
     * @param string $maxlength
     * @return Listingfield
     */
    public function setMaxlength($maxlength)
    {
        $this->maxlength = $maxlength;

        return $this;
    }

    /**
     * Get maxlength
     *
     * @return string
     */
    public function getMaxlength()
    {
        return $this->maxlength;
    }

    /**
     * Set max_file_size
     *
     * @param string $maxFileSize
     * @return Listingfield
     */
    public function setMaxFileSize($maxFileSize)
    {
        $this->max_file_size = $maxFileSize;

        return $this;
    }

    /**
     * Get max_file_size
     *
     * @return string
     */
    public function getMaxFileSize()
    {
        return $this->max_file_size;
    }

    /**
     * Set levels_ids
     *
     * @param string $levelsIds
     * @return Listingfield
     */
    public function setLevelsIds($levelsIds)
    {
        $this->levels_ids = $levelsIds;

        return $this;
    }

    /**
     * Get levels_ids
     *
     * @return string
     */
    public function getLevelsIds()
    {
        return $this->levels_ids;
    }

    /**
     * Set levels_captions
     *
     * @param string $levelsCaptions
     * @return Listingfield
     */
    public function setLevelsCaptions($levelsCaptions)
    {
        $this->levels_captions = $levelsCaptions;

        return $this;
    }

    /**
     * Get levels_captions
     *
     * @return string
     */
    public function getLevelsCaptions()
    {
        return $this->levels_captions;
    }

    /**
     * Add ImportMapping
     *
     * @param \Numa\DOAAdminBundle\Entity\Importmapping $importMapping
     * @return Listingfield
     */
    public function addImportMapping(\Numa\DOAAdminBundle\Entity\Importmapping $importMapping)
    {
        $this->ImportMapping[] = $importMapping;

        return $this;
    }

    /**
     * Remove ImportMapping
     *
     * @param \Numa\DOAAdminBundle\Entity\Importmapping $importMapping
     */
    public function removeImportMapping(\Numa\DOAAdminBundle\Entity\Importmapping $importMapping)
    {
        $this->ImportMapping->removeElement($importMapping);
    }

    /**
     * Get ImportMapping
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImportMapping()
    {
        return $this->ImportMapping;
    }

    public function __toString()
    {
        return $this->getCaption();
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ItemField;


    /**
     * Add ItemField
     *
     * @param \Numa\DOAAdminBundle\Entity\ItemField $itemField
     * @return Listingfield
     */
    public function addItemField(\Numa\DOAAdminBundle\Entity\ItemField $itemField)
    {
        $this->ItemField[] = $itemField;

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
     * Get ItemField
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItemField()
    {
        return $this->ItemField;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ListingFieldLists;


    /**
     * Add ListingFieldLists
     *
     * @param \Numa\DOAAdminBundle\Entity\ListingFieldLists $listingFieldLists
     * @return Listingfield
     */
    public function addListingFieldList(\Numa\DOAAdminBundle\Entity\ListingFieldLists $listingFieldLists)
    {
        $this->ListingFieldLists[] = $listingFieldLists;

        return $this;
    }

    /**
     * Remove ListingFieldLists
     *
     * @param \Numa\DOAAdminBundle\Entity\ListingFieldLists $listingFieldLists
     */
    public function removeListingFieldList(\Numa\DOAAdminBundle\Entity\ListingFieldLists $listingFieldLists)
    {
        $this->ListingFieldLists->removeElement($listingFieldLists);
    }

    /**
     * Get ListingFieldLists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListingFieldLists()
    {
        return $this->ListingFieldLists;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Importmapping;


    /**
     * @var string
     */
    private $item_field_caption;

    /**
     * @var string
     */
    private $api_caption;


    /**
     * Set itemFieldCaption
     *
     * @param string $itemFieldCaption
     *
     * @return Listingfield
     */
    public function setItemFieldCaption($itemFieldCaption)
    {
        $this->item_field_caption = $itemFieldCaption;

        return $this;
    }

    /**
     * Get itemFieldCaption
     *
     * @return string
     */
    public function getItemFieldCaption()
    {
        return $this->item_field_caption;
    }

    /**
     * Set apiCaption
     *
     * @param string $apiCaption
     *
     * @return Listingfield
     */
    public function setApiCaption($apiCaption)
    {
        $this->api_caption = $apiCaption;

        return $this;
    }

    /**
     * Get apiCaption
     *
     * @return string
     */
    public function getApiCaption()
    {
        return $this->api_caption;
    }

    /**
     * @var boolean
     */
    private $exclude_from_api;


    /**
     * Set excludeFromApi
     *
     * @param boolean $excludeFromApi
     *
     * @return Listingfield
     */
    public function setExcludeFromApi($excludeFromApi)
    {
        $this->exclude_from_api = $excludeFromApi;

        return $this;
    }

    /**
     * Get excludeFromApi
     *
     * @return boolean
     */
    public function getExcludeFromApi()
    {
        return $this->exclude_from_api;
    }
}
