<?php

namespace Numa\CCCAdminBundle\Entity;

/**
 * CustomRateValue
 */
class CustomRateValue
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $custom_rate_id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Numa\CCCAdminBundle\Entity\CustomRate
     */
    private $CustomRate;


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
     * Set customRateId
     *
     * @param integer $customRateId
     *
     * @return CustomRateValue
     */
    public function setCustomRateId($customRateId)
    {
        $this->custom_rate_id = $customRateId;

        return $this;
    }

    /**
     * Get customRateId
     *
     * @return integer
     */
    public function getCustomRateId()
    {
        return $this->custom_rate_id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return CustomRateValue
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
     * Set description
     *
     * @param string $description
     *
     * @return CustomRateValue
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
     * Set customRate
     *
     * @param \Numa\CCCAdminBundle\Entity\CustomRate $customRate
     *
     * @return CustomRateValue
     */
    public function setCustomRate(\Numa\CCCAdminBundle\Entity\CustomRate $customRate = null)
    {
        $this->CustomRate = $customRate;

        return $this;
    }

    /**
     * Get customRate
     *
     * @return \Numa\CCCAdminBundle\Entity\CustomRate
     */
    public function getCustomRate()
    {
        return $this->CustomRate;
    }

    public function __toString()
    {
        return $this->getName()."";
    }
}
