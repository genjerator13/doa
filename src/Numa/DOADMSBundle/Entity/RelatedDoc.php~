<?php

namespace Numa\DOADMSBundle\Entity;

/**
 * RelatedDoc
 */
class RelatedDoc
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $descriptionx;

    /**
     * @var string
     */
    private $src;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var \DateTime
     */
    private $date_updated;


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
     * Set title
     *
     * @param string $title
     *
     * @return RelatedDoc
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return RelatedDoc
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
     * Set descriptionx
     *
     * @param string $descriptionx
     *
     * @return RelatedDoc
     */
    public function setDescriptionx($descriptionx)
    {
        $this->descriptionx = $descriptionx;

        return $this;
    }

    /**
     * Get descriptionx
     *
     * @return string
     */
    public function getDescriptionx()
    {
        return $this->descriptionx;
    }

    /**
     * Set src
     *
     * @param string $src
     *
     * @return RelatedDoc
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return RelatedDoc
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return RelatedDoc
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return RelatedDoc
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->date_updated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $SaleRelatedDoc;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->SaleRelatedDoc = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add saleRelatedDoc
     *
     * @param \Numa\DOADMSBundle\Entity\SaleRelatedDoc $saleRelatedDoc
     *
     * @return RelatedDoc
     */
    public function addSaleRelatedDoc(\Numa\DOADMSBundle\Entity\SaleRelatedDoc $saleRelatedDoc)
    {
        $this->SaleRelatedDoc[] = $saleRelatedDoc;

        return $this;
    }

    /**
     * Remove saleRelatedDoc
     *
     * @param \Numa\DOADMSBundle\Entity\SaleRelatedDoc $saleRelatedDoc
     */
    public function removeSaleRelatedDoc(\Numa\DOADMSBundle\Entity\SaleRelatedDoc $saleRelatedDoc)
    {
        $this->SaleRelatedDoc->removeElement($saleRelatedDoc);
    }

    /**
     * Get saleRelatedDoc
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSaleRelatedDoc()
    {
        return $this->SaleRelatedDoc;
    }
}
