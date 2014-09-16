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
     * @var \Numa\DOAAdminBundle\Entity\Catalogcategory
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
     * @param \Numa\DOAAdminBundle\Entity\Catalogcategory $catalogCategory
     * @return Catalogrecords
     */
    public function setCatalogCategory(\Numa\DOAAdminBundle\Entity\Catalogcategory $catalogCategory = null)
    {
        $this->CatalogCategory = $catalogCategory;
    
        return $this;
    }

    /**
     * Get CatalogCategory
     *
     * @return \Numa\DOAAdminBundle\Entity\Catalogcategory 
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
    /**
     * @var string
     */
    private $description;


    /**
     * Set description
     *
     * @param string $description
     * @return Catalogrecords
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
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $full;


    /**
     * Set address
     *
     * @param string $address
     * @return Catalogrecords
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
     * Set phone
     *
     * @param string $phone
     * @return Catalogrecords
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Catalogrecords
     */
    public function setLocation($location)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Catalogrecords
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set full
     *
     * @param string $full
     * @return Catalogrecords
     */
    public function setFull($full)
    {
        $this->full = $full;
    
        return $this;
    }

    /**
     * Get full
     *
     * @return string 
     */
    public function getFull()
    {
        return $this->full;
    }
    /**
     * @var string
     */
    private $fax;


    /**
     * Set fax
     *
     * @param string $fax
     * @return Catalogrecords
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    
        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }
    
    public function __toString() {
        return $this->getName();
    }
    /**
     * @var string
     */
    private $logo;

    /**
     * @var string
     */
    private $logo_url;


    /**
     * Set logo
     *
     * @param string $logo
     * @return Catalogrecords
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    
        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set logo_url
     *
     * @param string $logoUrl
     * @return Catalogrecords
     */
    public function setLogoUrl($logoUrl)
    {
        $this->logo_url = $logoUrl;
    
        return $this;
    }

    /**
     * Get logo_url
     *
     * @return string 
     */
    public function getLogoUrl()
    {
        return $this->logo_url;
    }
}