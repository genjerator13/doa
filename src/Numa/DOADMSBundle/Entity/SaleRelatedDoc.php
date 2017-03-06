<?php

namespace Numa\DOADMSBundle\Entity;

/**
 * SaleRelatedDoc
 */
class SaleRelatedDoc
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $sale_id;

    /**
     * @var integer
     */
    private $related_doc_id;

    /**
     * @var \Numa\DOADMSBundle\Entity\Sale
     */
    private $Sale;

    /**
     * @var \Numa\DOADMSBundle\Entity\RelatedDoc
     */
    private $RelatedDoc;


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
     * Set saleId
     *
     * @param integer $saleId
     *
     * @return SaleRelatedDoc
     */
    public function setSaleId($saleId)
    {
        $this->sale_id = $saleId;

        return $this;
    }

    /**
     * Get saleId
     *
     * @return integer
     */
    public function getSaleId()
    {
        return $this->sale_id;
    }

    /**
     * Set relatedDocId
     *
     * @param integer $relatedDocId
     *
     * @return SaleRelatedDoc
     */
    public function setRelatedDocId($relatedDocId)
    {
        $this->related_doc_id = $relatedDocId;

        return $this;
    }

    /**
     * Get relatedDocId
     *
     * @return integer
     */
    public function getRelatedDocId()
    {
        return $this->related_doc_id;
    }

    /**
     * Set sale
     *
     * @param \Numa\DOADMSBundle\Entity\Sale $sale
     *
     * @return SaleRelatedDoc
     */
    public function setSale(\Numa\DOADMSBundle\Entity\Sale $sale = null)
    {
        $this->Sale = $sale;

        return $this;
    }

    /**
     * Get sale
     *
     * @return \Numa\DOADMSBundle\Entity\Sale
     */
    public function getSale()
    {
        return $this->Sale;
    }

    /**
     * Set relatedDoc
     *
     * @param \Numa\DOADMSBundle\Entity\RelatedDoc $relatedDoc
     *
     * @return SaleRelatedDoc
     */
    public function setRelatedDoc(\Numa\DOADMSBundle\Entity\RelatedDoc $relatedDoc = null)
    {
        $this->RelatedDoc = $relatedDoc;

        return $this;
    }

    /**
     * Get relatedDoc
     *
     * @return \Numa\DOADMSBundle\Entity\RelatedDoc
     */
    public function getRelatedDoc()
    {
        return $this->RelatedDoc;
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
