<?php

namespace Numa\CCCAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Drivers
 */
class Drivers {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $drivernum;

    /**
     * @var string
     */
    private $drivernam;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $postal;

    /**
     * @var string
     */
    private $tel;

    /**
     * @var string
     */
    private $cell;

    /**
     * @var \DateTime
     */
    private $hired;

    /**
     * @var \DateTime
     */
    private $dob;

    /**
     * @var string
     */
    private $sin;

    /**
     * @var string
     */
    private $married;

    /**
     * @var string
     */
    private $pic;

    /**
     * @var \DateTime
     */
    private $picExpiry;

    /**
     * @var \DateTime
     */
    private $vehExpiry;

    /**
     * @var string
     */
    private $vehPlat;

    /**
     * @var string
     */
    private $vehYear;

    /**
     * @var string
     */
    private $vehType;

    /**
     * @var string
     */
    private $vehColor;

    /**
     * @var string
     */
    private $vehSerial;

    /**
     * @var string
     */
    private $vehClass;

    /**
     * @var float
     */
    private $drivRate;

    /**
     * @var string
     */
    private $insAgent;

    /**
     * @var string
     */
    private $insPolicy;

    /**
     * @var float
     */
    private $insAmt;

    /**
     * @var \DateTime
     */
    private $insExpiry;

    /**
     * @var string
     */
    private $comments;

    /**
     * @var string
     */
    private $dgc;

    /**
     * @var \DateTime
     */
    private $dgcExpiry;

    /**
     * @var float
     */
    private $drvsurrate;

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
     * Set drivernum
     *
     * @param string $drivernum
     * @return Drivers
     */
    public function setDrivernum($drivernum) {
        $this->drivernum = $drivernum;

        return $this;
    }

