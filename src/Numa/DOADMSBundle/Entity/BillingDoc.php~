<?php

namespace Numa\DOADMSBundle\Entity;

/**
 * BillingDoc
 */
class BillingDoc
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
     * @var integer
     */
    private $fillable_pdf_id;

    /**
     * @var integer
     */
    private $billing_id;

    /**
     * @var \Numa\DOADMSBundle\Entity\FillablePdf
     */
    private $FillablePdf;

    /**
     * @var \Numa\DOADMSBundle\Entity\Billing
     */
    private $Billing;


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
     * @return BillingDoc
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
     * Set fillablePdfId
     *
     * @param integer $fillablePdfId
     *
     * @return BillingDoc
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
     * Set billingId
     *
     * @param integer $billingId
     *
     * @return BillingDoc
     */
    public function setBillingId($billingId)
    {
        $this->billing_id = $billingId;

        return $this;
    }

    /**
     * Get billingId
     *
     * @return integer
     */
    public function getBillingId()
    {
        return $this->billing_id;
    }

    /**
     * Set fillablePdf
     *
     * @param \Numa\DOADMSBundle\Entity\FillablePdf $fillablePdf
     *
     * @return BillingDoc
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
     * Set billing
     *
     * @param \Numa\DOADMSBundle\Entity\Billing $billing
     *
     * @return BillingDoc
     */
    public function setBilling(\Numa\DOADMSBundle\Entity\Billing $billing = null)
    {
        $this->Billing = $billing;

        return $this;
    }

    /**
     * Get billing
     *
     * @return \Numa\DOADMSBundle\Entity\Billing
     */
    public function getBilling()
    {
        return $this->Billing;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        // Add your code here
    }
}
