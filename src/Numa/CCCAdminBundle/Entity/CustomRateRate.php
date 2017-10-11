<?php

namespace Numa\CCCAdminBundle\Entity;

/**
 * CustomRateRate
 */
class CustomRateRate
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
     * @var integer
     */
    private $rate_id;


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
     * @return CustomRateRate
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
     * Set rateId
     *
     * @param integer $rateId
     *
     * @return CustomRateRate
     */
    public function setRateId($rateId)
    {
        $this->rate_id = $rateId;

        return $this;
    }

    /**
     * Get rateId
     *
     * @return integer
     */
    public function getRateId()
    {
        return $this->rate_id;
    }
    /**
     * @var \Numa\CCCAdminBundle\Entity\CustomRate
     */
    private $CustomRate;

    /**
     * @var \Numa\CCCAdminBundle\Entity\Rates
     */
    private $Rates;


    /**
     * Set customRate
     *
     * @param \Numa\CCCAdminBundle\Entity\CustomRate $customRate
     *
     * @return CustomRateRate
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

    /**
     * Set rates
     *
     * @param \Numa\CCCAdminBundle\Entity\Rates $rates
     *
     * @return CustomRateRate
     */
    public function setRates(\Numa\CCCAdminBundle\Entity\Rates $rates = null)
    {
        $this->Rates = $rates;

        return $this;
    }

    /**
     * Get rates
     *
     * @return \Numa\CCCAdminBundle\Entity\Rates
     */
    public function getRates()
    {
        return $this->Rates;
    }
}
