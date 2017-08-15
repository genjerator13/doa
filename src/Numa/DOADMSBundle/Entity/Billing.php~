<?php

namespace Numa\DOADMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;
use Numa\DOAAdminBundle\Entity\Item;

/**
 * Billing
 * @JMS\XmlRoot("billing")
 * @JMS\ExclusionPolicy("ALL")
 */
class Billing
{
    /**
     * @var int
     * @JMS\Expose
     */
    private $id;

    /**
     * @var int
     * @JMS\Expose
     */
    private $customer_id;

    /**
     * @var \DateTime
     * @JMS\Expose
     */
    private $date_created;

    /**
     * @var \DateTime
     * @JMS\Expose
     */
    private $date_updated;

    /**
     * @var string
     * @JMS\Expose
     */
    private $status;

    /**
     * @var string
     * @JMS\Expose
     */
    private $comments;

    /**
     * @var \Numa\DOADMSBundle\Entity\Customer
     * @JMS\Expose
     */
    private $Customer;

    /**
     * @var \DateTime
     * @JMS\Expose
     */
    private $date_billing;


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
     * Set customerId
     *
     * @param int $customerId
     *
     * @return Billing
     */
    public function setCustomerId($customerId)
    {
        $this->customer_id = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Billing
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
     * @return Billing
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
     * Set status
     *
     * @param string $status
     *
     * @return Billing
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
     * Set comments
     *
     * @param string $comments
     *
     * @return Billing
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
     * Set customer
     *
     * @param \Numa\DOADMSBundle\Entity\Customer $customer
     *
     * @return Billing
     */
    public function setCustomer(\Numa\DOADMSBundle\Entity\Customer $customer = null)
    {
        $this->Customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Numa\DOADMSBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->Customer;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if (!$this->getDateCreated()) {
            $this->date_created = new \DateTime();
            $this->date_updated = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->date_updated = new \DateTime();
    }


    /**
     * Set dateBilling
     *
     * @param \DateTime $dateBilling
     *
     * @return Billing
     */
    public function setDateBilling($dateBilling)
    {
        $this->date_billing = $dateBilling;

        return $this;
    }

    /**
     * Get dateBilling
     *
     * @return \DateTime
     */
    public function getDateBilling()
    {
        return $this->date_billing;
    }

    /**
     * @var integer
     * @JMS\Expose
     */
    private $dealer_id;

    /**
     * @var integer
     * @JMS\Expose
     */
    private $item_id;

    /**
     * @var string
     * @JMS\Expose
     */
    private $sales_person;

    /**
     * @var string
     * @JMS\Expose
     */
    private $trim;

    /**
     * @var string
     * @JMS\Expose
     */
    private $tid_make;

    /**
     * @var string
     * @JMS\Expose
     */
    private $tid_model;

    /**
     * @var integer
     * @JMS\Expose
     */
    private $tid_year;

    /**
     * @var string
     * @JMS\Expose
     */
    private $tid_milleage;

    /**
     * @var string
     * @JMS\Expose
     */
    private $tid_km;

    /**
     * @var string
     * @JMS\Expose
     */
    private $tid_vin;

    /**
     * @var string
     * @JMS\Expose
     */
    private $payableto;

    /**
     * @var string
     * @JMS\Expose
     */
    private $address;

    /**
     * @var float
     * @JMS\Expose
     */
    private $amount;

    /**
     * @var float
     * @JMS\Expose
     */
    private $total;

    /**
     * @var float
     * @JMS\Expose
     */
    private $less_discount;

    /**
     * @var float
     * @JMS\Expose
     */
    private $options_total_cost;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opt1;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opteq1;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opt2;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opteq2;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opt3;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opteq3;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opt4;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opteq4;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opt5;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opteq5;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opt6;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opteq6;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opt7;

    /**
     * @var string
     * @JMS\Expose
     *
     */
    private $opteq7;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opt8;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opteq8;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opt9;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opteq9;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opt10;

    /**
     * @var string
     * @JMS\Expose
     */
    private $opteq10;

    /**
     * @var float
     * @JMS\Expose
     */
    private $sale_price;

    /**
     * @var float
     * @JMS\Expose
     */
    private $admin_fee;

    /**
     * @var float
     * @JMS\Expose
     */
    private $warranty;

    /**
     * @var float
     * @JMS\Expose
     */
    private $protection_pkg;

    /**
     * @var float
     * @JMS\Expose
     */
    private $tos_total;

    /**
     * @var float
     * @JMS\Expose
     */
    private $less_trade_in;

    /**
     * @var float
     * @JMS\Expose
     */
    private $difference_payable;

    /**
     * @var float
     * @JMS\Expose
     */
    private $tax1;

    /**
     * @var float
     * @JMS\Expose
     */
    private $tax2;

    /**
     * @var float
     * @JMS\Expose
     */
    private $tax3;

    /**
     * @var float
     * @JMS\Expose
     */
    private $other_misc1;

    /**
     * @var float
     * @JMS\Expose
     */
    private $other_misc2;

    /**
     * @var string
     * @JMS\Expose
     */
    private $text1_name;

    /**
     * @var string
     * @JMS\Expose
     */
    private $text2_name;

    /**
     * @var string
     * @JMS\Expose
     */
    private $text3_name;

    /**
     * @var string
     * @JMS\Expose
     */
    private $other_misc1_name;

    /**
     * @var string
     * @JMS\Expose
     */
    private $other_misc2_name;

    /**
     * @var float
     * @JMS\Expose
     */
    private $taxes_paid_total;

    /**
     * @var float
     * @JMS\Expose
     */
    private $lien_on_trade_in;

    /**
     * @var float
     * @JMS\Expose
     */
    private $total_due;

    /**
     * @var float
     * @JMS\Expose
     */
    private $less_trade_in_tax;

    /**
     * @var float
     * @JMS\Expose
     */
    private $less_deposit;

    /**
     * @var float
     * @JMS\Expose
     */
    private $payable_on_delivery;

    /**
     * @var float
     * @JMS\Expose
     */
    private $balance_to_finance;

    /**
     * @var float
     * @JMS\Expose
     */
    private $insurance;

    /**
     * @var float
     * @JMS\Expose
     */
    private $bank_registration_fee;

    /**
     * @var float
     * @JMS\Expose
     */
    private $total_balance_due;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     * @JMS\Expose
     */
    private $Dealer;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Item
     * @JMS\Expose
     */
    private $Item;


    /**
     * Set dealer_id
     *
     * @param integer $dealerId
     * @return Billing
     */
    public function setDealerId($dealerId)
    {
        $this->dealer_id = $dealerId;

        return $this;
    }

    /**
     * Get dealer_id
     *
     * @return integer
     */
    public function getDealerId()
    {
        return $this->dealer_id;
    }

    /**
     * Set item_id
     *
     * @param integer $itemId
     * @return Billing
     */
    public function setItemId($itemId)
    {
        $this->item_id = $itemId;

        return $this;
    }

    /**
     * Get item_id
     *
     * @return integer
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Set sales_person
     *
     * @param string $salesPerson
     * @return Billing
     */
    public function setSalesPerson($salesPerson)
    {
        $this->sales_person = $salesPerson;

        return $this;
    }

    /**
     * Get sales_person
     *
     * @return string
     */
    public function getSalesPerson()
    {
        return $this->sales_person;
    }

    /**
     * Set trim
     *
     * @param string $trim
     * @return Billing
     */
    public function setTrim($trim)
    {
        $this->trim = $trim;

        return $this;
    }

    /**
     * Get trim
     *
     * @return string
     */
    public function getTrim()
    {
        return $this->trim;
    }

    /**
     * Set tid_make
     *
     * @param string $tidMake
     * @return Billing
     */
    public function setTidMake($tidMake)
    {
        $this->tid_make = $tidMake;

        return $this;
    }

    /**
     * Get tid_make
     *
     * @return string
     */
    public function getTidMake()
    {
        return $this->tid_make;
    }

    /**
     * Set tid_model
     *
     * @param string $tidModel
     * @return Billing
     */
    public function setTidModel($tidModel)
    {
        $this->tid_model = $tidModel;

        return $this;
    }

    /**
     * Get tid_model
     *
     * @return string
     */
    public function getTidModel()
    {
        return $this->tid_model;
    }

    /**
     * Set tid_year
     *
     * @param integer $tidYear
     * @return Billing
     */
    public function setTidYear($tidYear)
    {
        $this->tid_year = $tidYear;

        return $this;
    }

    /**
     * Get tid_year
     *
     * @return integer
     */
    public function getTidYear()
    {
        return $this->tid_year;
    }

    /**
     * Set tid_milleage
     *
     * @param string $tidMilleage
     * @return Billing
     */
    public function setTidMilleage($tidMilleage)
    {
        $this->tid_milleage = $tidMilleage;

        return $this;
    }

    /**
     * Get tid_milleage
     *
     * @return string
     */
    public function getTidMilleage()
    {
        return $this->tid_milleage;
    }

    /**
     * Set tid_km
     *
     * @param string $tidKm
     * @return Billing
     */
    public function setTidKm($tidKm)
    {
        $this->tid_km = $tidKm;

        return $this;
    }

    /**
     * Get tid_km
     *
     * @return string
     */
    public function getTidKm()
    {
        return $this->tid_km;
    }

    /**
     * Set tid_vin
     *
     * @param string $tidVin
     * @return Billing
     */
    public function setTidVin($tidVin)
    {
        $this->tid_vin = $tidVin;

        return $this;
    }

    /**
     * Get tid_vin
     *
     * @return string
     */
    public function getTidVin()
    {
        return $this->tid_vin;
    }

    /**
     * Set payableto
     *
     * @param string $payableto
     * @return Billing
     */
    public function setPayableto($payableto)
    {
        $this->payableto = $payableto;

        return $this;
    }

    /**
     * Get payableto
     *
     * @return string
     */
    public function getPayableto()
    {
        return $this->payableto;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Billing
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
     * Set amount
     *
     * @param float $amount
     * @return Billing
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return Billing
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
     * Set less_discount
     *
     * @param float $lessDiscount
     * @return Billing
     */
    public function setLessDiscount($lessDiscount)
    {
        $this->less_discount = $lessDiscount;

        return $this;
    }

    /**
     * Get less_discount
     *
     * @return float
     */
    public function getLessDiscount()
    {
        return $this->less_discount;
    }

    /**
     * Set options_total_cost
     *
     * @param float $optionsTotalCost
     * @return Billing
     */
    public function setOptionsTotalCost($optionsTotalCost)
    {
        $this->options_total_cost = $optionsTotalCost;

        return $this;
    }

    /**
     * Get options_total_cost
     *
     * @return float
     */
    public function getOptionsTotalCost()
    {
        return $this->options_total_cost;
    }

    /**
     * Set opt1
     *
     * @param string $opt1
     * @return Billing
     */
    public function setOpt1($opt1)
    {
        $this->opt1 = $opt1;

        return $this;
    }

    /**
     * Get opt1
     *
     * @return string
     */
    public function getOpt1()
    {
        return $this->opt1;
    }

    /**
     * Set opteq1
     *
     * @param string $opteq1
     * @return Billing
     */
    public function setOpteq1($opteq1)
    {
        $this->opteq1 = $opteq1;

        return $this;
    }

    /**
     * Get opteq1
     *
     * @return string
     */
    public function getOpteq1()
    {
        return $this->opteq1;
    }

    /**
     * Set opt2
     *
     * @param string $opt2
     * @return Billing
     */
    public function setOpt2($opt2)
    {
        $this->opt2 = $opt2;

        return $this;
    }

    /**
     * Get opt2
     *
     * @return string
     */
    public function getOpt2()
    {
        return $this->opt2;
    }

    /**
     * Set opteq2
     *
     * @param string $opteq2
     * @return Billing
     */
    public function setOpteq2($opteq2)
    {
        $this->opteq2 = $opteq2;

        return $this;
    }

    /**
     * Get opteq2
     *
     * @return string
     */
    public function getOpteq2()
    {
        return $this->opteq2;
    }

    /**
     * Set opt3
     *
     * @param string $opt3
     * @return Billing
     */
    public function setOpt3($opt3)
    {
        $this->opt3 = $opt3;

        return $this;
    }

    /**
     * Get opt3
     *
     * @return string
     */
    public function getOpt3()
    {
        return $this->opt3;
    }

    /**
     * Set opteq3
     *
     * @param string $opteq3
     * @return Billing
     */
    public function setOpteq3($opteq3)
    {
        $this->opteq3 = $opteq3;

        return $this;
    }

    /**
     * Get opteq3
     *
     * @return string
     */
    public function getOpteq3()
    {
        return $this->opteq3;
    }

    /**
     * Set opt4
     *
     * @param string $opt4
     * @return Billing
     */
    public function setOpt4($opt4)
    {
        $this->opt4 = $opt4;

        return $this;
    }

    /**
     * Get opt4
     *
     * @return string
     */
    public function getOpt4()
    {
        return $this->opt4;
    }

    /**
     * Set opteq4
     *
     * @param string $opteq4
     * @return Billing
     */
    public function setOpteq4($opteq4)
    {
        $this->opteq4 = $opteq4;

        return $this;
    }

    /**
     * Get opteq4
     *
     * @return string
     */
    public function getOpteq4()
    {
        return $this->opteq4;
    }

    /**
     * Set opt5
     *
     * @param string $opt5
     * @return Billing
     */
    public function setOpt5($opt5)
    {
        $this->opt5 = $opt5;

        return $this;
    }

    /**
     * Get opt5
     *
     * @return string
     */
    public function getOpt5()
    {
        return $this->opt5;
    }

    /**
     * Set opteq5
     *
     * @param string $opteq5
     * @return Billing
     */
    public function setOpteq5($opteq5)
    {
        $this->opteq5 = $opteq5;

        return $this;
    }

    /**
     * Get opteq5
     *
     * @return string
     */
    public function getOpteq5()
    {
        return $this->opteq5;
    }

    /**
     * Set opt6
     *
     * @param string $opt6
     * @return Billing
     */
    public function setOpt6($opt6)
    {
        $this->opt6 = $opt6;

        return $this;
    }

    /**
     * Get opt6
     *
     * @return string
     */
    public function getOpt6()
    {
        return $this->opt6;
    }

    /**
     * Set opteq6
     *
     * @param string $opteq6
     * @return Billing
     */
    public function setOpteq6($opteq6)
    {
        $this->opteq6 = $opteq6;

        return $this;
    }

    /**
     * Get opteq6
     *
     * @return string
     */
    public function getOpteq6()
    {
        return $this->opteq6;
    }

    /**
     * Set opt7
     *
     * @param string $opt7
     * @return Billing
     */
    public function setOpt7($opt7)
    {
        $this->opt7 = $opt7;

        return $this;
    }

    /**
     * Get opt7
     *
     * @return string
     */
    public function getOpt7()
    {
        return $this->opt7;
    }

    /**
     * Set opteq7
     *
     * @param string $opteq7
     * @return Billing
     */
    public function setOpteq7($opteq7)
    {
        $this->opteq7 = $opteq7;

        return $this;
    }

    /**
     * Get opteq7
     *
     * @return string
     */
    public function getOpteq7()
    {
        return $this->opteq7;
    }

    /**
     * Set opt8
     *
     * @param string $opt8
     * @return Billing
     */
    public function setOpt8($opt8)
    {
        $this->opt8 = $opt8;

        return $this;
    }

    /**
     * Get opt8
     *
     * @return string
     */
    public function getOpt8()
    {
        return $this->opt8;
    }

    /**
     * Set opteq8
     *
     * @param string $opteq8
     * @return Billing
     */
    public function setOpteq8($opteq8)
    {
        $this->opteq8 = $opteq8;

        return $this;
    }

    /**
     * Get opteq8
     *
     * @return string
     */
    public function getOpteq8()
    {
        return $this->opteq8;
    }

    /**
     * Set opt9
     *
     * @param string $opt9
     * @return Billing
     */
    public function setOpt9($opt9)
    {
        $this->opt9 = $opt9;

        return $this;
    }

    /**
     * Get opt9
     *
     * @return string
     */
    public function getOpt9()
    {
        return $this->opt9;
    }

    /**
     * Set opteq9
     *
     * @param string $opteq9
     * @return Billing
     */
    public function setOpteq9($opteq9)
    {
        $this->opteq9 = $opteq9;

        return $this;
    }

    /**
     * Get opteq9
     *
     * @return string
     */
    public function getOpteq9()
    {
        return $this->opteq9;
    }

    /**
     * Set opt10
     *
     * @param string $opt10
     * @return Billing
     */
    public function setOpt10($opt10)
    {
        $this->opt10 = $opt10;

        return $this;
    }

    /**
     * Get opt10
     *
     * @return string
     */
    public function getOpt10()
    {
        return $this->opt10;
    }

    /**
     * Set opteq10
     *
     * @param string $opteq10
     * @return Billing
     */
    public function setOpteq10($opteq10)
    {
        $this->opteq10 = $opteq10;

        return $this;
    }

    /**
     * Get opteq10
     *
     * @return string
     */
    public function getOpteq10()
    {
        return $this->opteq10;
    }

    /**
     * Set sale_price
     *
     * @param float $salePrice
     * @return Billing
     */
    public function setSalePrice($salePrice)
    {
        $this->sale_price = $salePrice;

        return $this;
    }

    /**
     * Get sale_price
     *
     * @return float
     */
    public function getSalePrice()
    {
        return $this->sale_price;
    }

    /**
     * Set admin_fee
     *
     * @param float $adminFee
     * @return Billing
     */
    public function setAdminFee($adminFee)
    {
        $this->admin_fee = $adminFee;

        return $this;
    }

    /**
     * Get admin_fee
     *
     * @return float
     */
    public function getAdminFee()
    {
        return $this->admin_fee;
    }

    public function getDocFees()
    {
        return $this->getAdminFee();
    }

    /**
     * Set warranty
     *
     * @param float $warranty
     * @return Billing
     */
    public function setWarranty($warranty)
    {
        $this->warranty = $warranty;

        return $this;
    }

    /**
     * Get warranty
     *
     * @return float
     */
    public function getWarranty()
    {
        return $this->warranty;
    }

    /**
     * Set protection_pkg
     *
     * @param float $protectionPkg
     * @return Billing
     */
    public function setProtectionPkg($protectionPkg)
    {
        $this->protection_pkg = $protectionPkg;

        return $this;
    }

    /**
     * Get protection_pkg
     *
     * @return float
     */
    public function getProtectionPkg()
    {
        return $this->protection_pkg;
    }

    /**
     * Set tos_total
     *
     * @param float $tosTotal
     * @return Billing
     */
    public function setTosTotal($tosTotal)
    {
        $this->tos_total = $tosTotal;

        return $this;
    }

    /**
     * Get tos_total
     *
     * @return float
     */
    public function getTosTotal()
    {
        return $this->tos_total;
    }

    /**
     * Set less_trade_in
     *
     * @param float $lessTradeIn
     * @return Billing
     */
    public function setLessTradeIn($lessTradeIn)
    {
        $this->less_trade_in = $lessTradeIn;

        return $this;
    }

    /**
     * Get less_trade_in
     *
     * @return float
     */
    public function getLessTradeIn()
    {
        return $this->less_trade_in;
    }

    /**
     * Set difference_payable
     *
     * @param float $differencePayable
     * @return Billing
     */
    public function setDifferencePayable($differencePayable)
    {
        $this->difference_payable = $differencePayable;

        return $this;
    }

    /**
     * Get difference_payable
     *
     * @return float
     */
    public function getDifferencePayable()
    {
        return $this->difference_payable;
    }

    /**
     * Set tax1
     *
     * @param float $tax1
     * @return Billing
     */
    public function setTax1($tax1)
    {
        $this->tax1 = $tax1;

        return $this;
    }

    /**
     * Get tax1
     *
     * @return float
     */
    public function getTax1()
    {
        return $this->tax1;
    }

    /**
     * Set tax2
     *
     * @param float $tax2
     * @return Billing
     */
    public function setTax2($tax2)
    {
        $this->tax2 = $tax2;

        return $this;
    }

    /**
     * Get tax2
     *
     * @return float
     */
    public function getTax2()
    {
        return $this->tax2;
    }

    /**
     * Set tax3
     *
     * @param float $tax3
     * @return Billing
     */
    public function setTax3($tax3)
    {
        $this->tax3 = $tax3;

        return $this;
    }

    /**
     * Get tax3
     *
     * @return float
     */
    public function getTax3()
    {
        return $this->tax3;
    }

    /**
     * Set other_misc1
     *
     * @param float $otherMisc1
     * @return Billing
     */
    public function setOtherMisc1($otherMisc1)
    {
        $this->other_misc1 = $otherMisc1;

        return $this;
    }

    /**
     * Get other_misc1
     *
     * @return float
     */
    public function getOtherMisc1()
    {
        return $this->other_misc1;
    }

    /**
     * Set other_misc2
     *
     * @param float $otherMisc2
     * @return Billing
     */
    public function setOtherMisc2($otherMisc2)
    {
        $this->other_misc2 = $otherMisc2;

        return $this;
    }

    /**
     * Get other_misc2
     *
     * @return float
     */
    public function getOtherMisc2()
    {
        return $this->other_misc2;
    }

    /**
     * Set text1_name
     *
     * @param string $text1Name
     * @return Billing
     */
    public function setText1Name($text1Name)
    {
        $this->text1_name = $text1Name;

        return $this;
    }

    /**
     * Get text1_name
     *
     * @return string
     */
    public function getText1Name()
    {
        return $this->text1_name;
    }

    /**
     * Set text2_name
     *
     * @param string $text2Name
     * @return Billing
     */
    public function setText2Name($text2Name)
    {
        $this->text2_name = $text2Name;

        return $this;
    }

    /**
     * Get text2_name
     *
     * @return string
     */
    public function getText2Name()
    {
        return $this->text2_name;
    }

    /**
     * Set text3_name
     *
     * @param string $text3Name
     * @return Billing
     */
    public function setText3Name($text3Name)
    {
        $this->text3_name = $text3Name;

        return $this;
    }

    /**
     * Get text3_name
     *
     * @return string
     */
    public function getText3Name()
    {
        return $this->text3_name;
    }

    /**
     * Set other_misc1_name
     *
     * @param string $otherMisc1Name
     * @return Billing
     */
    public function setOtherMisc1Name($otherMisc1Name)
    {
        $this->other_misc1_name = $otherMisc1Name;

        return $this;
    }

    /**
     * Get other_misc1_name
     *
     * @return string
     */
    public function getOtherMisc1Name()
    {
        return $this->other_misc1_name;
    }

    /**
     * Set other_misc2_name
     *
     * @param string $otherMisc2Name
     * @return Billing
     */
    public function setOtherMisc2Name($otherMisc2Name)
    {
        $this->other_misc2_name = $otherMisc2Name;

        return $this;
    }

    /**
     * Get other_misc2_name
     *
     * @return string
     */
    public function getOtherMisc2Name()
    {
        return $this->other_misc2_name;
    }

    /**
     * Set taxes_paid_total
     *
     * @param float $taxesPaidTotal
     * @return Billing
     */
    public function setTaxesPaidTotal($taxesPaidTotal)
    {
        $this->taxes_paid_total = $taxesPaidTotal;

        return $this;
    }

    /**
     * Get taxes_paid_total
     *
     * @return float
     */
    public function getTaxesPaidTotal()
    {
        return $this->taxes_paid_total;
    }

    /**
     * Set lien_on_trade_in
     *
     * @param float $lienOnTradeIn
     * @return Billing
     */
    public function setLienOnTradeIn($lienOnTradeIn)
    {
        $this->lien_on_trade_in = $lienOnTradeIn;

        return $this;
    }

    /**
     * Get lien_on_trade_in
     *
     * @return float
     */
    public function getLienOnTradeIn()
    {
        return $this->lien_on_trade_in;
    }

    /**
     * Set total_due
     *
     * @param float $totalDue
     * @return Billing
     */
    public function setTotalDue($totalDue)
    {
        $this->total_due = $totalDue;

        return $this;
    }

    /**
     * Get total_due
     *
     * @return float
     */
    public function getTotalDue()
    {
        return $this->total_due;
    }

    /**
     * Set less_trade_in_tax
     *
     * @param float $lessTradeInTax
     * @return Billing
     */
    public function setLessTradeInTax($lessTradeInTax)
    {
        $this->less_trade_in_tax = $lessTradeInTax;

        return $this;
    }

    /**
     * Get less_trade_in_tax
     *
     * @return float
     */
    public function getLessTradeInTax()
    {
        return $this->less_trade_in_tax;
    }

    /**
     * Set less_deposit
     *
     * @param float $lessDeposit
     * @return Billing
     */
    public function setLessDeposit($lessDeposit)
    {
        $this->less_deposit = $lessDeposit;

        return $this;
    }

    /**
     * Get less_deposit
     *
     * @return float
     */
    public function getLessDeposit()
    {
        return $this->less_deposit;
    }

    /**
     * Set payable_on_delivery
     *
     * @param float $payableOnDelivery
     * @return Billing
     */
    public function setPayableOnDelivery($payableOnDelivery)
    {
        $this->payable_on_delivery = $payableOnDelivery;

        return $this;
    }

    /**
     * Get payable_on_delivery
     *
     * @return float
     */
    public function getPayableOnDelivery()
    {
        return $this->payable_on_delivery;
    }

    /**
     * Set balance_to_finance
     *
     * @param float $balanceToFinance
     * @return Billing
     */
    public function setBalanceToFinance($balanceToFinance)
    {
        $this->balance_to_finance = $balanceToFinance;

        return $this;
    }

    /**
     * Get balance_to_finance
     *
     * @return float
     */
    public function getBalanceToFinance()
    {
        return $this->balance_to_finance;
    }

    /**
     * Set insurance
     *
     * @param float $insurance
     * @return Billing
     */
    public function setInsurance($insurance)
    {
        $this->insurance = $insurance;

        return $this;
    }

    /**
     * Get insurance
     *
     * @return float
     */
    public function getInsurance()
    {
        return $this->insurance;
    }

    /**
     * Set bank_registration_fee
     *
     * @param float $bankRegistrationFee
     * @return Billing
     */
    public function setBankRegistrationFee($bankRegistrationFee)
    {
        $this->bank_registration_fee = $bankRegistrationFee;

        return $this;
    }

    /**
     * Get bank_registration_fee
     *
     * @return float
     */
    public function getBankRegistrationFee()
    {
        return $this->bank_registration_fee;
    }

    /**
     * Set total_balance_due
     *
     * @param float $totalBalanceDue
     * @return Billing
     */
    public function setTotalBalanceDue($totalBalanceDue)
    {
        $this->total_balance_due = $totalBalanceDue;

        return $this;
    }

    /**
     * Get total_balance_due
     *
     * @return float
     */
    public function getTotalBalanceDue()
    {
        return $this->total_balance_due;
    }

    /**
     * Set Dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     * @return Billing
     */
    public function setDealer(\Numa\DOAAdminBundle\Entity\Catalogrecords $dealer = null)
    {
        $this->Dealer = $dealer;

        return $this;
    }

    /**
     * Get Dealer
     *
     * @return \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    public function getDealer()
    {
        return $this->Dealer;
    }

    /**
     * Set Item
     *
     * @param \Numa\DOAAdminBundle\Entity\Item $item
     * @return Billing
     */
    public function setItem(\Numa\DOAAdminBundle\Entity\Item $item = null)
    {
        $this->Item = $item;

        return $this;
    }

    /**
     * Get Item
     *
     * @return \Numa\DOAAdminBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->Item;
    }

    /**
     * @var string
     * @JMS\Expose
     */
    private $dealer_nr;


    /**
     * Set dealer_nr
     *
     * @param string $dealerNr
     * @return Billing
     */
    public function setDealerNr($dealerNr)
    {
        $this->dealer_nr = $dealerNr;

        return $this;
    }

    /**
     * Get dealer_nr
     *
     * @return string
     */
    public function getDealerNr()
    {
        return $this->dealer_nr;
    }

    /**
     * @var string
     * @JMS\Expose
     */
    private $taxt1_name;

    /**
     * @var string
     * @JMS\Expose
     */
    private $taxt2_name;

    /**
     * @var string
     * @JMS\Expose
     */
    private $taxt3_name;


    /**
     * Set taxt1Name
     *
     * @param string $taxt1Name
     *
     * @return Billing
     */
    public function setTaxt1Name($taxt1Name)
    {
        $this->taxt1_name = $taxt1Name;

        return $this;
    }

    /**
     * Get taxt1Name
     *
     * @return string
     */
    public function getTaxt1Name()
    {
        return $this->taxt1_name;
    }

    /**
     * Set taxt2Name
     *
     * @param string $taxt2Name
     *
     * @return Billing
     */
    public function setTaxt2Name($taxt2Name)
    {
        $this->taxt2_name = $taxt2Name;

        return $this;
    }

    /**
     * Get taxt2Name
     *
     * @return string
     */
    public function getTaxt2Name()
    {
        return $this->taxt2_name;
    }

    /**
     * Set taxt3Name
     *
     * @param string $taxt3Name
     *
     * @return Billing
     */
    public function setTaxt3Name($taxt3Name)
    {
        $this->taxt3_name = $taxt3Name;

        return $this;
    }

    /**
     * Get taxt3Name
     *
     * @return string
     */
    public function getTaxt3Name()
    {
        return $this->taxt3_name;
    }

    /**
     * @var string
     * @JMS\Expose
     */
    private $new_warranty;

    /**
     * @var string
     * @JMS\Expose
     */
    private $used_warranty;


    /**
     * Set new_warranty
     *
     * @param string $newWarranty
     * @return Billing
     */
    public function setNewWarranty($newWarranty)
    {
        $this->new_warranty = $newWarranty;

        return $this;
    }

    /**
     * Get new_warranty
     *
     * @return string
     */
    public function getNewWarranty()
    {
        return $this->new_warranty;
    }

    /**
     * Set used_warranty
     *
     * @param string $usedWarranty
     * @return Billing
     */
    public function setUsedWarranty($usedWarranty)
    {
        $this->used_warranty = $usedWarranty;

        return $this;
    }

    /**
     * Get used_warranty
     *
     * @return string
     */
    public function getUsedWarranty()
    {
        return $this->used_warranty;
    }

    /**
     * @var string
     */
    private $opt11;

    /**
     * @var string
     */
    private $opteq11;

    /**
     * @var string
     */
    private $opt12;

    /**
     * @var string
     */
    private $opteq12;

    /**
     * @var string
     */
    private $opt13;

    /**
     * @var string
     */
    private $opteq13;

    /**
     * @var string
     */
    private $opt14;

    /**
     * @var string
     */
    private $opteq14;

    /**
     * @var string
     */
    private $opt15;

    /**
     * @var string
     */
    private $opteq15;

    /**
     * @var string
     */
    private $opt16;

    /**
     * @var string
     */
    private $opteq16;

    /**
     * @var string
     */
    private $opt17;

    /**
     * @var string
     */
    private $opteq17;

    /**
     * @var string
     */
    private $opt18;

    /**
     * @var string
     */
    private $opteq18;

    /**
     * @var string
     */
    private $opt19;

    /**
     * @var string
     */
    private $opteq19;

    /**
     * @var string
     */
    private $opt20;

    /**
     * @var string
     */
    private $opteq20;

    /**
     * @var string
     */
    private $opt21;

    /**
     * @var string
     */
    private $opteq21;

    /**
     * @var string
     */
    private $opt22;

    /**
     * @var string
     */
    private $opteq22;

    /**
     * @var string
     */
    private $opt23;

    /**
     * @var string
     */
    private $opteq23;

    /**
     * @var string
     */
    private $opt24;

    /**
     * @var string
     */
    private $opteq24;

    /**
     * @var string
     */
    private $opt25;

    /**
     * @var string
     */
    private $opteq25;


    /**
     * Set opt11
     *
     * @param string $opt11
     *
     * @return Billing
     */
    public function setOpt11($opt11)
    {
        $this->opt11 = $opt11;

        return $this;
    }

    /**
     * Get opt11
     *
     * @return string
     */
    public function getOpt11()
    {
        return $this->opt11;
    }

    /**
     * Set opteq11
     *
     * @param string $opteq11
     *
     * @return Billing
     */
    public function setOpteq11($opteq11)
    {
        $this->opteq11 = $opteq11;

        return $this;
    }

    /**
     * Get opteq11
     *
     * @return string
     */
    public function getOpteq11()
    {
        return $this->opteq11;
    }

    /**
     * Set opt12
     *
     * @param string $opt12
     *
     * @return Billing
     */
    public function setOpt12($opt12)
    {
        $this->opt12 = $opt12;

        return $this;
    }

    /**
     * Get opt12
     *
     * @return string
     */
    public function getOpt12()
    {
        return $this->opt12;
    }

    /**
     * Set opteq12
     *
     * @param string $opteq12
     *
     * @return Billing
     */
    public function setOpteq12($opteq12)
    {
        $this->opteq12 = $opteq12;

        return $this;
    }

    /**
     * Get opteq12
     *
     * @return string
     */
    public function getOpteq12()
    {
        return $this->opteq12;
    }

    /**
     * Set opt13
     *
     * @param string $opt13
     *
     * @return Billing
     */
    public function setOpt13($opt13)
    {
        $this->opt13 = $opt13;

        return $this;
    }

    /**
     * Get opt13
     *
     * @return string
     */
    public function getOpt13()
    {
        return $this->opt13;
    }

    /**
     * Set opteq13
     *
     * @param string $opteq13
     *
     * @return Billing
     */
    public function setOpteq13($opteq13)
    {
        $this->opteq13 = $opteq13;

        return $this;
    }

    /**
     * Get opteq13
     *
     * @return string
     */
    public function getOpteq13()
    {
        return $this->opteq13;
    }

    /**
     * Set opt14
     *
     * @param string $opt14
     *
     * @return Billing
     */
    public function setOpt14($opt14)
    {
        $this->opt14 = $opt14;

        return $this;
    }

    /**
     * Get opt14
     *
     * @return string
     */
    public function getOpt14()
    {
        return $this->opt14;
    }

    /**
     * Set opteq14
     *
     * @param string $opteq14
     *
     * @return Billing
     */
    public function setOpteq14($opteq14)
    {
        $this->opteq14 = $opteq14;

        return $this;
    }

    /**
     * Get opteq14
     *
     * @return string
     */
    public function getOpteq14()
    {
        return $this->opteq14;
    }

    /**
     * Set opt15
     *
     * @param string $opt15
     *
     * @return Billing
     */
    public function setOpt15($opt15)
    {
        $this->opt15 = $opt15;

        return $this;
    }

    /**
     * Get opt15
     *
     * @return string
     */
    public function getOpt15()
    {
        return $this->opt15;
    }

    /**
     * Set opteq15
     *
     * @param string $opteq15
     *
     * @return Billing
     */
    public function setOpteq15($opteq15)
    {
        $this->opteq15 = $opteq15;

        return $this;
    }

    /**
     * Get opteq15
     *
     * @return string
     */
    public function getOpteq15()
    {
        return $this->opteq15;
    }

    /**
     * Set opt16
     *
     * @param string $opt16
     *
     * @return Billing
     */
    public function setOpt16($opt16)
    {
        $this->opt16 = $opt16;

        return $this;
    }

    /**
     * Get opt16
     *
     * @return string
     */
    public function getOpt16()
    {
        return $this->opt16;
    }

    /**
     * Set opteq16
     *
     * @param string $opteq16
     *
     * @return Billing
     */
    public function setOpteq16($opteq16)
    {
        $this->opteq16 = $opteq16;

        return $this;
    }

    /**
     * Get opteq16
     *
     * @return string
     */
    public function getOpteq16()
    {
        return $this->opteq16;
    }

    /**
     * Set opt17
     *
     * @param string $opt17
     *
     * @return Billing
     */
    public function setOpt17($opt17)
    {
        $this->opt17 = $opt17;

        return $this;
    }

    /**
     * Get opt17
     *
     * @return string
     */
    public function getOpt17()
    {
        return $this->opt17;
    }

    /**
     * Set opteq17
     *
     * @param string $opteq17
     *
     * @return Billing
     */
    public function setOpteq17($opteq17)
    {
        $this->opteq17 = $opteq17;

        return $this;
    }

    /**
     * Get opteq17
     *
     * @return string
     */
    public function getOpteq17()
    {
        return $this->opteq17;
    }

    /**
     * Set opt18
     *
     * @param string $opt18
     *
     * @return Billing
     */
    public function setOpt18($opt18)
    {
        $this->opt18 = $opt18;

        return $this;
    }

    /**
     * Get opt18
     *
     * @return string
     */
    public function getOpt18()
    {
        return $this->opt18;
    }

    /**
     * Set opteq18
     *
     * @param string $opteq18
     *
     * @return Billing
     */
    public function setOpteq18($opteq18)
    {
        $this->opteq18 = $opteq18;

        return $this;
    }

    /**
     * Get opteq18
     *
     * @return string
     */
    public function getOpteq18()
    {
        return $this->opteq18;
    }

    /**
     * Set opt19
     *
     * @param string $opt19
     *
     * @return Billing
     */
    public function setOpt19($opt19)
    {
        $this->opt19 = $opt19;

        return $this;
    }

    /**
     * Get opt19
     *
     * @return string
     */
    public function getOpt19()
    {
        return $this->opt19;
    }

    /**
     * Set opteq19
     *
     * @param string $opteq19
     *
     * @return Billing
     */
    public function setOpteq19($opteq19)
    {
        $this->opteq19 = $opteq19;

        return $this;
    }

    /**
     * Get opteq19
     *
     * @return string
     */
    public function getOpteq19()
    {
        return $this->opteq19;
    }

    /**
     * Set opt20
     *
     * @param string $opt20
     *
     * @return Billing
     */
    public function setOpt20($opt20)
    {
        $this->opt20 = $opt20;

        return $this;
    }

    /**
     * Get opt20
     *
     * @return string
     */
    public function getOpt20()
    {
        return $this->opt20;
    }

    /**
     * Set opteq20
     *
     * @param string $opteq20
     *
     * @return Billing
     */
    public function setOpteq20($opteq20)
    {
        $this->opteq20 = $opteq20;

        return $this;
    }

    /**
     * Get opteq20
     *
     * @return string
     */
    public function getOpteq20()
    {
        return $this->opteq20;
    }

    /**
     * Set opt21
     *
     * @param string $opt21
     *
     * @return Billing
     */
    public function setOpt21($opt21)
    {
        $this->opt21 = $opt21;

        return $this;
    }

    /**
     * Get opt21
     *
     * @return string
     */
    public function getOpt21()
    {
        return $this->opt21;
    }

    /**
     * Set opteq21
     *
     * @param string $opteq21
     *
     * @return Billing
     */
    public function setOpteq21($opteq21)
    {
        $this->opteq21 = $opteq21;

        return $this;
    }

    /**
     * Get opteq21
     *
     * @return string
     */
    public function getOpteq21()
    {
        return $this->opteq21;
    }

    /**
     * Set opt22
     *
     * @param string $opt22
     *
     * @return Billing
     */
    public function setOpt22($opt22)
    {
        $this->opt22 = $opt22;

        return $this;
    }

    /**
     * Get opt22
     *
     * @return string
     */
    public function getOpt22()
    {
        return $this->opt22;
    }

    /**
     * Set opteq22
     *
     * @param string $opteq22
     *
     * @return Billing
     */
    public function setOpteq22($opteq22)
    {
        $this->opteq22 = $opteq22;

        return $this;
    }

    /**
     * Get opteq22
     *
     * @return string
     */
    public function getOpteq22()
    {
        return $this->opteq22;
    }

    /**
     * Set opt23
     *
     * @param string $opt23
     *
     * @return Billing
     */
    public function setOpt23($opt23)
    {
        $this->opt23 = $opt23;

        return $this;
    }

    /**
     * Get opt23
     *
     * @return string
     */
    public function getOpt23()
    {
        return $this->opt23;
    }

    /**
     * Set opteq23
     *
     * @param string $opteq23
     *
     * @return Billing
     */
    public function setOpteq23($opteq23)
    {
        $this->opteq23 = $opteq23;

        return $this;
    }

    /**
     * Get opteq23
     *
     * @return string
     */
    public function getOpteq23()
    {
        return $this->opteq23;
    }

    /**
     * Set opt24
     *
     * @param string $opt24
     *
     * @return Billing
     */
    public function setOpt24($opt24)
    {
        $this->opt24 = $opt24;

        return $this;
    }

    /**
     * Get opt24
     *
     * @return string
     */
    public function getOpt24()
    {
        return $this->opt24;
    }

    /**
     * Set opteq24
     *
     * @param string $opteq24
     *
     * @return Billing
     */
    public function setOpteq24($opteq24)
    {
        $this->opteq24 = $opteq24;

        return $this;
    }

    /**
     * Get opteq24
     *
     * @return string
     */
    public function getOpteq24()
    {
        return $this->opteq24;
    }

    /**
     * Set opt25
     *
     * @param string $opt25
     *
     * @return Billing
     */
    public function setOpt25($opt25)
    {
        $this->opt25 = $opt25;

        return $this;
    }

    /**
     * Get opt25
     *
     * @return string
     */
    public function getOpt25()
    {
        return $this->opt25;
    }

    /**
     * Set opteq25
     *
     * @param string $opteq25
     *
     * @return Billing
     */
    public function setOpteq25($opteq25)
    {
        $this->opteq25 = $opteq25;

        return $this;
    }

    /**
     * Get opteq25
     *
     * @return string
     */
    public function getOpteq25()
    {
        return $this->opteq25;
    }

    /**
     * @var string
     * @JMS\Expose
     */
    private $invoice_nr;


    /**
     * Set invoiceNr
     *
     * @param string $invoiceNr
     *
     * @return Billing
     */
    public function setInvoiceNr($invoiceNr)
    {
        $this->invoice_nr = $invoiceNr;

        return $this;
    }

    /**
     * Get invoiceNr
     *
     * @return string
     */
    public function getInvoiceNr()
    {
        return $this->invoice_nr;
    }

    public function get($property)
    {
        $propSplit = explode(":",$property);
        $function = 'get' . str_ireplace(array(" ", "_"), '', ucfirst($property));
        if(count($propSplit)==2){
            if(strtolower($propSplit[0])=='item'){
                if($this->getItem() instanceof Item) {
                    return $this->getItem()->get($propSplit[1]);
                }else{
                    return "";
                }
            }
            if(strtolower($propSplit[0])=='customer'){
                if($this->getCustomer() instanceof Customer) {
                    $function = 'get' . str_ireplace(array(" ", "_"), '', ucfirst($propSplit[1]));
                    return $this->getCustomer()->{$function}();
                }else{
                    return "";
                }
            }
        }

        if (method_exists($this, $function)) {
            return $this->{$function}();
        }
    }

    /**
     * @var float
     * @JMS\Expose
     */
    private $life_insurance;

    /**
     * @var float
     * @JMS\Expose
     */
    private $disability_insurance;


    /**
     * Set lifeInsurance
     *
     * @param float $lifeInsurance
     *
     * @return Billing
     */
    public function setLifeInsurance($lifeInsurance)
    {
        $this->life_insurance = $lifeInsurance;

        return $this;
    }

    /**
     * Get lifeInsurance
     *
     * @return float
     */
    public function getLifeInsurance()
    {
        return $this->life_insurance;
    }

    /**
     * Set disabilityInsurance
     *
     * @param float $disabilityInsurance
     *
     * @return Billing
     */
    public function setDisabilityInsurance($disabilityInsurance)
    {
        $this->disability_insurance = $disabilityInsurance;

        return $this;
    }

    /**
     * Get disabilityInsurance
     *
     * @return float
     */
    public function getDisabilityInsurance()
    {
        return $this->disability_insurance;
    }
    /**
     * @var boolean
     * @JMS\Expose
     */
    private $work_order;


    /**
     * Set workOrder
     *
     * @param boolean $workOrder
     *
     * @return Billing
     */
    public function setWorkOrder($workOrder)
    {
        $this->work_order = $workOrder;

        return $this;
    }

    /**
     * Get workOrder
     *
     * @return boolean
     */
    public function getWorkOrder()
    {
        return $this->work_order;
    }
    /**
     * @var boolean
     * @JMS\Expose
     */
    private $active=true;


    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Billing
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * @var string
     * @JMS\Expose
     */
    private $tid_color;


    /**
     * Set tidColor
     *
     * @param string $tidColor
     *
     * @return Billing
     */
    public function setTidColor($tidColor)
    {
        $this->tid_color = $tidColor;

        return $this;
    }

    /**
     * Get tidColor
     *
     * @return string
     */
    public function getTidColor()
    {
        return $this->tid_color;
    }
    /**
     * @var boolean
     */
    private $qb_post_include = false;


    /**
     * Set qbPostInclude
     *
     * @param boolean $qbPostInclude
     *
     * @return Billing
     */
    public function setQbPostInclude($qbPostInclude)
    {
        $this->qb_post_include = $qbPostInclude;

        return $this;
    }

    /**
     * Get qbPostInclude
     *
     * @return boolean
     */
    public function getQbPostInclude()
    {
        return $this->qb_post_include;
    }
}
