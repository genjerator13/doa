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
    private $id;

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
     * @var \Numa\DOAAdminBundle\Entity\Listingfield
     */
    private $Listingfield;

    /**
     * @var \Numa\DOAAdminBundle\Entity\ListingFieldTree
     */
    private $tree;


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
     * Set Listingfield
     *
     * @param \Numa\DOAAdminBundle\Entity\Listingfield $listingfield
     * @return ListingFieldTree
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

    /**
     * Set tree
     *
     * @param \Numa\DOAAdminBundle\Entity\ListingFieldTree $tree
     * @return ListingFieldTree
     */
    public function setTree(\Numa\DOAAdminBundle\Entity\ListingFieldTree $tree = null)
    {
        $this->tree = $tree;
    
        return $this;
    }

    /**
     * Get tree
     *
     * @return \Numa\DOAAdminBundle\Entity\ListingFieldTree 
     */
    public function getTree()
    {
        return $this->tree;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tree = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add tree
     *
     * @param \Numa\DOAAdminBundle\Entity\ListingFieldTree $tree
     * @return ListingFieldTree
     */
    public function addTree(\Numa\DOAAdminBundle\Entity\ListingFieldTree $tree)
    {
        $this->tree[] = $tree;
    
        return $this;
    }

    /**
     * Remove tree
     *
     * @param \Numa\DOAAdminBundle\Entity\ListingFieldTree $tree
     */
    public function removeTree(\Numa\DOAAdminBundle\Entity\ListingFieldTree $tree)
    {
        $this->tree->removeElement($tree);
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \Numa\DOAAdminBundle\Entity\ListingFieldTree
     */
    private $parent;


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
}