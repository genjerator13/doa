<?php

namespace Numa\DOADMSBundle\Entity;

/**
 * FillablePdfField
 */
class FillablePdfField
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
    private $value;

    /**
     * @var integer
     */
    private $fillable_pdf_id;

    /**
     * @var \Numa\DOADMSBundle\Entity\FillablePdf
     */
    private $FillablePdf;


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
     * @return FillablePdfField
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
     * Set value
     *
     * @param string $value
     *
     * @return FillablePdfField
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
     * Set fillablePdfId
     *
     * @param integer $fillablePdfId
     *
     * @return FillablePdfField
     */
    public function setFillablePdfId($fillablePdfId)
    {
        $this->fillable_pdf_id = $fillablePdfId;

        return $this;
    }

    /**
     * Get fillablePdfId
     *
     * @return integer
     */
    public function getFillablePdfId()
    {
        return $this->fillable_pdf_id;
    }

    /**
     * Set fillablePdf
     *
     * @param \Numa\DOADMSBundle\Entity\FillablePdf $fillablePdf
     *
     * @return FillablePdfField
     */
    public function setFillablePdf(\Numa\DOADMSBundle\Entity\FillablePdf $fillablePdf = null)
    {
        $this->FillablePdf = $fillablePdf;

        return $this;
    }

    /**
     * Get fillablePdf
     *
     * @return \Numa\DOADMSBundle\Entity\FillablePdf
     */
    public function getFillablePdf()
    {
        return $this->FillablePdf;
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
     */
    private $type;


    /**
     * Set type
     *
     * @param string $type
     *
     * @return FillablePdfField
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @var string
     */
    private $billing_field_name;


    /**
     * Set billingFieldName
     *
     * @param string $billingFieldName
     *
     * @return FillablePdfField
     */
    public function setBillingFieldName($billingFieldName)
    {
        $this->billing_field_name = $billingFieldName;

        return $this;
    }

    /**
     * Get billingFieldName
     *
     * @return string
     */
    public function getBillingFieldName()
    {
        return $this->billing_field_name;
    }
}