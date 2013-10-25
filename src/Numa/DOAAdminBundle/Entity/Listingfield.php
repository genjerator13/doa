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
}