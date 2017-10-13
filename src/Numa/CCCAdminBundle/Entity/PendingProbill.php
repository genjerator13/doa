<?php

namespace Numa\CCCAdminBundle\Entity;

/**
 * Test
 */
class PendingProbill
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $qwe;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set qwe
     *
     * @param string $qwe
     *
     * @return Test
     */
    public function setQwe($qwe)
    {
        $this->qwe = $qwe;

        return $this;
    }

    /**
     * Get qwe
     *
     * @return string
     */
    public function getQwe()
    {
        return $this->qwe;
    }
    /**
     * @var string
     */
    private $qweqwe;


    /**
     * Set qweqwe
     *
     * @param string $qweqwe
     *
     * @return Test
     */
    public function setQweqwe($qweqwe)
    {
        $this->qweqwe = $qweqwe;

        return $this;
    }

    /**
     * Get qweqwe
     *
     * @return string
     */
    public function getQweqwe()
    {
        return $this->qweqwe;
    }
    /**
     * @var string
     */
    private $isinvoiced;

    /**
     * @var string
     */
    private $shipmentmode;

    /**
     * @var \DateTime
     */
    private $pDate;

    /**
     * @var string
     */
    private $driver_code;

    /**
     * @var string
     */
    private $customer_code;

    /**
     * @var string
     */
    private $ref;

    /**
     * @var string
     */
    private $servType;

    /**
     * @var string
     */
    private $customer;

    /**
     * @var string
     */
    private $dept;

    /**
     * @var string
     */
    private $waybill;

    /**
     * @var string
     */
    private $shipper;

    /**
     * @var integer
     */
    private $pickupHr;

    /**
     * @var integer
     */
    private $pickupMn;

    /**
     * @var integer
     */
    private $deliveryHr;

    /**
     * @var integer
     */
    private $deliveryMn;

    /**
     * @var string
     */
    private $pU;

    /**
     * @var string
     */
    private $dE;

    /**
     * @var string
     */
    private $receiver;

    /**
     * @var float
     */
    private $pce;

    /**
     * @var float
     */
    private $wgt;

    /**
     * @var string
     */
    private $rate_code;

    /**
     * @var string
     */
    private $rateDescription;

    /**
     * @var string
     */
    private $paygst;

    /**
     * @var float
     */
    private $rateAmt;

    /**
     * @var integer
     */
    private $extraPiece;

    /**
     * @var float
     */
    private $extraPceRate;

    /**
     * @var float
     */
    private $extraAmt;

    /**
     * @var float
     */
    private $miscAmt;

    /**
     * @var string
     */
    private $miscdesc;

    /**
     * @var float
     */
    private $gstAmt;

    /**
     * @var float
     */
    private $grandtotal;

    /**
     * @var float
     */
    private $paid;

    /**
     * @var float
     */
    private $balance;

    /**
     * @var float
     */
    private $drvRate;

    /**
     * @var float
     */
    private $drvTotal;

    /**
     * @var float
     */
    private $gross;

    /**
     * @var string
     */
    private $comments;

    /**
     * @var string
     */
    private $signature;

    /**
     * @var integer
     */
    private $ttimeH;

    /**
     * @var integer
     */
    private $ttimeM;

    /**
     * @var string
     */
    private $invoice;

    /**
     * @var integer
     */
    private $waitime;

    /**
     * @var float
     */
    private $waitchrg;

    /**
     * @var integer
     */
    private $vehicleId;

    /**
     * @var integer
     */
    private $trailerId;

    /**
     * @var string
     */
    private $batch;

    /**
     * @var float
     */
    private $rushAmt;

    /**
     * @var \DateTime
     */
    private $called;

    /**
     * @var \DateTime
     */
    private $delivered;

    /**
     * @var \DateTime
     */
    private $deliverytime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var float
     */
    private $custsurchargeamt;

    /**
     * @var float
     */
    private $drvsurrate;

    /**
     * @var float
     */
    private $cussurchargerate;

    /**
     * @var float
     */
    private $driversurcharge;

    /**
     * @var float
     */
    private $total;

    /**
     * @var string
     */
    private $taxcode;

    /**
     * @var float
     */
    private $drvgross;

    /**
     * @var float
     */
    private $trailerchg;

    /**
     * @var float
     */
    private $miles;

    /**
     * @var string
     */
    private $pickupShipper;

    /**
     * @var string
     */
    private $pickupAddr1;

    /**
     * @var string
     */
    private $pickupAddr2;

    /**
     * @var string
     */
    private $pickupCity;

    /**
     * @var string
     */
    private $pickupProv;

    /**
     * @var string
     */
    private $pickupPostal;

    /**
     * @var string
     */
    private $pickupPhone;

    /**
     * @var string
     */
    private $pickupContact;

    /**
     * @var string
     */
    private $pickupDetail;

    /**
     * @var string
     */
    private $pickupRef;

    /**
     * @var string
     */
    private $shiptoReceiver;

    /**
     * @var string
     */
    private $shiptoAddr1;

    /**
     * @var string
     */
    private $shiptoAddr2;

    /**
     * @var string
     */
    private $shiptoCity;

    /**
     * @var string
     */
    private $shiptoProv;

    /**
     * @var string
     */
    private $shiptoPostal;

    /**
     * @var string
     */
    private $shiptoPhone;

    /**
     * @var string
     */
    private $shiptoContact;

    /**
     * @var string
     */
    private $shiptoDetail;

    /**
     * @var string
     */
    private $shiptoRef;

    /**
     * @var string
     */
    private $posted;

    /**
     * @var string
     */
    private $printed;

    /**
     * @var string
     */
    private $commodity;

    /**
     * @var string
     */
    private $routecode;

    /**
     * @var float
     */
    private $tracking;

    /**
     * @var string
     */
    private $barcode;

    /**
     * @var string
     */
    private $details;

    /**
     * @var string
     */
    private $glaccount;

    /**
     * @var string
     */
    private $paymenttype;

    /**
     * @var string
     */
    private $payref;

    /**
     * @var float
     */
    private $codAmt;

    /**
     * @var string
     */
    private $subitem;

    /**
     * @var \DateTime
     */
    private $entrydate;

    /**
     * @var integer
     */
    private $shipmentid;

    /**
     * @var string
     */
    private $ratelevel;

    /**
     * @var float
     */
    private $subtotal;

    /**
     * @var string
     */
    private $billtype;

    /**
     * @var float
     */
    private $fuelsurchargedifferential;

    /**
     * @var float
     */
    private $diffsurchargeamt;

    /**
     * @var integer
     */
    private $commodityId;

    /**
     * @var string
     */
    private $initials;

    /**
     * @var integer
     */
    private $shiptoId;

    /**
     * @var integer
     */
    private $pickupfromId;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var integer
     */
    private $vehcode;

    /**
     * @var integer
     */
    private $batchId;

    /**
     * @var integer
     */
    private $customersId;

    /**
     * @var \Numa\CCCAdminBundle\Entity\Customers
     */
    private $customers;

    /**
     * @var \Numa\CCCAdminBundle\Entity\Rates
     */
    private $rates;

    /**
     * @var \Numa\CCCAdminBundle\Entity\Vehtypes
     */
    private $vehtypes;

    /**
     * @var \Numa\CCCAdminBundle\Entity\Drivers
     */
    private $drivers;

    /**
     * @var \Numa\CCCAdminBundle\Entity\batchX
     */
    private $batchX;


    /**
     * Set isinvoiced
     *
     * @param string $isinvoiced
     *
     * @return Test
     */
    public function setIsinvoiced($isinvoiced)
    {
        $this->isinvoiced = $isinvoiced;

        return $this;
    }

    /**
     * Get isinvoiced
     *
     * @return string
     */
    public function getIsinvoiced()
    {
        return $this->isinvoiced;
    }

    /**
     * Set shipmentmode
     *
     * @param string $shipmentmode
     *
     * @return Test
     */
    public function setShipmentmode($shipmentmode)
    {
        $this->shipmentmode = $shipmentmode;

        return $this;
    }

    /**
     * Get shipmentmode
     *
     * @return string
     */
    public function getShipmentmode()
    {
        return $this->shipmentmode;
    }

    /**
     * Set pDate
     *
     * @param \DateTime $pDate
     *
     * @return Test
     */
    public function setPDate($pDate)
    {
        $this->pDate = $pDate;

        return $this;
    }

    /**
     * Get pDate
     *
     * @return \DateTime
     */
    public function getPDate()
    {
        return $this->pDate;
    }

    /**
     * Set driverCode
     *
     * @param string $driverCode
     *
     * @return Test
     */
    public function setDriverCode($driverCode)
    {
        $this->driver_code = $driverCode;

        return $this;
    }

    /**
     * Get driverCode
     *
     * @return string
     */
    public function getDriverCode()
    {
        return $this->driver_code;
    }

    /**
     * Set customerCode
     *
     * @param string $customerCode
     *
     * @return Test
     */
    public function setCustomerCode($customerCode)
    {
        $this->customer_code = $customerCode;

        return $this;
    }

    /**
     * Get customerCode
     *
     * @return string
     */
    public function getCustomerCode()
    {
        return $this->customer_code;
    }

    /**
     * Set ref
     *
     * @param string $ref
     *
     * @return Test
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set servType
     *
     * @param string $servType
     *
     * @return Test
     */
    public function setServType($servType)
    {
        $this->servType = $servType;

        return $this;
    }

    /**
     * Get servType
     *
     * @return string
     */
    public function getServType()
    {
        return $this->servType;
    }

    /**
     * Set customer
     *
     * @param string $customer
     *
     * @return Test
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return string
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set dept
     *
     * @param string $dept
     *
     * @return Test
     */
    public function setDept($dept)
    {
        $this->dept = $dept;

        return $this;
    }

    /**
     * Get dept
     *
     * @return string
     */
    public function getDept()
    {
        return $this->dept;
    }

    /**
     * Set waybill
     *
     * @param string $waybill
     *
     * @return Test
     */
    public function setWaybill($waybill)
    {
        $this->waybill = $waybill;

        return $this;
    }

    /**
     * Get waybill
     *
     * @return string
     */
    public function getWaybill()
    {
        return $this->waybill;
    }

    /**
     * Set shipper
     *
     * @param string $shipper
     *
     * @return Test
     */
    public function setShipper($shipper)
    {
        $this->shipper = $shipper;

        return $this;
    }

    /**
     * Get shipper
     *
     * @return string
     */
    public function getShipper()
    {
        return $this->shipper;
    }

    /**
     * Set pickupHr
     *
     * @param integer $pickupHr
     *
     * @return Test
     */
    public function setPickupHr($pickupHr)
    {
        $this->pickupHr = $pickupHr;

        return $this;
    }

    /**
     * Get pickupHr
     *
     * @return integer
     */
    public function getPickupHr()
    {
        return $this->pickupHr;
    }

    /**
     * Set pickupMn
     *
     * @param integer $pickupMn
     *
     * @return Test
     */
    public function setPickupMn($pickupMn)
    {
        $this->pickupMn = $pickupMn;

        return $this;
    }

    /**
     * Get pickupMn
     *
     * @return integer
     */
    public function getPickupMn()
    {
        return $this->pickupMn;
    }

    /**
     * Set deliveryHr
     *
     * @param integer $deliveryHr
     *
     * @return Test
     */
    public function setDeliveryHr($deliveryHr)
    {
        $this->deliveryHr = $deliveryHr;

        return $this;
    }

    /**
     * Get deliveryHr
     *
     * @return integer
     */
    public function getDeliveryHr()
    {
        return $this->deliveryHr;
    }

    /**
     * Set deliveryMn
     *
     * @param integer $deliveryMn
     *
     * @return Test
     */
    public function setDeliveryMn($deliveryMn)
    {
        $this->deliveryMn = $deliveryMn;

        return $this;
    }

    /**
     * Get deliveryMn
     *
     * @return integer
     */
    public function getDeliveryMn()
    {
        return $this->deliveryMn;
    }

    /**
     * Set pU
     *
     * @param string $pU
     *
     * @return Test
     */
    public function setPU($pU)
    {
        $this->pU = $pU;

        return $this;
    }

    /**
     * Get pU
     *
     * @return string
     */
    public function getPU()
    {
        return $this->pU;
    }

    /**
     * Set dE
     *
     * @param string $dE
     *
     * @return Test
     */
    public function setDE($dE)
    {
        $this->dE = $dE;

        return $this;
    }

    /**
     * Get dE
     *
     * @return string
     */
    public function getDE()
    {
        return $this->dE;
    }

    /**
     * Set receiver
     *
     * @param string $receiver
     *
     * @return Test
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return string
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Set pce
     *
     * @param float $pce
     *
     * @return Test
     */
    public function setPce($pce)
    {
        $this->pce = $pce;

        return $this;
    }

    /**
     * Get pce
     *
     * @return float
     */
    public function getPce()
    {
        return $this->pce;
    }

    /**
     * Set wgt
     *
     * @param float $wgt
     *
     * @return Test
     */
    public function setWgt($wgt)
    {
        $this->wgt = $wgt;

        return $this;
    }

    /**
     * Get wgt
     *
     * @return float
     */
    public function getWgt()
    {
        return $this->wgt;
    }

    /**
     * Set rateCode
     *
     * @param string $rateCode
     *
     * @return Test
     */
    public function setRateCode($rateCode)
    {
        $this->rate_code = $rateCode;

        return $this;
    }

    /**
     * Get rateCode
     *
     * @return string
     */
    public function getRateCode()
    {
        return $this->rate_code;
    }

    /**
     * Set rateDescription
     *
     * @param string $rateDescription
     *
     * @return Test
     */
    public function setRateDescription($rateDescription)
    {
        $this->rateDescription = $rateDescription;

        return $this;
    }

    /**
     * Get rateDescription
     *
     * @return string
     */
    public function getRateDescription()
    {
        return $this->rateDescription;
    }

    /**
     * Set paygst
     *
     * @param string $paygst
     *
     * @return Test
     */
    public function setPaygst($paygst)
    {
        $this->paygst = $paygst;

        return $this;
    }

    /**
     * Get paygst
     *
     * @return string
     */
    public function getPaygst()
    {
        return $this->paygst;
    }

    /**
     * Set rateAmt
     *
     * @param float $rateAmt
     *
     * @return Test
     */
    public function setRateAmt($rateAmt)
    {
        $this->rateAmt = $rateAmt;

        return $this;
    }

    /**
     * Get rateAmt
     *
     * @return float
     */
    public function getRateAmt()
    {
        return $this->rateAmt;
    }

    /**
     * Set extraPiece
     *
     * @param integer $extraPiece
     *
     * @return Test
     */
    public function setExtraPiece($extraPiece)
    {
        $this->extraPiece = $extraPiece;

        return $this;
    }

    /**
     * Get extraPiece
     *
     * @return integer
     */
    public function getExtraPiece()
    {
        return $this->extraPiece;
    }

    /**
     * Set extraPceRate
     *
     * @param float $extraPceRate
     *
     * @return Test
     */
    public function setExtraPceRate($extraPceRate)
    {
        $this->extraPceRate = $extraPceRate;

        return $this;
    }

    /**
     * Get extraPceRate
     *
     * @return float
     */
    public function getExtraPceRate()
    {
        return $this->extraPceRate;
    }

    /**
     * Set extraAmt
     *
     * @param float $extraAmt
     *
     * @return Test
     */
    public function setExtraAmt($extraAmt)
    {
        $this->extraAmt = $extraAmt;

        return $this;
    }

    /**
     * Get extraAmt
     *
     * @return float
     */
    public function getExtraAmt()
    {
        return $this->extraAmt;
    }

    /**
     * Set miscAmt
     *
     * @param float $miscAmt
     *
     * @return Test
     */
    public function setMiscAmt($miscAmt)
    {
        $this->miscAmt = $miscAmt;

        return $this;
    }

    /**
     * Get miscAmt
     *
     * @return float
     */
    public function getMiscAmt()
    {
        return $this->miscAmt;
    }

    /**
     * Set miscdesc
     *
     * @param string $miscdesc
     *
     * @return Test
     */
    public function setMiscdesc($miscdesc)
    {
        $this->miscdesc = $miscdesc;

        return $this;
    }

    /**
     * Get miscdesc
     *
     * @return string
     */
    public function getMiscdesc()
    {
        return $this->miscdesc;
    }

    /**
     * Set gstAmt
     *
     * @param float $gstAmt
     *
     * @return Test
     */
    public function setGstAmt($gstAmt)
    {
        $this->gstAmt = $gstAmt;

        return $this;
    }

    /**
     * Get gstAmt
     *
     * @return float
     */
    public function getGstAmt()
    {
        return $this->gstAmt;
    }

    /**
     * Set grandtotal
     *
     * @param float $grandtotal
     *
     * @return Test
     */
    public function setGrandtotal($grandtotal)
    {
        $this->grandtotal = $grandtotal;

        return $this;
    }

    /**
     * Get grandtotal
     *
     * @return float
     */
    public function getGrandtotal()
    {
        return $this->grandtotal;
    }

    /**
     * Set paid
     *
     * @param float $paid
     *
     * @return Test
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return float
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Set balance
     *
     * @param float $balance
     *
     * @return Test
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set drvRate
     *
     * @param float $drvRate
     *
     * @return Test
     */
    public function setDrvRate($drvRate)
    {
        $this->drvRate = $drvRate;

        return $this;
    }

    /**
     * Get drvRate
     *
     * @return float
     */
    public function getDrvRate()
    {
        return $this->drvRate;
    }

    /**
     * Set drvTotal
     *
     * @param float $drvTotal
     *
     * @return Test
     */
    public function setDrvTotal($drvTotal)
    {
        $this->drvTotal = $drvTotal;

        return $this;
    }

    /**
     * Get drvTotal
     *
     * @return float
     */
    public function getDrvTotal()
    {
        return $this->drvTotal;
    }

    /**
     * Set gross
     *
     * @param float $gross
     *
     * @return Test
     */
    public function setGross($gross)
    {
        $this->gross = $gross;

        return $this;
    }

    /**
     * Get gross
     *
     * @return float
     */
    public function getGross()
    {
        return $this->gross;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Test
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
     * Set signature
     *
     * @param string $signature
     *
     * @return Test
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Get signature
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Set ttimeH
     *
     * @param integer $ttimeH
     *
     * @return Test
     */
    public function setTtimeH($ttimeH)
    {
        $this->ttimeH = $ttimeH;

        return $this;
    }

    /**
     * Get ttimeH
     *
     * @return integer
     */
    public function getTtimeH()
    {
        return $this->ttimeH;
    }

    /**
     * Set ttimeM
     *
     * @param integer $ttimeM
     *
     * @return Test
     */
    public function setTtimeM($ttimeM)
    {
        $this->ttimeM = $ttimeM;

        return $this;
    }

    /**
     * Get ttimeM
     *
     * @return integer
     */
    public function getTtimeM()
    {
        return $this->ttimeM;
    }

    /**
     * Set invoice
     *
     * @param string $invoice
     *
     * @return Test
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @return string
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Set waitime
     *
     * @param integer $waitime
     *
     * @return Test
     */
    public function setWaitime($waitime)
    {
        $this->waitime = $waitime;

        return $this;
    }

    /**
     * Get waitime
     *
     * @return integer
     */
    public function getWaitime()
    {
        return $this->waitime;
    }

    /**
     * Set waitchrg
     *
     * @param float $waitchrg
     *
     * @return Test
     */
    public function setWaitchrg($waitchrg)
    {
        $this->waitchrg = $waitchrg;

        return $this;
    }

    /**
     * Get waitchrg
     *
     * @return float
     */
    public function getWaitchrg()
    {
        return $this->waitchrg;
    }

    /**
     * Set vehicleId
     *
     * @param integer $vehicleId
     *
     * @return Test
     */
    public function setVehicleId($vehicleId)
    {
        $this->vehicleId = $vehicleId;

        return $this;
    }

    /**
     * Get vehicleId
     *
     * @return integer
     */
    public function getVehicleId()
    {
        return $this->vehicleId;
    }

    /**
     * Set trailerId
     *
     * @param integer $trailerId
     *
     * @return Test
     */
    public function setTrailerId($trailerId)
    {
        $this->trailerId = $trailerId;

        return $this;
    }

    /**
     * Get trailerId
     *
     * @return integer
     */
    public function getTrailerId()
    {
        return $this->trailerId;
    }

    /**
     * Set batch
     *
     * @param string $batch
     *
     * @return Test
     */
    public function setBatch($batch)
    {
        $this->batch = $batch;

        return $this;
    }

    /**
     * Get batch
     *
     * @return string
     */
    public function getBatch()
    {
        return $this->batch;
    }

    /**
     * Set rushAmt
     *
     * @param float $rushAmt
     *
     * @return Test
     */
    public function setRushAmt($rushAmt)
    {
        $this->rushAmt = $rushAmt;

        return $this;
    }

    /**
     * Get rushAmt
     *
     * @return float
     */
    public function getRushAmt()
    {
        return $this->rushAmt;
    }

    /**
     * Set called
     *
     * @param \DateTime $called
     *
     * @return Test
     */
    public function setCalled($called)
    {
        $this->called = $called;

        return $this;
    }

    /**
     * Get called
     *
     * @return \DateTime
     */
    public function getCalled()
    {
        return $this->called;
    }

    /**
     * Set delivered
     *
     * @param \DateTime $delivered
     *
     * @return Test
     */
    public function setDelivered($delivered)
    {
        $this->delivered = $delivered;

        return $this;
    }

    /**
     * Get delivered
     *
     * @return \DateTime
     */
    public function getDelivered()
    {
        return $this->delivered;
    }

    /**
     * Set deliverytime
     *
     * @param \DateTime $deliverytime
     *
     * @return Test
     */
    public function setDeliverytime($deliverytime)
    {
        $this->deliverytime = $deliverytime;

        return $this;
    }

    /**
     * Get deliverytime
     *
     * @return \DateTime
     */
    public function getDeliverytime()
    {
        return $this->deliverytime;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Test
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
     * Set custsurchargeamt
     *
     * @param float $custsurchargeamt
     *
     * @return Test
     */
    public function setCustsurchargeamt($custsurchargeamt)
    {
        $this->custsurchargeamt = $custsurchargeamt;

        return $this;
    }

    /**
     * Get custsurchargeamt
     *
     * @return float
     */
    public function getCustsurchargeamt()
    {
        return $this->custsurchargeamt;
    }

    /**
     * Set drvsurrate
     *
     * @param float $drvsurrate
     *
     * @return Test
     */
    public function setDrvsurrate($drvsurrate)
    {
        $this->drvsurrate = $drvsurrate;

        return $this;
    }

    /**
     * Get drvsurrate
     *
     * @return float
     */
    public function getDrvsurrate()
    {
        return $this->drvsurrate;
    }

    /**
     * Set cussurchargerate
     *
     * @param float $cussurchargerate
     *
     * @return Test
     */
    public function setCussurchargerate($cussurchargerate)
    {
        $this->cussurchargerate = $cussurchargerate;

        return $this;
    }

    /**
     * Get cussurchargerate
     *
     * @return float
     */
    public function getCussurchargerate()
    {
        return $this->cussurchargerate;
    }

    /**
     * Set driversurcharge
     *
     * @param float $driversurcharge
     *
     * @return Test
     */
    public function setDriversurcharge($driversurcharge)
    {
        $this->driversurcharge = $driversurcharge;

        return $this;
    }

    /**
     * Get driversurcharge
     *
     * @return float
     */
    public function getDriversurcharge()
    {
        return $this->driversurcharge;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return Test
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set taxcode
     *
     * @param string $taxcode
     *
     * @return Test
     */
    public function setTaxcode($taxcode)
    {
        $this->taxcode = $taxcode;

        return $this;
    }

    /**
     * Get taxcode
     *
     * @return string
     */
    public function getTaxcode()
    {
        return $this->taxcode;
    }

    /**
     * Set drvgross
     *
     * @param float $drvgross
     *
     * @return Test
     */
    public function setDrvgross($drvgross)
    {
        $this->drvgross = $drvgross;

        return $this;
    }

    /**
     * Get drvgross
     *
     * @return float
     */
    public function getDrvgross()
    {
        return $this->drvgross;
    }

    /**
     * Set trailerchg
     *
     * @param float $trailerchg
     *
     * @return Test
     */
    public function setTrailerchg($trailerchg)
    {
        $this->trailerchg = $trailerchg;

        return $this;
    }

    /**
     * Get trailerchg
     *
     * @return float
     */
    public function getTrailerchg()
    {
        return $this->trailerchg;
    }

    /**
     * Set miles
     *
     * @param float $miles
     *
     * @return Test
     */
    public function setMiles($miles)
    {
        $this->miles = $miles;

        return $this;
    }

    /**
     * Get miles
     *
     * @return float
     */
    public function getMiles()
    {
        return $this->miles;
    }

    /**
     * Set pickupShipper
     *
     * @param string $pickupShipper
     *
     * @return Test
     */
    public function setPickupShipper($pickupShipper)
    {
        $this->pickupShipper = $pickupShipper;

        return $this;
    }

    /**
     * Get pickupShipper
     *
     * @return string
     */
    public function getPickupShipper()
    {
        return $this->pickupShipper;
    }

    /**
     * Set pickupAddr1
     *
     * @param string $pickupAddr1
     *
     * @return Test
     */
    public function setPickupAddr1($pickupAddr1)
    {
        $this->pickupAddr1 = $pickupAddr1;

        return $this;
    }

    /**
     * Get pickupAddr1
     *
     * @return string
     */
    public function getPickupAddr1()
    {
        return $this->pickupAddr1;
    }

    /**
     * Set pickupAddr2
     *
     * @param string $pickupAddr2
     *
     * @return Test
     */
    public function setPickupAddr2($pickupAddr2)
    {
        $this->pickupAddr2 = $pickupAddr2;

        return $this;
    }

    /**
     * Get pickupAddr2
     *
     * @return string
     */
    public function getPickupAddr2()
    {
        return $this->pickupAddr2;
    }

    /**
     * Set pickupCity
     *
     * @param string $pickupCity
     *
     * @return Test
     */
    public function setPickupCity($pickupCity)
    {
        $this->pickupCity = $pickupCity;

        return $this;
    }

    /**
     * Get pickupCity
     *
     * @return string
     */
    public function getPickupCity()
    {
        return $this->pickupCity;
    }

    /**
     * Set pickupProv
     *
     * @param string $pickupProv
     *
     * @return Test
     */
    public function setPickupProv($pickupProv)
    {
        $this->pickupProv = $pickupProv;

        return $this;
    }

    /**
     * Get pickupProv
     *
     * @return string
     */
    public function getPickupProv()
    {
        return $this->pickupProv;
    }

    /**
     * Set pickupPostal
     *
     * @param string $pickupPostal
     *
     * @return Test
     */
    public function setPickupPostal($pickupPostal)
    {
        $this->pickupPostal = $pickupPostal;

        return $this;
    }

    /**
     * Get pickupPostal
     *
     * @return string
     */
    public function getPickupPostal()
    {
        return $this->pickupPostal;
    }

    /**
     * Set pickupPhone
     *
     * @param string $pickupPhone
     *
     * @return Test
     */
    public function setPickupPhone($pickupPhone)
    {
        $this->pickupPhone = $pickupPhone;

        return $this;
    }

    /**
     * Get pickupPhone
     *
     * @return string
     */
    public function getPickupPhone()
    {
        return $this->pickupPhone;
    }

    /**
     * Set pickupContact
     *
     * @param string $pickupContact
     *
     * @return Test
     */
    public function setPickupContact($pickupContact)
    {
        $this->pickupContact = $pickupContact;

        return $this;
    }

    /**
     * Get pickupContact
     *
     * @return string
     */
    public function getPickupContact()
    {
        return $this->pickupContact;
    }

    /**
     * Set pickupDetail
     *
     * @param string $pickupDetail
     *
     * @return Test
     */
    public function setPickupDetail($pickupDetail)
    {
        $this->pickupDetail = $pickupDetail;

        return $this;
    }

    /**
     * Get pickupDetail
     *
     * @return string
     */
    public function getPickupDetail()
    {
        return $this->pickupDetail;
    }

    /**
     * Set pickupRef
     *
     * @param string $pickupRef
     *
     * @return Test
     */
    public function setPickupRef($pickupRef)
    {
        $this->pickupRef = $pickupRef;

        return $this;
    }

    /**
     * Get pickupRef
     *
     * @return string
     */
    public function getPickupRef()
    {
        return $this->pickupRef;
    }

    /**
     * Set shiptoReceiver
     *
     * @param string $shiptoReceiver
     *
     * @return Test
     */
    public function setShiptoReceiver($shiptoReceiver)
    {
        $this->shiptoReceiver = $shiptoReceiver;

        return $this;
    }

    /**
     * Get shiptoReceiver
     *
     * @return string
     */
    public function getShiptoReceiver()
    {
        return $this->shiptoReceiver;
    }

    /**
     * Set shiptoAddr1
     *
     * @param string $shiptoAddr1
     *
     * @return Test
     */
    public function setShiptoAddr1($shiptoAddr1)
    {
        $this->shiptoAddr1 = $shiptoAddr1;

        return $this;
    }

    /**
     * Get shiptoAddr1
     *
     * @return string
     */
    public function getShiptoAddr1()
    {
        return $this->shiptoAddr1;
    }

    /**
     * Set shiptoAddr2
     *
     * @param string $shiptoAddr2
     *
     * @return Test
     */
    public function setShiptoAddr2($shiptoAddr2)
    {
        $this->shiptoAddr2 = $shiptoAddr2;

        return $this;
    }

    /**
     * Get shiptoAddr2
     *
     * @return string
     */
    public function getShiptoAddr2()
    {
        return $this->shiptoAddr2;
    }

    /**
     * Set shiptoCity
     *
     * @param string $shiptoCity
     *
     * @return Test
     */
    public function setShiptoCity($shiptoCity)
    {
        $this->shiptoCity = $shiptoCity;

        return $this;
    }

    /**
     * Get shiptoCity
     *
     * @return string
     */
    public function getShiptoCity()
    {
        return $this->shiptoCity;
    }

    /**
     * Set shiptoProv
     *
     * @param string $shiptoProv
     *
     * @return Test
     */
    public function setShiptoProv($shiptoProv)
    {
        $this->shiptoProv = $shiptoProv;

        return $this;
    }

    /**
     * Get shiptoProv
     *
     * @return string
     */
    public function getShiptoProv()
    {
        return $this->shiptoProv;
    }

    /**
     * Set shiptoPostal
     *
     * @param string $shiptoPostal
     *
     * @return Test
     */
    public function setShiptoPostal($shiptoPostal)
    {
        $this->shiptoPostal = $shiptoPostal;

        return $this;
    }

    /**
     * Get shiptoPostal
     *
     * @return string
     */
    public function getShiptoPostal()
    {
        return $this->shiptoPostal;
    }

    /**
     * Set shiptoPhone
     *
     * @param string $shiptoPhone
     *
     * @return Test
     */
    public function setShiptoPhone($shiptoPhone)
    {
        $this->shiptoPhone = $shiptoPhone;

        return $this;
    }

    /**
     * Get shiptoPhone
     *
     * @return string
     */
    public function getShiptoPhone()
    {
        return $this->shiptoPhone;
    }

    /**
     * Set shiptoContact
     *
     * @param string $shiptoContact
     *
     * @return Test
     */
    public function setShiptoContact($shiptoContact)
    {
        $this->shiptoContact = $shiptoContact;

        return $this;
    }

    /**
     * Get shiptoContact
     *
     * @return string
     */
    public function getShiptoContact()
    {
        return $this->shiptoContact;
    }

    /**
     * Set shiptoDetail
     *
     * @param string $shiptoDetail
     *
     * @return Test
     */
    public function setShiptoDetail($shiptoDetail)
    {
        $this->shiptoDetail = $shiptoDetail;

        return $this;
    }

    /**
     * Get shiptoDetail
     *
     * @return string
     */
    public function getShiptoDetail()
    {
        return $this->shiptoDetail;
    }

    /**
     * Set shiptoRef
     *
     * @param string $shiptoRef
     *
     * @return Test
     */
    public function setShiptoRef($shiptoRef)
    {
        $this->shiptoRef = $shiptoRef;

        return $this;
    }

    /**
     * Get shiptoRef
     *
     * @return string
     */
    public function getShiptoRef()
    {
        return $this->shiptoRef;
    }

    /**
     * Set posted
     *
     * @param string $posted
     *
     * @return Test
     */
    public function setPosted($posted)
    {
        $this->posted = $posted;

        return $this;
    }

    /**
     * Get posted
     *
     * @return string
     */
    public function getPosted()
    {
        return $this->posted;
    }

    /**
     * Set printed
     *
     * @param string $printed
     *
     * @return Test
     */
    public function setPrinted($printed)
    {
        $this->printed = $printed;

        return $this;
    }

    /**
     * Get printed
     *
     * @return string
     */
    public function getPrinted()
    {
        return $this->printed;
    }

    /**
     * Set commodity
     *
     * @param string $commodity
     *
     * @return Test
     */
    public function setCommodity($commodity)
    {
        $this->commodity = $commodity;

        return $this;
    }

    /**
     * Get commodity
     *
     * @return string
     */
    public function getCommodity()
    {
        return $this->commodity;
    }

    /**
     * Set routecode
     *
     * @param string $routecode
     *
     * @return Test
     */
    public function setRoutecode($routecode)
    {
        $this->routecode = $routecode;

        return $this;
    }

    /**
     * Get routecode
     *
     * @return string
     */
    public function getRoutecode()
    {
        return $this->routecode;
    }

    /**
     * Set tracking
     *
     * @param float $tracking
     *
     * @return Test
     */
    public function setTracking($tracking)
    {
        $this->tracking = $tracking;

        return $this;
    }

    /**
     * Get tracking
     *
     * @return float
     */
    public function getTracking()
    {
        return $this->tracking;
    }

    /**
     * Set barcode
     *
     * @param string $barcode
     *
     * @return Test
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return Test
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set glaccount
     *
     * @param string $glaccount
     *
     * @return Test
     */
    public function setGlaccount($glaccount)
    {
        $this->glaccount = $glaccount;

        return $this;
    }

    /**
     * Get glaccount
     *
     * @return string
     */
    public function getGlaccount()
    {
        return $this->glaccount;
    }

    /**
     * Set paymenttype
     *
     * @param string $paymenttype
     *
     * @return Test
     */
    public function setPaymenttype($paymenttype)
    {
        $this->paymenttype = $paymenttype;

        return $this;
    }

    /**
     * Get paymenttype
     *
     * @return string
     */
    public function getPaymenttype()
    {
        return $this->paymenttype;
    }

    /**
     * Set payref
     *
     * @param string $payref
     *
     * @return Test
     */
    public function setPayref($payref)
    {
        $this->payref = $payref;

        return $this;
    }

    /**
     * Get payref
     *
     * @return string
     */
    public function getPayref()
    {
        return $this->payref;
    }

    /**
     * Set codAmt
     *
     * @param float $codAmt
     *
     * @return Test
     */
    public function setCodAmt($codAmt)
    {
        $this->codAmt = $codAmt;

        return $this;
    }

    /**
     * Get codAmt
     *
     * @return float
     */
    public function getCodAmt()
    {
        return $this->codAmt;
    }

    /**
     * Set subitem
     *
     * @param string $subitem
     *
     * @return Test
     */
    public function setSubitem($subitem)
    {
        $this->subitem = $subitem;

        return $this;
    }

    /**
     * Get subitem
     *
     * @return string
     */
    public function getSubitem()
    {
        return $this->subitem;
    }

    /**
     * Set entrydate
     *
     * @param \DateTime $entrydate
     *
     * @return Test
     */
    public function setEntrydate($entrydate)
    {
        $this->entrydate = $entrydate;

        return $this;
    }

    /**
     * Get entrydate
     *
     * @return \DateTime
     */
    public function getEntrydate()
    {
        return $this->entrydate;
    }

    /**
     * Set shipmentid
     *
     * @param integer $shipmentid
     *
     * @return Test
     */
    public function setShipmentid($shipmentid)
    {
        $this->shipmentid = $shipmentid;

        return $this;
    }

    /**
     * Get shipmentid
     *
     * @return integer
     */
    public function getShipmentid()
    {
        return $this->shipmentid;
    }

    /**
     * Set ratelevel
     *
     * @param string $ratelevel
     *
     * @return Test
     */
    public function setRatelevel($ratelevel)
    {
        $this->ratelevel = $ratelevel;

        return $this;
    }

    /**
     * Get ratelevel
     *
     * @return string
     */
    public function getRatelevel()
    {
        return $this->ratelevel;
    }

    /**
     * Set subtotal
     *
     * @param float $subtotal
     *
     * @return Test
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * Get subtotal
     *
     * @return float
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * Set billtype
     *
     * @param string $billtype
     *
     * @return Test
     */
    public function setBilltype($billtype)
    {
        $this->billtype = $billtype;

        return $this;
    }

    /**
     * Get billtype
     *
     * @return string
     */
    public function getBilltype()
    {
        return $this->billtype;
    }

    /**
     * Set fuelsurchargedifferential
     *
     * @param float $fuelsurchargedifferential
     *
     * @return Test
     */
    public function setFuelsurchargedifferential($fuelsurchargedifferential)
    {
        $this->fuelsurchargedifferential = $fuelsurchargedifferential;

        return $this;
    }

    /**
     * Get fuelsurchargedifferential
     *
     * @return float
     */
    public function getFuelsurchargedifferential()
    {
        return $this->fuelsurchargedifferential;
    }

    /**
     * Set diffsurchargeamt
     *
     * @param float $diffsurchargeamt
     *
     * @return Test
     */
    public function setDiffsurchargeamt($diffsurchargeamt)
    {
        $this->diffsurchargeamt = $diffsurchargeamt;

        return $this;
    }

    /**
     * Get diffsurchargeamt
     *
     * @return float
     */
    public function getDiffsurchargeamt()
    {
        return $this->diffsurchargeamt;
    }

    /**
     * Set commodityId
     *
     * @param integer $commodityId
     *
     * @return Test
     */
    public function setCommodityId($commodityId)
    {
        $this->commodityId = $commodityId;

        return $this;
    }

    /**
     * Get commodityId
     *
     * @return integer
     */
    public function getCommodityId()
    {
        return $this->commodityId;
    }

    /**
     * Set initials
     *
     * @param string $initials
     *
     * @return Test
     */
    public function setInitials($initials)
    {
        $this->initials = $initials;

        return $this;
    }

    /**
     * Get initials
     *
     * @return string
     */
    public function getInitials()
    {
        return $this->initials;
    }

    /**
     * Set shiptoId
     *
     * @param integer $shiptoId
     *
     * @return Test
     */
    public function setShiptoId($shiptoId)
    {
        $this->shiptoId = $shiptoId;

        return $this;
    }

    /**
     * Get shiptoId
     *
     * @return integer
     */
    public function getShiptoId()
    {
        return $this->shiptoId;
    }

    /**
     * Set pickupfromId
     *
     * @param integer $pickupfromId
     *
     * @return Test
     */
    public function setPickupfromId($pickupfromId)
    {
        $this->pickupfromId = $pickupfromId;

        return $this;
    }

    /**
     * Get pickupfromId
     *
     * @return integer
     */
    public function getPickupfromId()
    {
        return $this->pickupfromId;
    }

    /**
     * Set createdAt
     *
     * @param string $createdAt
     *
     * @return Test
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set vehcode
     *
     * @param integer $vehcode
     *
     * @return Test
     */
    public function setVehcode($vehcode)
    {
        $this->vehcode = $vehcode;

        return $this;
    }

    /**
     * Get vehcode
     *
     * @return integer
     */
    public function getVehcode()
    {
        return $this->vehcode;
    }

    /**
     * Set batchId
     *
     * @param integer $batchId
     *
     * @return Test
     */
    public function setBatchId($batchId)
    {
        $this->batchId = $batchId;

        return $this;
    }

    /**
     * Get batchId
     *
     * @return integer
     */
    public function getBatchId()
    {
        return $this->batchId;
    }

    /**
     * Set customersId
     *
     * @param integer $customersId
     *
     * @return Test
     */
    public function setCustomersId($customersId)
    {
        $this->customersId = $customersId;

        return $this;
    }

    /**
     * Get customersId
     *
     * @return integer
     */
    public function getCustomersId()
    {
        return $this->customersId;
    }

    /**
     * Set customers
     *
     * @param \Numa\CCCAdminBundle\Entity\Customers $customers
     *
     * @return Test
     */
    public function setCustomers(\Numa\CCCAdminBundle\Entity\Customers $customers = null)
    {
        $this->customers = $customers;

        return $this;
    }

    /**
     * Get customers
     *
     * @return \Numa\CCCAdminBundle\Entity\Customers
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * Set rates
     *
     * @param \Numa\CCCAdminBundle\Entity\Rates $rates
     *
     * @return Test
     */
    public function setRates(\Numa\CCCAdminBundle\Entity\Rates $rates = null)
    {
        $this->rates = $rates;

        return $this;
    }

    /**
     * Get rates
     *
     * @return \Numa\CCCAdminBundle\Entity\Rates
     */
    public function getRates()
    {
        return $this->rates;
    }

    /**
     * Set vehtypes
     *
     * @param \Numa\CCCAdminBundle\Entity\Vehtypes $vehtypes
     *
     * @return Test
     */
    public function setVehtypes(\Numa\CCCAdminBundle\Entity\Vehtypes $vehtypes = null)
    {
        $this->vehtypes = $vehtypes;

        return $this;
    }

    /**
     * Get vehtypes
     *
     * @return \Numa\CCCAdminBundle\Entity\Vehtypes
     */
    public function getVehtypes()
    {
        return $this->vehtypes;
    }

    /**
     * Set drivers
     *
     * @param \Numa\CCCAdminBundle\Entity\Drivers $drivers
     *
     * @return Test
     */
    public function setDrivers(\Numa\CCCAdminBundle\Entity\Drivers $drivers = null)
    {
        $this->drivers = $drivers;

        return $this;
    }

    /**
     * Get drivers
     *
     * @return \Numa\CCCAdminBundle\Entity\Drivers
     */
    public function getDrivers()
    {
        return $this->drivers;
    }

    /**
     * Set batchX
     *
     * @param \Numa\CCCAdminBundle\Entity\batchX $batchX
     *
     * @return Test
     */
    public function setBatchX(\Numa\CCCAdminBundle\Entity\batchX $batchX = null)
    {
        $this->batchX = $batchX;

        return $this;
    }

    /**
     * Get batchX
     *
     * @return \Numa\CCCAdminBundle\Entity\batchX
     */
    public function getBatchX()
    {
        return $this->batchX;
    }

    public function set($fieldname, $value) {
        $fieldname = strtolower($fieldname);

        $fieldnameParts = explode("_", $fieldname);
        if (count($fieldnameParts) == 2) {
            $fieldname = $fieldnameParts[0] . ucfirst($fieldnameParts[1]);
        }

        if($fieldname=='customerId'){
            $fieldname='customer_code';
        }
        //echo '$this->' . $fieldname . "=" . $value . "\n";
        $this->$fieldname = $value;


        //check if date
        if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/", $value)) {
            $this->$fieldname = new \DateTime($value);
        }
    }
}
