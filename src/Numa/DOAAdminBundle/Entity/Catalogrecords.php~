<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Catalogrecords
 */
class Catalogrecords
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
    private $url;

    /**
     * @var integer
     */
    private $category_id;

    /**
     * @var \Numa\DOAAdminBundle\Entity\CatalogCategory
     */
    private $CatalogCategory;


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
     * @return Catalogrecords
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
     * Set url
     *
     * @param string $url
     * @return Catalogrecords
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set category_id
     *
     * @param integer $categoryId
     * @return Catalogrecords
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
     * Set CatalogCategory
     *
     * @param \Numa\DOAAdminBundle\Entity\CatalogCategory $catalogCategory
     * @return Catalogrecords
     */
    public function setCatalogCategory(\Numa\DOAAdminBundle\Entity\CatalogCategory $catalogCategory = null)
    {
        $this->CatalogCategory = $catalogCategory;
    
        return $this;
    }

    /**
     * Get CatalogCategory
     *
     * @return \Numa\DOAAdminBundle\Entity\CatalogCategory 
     */
    public function getCatalogCategory()
    {
        return $this->CatalogCategory;
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