    /**
     * Get drivernum
     *
     * @return string 
     */
    public function getDrivernum() {
        return $this->drivernum;
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

    /**
     * Set drivernam
     *
     * @param string $drivernam
     * @return Drivers
     */
    public function setDrivernam($drivernam) {
        $this->drivernam = $drivernam;

        return $this;
    }

    /**
     * Get drivernam
     *
     * @return string 
     */
    public function getDrivernam() {
        return $this->drivernam;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Drivers
     */
    public function setAddress($address) {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Drivers
     */
    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set postal
     *
     * @param string $postal
     * @return Drivers
     */
    public function setPostal($postal) {
        $this->postal = $postal;

        return $this;
    }

    /**
     * Get postal
     *
     * @return string 
     */
    public function getPostal() {
        return $this->postal;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return Drivers
     */
    public function setTel($tel) {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel() {
        return $this->tel;
    }

    /**
     * Set cell
     *
     * @param string $cell
     * @return Drivers
     */
    public function setCell($cell) {
        $this->cell = $cell;

        return $this;
    }

    /**
     * Get cell
     *
     * @return string 
     */
    public function getCell() {
        return $this->cell;
    }

    /**
     * Set hired
     *
     * @param \DateTime $hired
     * @return Drivers
     */
    public function setHired($hired) {
        $this->hired = $hired;

        return $this;
    }

    /**
     * Get hired
     *
     * @return \DateTime 
     */
    public function getHired() {
        return $this->hired;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     * @return Drivers
     */
    public function setDob($dob) {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime 
     */
    public function getDob() {
        return $this->dob;
    }

    /**
     * Set sin
     *
     * @param string $sin
     * @return Drivers
     */
    public function setSin($sin) {
        $this->sin = $sin;

        return $this;
    }

    /**
     * Get sin
     *
     * @return string 
     */
    public function getSin() {
        return $this->sin;
    }

    /**
     * Set married
     *
     * @param string $married
     * @return Drivers
     */
    public function setMarried($married) {
        $this->married = $married;

        return $this;
    }

    /**
     * Get married
     *
     * @return string 
     */
    public function getMarried() {
        return $this->married;
    }

    /**
     * Set pic
     *
     * @param string $pic
     * @return Drivers
     */
    public function setPic($pic) {
        $this->pic = $pic;

        return $this;
    }

    /**
     * Get pic
     *
     * @return string 
     */
    public function getPic() {
        return $this->pic;
    }

    /**
     * Set picExpiry
     *
     * @param \DateTime $picExpiry
     * @return Drivers
     */
    public function setPicExpiry($picExpiry) {
        $this->picExpiry = $picExpiry;

        return $this;
    }

    /**
     * Get picExpiry
     *
     * @return \DateTime 
     */
    public function getPicExpiry() {
        return $this->picExpiry;
    }

    /**
     * Set vehExpiry
     *
     * @param \DateTime $vehExpiry
     * @return Drivers
     */
    public function setVehExpiry($vehExpiry) {
        $this->vehExpiry = $vehExpiry;

        return $this;
    }

    /**
     * Get vehExpiry
     *
     * @return \DateTime 
     */
    public function getVehExpiry() {
        return $this->vehExpiry;
    }

    /**
     * Set vehPlat
     *
     * @param string $vehPlat
     * @return Drivers
     */
    public function setVehPlat($vehPlat) {
        $this->vehPlat = $vehPlat;

        return $this;
    }

    /**
     * Get vehPlat
     *
     * @return string 
     */
    public function getVehPlat() {
        return $this->vehPlat;
    }

    /**
     * Set vehYear
     *
     * @param string $vehYear
     * @return Drivers
     */
    public function setVehYear($vehYear) {
        $this->vehYear = $vehYear;

        return $this;
    }

    /**
     * Get vehYear
     *
     * @return string 
     */
    public function getVehYear() {
        return $this->vehYear;
    }

    /**
     * Set vehType
     *
     * @param string $vehType
     * @return Drivers
     */
    public function setVehType($vehType) {
        $this->vehType = $vehType;

        return $this;
    }

    /**
     * Get vehType
     *
     * @return string 
     */
    public function getVehType() {
        return $this->vehType;
    }

    /**
     * Set vehColor
     *
     * @param string $vehColor
     * @return Drivers
     */
    public function setVehColor($vehColor) {
        $this->vehColor = $vehColor;

        return $this;
    }

    /**
     * Get vehColor
     *
     * @return string 
     */
    public function getVehColor() {
        return $this->vehColor;
    }

    /**
     * Set vehSerial
     *
     * @param string $vehSerial
     * @return Drivers
     */
    public function setVehSerial($vehSerial) {
        $this->vehSerial = $vehSerial;

        return $this;
    }

    /**
     * Get vehSerial
     *
     * @return string 
     */
    public function getVehSerial() {
        return $this->vehSerial;
    }

    /**
     * Set vehClass
     *
     * @param string $vehClass
     * @return Drivers
     */
    public function setVehClass($vehClass) {
        $this->vehClass = $vehClass;

        return $this;
    }

    /**
     * Get vehClass
     *
     * @return string 
     */
    public function getVehClass() {
        return $this->vehClass;
    }

    /**
     * Set drivRate
     *
     * @param float $drivRate
     * @return Drivers
     */
    public function setDrivRate($drivRate) {
        $this->drivRate = $drivRate;

        return $this;
    }

    /**
     * Get drivRate
     *
     * @return float 
     */
    public function getDrivRate() {
        return $this->drivRate;
    }

    /**
     * Set insAgent
     *
     * @param string $insAgent
     * @return Drivers
     */
    public function setInsAgent($insAgent) {
        $this->insAgent = $insAgent;

        return $this;
    }

    /**
     * Get insAgent
     *
     * @return string 
     */
    public function getInsAgent() {
        return $this->insAgent;
    }

    /**
     * Set insPolicy
     *
     * @param string $insPolicy
     * @return Drivers
     */
    public function setInsPolicy($insPolicy) {
        $this->insPolicy = $insPolicy;

        return $this;
    }

    /**
     * Get insPolicy
     *
     * @return string 
     */
    public function getInsPolicy() {
        return $this->insPolicy;
    }

    /**
     * Set insAmt
     *
     * @param float $insAmt
     * @return Drivers
     */
    public function setInsAmt($insAmt) {
        $this->insAmt = $insAmt;

        return $this;
    }

    /**
     * Get insAmt
     *
     * @return float 
     */
    public function getInsAmt() {
        return $this->insAmt;
    }

    /**
     * Set insExpiry
     *
     * @param \DateTime $insExpiry
     * @return Drivers
     */
    public function setInsExpiry($insExpiry) {
        $this->insExpiry = $insExpiry;

        return $this;
    }

    /**
     * Get insExpiry
     *
     * @return \DateTime 
     */
    public function getInsExpiry() {
        return $this->insExpiry;
    }

    /**
     * Set comments
     *
     * @param string $comments
     * @return Drivers
     */
    public function setComments($comments) {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string 
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * Set dgc
     *
     * @param string $dgc
     * @return Drivers
     */
    public function setDgc($dgc) {
        $this->dgc = $dgc;

        return $this;
    }

    /**
     * Get dgc
     *
     * @return string 
     */
    public function getDgc() {
        return $this->dgc;
    }

    /**
     * Set dgcExpiry
     *
     * @param \DateTime $dgcExpiry
     * @return Drivers
     */
    public function setDgcExpiry($dgcExpiry) {
        $this->dgcExpiry = $dgcExpiry;

        return $this;
    }

    /**
     * Get dgcExpiry
     *
     * @return \DateTime 
     */
    public function getDgcExpiry() {
        return $this->dgcExpiry;
    }

    /**
     * Set drvsurrate
     *
     * @param float $drvsurrate
     * @return Drivers
     */
    public function setDrvsurrate($drvsurrate) {
        $this->drvsurrate = $drvsurrate;

        return $this;
    }

    /**
     * Get drvsurrate
     *
     * @return float 
     */
    public function getDrvsurrate() {
        return $this->drvsurrate;
    }

    /**
     * Add probills
     *
     * @param \Numa\CCCAdminBundle\Entity\Probills $probills
     * @return Drivers
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

    public function __toString() {
        return "asasa";
    }

}
