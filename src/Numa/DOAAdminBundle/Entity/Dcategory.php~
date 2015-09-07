<?php

namespace Numa\DOAAdminBundle\Entity;

/**
 * Dcategory
 */
class Dcategory
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
     *
     * @return Dcategory
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
     *
     * @return Dcategory
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
     * @param \Numa\DOAAdminBundle\Entity\DealerCategories $catalogrecord
     *
     * @return Dcategory
     */
    public function addCatalogrecord(\Numa\DOAAdminBundle\Entity\DealerCategories $catalogrecord)
    {
        $this->Catalogrecords[] = $catalogrecord;

        return $this;
    }

    /**
     * Remove catalogrecord
     *
     * @param \Numa\DOAAdminBundle\Entity\DealerCategories $catalogrecord
     */
    public function removeCatalogrecord(\Numa\DOAAdminBundle\Entity\DealerCategories $catalogrecord)
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
}
