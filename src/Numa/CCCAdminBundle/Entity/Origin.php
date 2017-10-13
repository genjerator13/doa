<?php

namespace Numa\CCCAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Origin
 */
class Origin
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $building_business;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $contact_person;

    /**
     * @var \DateTime
     */
    private $delivery_time;

    /**
     * @var integer
     */
    private $vehicletype_id;

    /**
     * @var integer
     */
    private $pieces;

    /**
     * @var float
     */
    private $weight;

    /**
     * @var string
     */
    private $location_type;

    /**
     * @var integer
     */
    private $dispatchcard_id;

    /**
     * @var \Numa\CCCAdminBundle\Entity\Dispatchcard
     */
    private $Dispatchcard;


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
     * Set building_business
     *
     * @param string $buildingBusiness
     * @return Origin
     */
    public function setBuildingBusiness($buildingBusiness)
    {
        $this->building_business = $buildingBusiness;
    
        return $this;
    }

    /**
     * Get building_business
     *
     * @return string 
     */
    public function getBuildingBusiness()
    {
        return $this->building_business;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Origin
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set contact_person
     *
     * @param string $contactPerson
     * @return Origin
     */
    public function setContactPerson($contactPerson)
    {
        $this->contact_person = $contactPerson;
    
        return $this;
    }

    /**
     * Get contact_person
     *
     * @return string 
     */
    public function getContactPerson()
    {
        return $this->contact_person;
    }

    /**
     * Set delivery_time
     *
     * @param \DateTime $deliveryTime
     * @return Origin
     */
    public function setDeliveryTime($deliveryTime)
    {
        $this->delivery_time = $deliveryTime;
    
        return $this;
    }

    /**
     * Get delivery_time
     *
     * @return \DateTime 
     */
    public function getDeliveryTime()
    {
        return $this->delivery_time;
    }

    /**
     * Set vehicletype_id
     *
     * @param integer $vehicletypeId
     * @return Origin
     */
    public function setVehicletypeId($vehicletypeId)
    {
        $this->vehicletype_id = $vehicletypeId;
    
        return $this;
    }

    /**
     * Get vehicletype_id
     *
     * @return integer 
     */
    public function getVehicletypeId()
    {
        return $this->vehicletype_id;
    }

    /**
     * Set pieces
     *
     * @param integer $pieces
     * @return Origin
     */
    public function setPieces($pieces)
    {
        $this->pieces = $pieces;
    
        return $this;
    }

    /**
     * Get pieces
     *
     * @return integer 
     */
    public function getPieces()
    {
        return $this->pieces;
    }

    /**
     * Set weight
     *
     * @param float $weight
     * @return Origin
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    
        return $this;
    }

    /**
     * Get weight
     *
     * @return float 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set location_type
     *
     * @param string $locationType
     * @return Origin
     */
    public function setLocationType($locationType)
    {
        $this->location_type = $locationType;
    
        return $this;
    }

    /**
     * Get location_type
     *
     * @return string 
     */
    public function getLocationType()
    {
        return $this->location_type;
    }

    /**
     * Set dispatchcard_id
     *
     * @param integer $dispatchcardId
     * @return Origin
     */
    public function setDispatchcardId($dispatchcardId)
    {
        $this->dispatchcard_id = $dispatchcardId;
    
        return $this;
    }

    /**
     * Get dispatchcard_id
     *
     * @return integer 
     */
    public function getDispatchcardId()
    {
        return $this->dispatchcard_id;
    }

    /**
     * Set Dispatchcard
     *
     * @param \Numa\CCCAdminBundle\Entity\Dispatchcard $dispatchcard
     * @return Origin
     */
    public function setDispatchcard(\Numa\CCCAdminBundle\Entity\Dispatchcard $dispatchcard = null)
    {
        $this->Dispatchcard = $dispatchcard;
    
        return $this;
    }

    /**
     * Get Dispatchcard
     *
     * @return \Numa\CCCAdminBundle\Entity\Dispatchcard 
     */
    public function getDispatchcard()
    {
        return $this->Dispatchcard;
    }
    
    public function isEmpty(){
        return empty($this->address) && empty($this->building_business) && empty($this->contact_person);
    }
    
    /**
     * @var boolean
     */
    private $time_flag;


    /**
     * Set time_flag
     *
     * @param boolean $timeFlag
     * @return Origin
     */
    public function setTimeFlag($timeFlag)
    {
        $this->time_flag = $timeFlag;
    
        return $this;
    }

    /**
     * Get time_flag
     *
     * @return boolean 
     */
    public function getTimeFlag()
    {
        return $this->time_flag;
    }
    /**
     * @var boolean
     */
    private $collect;


    /**
     * Set collect
     *
     * @param boolean $collect
     * @return Origin
     */
    public function setCollect($collect)
    {
        $this->collect = $collect;
    
        return $this;
    }

    /**
     * Get collect
     *
     * @return boolean 
     */
    public function getCollect()
    {
        return $this->collect;
    }
    /**
     * @var string
     */
    private $comments;

    /**
     * @var float
     */
    private $cod_amount;

    /**
     * @var string
     */
    private $po;


    /**
     * Set comments
     *
     * @param string $comments
     * @return Origin
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    
        return $this;
    }

    /**
     * Get comments
     *
     * @return string 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set cod_amount
     *
     * @param float $codAmount
     * @return Origin
     */
    public function setCodAmount($codAmount)
    {
        $this->cod_amount = $codAmount;
    
        return $this;
    }

    /**
     * Get cod_amount
     *
     * @return float 
     */
    public function getCodAmount()
    {
        return $this->cod_amount;
    }

    /**
     * Set po
     *
     * @param string $po
     * @return Origin
     */
    public function setPo($po)
    {
        $this->po = $po;
    
        return $this;
    }

    /**
     * Get po
     *
     * @return string 
     */
    public function getPo()
    {
        return $this->po;
    }
    /**
     * @var \Numa\CCCAdminBundle\Entity\Vehtypes
     */
    private $VehicleType;


    /**
     * Set VehicleType
     *
     * @param \Numa\CCCAdminBundle\Entity\Vehtypes $vehicleType
     * @return Origin
     */
    public function setVehicleType(\Numa\CCCAdminBundle\Entity\Vehtypes $vehicleType = null)
    {
        $this->VehicleType = $vehicleType;
    
        return $this;
    }

    /**
     * Get VehicleType
     *
     * @return \Numa\CCCAdminBundle\Entity\Vehtypes 
     */
    public function getVehicleType()
    {
        return $this->VehicleType;
    }
}
