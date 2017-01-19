<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListingFieldTree
 */
class ListingFieldTree
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    private $listing_field_id;

    /**
     * @var integer
     */
    private $parent_id;

    /**
     * @var integer
     */
    private $order;

    /**
     * @var integer
     */
    private $level;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \Numa\DOAAdminBundle\Entity\ListingFieldTree
     */
    private $parent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set listing_field_id
     *
     * @param integer $listingFieldId
     * @return ListingFieldTree
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
     * Set parent_id
     *
     * @param integer $parentId
     * @return ListingFieldTree
     */
    public function setParentId($parentId)
    {
        $this->parent_id = $parentId;

        return $this;
    }

    /**
     * Get parent_id
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return ListingFieldTree
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
     * Set level
     *
     * @param integer $level
     * @return ListingFieldTree
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ListingFieldTree
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
     * Add children
     *
     * @param \Numa\DOAAdminBundle\Entity\ListingFieldTree $children
     * @return ListingFieldTree
     */
    public function addChildren(\Numa\DOAAdminBundle\Entity\ListingFieldTree $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Numa\DOAAdminBundle\Entity\ListingFieldTree $children
     */
    public function removeChildren(\Numa\DOAAdminBundle\Entity\ListingFieldTree $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Numa\DOAAdminBundle\Entity\ListingFieldTree $parent
     * @return ListingFieldTree
     */
    public function setParent(\Numa\DOAAdminBundle\Entity\ListingFieldTree $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Numa\DOAAdminBundle\Entity\ListingFieldTree
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add child
     *
     * @param \Numa\DOAAdminBundle\Entity\ListingFieldTree $child
     *
     * @return ListingFieldTree
     */
    public function addChild(\Numa\DOAAdminBundle\Entity\ListingFieldTree $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Numa\DOAAdminBundle\Entity\ListingFieldTree $child
     */
    public function removeChild(\Numa\DOAAdminBundle\Entity\ListingFieldTree $child)
    {
        $this->children->removeElement($child);
    }
    /**
     * @var string
     */
    private $floor_plan_image;

    /**
     * @var string
     */
    private $logo_image;


    /**
     * Set floorPlanImage
     *
     * @param string $floorPlanImage
     *
     * @return ListingFieldTree
     */
    public function setFloorPlanImage($floorPlanImage)
    {
        $this->floor_plan_image = $floorPlanImage;

        return $this;
    }

    /**
     * Get floorPlanImage
     *
     * @return string
     */
    public function getFloorPlanImage()
    {
        return $this->floor_plan_image;
    }

    /**
     * Set logoImage
     *
     * @param string $logoImage
     *
     * @return ListingFieldTree
     */
    public function setLogoImage($logoImage)
    {
        $this->logo_image = $logoImage;

        return $this;
    }

    /**
     * Get logoImage
     *
     * @return string
     */
    public function getLogoImage()
    {
        return $this->logo_image;
    }
}
