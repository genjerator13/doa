<?php

namespace Numa\CCCAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dispatchcard
 */
class Dispatchcard
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $dateorder;

    /**
     * @var integer
     */
    private $po;

    /**
     * @var string
     */
    private $serv_type;

    /**
     * @var string
     */
    private $call_in_buy;

    /**
     * @var integer
     */
    private $active;

    /**
     * @var string
     */
    private $pickup_building_business;

    /**
     * @var string
     */
    private $pickup_address;

    /**
     * @var string
     */
    private $pickup_contact_person;

    /**
     * @var \DateTime
     */
    private $requested_pickup_time;

    /**
     * @var string
     */
    private $delivery_building_business;

    /**
     * @var string
     */
    private $delivery_address;

    /**
     * @var string
     */
    private $delivery_contact_person;

    /**
     * @var \DateTime
     */
    private $requested_delivery_time;

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
    private $commodity_instruction;

    /**
     * @var string
     */
    private $comments;

    /**
     * @var float
     */
    private $cod_amount;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Origin;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Destination;

    /**
     * @var \Numa\CCCAdminBundle\Entity\Vehtypes
     */
    private $VehicleType;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Origin = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Destination = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dateorder
     *
     * @param \DateTime $dateorder
     * @return Dispatchcard
     */
    public function setDateorder($dateorder)
    {
        $this->dateorder = $dateorder;
    
        return $this;
    }

    /**
     * Get dateorder
     *
     * @return \DateTime 
     */
    public function getDateorder()
    {
        return $this->dateorder;
    }

    /**
     * Set po
     *
     * @param integer $po
     * @return Dispatchcard
     */
    public function setPo($po)
    {
        $this->po = $po;
    
        return $this;
    }

    /**
     * Get po
     *
     * @return integer 
     */
    public function getPo()
    {
        return $this->po;
    }

    /**
     * Set serv_type
     *
     * @param string $servType
     * @return Dispatchcard
     */
    public function setServType($servType)
    {
        $this->serv_type = $servType;
    
        return $this;
    }

    /**
     * Get serv_type
     *
     * @return string 
     */
    public function getServType()
    {
        return $this->serv_type;
    }

    /**
     * Set call_in_buy
     *
     * @param string $callInBuy
     * @return Dispatchcard
     */
    public function setCallInBuy($callInBuy)
    {
        $this->call_in_buy = $callInBuy;
    
        return $this;
    }

    /**
     * Get call_in_buy
     *
     * @return string 
     */
    public function getCallInBuy()
    {
        return $this->call_in_buy;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return Dispatchcard
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set pickup_building_business
     *
     * @param string $pickupBuildingBusiness
     * @return Dispatchcard
     */
    public function setPickupBuildingBusiness($pickupBuildingBusiness)
    {
        $this->pickup_building_business = $pickupBuildingBusiness;
    
        return $this;
    }

    /**
     * Get pickup_building_business
     *
     * @return string 
     */
    public function getPickupBuildingBusiness()
    {
        return $this->pickup_building_business;
    }

    /**
     * Set pickup_address
     *
     * @param string $pickupAddress
     * @return Dispatchcard
     */
    public function setPickupAddress($pickupAddress)
    {
        $this->pickup_address = $pickupAddress;
    
        return $this;
    }

    /**
     * Get pickup_address
     *
     * @return string 
     */
    public function getPickupAddress()
    {
        return $this->pickup_address;
    }

    /**
     * Set pickup_contact_person
     *
     * @param string $pickupContactPerson
     * @return Dispatchcard
     */
    public function setPickupContactPerson($pickupContactPerson)
    {
        $this->pickup_contact_person = $pickupContactPerson;
    
        return $this;
    }

    /**
     * Get pickup_contact_person
     *
     * @return string 
     */
    public function getPickupContactPerson()
    {
        return $this->pickup_contact_person;
    }

    /**
     * Set requested_pickup_time
     *
     * @param \DateTime $requestedPickupTime
     * @return Dispatchcard
     */
    public function setRequestedPickupTime($requestedPickupTime)
    {
        $this->requested_pickup_time = $requestedPickupTime;
    
        return $this;
    }

    /**
     * Get requested_pickup_time
     *
     * @return \DateTime 
     */
    public function getRequestedPickupTime()
    {
        return $this->requested_pickup_time;
    }

    /**
     * Set delivery_building_business
     *
     * @param string $deliveryBuildingBusiness
     * @return Dispatchcard
     */
    public function setDeliveryBuildingBusiness($deliveryBuildingBusiness)
    {
        $this->delivery_building_business = $deliveryBuildingBusiness;
    
        return $this;
    }

    /**
     * Get delivery_building_business
     *
     * @return string 
     */
    public function getDeliveryBuildingBusiness()
    {
        return $this->delivery_building_business;
    }

    /**
     * Set delivery_address
     *
     * @param string $deliveryAddress
     * @return Dispatchcard
     */
    public function setDeliveryAddress($deliveryAddress)
    {
        $this->delivery_address = $deliveryAddress;
    
        return $this;
    }

    /**
     * Get delivery_address
     *
     * @return string 
     */
    public function getDeliveryAddress()
    {
        return $this->delivery_address;
    }

    /**
     * Set delivery_contact_person
     *
     * @param string $deliveryContactPerson
     * @return Dispatchcard
     */
    public function setDeliveryContactPerson($deliveryContactPerson)
    {
        $this->delivery_contact_person = $deliveryContactPerson;
    
        return $this;
    }

    /**
     * Get delivery_contact_person
     *
     * @return string 
     */
    public function getDeliveryContactPerson()
    {
        return $this->delivery_contact_person;
    }

    /**
     * Set requested_delivery_time
     *
     * @param \DateTime $requestedDeliveryTime
     * @return Dispatchcard
     */
    public function setRequestedDeliveryTime($requestedDeliveryTime)
    {
        $this->requested_delivery_time = $requestedDeliveryTime;
    
        return $this;
    }

    /**
     * Get requested_delivery_time
     *
     * @return \DateTime 
     */
    public function getRequestedDeliveryTime()
    {
        return $this->requested_delivery_time;
    }

    /**
     * Set vehicletype_id
     *
     * @param integer $vehicletypeId
     * @return Dispatchcard
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
     * @return Dispatchcard
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
     * @return Dispatchcard
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
     * Set commodity_instruction
     *
     * @param string $commodityInstruction
     * @return Dispatchcard
     */
    public function setCommodityInstruction($commodityInstruction)
    {
        $this->commodity_instruction = $commodityInstruction;
    
        return $this;
    }

    /**
     * Get commodity_instruction
     *
     * @return string 
     */
    public function getCommodityInstruction()
    {
        return $this->commodity_instruction;
    }

    /**
     * Set comments
     *
     * @param string $comments
     * @return Dispatchcard
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
     * @return Dispatchcard
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
     * Add Origin
     *
     * @param \Numa\CCCAdminBundle\Entity\Origin $origin
     * @return Dispatchcard
     */
    public function addOrigin(\Numa\CCCAdminBundle\Entity\Origin $origin)
    {
        $this->Origin[] = $origin;
        $origin->setDispatchcard($this); // *** Add this
        return $this;
    }

    /**
     * Remove Origin
     *
     * @param \Numa\CCCAdminBundle\Entity\Origin $origin
     */
    public function removeOrigin(\Numa\CCCAdminBundle\Entity\Origin $origin)
    {
        $this->Origin->removeElement($origin);
    }

    /**
     * Get Origin
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrigin()
    {
        return $this->Origin;
    }

    /**
     * Add Destination
     *
     * @param \Numa\CCCAdminBundle\Entity\Origin $destination
     * @return Dispatchcard
     */
    public function addDestination(\Numa\CCCAdminBundle\Entity\Destination $destination)
    {
        $this->Destination[] = $destination;
    
        return $this;
    }

    /**
     * Remove Destination
     *
     * @param \Numa\CCCAdminBundle\Entity\Origin $destination
     */
    public function removeDestination(\Numa\CCCAdminBundle\Entity\Destination $destination)
    {
        $this->Destination->removeElement($destination);
    }

    /**
     * Get Destination
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDestination()
    {
        return $this->Destination;
    }

    /**
     * Set VehicleType
     *
     * @param \Numa\CCCAdminBundle\Entity\Vehtypes $vehicleType
     * @return Dispatchcard
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
    /**
     * @ORM\PrePersist
     */
    public function setDateOrdered()
    {
        if (!$this->getDateorder()) {
            $this->dateorder = new \DateTime();
        }
        if (!$this->getDateCreated()) {
            $this->date_created = new \DateTime();
        }
    }
    /**
     * @var integer
     */
    private $customer_id;

    /**
     * @var \Numa\CCCAdminBundle\Entity\Customers
     */
    private $Customer;


    /**
     * Set customer_id
     *
     * @param integer $customerId
     * @return Dispatchcard
     */
    public function setCustomerId($customerId)
    {
        $this->customer_id = $customerId;
    
        return $this;
    }

    /**
     * Get customer_id
     *
     * @return integer 
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Set Customer
     *
     * @param \Numa\CCCAdminBundle\Entity\Customers $customer
     * @return Dispatchcard
     */
    public function setCustomer(\Numa\CCCAdminBundle\Entity\Customers $customer = null)
    {
        $this->Customer = $customer;
    
        return $this;
    }

    /**
     * Get Customer
     *
     * @return \Numa\CCCAdminBundle\Entity\Customers 
     */
    public function getCustomer()
    {
        return $this->Customer;
    }
    /**
     * @var integer
     */
    private $status;


    /**
     * Set status
     *
     * @param integer $status
     * @return Dispatchcard
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * @var \DateTime
     */
    private $date_created;


    /**
     * Set date_created
     *
     * @param \DateTime $dateCreated
     * @return Dispatchcard
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;
    
        return $this;
    }

    /**
     * Get date_created
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }
    /**
     * @var string
     */
    private $csr_name;


    /**
     * Set csrName
     *
     * @param string $csrName
     *
     * @return Dispatchcard
     */
    public function setCsrName($csrName)
    {
        $this->csr_name = $csrName;

        return $this;
    }

    /**
     * Get csrName
     *
     * @return string
     */
    public function getCsrName()
    {
        return $this->csr_name;
    }
}
