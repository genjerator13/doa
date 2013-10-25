<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Catalogcategory
 */
class Catalogcategory
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $CatalogRecords;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->CatalogRecords = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Catalogcategory
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
     * Set slug
     *
     * @param string $slug
     * @return Catalogcategory
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add CatalogRecords
     *
     * @param \Numa\DOAAdminBundle\Entity\CatalogRecords $catalogRecords
     * @return Catalogcategory
     */
    public function addCatalogRecord(\Numa\DOAAdminBundle\Entity\CatalogRecords $catalogRecords)
    {
        $this->CatalogRecords[] = $catalogRecords;
    
        return $this;
    }

    /**
     * Remove CatalogRecords
     *
     * @param \Numa\DOAAdminBundle\Entity\CatalogRecords $catalogRecords
     */
    public function removeCatalogRecord(\Numa\DOAAdminBundle\Entity\CatalogRecords $catalogRecords)
    {
        $this->CatalogRecords->removeElement($catalogRecords);
    }

    /**
     * Get CatalogRecords
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCatalogRecords()
    {
        return $this->CatalogRecords;
    }
    
    public function __toString()
    {
        return $this->getName();
    }
    
}