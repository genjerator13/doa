<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListingFieldLists
 */
class ListingFieldLists
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $listing_field_id;

    /**
     * @var integer
     */
    private $order;

    /**
     * @var string
     */
    private $value;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Listingfield
     */
    private $Listingfield;


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
     * Set listing_field_id
     *
     * @param integer $listingFieldId
     * @return ListingFieldLists
     */
    public function setListingFieldId($listingFieldId)
    {
        $this->listing_field_id = $listingFieldId;
    
        return $this;
    }

    /**
     * Get listing_field_id
     *
     * @return integer 
     */
    public function getListingFieldId()
    {
        return $this->listing_field_id;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return ListingFieldLists
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
     * Set value
     *
     * @param string $value
     * @return ListingFieldLists
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set Listingfield
     *
     * @param \Numa\DOAAdminBundle\Entity\Listingfield $listingfield
     * @return ListingFieldLists
     */
    public function setListingfield(\Numa\DOAAdminBundle\Entity\Listingfield $listingfield = null)
    {
        $this->Listingfield = $listingfield;
    
        return $this;
    }

    /**
     * Get Listingfield
     *
     * @return \Numa\DOAAdminBundle\Entity\Listingfield 
     */
    public function getListingfield()
    {
        return $this->Listingfield;
    }
    
    public function __toString() {
        return $this->getValue();
    }
}