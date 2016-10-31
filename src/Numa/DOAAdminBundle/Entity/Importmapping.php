<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Importmapping
 */
class Importmapping
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
    private $feed_sid;

    /**
     * @var string
     */
    private $property;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $field_sid;

    /**
     * @var string
     */
    private $true_value;

    /**
     * @var string
     */
    private $false_value;

    /**
     * @var integer
     */
    private $tree_level;

    /**
     * @var string
     */
    private $object_type;

    /**
     * @var string
     */
    private $value_map_values;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Listingfields = new \Doctrine\Common\Collections\ArrayCollection();

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
     * @return Importmapping
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
     * Set feed_sid
     *
     * @param integer $feedSid
     * @return Importmapping
     */
    public function setFeedSid($feedSid)
    {
        $this->feed_sid = $feedSid;

        return $this;
    }

    /**
     * Get feed_sid
     *
     * @return integer
     */
    public function getFeedSid()
    {
        return $this->feed_sid;
    }

    /**
     * Set property
     *
     * @param string $property
     * @return Importmapping
     */
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get property
     *
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Importmapping
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
     * Set field_sid
     *
     * @param integer $fieldSid
     * @return Importmapping
     */
    public function setFieldSid($fieldSid)
    {
        $this->field_sid = $fieldSid;

        return $this;
    }

    /**
     * Get field_sid
     *
     * @return integer
     */
    public function getFieldSid()
    {
        return $this->field_sid;
    }

    /**
     * Set true_value
     *
     * @param string $trueValue
     * @return Importmapping
     */
    public function setTrueValue($trueValue)
    {
        $this->true_value = $trueValue;

        return $this;
    }

    /**
     * Get true_value
     *
     * @return string
     */
    public function getTrueValue()
    {
        return $this->true_value;
    }

    /**
     * Set false_value
     *
     * @param string $falseValue
     * @return Importmapping
     */
    public function setFalseValue($falseValue)
    {
        $this->false_value = $falseValue;

        return $this;
    }

    /**
     * Get false_value
     *
     * @return string
     */
    public function getFalseValue()
    {
        return $this->false_value;
    }

    /**
     * Set tree_level
     *
     * @param integer $treeLevel
     * @return Importmapping
     */
    public function setTreeLevel($treeLevel)
    {
        $this->tree_level = $treeLevel;

        return $this;
    }

    /**
     * Get tree_level
     *
     * @return integer
     */
    public function getTreeLevel()
    {
        return $this->tree_level;
    }

    /**
     * Set object_type
     *
     * @param string $objectType
     * @return Importmapping
     */
    public function setObjectType($objectType)
    {
        $this->object_type = $objectType;

        return $this;
    }

    /**
     * Get object_type
     *
     * @return string
     */
    public function getObjectType()
    {
        return $this->object_type;
    }

    /**
     * Set value_map_values
     *
     * @param string $valueMapValues
     * @return Importmapping
     */
    public function setValueMapValues($valueMapValues)
    {
        $this->value_map_values = $valueMapValues;

        return $this;
    }

    /**
     * Get value_map_values
     *
     * @return string
     */
    public function getValueMapValues()
    {
        return $this->value_map_values;
    }

    /**
     * @var \Numa\DOAAdminBundle\Entity\Listingfield
     */
    private $Listingfield;


    /**
     * Set listingfield
     *
     * @param \Numa\DOAAdminBundle\Entity\Listingfield $listingfield
     *
     * @return Importmapping
     */
    public function setListingfield(\Numa\DOAAdminBundle\Entity\Listingfield $listingfield = null)
    {
        $this->Listingfield = $listingfield;

        return $this;
    }

    /**
     * Get listingfield
     *
     * @return \Numa\DOAAdminBundle\Entity\Listingfield
     */
    public function getListingfield()
    {
        return $this->Listingfield;
    }
}
