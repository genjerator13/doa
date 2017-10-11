<?php

namespace Numa\CCCAdminBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * LtDispatch
 */
class LtDispatch
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(max=12)
     */
    private $order_placed_by;

    /**
     * @var string
     * @Assert\Length(max=30)
     */
    private $order_placed_from;

    /**
     * @var string
     * @Assert\Length(max=12)
     */
    private $contact_phone_number;

    /**
     * @var string
     */
    private $service_type;

    /**
     * @var string
     * @Assert\Length(max=35)
     */
    private $pickup_location;

    /**
     * @var string
     * @Assert\Length(max=20)
     */
    private $pickup_city;

    /**
     * @var string
     * @Assert\Length(max=12)
     */
    private $pickup_contact_phone;

    /**
     * @Assert\True(message = "The Dates are not legal, pickup time must be at least today. Delivery time must be after pickup time.")
     */
    public function isDatesLegal()
    {

        $today = new \DateTime();
//        dump($this->getPickupTime()<$today);
//        dump($this->getDeliveryTime()<$today);
//        dump($this->getPickupTime()> $this->getDeliveryTime());
//        dump($this->getPickupTime());
//        dump($this->getDeliveryTime());
        $interval = $this->getDeliveryTime()->diff($this->getPickupTime());

        $firstDate = $this->getPickupTime()->format('Y-m-d');
        $secondDate = $this->getDeliveryTime()->format('Y-m-d');
//        dump($firstDate);
//        dump($secondDate);
//        dump(intval($interval->days));
//        dump(intval($interval->days)<0);
////        if($this->getPickupTime()<$today || $this->getDeliveryTime()<$today ){
////            return false;
////        }
        if(intval($interval->days)<0){
            return false;
        }
        return true;
    }

    /**
     * @var \DateTime
     * @Assert\GreaterThanOrEqual("today")
     */
    private $pickup_time;

    /**
     * @var string
     * @Assert\Length(max=35)
     */
    private $delivery_location;

    /**
     * @var string
     * @Assert\Length(max=20)
     */
    private $delivery_city;

    /**
     * @var string
     * @Assert\Length(max=12)
     */
    private $delivery_contact_phone;

    /**
     * @var \DateTime
     * @Assert\GreaterThanOrEqual("today")
     */
    private $delivery_time;

    /**
     * @var string
     * @Assert\Length(max=35)
     */
    private $customer_charged;

    /**
     * @var string
     * @Assert\Length(max=50)
     */
    private $contact_info;

    /**
     * @var string
     * @Assert\Length(max=10)
     */
    private $length;

    /**
     * @var string
     * @Assert\Length(max=10)
     */
    private $width;

    /**
     * @var string
     * @Assert\Length(max=10)
     */
    private $height;

    /**
     * @var string
     * @Assert\Length(max=10)
     */
    private $weight;

    /**
     * @var string
     */
    private $additional_details;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var \DateTime
     */
    private $date_updated;


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
     * Set orderPlacedBy
     *
     * @param string $orderPlacedBy
     *
     * @return LtDispatch
     */
    public function setOrderPlacedBy($orderPlacedBy)
    {
        $this->order_placed_by = $orderPlacedBy;

        return $this;
    }

    /**
     * Get orderPlacedBy
     *
     * @return string
     */
    public function getOrderPlacedBy()
    {
        return $this->order_placed_by;
    }

    /**
     * Set orderPlacedFrom
     *
     * @param string $orderPlacedFrom
     *
     * @return LtDispatch
     */
    public function setOrderPlacedFrom($orderPlacedFrom)
    {
        $this->order_placed_from = $orderPlacedFrom;

        return $this;
    }

    /**
     * Get orderPlacedFrom
     *
     * @return string
     */
    public function getOrderPlacedFrom()
    {
        return $this->order_placed_from;
    }

    /**
     * Set contactPhoneNumber
     *
     * @param string $contactPhoneNumber
     *
     * @return LtDispatch
     */
    public function setContactPhoneNumber($contactPhoneNumber)
    {
        $this->contact_phone_number = $contactPhoneNumber;

        return $this;
    }

    /**
     * Get contactPhoneNumber
     *
     * @return string
     */
    public function getContactPhoneNumber()
    {
        return $this->contact_phone_number;
    }

    /**
     * Set serviceType
     *
     * @param string $serviceType
     *
     * @return LtDispatch
     */
    public function setServiceType($serviceType)
    {
        $this->service_type = $serviceType;

        return $this;
    }

    /**
     * Get serviceType
     *
     * @return string
     */
    public function getServiceType()
    {
        return $this->service_type;
    }

    /**
     * Set pickupLocation
     *
     * @param string $pickupLocation
     *
     * @return LtDispatch
     */
    public function setPickupLocation($pickupLocation)
    {
        $this->pickup_location = $pickupLocation;

        return $this;
    }

    /**
     * Get pickupLocation
     *
     * @return string
     */
    public function getPickupLocation()
    {
        return $this->pickup_location;
    }

    /**
     * Set pickupCity
     *
     * @param string $pickupCity
     *
     * @return LtDispatch
     */
    public function setPickupCity($pickupCity)
    {
        $this->pickup_city = $pickupCity;

        return $this;
    }

    /**
     * Get pickupCity
     *
     * @return string
     */
    public function getPickupCity()
    {
        return $this->pickup_city;
    }

    /**
     * Set pickupContactPhone
     *
     * @param string $pickupContactPhone
     *
     * @return LtDispatch
     */
    public function setPickupContactPhone($pickupContactPhone)
    {
        $this->pickup_contact_phone = $pickupContactPhone;

        return $this;
    }

    /**
     * Get pickupContactPhone
     *
     * @return string
     */
    public function getPickupContactPhone()
    {
        return $this->pickup_contact_phone;
    }

    /**
     * Set pickupTime
     *
     * @param \DateTime $pickupTime
     *
     * @return LtDispatch
     */
    public function setPickupTime($pickupTime)
    {
        $this->pickup_time = $pickupTime;

        return $this;
    }

    /**
     * Get pickupTime
     *
     * @return \DateTime
     */
    public function getPickupTime()
    {
        return $this->pickup_time;
    }

    /**
     * Set deliveryLocation
     *
     * @param string $deliveryLocation
     *
     * @return LtDispatch
     */
    public function setDeliveryLocation($deliveryLocation)
    {
        $this->delivery_location = $deliveryLocation;

        return $this;
    }

    /**
     * Get deliveryLocation
     *
     * @return string
     */
    public function getDeliveryLocation()
    {
        return $this->delivery_location;
    }

    /**
     * Set deliveryCity
     *
     * @param string $deliveryCity
     *
     * @return LtDispatch
     */
    public function setDeliveryCity($deliveryCity)
    {
        $this->delivery_city = $deliveryCity;

        return $this;
    }

    /**
     * Get deliveryCity
     *
     * @return string
     */
    public function getDeliveryCity()
    {
        return $this->delivery_city;
    }

    /**
     * Set deliveryContactPhone
     *
     * @param string $deliveryContactPhone
     *
     * @return LtDispatch
     */
    public function setDeliveryContactPhone($deliveryContactPhone)
    {
        $this->delivery_contact_phone = $deliveryContactPhone;

        return $this;
    }

    /**
     * Get deliveryContactPhone
     *
     * @return string
     */
    public function getDeliveryContactPhone()
    {
        return $this->delivery_contact_phone;
    }

    /**
     * Set deliveryTime
     *
     * @param \DateTime $deliveryTime
     *
     * @return LtDispatch
     */
    public function setDeliveryTime($deliveryTime)
    {
        $this->delivery_time = $deliveryTime;

        return $this;
    }

    /**
     * Get deliveryTime
     *
     * @return \DateTime
     */
    public function getDeliveryTime()
    {
        return $this->delivery_time;
    }

    /**
     * Set customerCharged
     *
     * @param string $customerCharged
     *
     * @return LtDispatch
     */
    public function setCustomerCharged($customerCharged)
    {
        $this->customer_charged = $customerCharged;

        return $this;
    }

    /**
     * Get customerCharged
     *
     * @return string
     */
    public function getCustomerCharged()
    {
        return $this->customer_charged;
    }

    /**
     * Set contactInfo
     *
     * @param string $contactInfo
     *
     * @return LtDispatch
     */
    public function setContactInfo($contactInfo)
    {
        $this->contact_info = $contactInfo;

        return $this;
    }

    /**
     * Get contactInfo
     *
     * @return string
     */
    public function getContactInfo()
    {
        return $this->contact_info;
    }

    /**
     * Set length
     *
     * @param float $length
     *
     * @return LtDispatch
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return float
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set width
     *
     * @param float $width
     *
     * @return LtDispatch
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param float $height
     *
     * @return LtDispatch
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set weight
     *
     * @param float $weight
     *
     * @return LtDispatch
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
     * Set additionalDetails
     *
     * @param string $additionalDetails
     *
     * @return LtDispatch
     */
    public function setAdditionalDetails($additionalDetails)
    {
        $this->additional_details = $additionalDetails;

        return $this;
    }

    /**
     * Get additionalDetails
     *
     * @return string
     */
    public function getAdditionalDetails()
    {
        return $this->additional_details;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return LtDispatch
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return LtDispatch
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return LtDispatch
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->date_updated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        if (!$this->getDateCreated()) {
            $this->date_created = new \DateTime();
            $this->date_updated = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->date_updated = new \DateTime();
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $LtdVehicleType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $LtdAdditional;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pickup_time = new \DateTime();
        $this->delivery_time = new \DateTime();
        $this->LtdVehicleType = new \Doctrine\Common\Collections\ArrayCollection();
        $this->LtdAdditional = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ltdVehicleType
     *
     * @param \Numa\CCCAdminBundle\Entity\LtdVehicleType $ltdVehicleType
     *
     * @return LtDispatch
     */
    public function addLtdVehicleType(\Numa\CCCAdminBundle\Entity\LtdVehicleType $ltdVehicleType)
    {
        $this->LtdVehicleType[] = $ltdVehicleType;

        return $this;
    }

    /**
     * Remove ltdVehicleType
     *
     * @param \Numa\CCCAdminBundle\Entity\LtdVehicleType $ltdVehicleType
     */
    public function removeLtdVehicleType(\Numa\CCCAdminBundle\Entity\LtdVehicleType $ltdVehicleType)
    {
        $this->LtdVehicleType->removeElement($ltdVehicleType);
    }

    /**
     * Get ltdVehicleType
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLtdVehicleType()
    {
        return $this->LtdVehicleType;
    }

    /**
     * Add ltdAdditional
     *
     * @param \Numa\CCCAdminBundle\Entity\LtdAdditional $ltdAdditional
     *
     * @return LtDispatch
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

    // Important
    public function getVehicleTypes()
    {
        $vehtypes = new ArrayCollection();
        if (!empty($this->getLtdVehicleType()) && !$this->getLtdVehicleType()->isEmpty()) {

            foreach ($this->getLtdVehicleType() as $ltvt) {
                if ($ltvt instanceof LtdVehicleType) {
                    $vehtypes[] = $ltvt->getVehtypes();
                }
            }
        }
        return $vehtypes;
    }


    // Important
    public function setVehicleTypes($vehTypes)
    {
        foreach ($vehTypes as $vehType) {
            $ltvt = new LtdVehicleType();
            $ltvt->setLtDispatch($this);
            $ltvt->setVehtypes($vehType);
            $this->addLtdVehicleType($ltvt);
        }
    }

    // Important
    public function getAdditional()
    {
        $additionals = new ArrayCollection();
        if (!empty($this->getLtdAdditional()) && !$this->getLtdAdditional()->isEmpty()) {
            foreach ($this->getLtdAdditional() as $lta) {
                if ($lta instanceof LtdAdditional) {
                    $additionals[] = $lta->getAdditionalReq();
                }
            }
        }
        return $additionals;
    }


    // Important
    public function setAdditional($additionals)
    {
        foreach ($additionals as $additional) {
            $lta = new LtdAdditional();
            $lta->setLtDispatch($this);
            $lta->setAdditionalReq($additional);
            $this->addLtdAdditional($lta);
        }
    }
    /**
     * @var string
     */
    private $vehtypes_list;

    /**
     * @var string
     */
    private $additiona_req_list;


    /**
     * Set vehtypesList
     *
     * @param string $vehtypesList
     *
     * @return LtDispatch
     */
    public function setVehtypesList($vehtypesList)
    {
        $this->vehtypes_list = $vehtypesList;

        return $this;
    }

    /**
     * Get vehtypesList
     *
     * @return string
     */
    public function getVehtypesList()
    {
        return $this->vehtypes_list;
    }

    /**
     * Set additionaReqList
     *
     * @param string $additionaReqList
     *
     * @return LtDispatch
     */
    public function setAdditionaReqList($additionaReqList)
    {
        $this->additiona_req_list = $additionaReqList;

        return $this;
    }

    /**
     * Get additionaReqList
     *
     * @return string
     */
    public function getAdditionaReqList()
    {
        return $this->additiona_req_list;
    }
    /**
     * @var integer
     */
    private $send_quote;

    /**
     * @var string
     */
    private $email;


    /**
     * Set sendQuote
     *
     * @param \integer $sendQuote
     *
     * @return LtDispatch
     */
    public function setSendQuote($sendQuote)
    {
        $this->send_quote = $sendQuote;

        return $this;
    }

    /**
     * Get sendQuote
     *
     * @return \integer
     */
    public function getSendQuote()
    {
        return $this->send_quote;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return LtDispatch
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @var integer
     */
    private $vehtype_requested;


    /**
     * Set vehtypeRequested
     *
     * @param integer $vehtypeRequested
     *
     * @return LtDispatch
     */
    public function setVehtypeRequested($vehtypeRequested)
    {
        $this->vehtype_requested = $vehtypeRequested;

        return $this;
    }

    /**
     * Get vehtypeRequested
     *
     * @return integer
     */
    public function getVehtypeRequested()
    {
        return $this->vehtype_requested;
    }
    /**
     * @var string
     */
    private $vehicletype;

    /**
     * @var string
     */
    private $semipower_unit;


    /**
     * Set vehicletype
     *
     * @param string $vehicletype
     *
     * @return LtDispatch
     */
    public function setVehicletype($vehicletype)
    {
        $this->vehicletype = $vehicletype;

        return $this;
    }

    /**
     * Get vehicletype
     *
     * @return string
     */
    public function getVehicletype()
    {
        return $this->vehicletype;
    }

    /**
     * Set semipowerUnit
     *
     * @param string $semipowerUnit
     *
     * @return LtDispatch
     */
    public function setSemipowerUnit($semipowerUnit)
    {
        $this->semipower_unit = $semipowerUnit;

        return $this;
    }

    /**
     * Get semipowerUnit
     *
     * @return string
     */
    public function getSemipowerUnit()
    {
        return $this->semipower_unit;
    }
}
