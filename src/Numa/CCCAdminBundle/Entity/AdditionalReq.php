<?php

namespace Numa\CCCAdminBundle\Entity;

/**
 * AdditionalReq
 */
class AdditionalReq
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $comment;


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
     * Set status
     *
     * @param string $status
     *
     * @return AdditionalReq
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
     * Set name
     *
     * @param string $name
     *
     * @return AdditionalReq
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
     * Set comment
     *
     * @param string $comment
     *
     * @return AdditionalReq
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $LtdAdditional;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->LtdAdditional = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ltdAdditional
     *
     * @param \Numa\CCCAdminBundle\Entity\LtdAdditional $ltdAdditional
     *
     * @return AdditionalReq
     */
    public function addLtdAdditional(\Numa\CCCAdminBundle\Entity\LtdAdditional $ltdAdditional)
    {
        $this->LtdAdditional[] = $ltdAdditional;

        return $this;
    }

    /**
     * Remove ltdAdditional
     *
     * @param \Numa\CCCAdminBundle\Entity\LtdAdditional $ltdAdditional
     */
    public function removeLtdAdditional(\Numa\CCCAdminBundle\Entity\LtdAdditional $ltdAdditional)
    {
        $this->LtdAdditional->removeElement($ltdAdditional);
    }

    /**
     * Get ltdAdditional
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLtdAdditional()
    {
        return $this->LtdAdditional;
    }
}
