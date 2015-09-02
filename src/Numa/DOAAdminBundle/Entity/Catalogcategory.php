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
    private $Catalogrecords;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Catalogrecords = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add catalogrecord
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $catalogrecord
     *
     * @return Catalogcategory
     */
    public function addCatalogrecord(\Numa\DOAAdminBundle\Entity\Catalogrecords $catalogrecord)
    {
        $this->Catalogrecords[] = $catalogrecord;

        return $this;
    }

    /**
     * Remove catalogrecord
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $catalogrecord
     */
    public function removeCatalogrecord(\Numa\DOAAdminBundle\Entity\Catalogrecords $catalogrecord)
    {
        $this->Catalogrecords->removeElement($catalogrecord);
    }

    /**
     * Get catalogrecords
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCatalogrecords()
    {
        return $this->Catalogrecords;
    }

    public function __toString(){
        return $this->getName();
    }
}
