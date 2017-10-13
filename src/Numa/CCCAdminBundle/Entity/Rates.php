<?php

namespace Numa\CCCAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rates
 */
class Rates {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $rateCode;

    /**
     * @var string
     */
    private $rateDescription;

    /**
     * @var float
     */
    private $rateAmt;

    /**
     * @var string
     */
    private $serviceArea;

    /**
     * @var string
     */
    private $taxcode;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $probills;

    /**
     * Constructor
     */
    public function __construct() {
        $this->probills = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set rateCode
     *
     * @param string $rateCode
     * @return Rates
     */
    public function setRateCode($rateCode) {
        $this->rateCode = $rateCode;

        return $this;
    }

    /**
     * Get rateCode
     *
     * @return string 
     */
    public function getRateCode() {
        return $this->rateCode;
    }

    /**
     * Set rateDescription
     *
     * @param string $rateDescription
     * @return Rates
     */
    public function setRateDescription($rateDescription) {
        $this->rateDescription = $rateDescription;

        return $this;
    }

    /**
     * Get rateDescription
     *
     * @return string 
     */
    public function getRateDescription() {
        return $this->rateDescription;
    }

    /**
     * Set rateAmt
     *
     * @param float $rateAmt
     * @return Rates
     */
    public function setRateAmt($rateAmt) {
        $this->rateAmt = $rateAmt;

        return $this;
    }

    /**
     * Get rateAmt
     *
     * @return float 
     */
    public function getRateAmt() {
        return $this->rateAmt;
    }

    /**
     * Set serviceArea
     *
     * @param string $serviceArea
     * @return Rates
     */
    public function setServiceArea($serviceArea) {
        $this->serviceArea = $serviceArea;

        return $this;
    }

    /**
     * Get serviceArea
     *
     * @return string 
     */
    public function getServiceArea() {
        return $this->serviceArea;
    }

    /**
     * Set taxcode
     *
     * @param string $taxcode
     * @return Rates
     */
    public function setTaxcode($taxcode) {
        $this->taxcode = $taxcode;

        return $this;
    }

    /**
     * Get taxcode
     *
     * @return string 
     */
    public function getTaxcode() {
        return $this->taxcode;
    }

    /**
     * Add probills
     *
     * @param \Numa\CCCAdminBundle\Entity\Probills $probills
     * @return Rates
     */
    public function addProbill(\Numa\CCCAdminBundle\Entity\Probills $probills) {
        $this->probills[] = $probills;

        return $this;
    }

    /**
     * Remove probills
     *
     * @param \Numa\CCCAdminBundle\Entity\Probills $probills
     */
    public function removeProbill(\Numa\CCCAdminBundle\Entity\Probills $probills) {
        $this->probills->removeElement($probills);
    }

    /**
     * Get probills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProbills() {
        return $this->probills;
    }

    public function set($fieldname, $value) {
        $fieldname = strtolower($fieldname);

        $fieldnameParts = explode("_", $fieldname);
        if (count($fieldnameParts) == 2) {
            $fieldname = $fieldnameParts[0] . ucfirst($fieldnameParts[1]);
        }

        $this->$fieldname = $value;


        //check if date
        if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/", $value)) {
            $this->$fieldname = new \DateTime($value);
        }
    }

    public function __toString() {
        return $this->rateDescription;
    }

}
