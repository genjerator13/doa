<?php

namespace Numa\DOADMSBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;
/**
 * FillablePdf
 * @JMS\ExclusionPolicy("ALL")
 */
class FillablePdf
{
    /**
     * @var integer
     * @JMS\Expose
     */
    private $id;

    /**
     * @var string
     * @JMS\Expose
     */
    private $name;

    /**
     * @var integer
     * @JMS\Expose
     */
    private $media_id;

    /**
     * @var \Numa\DOADMSBundle\Media
     */
    private $Media;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $BillingDoc;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $FillablePdfField;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->BillingDoc = new \Doctrine\Common\Collections\ArrayCollection();
        $this->FillablePdfField = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return FillablePdf
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
     * Set mediaId
     *
     * @param integer $mediaId
     *
     * @return FillablePdf
     */
    public function setMediaId($mediaId)
    {
        $this->media_id = $mediaId;

        return $this;
    }

    /**
     * Get mediaId
     *
     * @return integer
     */
    public function getMediaId()
    {
        return $this->media_id;
    }

    /**
     * Set media
     *
     * @param \Numa\DOADMSBundle\Entity\Media $media
     *
     * @return FillablePdf
     */
    public function setMedia(Media $media = null)
    {
        $this->Media = $media;
        return $this;
    }

    /**
     * Get media
     *
     * @return \Numa\DOADMSBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->Media;
    }

    /**
     * Add billingDoc
     *
     * @param \Numa\DOADMSBundle\Entity\BillingDoc $billingDoc
     *
     * @return FillablePdf
     */
    public function addBillingDoc(\Numa\DOADMSBundle\Entity\BillingDoc $billingDoc)
    {
        $this->BillingDoc[] = $billingDoc;

        return $this;
    }

    /**
     * Remove billingDoc
     *
     * @param \Numa\DOADMSBundle\Entity\BillingDoc $billingDoc
     */
    public function removeBillingDoc(\Numa\DOADMSBundle\Entity\BillingDoc $billingDoc)
    {
        $this->BillingDoc->removeElement($billingDoc);
    }

    /**
     * Get billingDoc
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBillingDoc()
    {
        return $this->BillingDoc;
    }

    /**
     * Add fillablePdfField
     *
     * @param \Numa\DOADMSBundle\Entity\FillablePdfField $fillablePdfField
     *
     * @return FillablePdf
     */
    public function addFillablePdfField(\Numa\DOADMSBundle\Entity\FillablePdfField $fillablePdfField)
    {
        $this->FillablePdfField[] = $fillablePdfField;

        return $this;
    }

    /**
     * Remove fillablePdfField
     *
     * @param \Numa\DOADMSBundle\Entity\FillablePdfField $fillablePdfField
     */
    public function removeFillablePdfField(\Numa\DOADMSBundle\Entity\FillablePdfField $fillablePdfField)
    {
        $this->FillablePdfField->removeElement($fillablePdfField);
    }

    /**
     * Get fillablePdfField
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFillablePdfField()
    {
        return $this->FillablePdfField;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        // Add your code here
    }
    /**
     * @var string
     * @JMS\Expose
     */
    private $state;


    /**
     * Set state
     *
     * @param string $state
     *
     * @return FillablePdf
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }
}
