<?php

namespace Numa\DOADMSBundle\Entity;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;

/**
 * Sale
 */
class Sale
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $vendor_id;

    /**
     * @var integer
     */
    private $item_id;

    /**
     * @var string
     */
    private $sales_person;

    /**
     * @var string
     */
    private $stock_nr;

    /**
     * @var string
     */
    private $vin;

    /**
     * @var string
     */
    private $invoice_nr;

    /**
     * @var \DateTime
     */
    private $invoice_date;



    /**
     * @var float
     */
    private $related_taxes_1;

    /**
     * @var float
     */
    private $related_taxes_2;

    /**
     * @var float
     */
    private $delivery;

    /**
     * @var float
     */
    private $clear_up;

    /**
     * @var float
     */
    private $glass;

    /**
     * @var float
     */
    private $mechanical_1;

    /**
     * @var float
     */
    private $mechanical_2;

    /**
     * @var float
     */
    private $other_exp_1;

    /**
     * @var float
     */
    private $other_exp_2;

    /**
     * @var float
     */
    private $other_exp_3;

    /**
     * @var float
     */
    private $other_exp_4;

    /**
     * @var float
     */
    private $other_exp_5;

    /**
     * @var float
     */
    private $total_unit_cost;

    /**
     * @var float
     */
    private $protect_pkg;

    /**
     * @var float
     */
    private $warranty;

    /**
     * @var float
     */
    private $doc_fees;

    /**
     * @var float
     */
    private $admin_fees;

    /**
     * @var float
     */
    private $insurance;

    /**
     * @var float
     */
    private $life_ins;

    /**
     * @var float
     */
    private $disability_ins;

    /**
     * @var float
     */
    private $feverse;

    /**
     * @var float
     */
    private $misc_1;

    /**
     * @var float
     */
    private $misc_2;

    /**
     * @var float
     */
    private $misc_3;

    /**
     * @var float
     */
    private $sales_comms;

    /**
     * @var float
     */
    private $total_sale_cost;

    /**
     * @var float
     */
    private $tax_1_out;

    /**
     * @var float
     */
    private $tax_2_out;

    /**
     * @var float
     */
    private $trade_in_tax;

    /**
     * @var float
     */
    private $tax_1_in;

    /**
     * @var float
     */
    private $tax_2_in;

    /**
     * @var float
     */
    private $net_tax;

    /**
     * @var float
     */
    private $selling_price;

    /**
     * @var float
     */
    private $trade_in;

    /**
     * @var float
     */
    private $warranty1;

    /**
     * @var float
     */
    private $life_insur;

    /**
     * @var float
     */
    private $disability_ins1;

    /**
     * @var float
     */
    private $admin_fees1;

    /**
     * @var float
     */
    private $doc_fees1;

    /**
     * @var float
     */
    private $protect_pkg1;

    /**
     * @var float
     */
    private $insurance1;

    /**
     * @var float
     */
    private $bank_commis;

    /**
     * @var float
     */
    private $other_1;

    /**
     * @var float
     */
    private $other_2;

    /**
     * @var float
     */
    private $other_3;

    /**
     * @var float
     */
    private $total_revenue;

    /**
     * @var float
     */
    private $revenue_this_unit;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Item
     */
    private $Item;


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
     * Set vendorId
     *
     * @param integer $vendorId
     *
     * @return Sale
     */
    public function setVendorId($vendorId)
    {
        $this->vendor_id = $vendorId;

        return $this;
    }

    /**
     * Get vendorId
     *
     * @return integer
     */
    public function getVendorId()
    {
        return $this->vendor_id;
    }

    /**
     * Set itemId
     *
     * @param integer $itemId
     *
     * @return Sale
     */
    public function setItemId($itemId)
    {
        $this->item_id = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return integer
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Set salesPerson
     *
     * @param string $salesPerson
     *
     * @return Sale
     */
    public function setSalesPerson($salesPerson)
    {
        $this->sales_person = $salesPerson;

        return $this;
    }

    /**
     * Get salesPerson
     *
     * @return string
     */
    public function getSalesPerson()
    {
        return $this->sales_person;
    }

    /**
     * Set stockNr
     *
     * @param string $stockNr
     *
     * @return Sale
     */
    public function setStockNr($stockNr)
    {
        $this->stock_nr = $stockNr;

        return $this;
    }

    /**
     * Get stockNr
     *
     * @return string
     */
    public function getStockNr()
    {
        return $this->stock_nr;
    }

    /**
     * Set vin
     *
     * @param string $vin
     *
     * @return Sale
     */
    public function setVin($vin)
    {
        $this->vin = $vin;

        return $this;
    }

    /**
     * Get vin
     *
     * @return string
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * Set invoiceNr
     *
     * @param string $invoiceNr
     *
     * @return Sale
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

    /**
     * Set invoiceDate
     *
     * @param \DateTime $invoiceDate
     *
     * @return Sale
     */
    public function setInvoiceDate($invoiceDate)
    {
        $this->invoice_date = $invoiceDate;

        return $this;
    }

    /**
     * Get invoiceDate
     *
     * @return \DateTime
     */
    public function getInvoiceDate()
    {
        return $this->invoice_date;
    }


    /**
     * Get invoiceDate
     *
     * @return \DateTime
     */
    public function getInvoiceDateFormated()
    {
        if($this->getInvoiceDate() instanceof \DateTime) {
            return $this->invoice_date->format("Y-m-d");
        }
    }



    /**
     * Set relatedTaxes1
     *
     * @param float $relatedTaxes1
     *
     * @return Sale
     */
    public function setRelatedTaxes1($relatedTaxes1)
    {
        $this->related_taxes_1 = $relatedTaxes1;

        return $this;
    }

    /**
     * Get relatedTaxes1
     *
     * @return float
     */
    public function getRelatedTaxes1()
    {
        return number_format((float)$this->related_taxes_1,2, '.', '');
    }

    /**
     * Set relatedTaxes2
     *
     * @param float $relatedTaxes2
     *
     * @return Sale
     */
    public function setRelatedTaxes2($relatedTaxes2)
    {
        $this->related_taxes_2 = $relatedTaxes2;

        return $this;
    }

    /**
     * Get relatedTaxes2
     *
     * @return float
     */
    public function getRelatedTaxes2()
    {
        return number_format((float)$this->related_taxes_2,2, '.', '');
    }

    /**
     * Set delivery
     *
     * @param float $delivery
     *
     * @return Sale
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * Get delivery
     *
     * @return float
     */
    public function getDelivery()
    {
        return number_format((float)$this->delivery,2, '.', '');
    }

    /**
     * Set clearUp
     *
     * @param float $clearUp
     *
     * @return Sale
     */
    public function setClearUp($clearUp)
    {
        $this->clear_up = $clearUp;

        return $this;
    }

    /**
     * Get clearUp
     *
     * @return float
     */
    public function getClearUp()
    {
        return number_format((float)$this->clear_up,2, '.', '');
    }

    /**
     * Set glass
     *
     * @param float $glass
     *
     * @return Sale
     */
    public function setGlass($glass)
    {
        $this->glass = $glass;

        return $this;
    }

    /**
     * Get glass
     *
     * @return float
     */
    public function getGlass()
    {
        return number_format((float)$this->glass,2, '.', '');
    }

    /**
     * Set mechanical1
     *
     * @param float $mechanical1
     *
     * @return Sale
     */
    public function setMechanical1($mechanical1)
    {
        $this->mechanical_1 = $mechanical1;

        return $this;
    }

    /**
     * Get mechanical1
     *
     * @return float
     */
    public function getMechanical1()
    {
        return number_format((float)$this->mechanical_1,2, '.', '');
    }

    /**
     * Set mechanical2
     *
     * @param float $mechanical2
     *
     * @return Sale
     */
    public function setMechanical2($mechanical2)
    {
        $this->mechanical_2 = $mechanical2;

        return $this;
    }

    /**
     * Get mechanical2
     *
     * @return float
     */
    public function getMechanical2()
    {
        return number_format((float)$this->mechanical_2,2, '.', '');
    }

    /**
     * Set otherExp1
     *
     * @param float $otherExp1
     *
     * @return Sale
     */
    public function setOtherExp1($otherExp1)
    {
        $this->other_exp_1 = $otherExp1;

        return $this;
    }

    /**
     * Get otherExp1
     *
     * @return float
     */
    public function getOtherExp1()
    {
        return number_format((float)$this->other_exp_1,2, '.', '');
    }

    /**
     * Set otherExp2
     *
     * @param float $otherExp2
     *
     * @return Sale
     */
    public function setOtherExp2($otherExp2)
    {
        $this->other_exp_2 = $otherExp2;

        return $this;
    }

    /**
     * Get otherExp2
     *
     * @return float
     */
    public function getOtherExp2()
    {
        return number_format((float)$this->other_exp_2,2, '.', '');
    }

    /**
     * Set otherExp3
     *
     * @param float $otherExp3
     *
     * @return Sale
     */
    public function setOtherExp3($otherExp3)
    {
        $this->other_exp_3 = $otherExp3;

        return $this;
    }

    /**
     * Get otherExp3
     *
     * @return float
     */
    public function getOtherExp3()
    {
        return number_format((float)$this->other_exp_3,2, '.', '');
    }

    /**
     * Set otherExp4
     *
     * @param float $otherExp4
     *
     * @return Sale
     */
    public function setOtherExp4($otherExp4)
    {
        $this->other_exp_4 = $otherExp4;

        return $this;
    }

    /**
     * Get otherExp4
     *
     * @return float
     */
    public function getOtherExp4()
    {
        return number_format((float)$this->other_exp_4,2, '.', '');
    }

    /**
     * Set otherExp5
     *
     * @param float $otherExp5
     *
     * @return Sale
     */
    public function setOtherExp5($otherExp5)
    {
        $this->other_exp_5 = $otherExp5;

        return $this;
    }

    /**
     * Get otherExp5
     *
     * @return float
     */
    public function getOtherExp5()
    {
        return number_format((float)$this->other_exp_5,2, '.', '');
    }

    /**
     * Set totalUnitCost
     *
     * @param float $totalUnitCost
     *
     * @return Sale
     */
    public function setTotalUnitCost($totalUnitCost)
    {
        $this->total_unit_cost = $totalUnitCost;

        return $this;
    }

    /**
     * Get totalUnitCost
     *
     * @return float
     */
    public function getTotalUnitCost()
    {

        $this->total_unit_cost = number_format((float)$this->getInvoiceAmt() + $this->getDelivery() + $this->getCleanUp() + $this->getGlass() + $this->getMechanical1() + $this->getMechanical2() + $this->getOtherExp1() + $this->getOtherExp2() + $this->getOtherExp3() + $this->getOtherExp4() + $this->getOtherExp5(),2, '.', '');
        return $this->total_unit_cost;
    }

    /**
     * Set protectPkg
     *
     * @param float $protectPkg
     *
     * @return Sale
     */
    public function setProtectPkg($protectPkg)
    {
        $this->protect_pkg = $protectPkg;

        return $this;
    }

    /**
     * Get protectPkg
     *
     * @return float
     */
    public function getProtectPkg()
    {
        return number_format((float)$this->protect_pkg,2, '.', '');
    }

    /**
     * Set warranty
     *
     * @param float $warranty
     *
     * @return Sale
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
        return number_format((float)$this->warranty,2, '.', '');
    }

    /**
     * Set docFees
     *
     * @param float $docFees
     *
     * @return Sale
     */
    public function setDocFees($docFees)
    {
        $this->doc_fees = $docFees;

        return $this;
    }

    /**
     * Get docFees
     *
     * @return float
     */
    public function getDocFees()
    {
        return number_format((float)$this->doc_fees,2, '.', '');
    }

    /**
     * Set adminFees
     *
     * @param float $adminFees
     *
     * @return Sale
     */
    public function setAdminFees($adminFees)
    {
        $this->admin_fees = $adminFees;

        return $this;
    }

    /**
     * Get adminFees
     *
     * @return float
     */
    public function getAdminFees()
    {
        return number_format((float)$this->admin_fees,2, '.', '');
    }

    /**
     * Set insurance
     *
     * @param float $insurance
     *
     * @return Sale
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
        return number_format((float)$this->insurance,2, '.', '');
    }

    /**
     * Set lifeIns
     *
     * @param float $lifeIns
     *
     * @return Sale
     */
    public function setLifeIns($lifeIns)
    {
        $this->life_ins = $lifeIns;

        return $this;
    }

    /**
     * Get lifeIns
     *
     * @return float
     */
    public function getLifeIns()
    {
        return number_format((float)$this->life_ins,2, '.', '');
    }

    /**
     * Set disabilityIns
     *
     * @param float $disabilityIns
     *
     * @return Sale
     */
    public function setDisabilityIns($disabilityIns)
    {
        $this->disability_ins = $disabilityIns;

        return $this;
    }

    /**
     * Get disabilityIns
     *
     * @return float
     */
    public function getDisabilityIns()
    {
        return number_format((float)$this->disability_ins,2, '.', '');
    }

    /**
     * Set feverse
     *
     * @param float $feverse
     *
     * @return Sale
     */
    public function setFeverse($feverse)
    {
        $this->feverse = $feverse;

        return $this;
    }

    /**
     * Get feverse
     *
     * @return float
     */
    public function getFeverse()
    {
        return number_format((float)$this->feverse,2, '.', '');
    }

    /**
     * Set misc1
     *
     * @param float $misc1
     *
     * @return Sale
     */
    public function setMisc1($misc1)
    {
        $this->misc_1 = $misc1;

        return $this;
    }

    /**
     * Get misc1
     *
     * @return float
     */
    public function getMisc1()
    {
        return number_format((float)$this->misc_1,2, '.', '');
    }

    /**
     * Set misc2
     *
     * @param float $misc2
     *
     * @return Sale
     */
    public function setMisc2($misc2)
    {
        $this->misc_2 = $misc2;

        return $this;
    }

    /**
     * Get misc2
     *
     * @return float
     */
    public function getMisc2()
    {
        return number_format((float)$this->misc_2,2, '.', '');
    }

    /**
     * Set misc3
     *
     * @param float $misc3
     *
     * @return Sale
     */
    public function setMisc3($misc3)
    {
        $this->misc_3 = $misc3;

        return $this;
    }

    /**
     * Get misc3
     *
     * @return float
     */
    public function getMisc3()
    {
        return number_format((float)$this->misc_3,2, '.', '');
    }

    /**
     * Set salesComms
     *
     * @param float $salesComms
     *
     * @return Sale
     */
    public function setSalesComms($salesComms)
    {
        $this->sales_comms = $salesComms;
        return $this;
    }

    /**
     * Get salesComms
     *
     * @return float
     */
    public function getSalesComms()
    {
        return number_format((float)$this->sales_comms,2, '.', '');
    }

    /**
     * Set totalSaleCost
     *
     * @param float $totalSaleCost
     *
     * @return Sale
     */
    public function setTotalSaleCost($totalSaleCost)
    {
        $this->total_sale_cost = $totalSaleCost;

        return $this;
    }

    /**
     * Get totalSaleCost
     *
     * @return float
     */
    public function getTotalSaleCost()
    {
        $this->total_sale_cost= number_format((float)$this->getProtectPkg() + $this->getWarranty() + $this->getDocFees() + $this->getAdminFees() + $this->getInsurance() + $this->getLifeIns() + $this->getDisabilityIns() + $this->getFeverse() + $this->getMisc1() + $this->getMisc2() + $this->getMisc3() + $this->getSalesComms(),2, '.', '');
        return $this->total_sale_cost;
    }

    /**
     * Set tax1Out
     *
     * @param float $tax1Out
     *
     * @return Sale
     */
    public function setTax1Out($tax1Out)
    {
        $this->tax_1_out = $tax1Out;

        return $this;
    }

    /**
     * Get tax1Out
     *
     * @return float
     */
    public function getTax1Out()
    {
        return number_format((float)$this->tax_1_out,2, '.', '');
    }

    /**
     * Set tax2Out
     *
     * @param float $tax2Out
     *
     * @return Sale
     */
    public function setTax2Out($tax2Out)
    {
        $this->tax_2_out = $tax2Out;

        return $this;
    }

    /**
     * Get tax2Out
     *
     * @return float
     */
    public function getTax2Out()
    {
        return number_format((float)$this->tax_2_out,2, '.', '');
    }

    /**
     * Set tradeInTax
     *
     * @param float $tradeInTax
     *
     * @return Sale
     */
    public function setTradeInTax($tradeInTax)
    {
        $this->trade_in_tax = $tradeInTax;

        return $this;
    }

    /**
     * Get tradeInTax
     *
     * @return float
     */
    public function getTradeInTax()
    {
        return number_format((float)$this->trade_in_tax,2, '.', '');
    }

    /**
     * Set tax1In
     *
     * @param float $tax1In
     *
     * @return Sale
     */
    public function setTax1In($tax1In)
    {
        $this->tax_1_in = $tax1In;

        return $this;
    }

    /**
     * Get tax1In
     *
     * @return float
     */
    public function getTax1In()
    {
        return number_format((float)$this->tax_1_in,2, '.', '');
    }

    /**
     * Set tax2In
     *
     * @param float $tax2In
     *
     * @return Sale
     */
    public function setTax2In($tax2In)
    {
        $this->tax_2_in = $tax2In;

        return $this;
    }

    /**
     * Get tax2In
     *
     * @return float
     */
    public function getTax2In()
    {
        return number_format((float)$this->tax_2_in,2, '.', '');
    }

    /**
     * Set netTax
     *
     * @param float $netTax
     *
     * @return Sale
     */
    public function setNetTax($netTax)
    {
        $this->net_tax = $netTax;

        return $this;
    }

    /**
     * Get netTax
     *
     * @return float
     */
    public function getNetTax()
    {
        $this->net_tax = number_format((float)($this->getTax1Out() + $this->getTax2Out() + $this->getUnitTaxOther()) - (($this->getTax1In() + $this->getTax2In()) + $this->getTradeInTax()),2, '.', '');
        return $this->net_tax;
    }

    /**
     * Set sellingPrice
     *
     * @param float $sellingPrice
     *
     * @return Sale
     */
    public function setSellingPrice($sellingPrice)
    {
        $this->selling_price = $sellingPrice;

        return $this;
    }

    /**
     * Get sellingPrice
     *
     * @return float
     */
    public function getSellingPrice()
    {
        return number_format((float)$this->selling_price,2, '.', '');
    }

    /**
     * Set tradeIn
     *
     * @param float $tradeIn
     *
     * @return Sale
     */
    public function setTradeIn($tradeIn)
    {
        $this->trade_in = $tradeIn;

        return $this;
    }

    /**
     * Get tradeIn
     *
     * @return float
     */
    public function getTradeIn()
    {
        return number_format((float)$this->trade_in,2, '.', '');
    }

    /**
     * Set warranty1
     *
     * @param float $warranty1
     *
     * @return Sale
     */
    public function setWarranty1($warranty1)
    {
        $this->warranty1 = $warranty1;

        return $this;
    }

    /**
     * Get warranty1
     *
     * @return float
     */
    public function getWarranty1()
    {
        return number_format((float)$this->warranty1,2, '.', '');
    }

    /**
     * Set lifeInsur
     *
     * @param float $lifeInsur
     *
     * @return Sale
     */
    public function setLifeInsur($lifeInsur)
    {
        $this->life_insur = $lifeInsur;

        return $this;
    }

    /**
     * Get lifeInsur
     *
     * @return float
     */
    public function getLifeInsur()
    {
        return number_format((float)$this->life_insur,2, '.', '');
    }

    /**
     * Set disabilityIns1
     *
     * @param float $disabilityIns1
     *
     * @return Sale
     */
    public function setDisabilityIns1($disabilityIns1)
    {
        $this->disability_ins1 = $disabilityIns1;

        return $this;
    }

    /**
     * Get disabilityIns1
     *
     * @return float
     */
    public function getDisabilityIns1()
    {
        return number_format((float)$this->disability_ins1,2, '.', '');
    }

    /**
     * Set adminFees1
     *
     * @param float $adminFees1
     *
     * @return Sale
     */
    public function setAdminFees1($adminFees1)
    {
        $this->admin_fees1 = $adminFees1;

        return $this;
    }

    /**
     * Get adminFees1
     *
     * @return float
     */
    public function getAdminFees1()
    {
        return number_format((float)$this->admin_fees1,2, '.', '');
    }

    /**
     * Set docFees1
     *
     * @param float $docFees1
     *
     * @return Sale
     */
    public function setDocFees1($docFees1)
    {
        $this->doc_fees1 = $docFees1;

        return $this;
    }

    /**
     * Get docFees1
     *
     * @return float
     */
    public function getDocFees1()
    {
        return number_format((float)$this->doc_fees1,2, '.', '');
    }

    /**
     * Set protectPkg1
     *
     * @param float $protectPkg1
     *
     * @return Sale
     */
    public function setProtectPkg1($protectPkg1)
    {
        $this->protect_pkg1 = $protectPkg1;

        return $this;
    }

    /**
     * Get protectPkg1
     *
     * @return float
     */
    public function getProtectPkg1()
    {
        return number_format((float)$this->protect_pkg1,2, '.', '');
    }

    /**
     * Set insurance1
     *
     * @param float $insurance1
     *
     * @return Sale
     */
    public function setInsurance1($insurance1)
    {
        $this->insurance1 = $insurance1;

        return $this;
    }

    /**
     * Get insurance1
     *
     * @return float
     */
    public function getInsurance1()
    {
        return number_format((float)$this->insurance1,2, '.', '');
    }

    /**
     * Set bankCommis
     *
     * @param float $bankCommis
     *
     * @return Sale
     */
    public function setBankCommis($bankCommis)
    {
        $this->bank_commis = $bankCommis;

        return $this;
    }

    /**
     * Get bankCommis
     *
     * @return float
     */
    public function getBankCommis()
    {
        return number_format((float)$this->bank_commis,2, '.', '');
    }

    /**
     * Set other1
     *
     * @param float $other1
     *
     * @return Sale
     */
    public function setOther1($other1)
    {
        $this->other_1 = $other1;

        return $this;
    }

    /**
     * Get other1
     *
     * @return float
     */
    public function getOther1()
    {
        return number_format((float)$this->other_1,2, '.', '');
    }

    /**
     * Set other2
     *
     * @param float $other2
     *
     * @return Sale
     */
    public function setOther2($other2)
    {
        $this->other_2 = $other2;

        return $this;
    }

    /**
     * Get other2
     *
     * @return float
     */
    public function getOther2()
    {
        return number_format((float)$this->other_2,2, '.', '');
    }

    /**
     * Set other3
     *
     * @param float $other3
     *
     * @return Sale
     */
    public function setOther3($other3)
    {
        $this->other_3 = $other3;

        return $this;
    }

    /**
     * Get other3
     *
     * @return float
     */
    public function getOther3()
    {
        return number_format((float)$this->other_3,2, '.', '');
    }

    /**
     * Set totalRevenue
     *
     * @param float $totalRevenue
     *
     * @return Sale
     */
    public function setTotalRevenue($totalRevenue)
    {
        $this->total_revenue = $totalRevenue;

        return $this;
    }

    /**
     * Get totalRevenue
     *
     * @return float
     */
    public function getTotalRevenue()
    {
        $this->total_revenue = number_format((float)$this->getSellingPrice() + $this->getTradeIn() + $this->getWarranty1() + $this->getLifeInsur() + $this->getDisabilityIns1() + $this->getAdminFees1() + $this->getDocFees1() + $this->getProtectPkg1() + $this->getInsurance1() + $this->getBankCommis() + $this->getOther1() + $this->getOther2() + $this->getOther3(),2, '.', '');
        return $this->total_revenue;
    }

    /**
     * Set revenueThisUnit
     *
     * @param float $revenueThisUnit
     *
     * @return Sale
     */
    public function setRevenueThisUnit($revenueThisUnit)
    {
        $this->revenue_this_unit = $revenueThisUnit;

        return $this;
    }

    /**
     * Get revenueThisUnit
     *
     * @return float
     */
    public function getRevenueThisUnit()
    {
        $this->revenue_this_unit = number_format((float)$this->getTotalRevenue()-($this->getTotalUnitCost() + $this->getTotalSaleCost()),2, '.', '');
        return $this->revenue_this_unit;
    }

    /**
     * Set vendor
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendor
     *
     * @return Sale
     */
    public function setVendor(\Numa\DOADMSBundle\Entity\Vendor $vendor = null)
    {
        $this->Vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendor()
    {
        return $this->Vendor;
    }

    /**
     * Set item
     *
     * @param \Numa\DOAAdminBundle\Entity\Item $item
     *
     * @return Sale
     */
    public function setItem(\Numa\DOAAdminBundle\Entity\Item $item = null)
    {
        $this->Item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \Numa\DOAAdminBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->Item;
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
        if(empty($this->dontupdate)){

            $this->date_updated = new \DateTime();
        }
    }
    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var \DateTime
     */
    private $date_updated;

    /**
     * @var string
     */
    private $status;


    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Sale
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
     * @return Sale
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
     * @return Sale
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
     * @var float
     */
    private $invoice_amt;

    /**
     * @var float
     */
    private $clean_up;


    /**
     * Set invoiceAmt
     *
     * @param float $invoiceAmt
     *
     * @return Sale
     */
    public function setInvoiceAmt($invoiceAmt)
    {
        $this->invoice_amt = $invoiceAmt;

        return $this;
    }

    /**
     * Get invoiceAmt
     *
     * @return float
     */
    public function getInvoiceAmt()
    {
        return number_format((float)$this->invoice_amt,2, '.', '');
    }

    /**
     * Set cleanUp
     *
     * @param float $cleanUp
     *
     * @return Sale
     */
    public function setCleanUp($cleanUp)
    {
        $this->clean_up = $cleanUp;

        return $this;
    }

    /**
     * Get cleanUp
     *
     * @return float
     */
    public function getCleanUp()
    {
        return number_format((float)$this->clean_up,2, '.', '');
    }

    /**
     * Get supplier2
     *
     * @return string
     */
    public function getSupplier2()
    {
        return $this->supplier2;
    }
    /**
     * @var float
     */
    private $net_gain;


    /**
     * Set netGain
     *
     * @param float $netGain
     *
     * @return Sale
     */
    public function setNetGain($netGain)
    {
        $this->net_gain = $netGain;

        return $this;
    }

    /**
     * Get netGain
     *
     * @return float
     */
    public function getNetGain()
    {
        $this->net_gain = number_format((float)($this->getSellingPrice() + $this->getTradeIn()) - $this->getTotalUnitCost(),2, '.', '');
        return $this->net_gain;
    }
    /**
     * @var string
     */
    private $other_1_des;

    /**
     * @var string
     */
    private $other_2_des;


    /**
     * Set other1Des
     *
     * @param string $other1Des
     *
     * @return Sale
     */
    public function setOther1Des($other1Des)
    {
        $this->other_1_des = $other1Des;

        return $this;
    }

    /**
     * Get other1Des
     *
     * @return string
     */
    public function getOther1Des()
    {
        return $this->other_1_des;
    }

    /**
     * Set other2Des
     *
     * @param string $other2Des
     *
     * @return Sale
     */
    public function setOther2Des($other2Des)
    {
        $this->other_2_des = $other2Des;

        return $this;
    }

    /**
     * Get other2Des
     *
     * @return string
     */
    public function getOther2Des()
    {
        return $this->other_2_des;
    }
    /**
     * @var string
     */
    private $other_3_des;


    /**
     * Set other3Des
     *
     * @param string $other3Des
     *
     * @return Sale
     */
    public function setOther3Des($other3Des)
    {
        $this->other_3_des = $other3Des;

        return $this;
    }

    /**
     * Get other3Des
     *
     * @return string
     */
    public function getOther3Des()
    {
        return $this->other_3_des;
    }
    /**
     * @var float
     */
    private $unit_tax_other;


    /**
     * Set unitTaxOther
     *
     * @param float $unitTaxOther
     *
     * @return Sale
     */
    public function setUnitTaxOther($unitTaxOther)
    {
        $this->unit_tax_other = $unitTaxOther;

        return $this;
    }

    /**
     * Get unitTaxOther
     *
     * @return float
     */
    public function getUnitTaxOther()
    {
        $this->unit_tax_other = number_format((float)$this->getGstDelivery()+$this->getGstCleanUp()+$this->getGstGlass()+$this->getGstMechanical1()+$this->getGstMechanical2()+$this->getGstOtherExp1()+$this->getGstOtherExp2()+$this->getGstOtherExp3()+$this->getGstOtherExp4()+$this->getGstOtherExp5(),2, '.', '');
        return $this->unit_tax_other;
    }

//    public function __toString()
//    {
//        return $this->id."";
//        // TODO: Implement __toString() method.
//    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $SaleRelatedDoc;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->SaleRelatedDoc = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add saleRelatedDoc
     *
     * @param \Numa\DOADMSBundle\Entity\SaleRelatedDoc $saleRelatedDoc
     *
     * @return Sale
     */
    public function addSaleRelatedDoc(\Numa\DOADMSBundle\Entity\SaleRelatedDoc $saleRelatedDoc)
    {
        $this->SaleRelatedDoc[] = $saleRelatedDoc;

        return $this;
    }

    /**
     * Remove saleRelatedDoc
     *
     * @param \Numa\DOADMSBundle\Entity\SaleRelatedDoc $saleRelatedDoc
     */
    public function removeSaleRelatedDoc(\Numa\DOADMSBundle\Entity\SaleRelatedDoc $saleRelatedDoc)
    {
        $this->SaleRelatedDoc->removeElement($saleRelatedDoc);
    }

    /**
     * Get saleRelatedDoc
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSaleRelatedDoc()
    {
        return $this->SaleRelatedDoc;
    }

    public function hasRelatedDocs(){
        return count($this->SaleRelatedDoc)>0;
    }
    /**
     * @var integer
     */
    private $protect_pkg_vendor_id;

    /**
     * @var integer
     */
    private $warranty_vendor_id;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Protect_pkg;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Warranty;


    /**
     * Set protectPkgVendorId
     *
     * @param integer $protectPkgVendorId
     *
     * @return Sale
     */
    public function setProtectPkgVendorId($protectPkgVendorId)
    {
        $this->protect_pkg_vendor_id = $protectPkgVendorId;

        return $this;
    }

    /**
     * Get protectPkgVendorId
     *
     * @return integer
     */
    public function getProtectPkgVendorId()
    {
        return $this->protect_pkg_vendor_id;
    }

    /**
     * Set warrantyVendorId
     *
     * @param integer $warrantyVendorId
     *
     * @return Sale
     */
    public function setWarrantyVendorId($warrantyVendorId)
    {
        $this->warranty_vendor_id = $warrantyVendorId;

        return $this;
    }

    /**
     * Get warrantyVendorId
     *
     * @return integer
     */
    public function getWarrantyVendorId()
    {
        return $this->warranty_vendor_id;
    }

    /**
     * Set vendorProtectPkg
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorProtectPkg
     *
     * @return Sale
     */
    public function setVendorProtectPkg(\Numa\DOADMSBundle\Entity\Vendor $vendorProtectPkg = null)
    {
        $this->Vendor_Protect_pkg = $vendorProtectPkg;

        return $this;
    }

    /**
     * Get vendorProtectPkg
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorProtectPkg()
    {
        return $this->Vendor_Protect_pkg;
    }

    /**
     * Set vendorWarranty
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorWarranty
     *
     * @return Sale
     */
    public function setVendorWarranty(\Numa\DOADMSBundle\Entity\Vendor $vendorWarranty = null)
    {
        $this->Vendor_Warranty = $vendorWarranty;

        return $this;
    }

    /**
     * Get vendorWarranty
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorWarranty()
    {
        return $this->Vendor_Warranty;
    }
    /**
     * @var integer
     */
    private $doc_fees_vendor_id;

    /**
     * @var integer
     */
    private $admin_fees_vendor_id;

    /**
     * @var integer
     */
    private $insurance_vendor_id;

    /**
     * @var integer
     */
    private $life_ins_vendor_id;

    /**
     * @var integer
     */
    private $disability_ins_vendor_id;

    /**
     * @var integer
     */
    private $feverse_vendor_id;

    /**
     * @var integer
     */
    private $misc_1_vendor_id;

    /**
     * @var integer
     */
    private $misc_2_vendor_id;

    /**
     * @var integer
     */
    private $misc_3_vendor_id;

    /**
     * @var integer
     */
    private $sales_comms_vendor_id;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Doc_fees;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Admin_fees;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Insurance;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Life_ins;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Disability_ins;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Feverse;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Misc_1;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Misc_2;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Misc_3;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Sales_comms;


    /**
     * Set docFeesVendorId
     *
     * @param integer $docFeesVendorId
     *
     * @return Sale
     */
    public function setDocFeesVendorId($docFeesVendorId)
    {
        $this->doc_fees_vendor_id = $docFeesVendorId;

        return $this;
    }

    /**
     * Get docFeesVendorId
     *
     * @return integer
     */
    public function getDocFeesVendorId()
    {
        return $this->doc_fees_vendor_id;
    }

    /**
     * Set adminFeesVendorId
     *
     * @param integer $adminFeesVendorId
     *
     * @return Sale
     */
    public function setAdminFeesVendorId($adminFeesVendorId)
    {
        $this->admin_fees_vendor_id = $adminFeesVendorId;

        return $this;
    }

    /**
     * Get adminFeesVendorId
     *
     * @return integer
     */
    public function getAdminFeesVendorId()
    {
        return $this->admin_fees_vendor_id;
    }

    /**
     * Set insuranceVendorId
     *
     * @param integer $insuranceVendorId
     *
     * @return Sale
     */
    public function setInsuranceVendorId($insuranceVendorId)
    {
        $this->insurance_vendor_id = $insuranceVendorId;

        return $this;
    }

    /**
     * Get insuranceVendorId
     *
     * @return integer
     */
    public function getInsuranceVendorId()
    {
        return $this->insurance_vendor_id;
    }

    /**
     * Set lifeInsVendorId
     *
     * @param integer $lifeInsVendorId
     *
     * @return Sale
     */
    public function setLifeInsVendorId($lifeInsVendorId)
    {
        $this->life_ins_vendor_id = $lifeInsVendorId;

        return $this;
    }

    /**
     * Get lifeInsVendorId
     *
     * @return integer
     */
    public function getLifeInsVendorId()
    {
        return $this->life_ins_vendor_id;
    }

    /**
     * Set disabilityInsVendorId
     *
     * @param integer $disabilityInsVendorId
     *
     * @return Sale
     */
    public function setDisabilityInsVendorId($disabilityInsVendorId)
    {
        $this->disability_ins_vendor_id = $disabilityInsVendorId;

        return $this;
    }

    /**
     * Get disabilityInsVendorId
     *
     * @return integer
     */
    public function getDisabilityInsVendorId()
    {
        return $this->disability_ins_vendor_id;
    }

    /**
     * Set feverseVendorId
     *
     * @param integer $feverseVendorId
     *
     * @return Sale
     */
    public function setFeverseVendorId($feverseVendorId)
    {
        $this->feverse_vendor_id = $feverseVendorId;

        return $this;
    }

    /**
     * Get feverseVendorId
     *
     * @return integer
     */
    public function getFeverseVendorId()
    {
        return $this->feverse_vendor_id;
    }

    /**
     * Set misc1VendorId
     *
     * @param integer $misc1VendorId
     *
     * @return Sale
     */
    public function setMisc1VendorId($misc1VendorId)
    {
        $this->misc_1_vendor_id = $misc1VendorId;

        return $this;
    }

    /**
     * Get misc1VendorId
     *
     * @return integer
     */
    public function getMisc1VendorId()
    {
        return $this->misc_1_vendor_id;
    }

    /**
     * Set misc2VendorId
     *
     * @param integer $misc2VendorId
     *
     * @return Sale
     */
    public function setMisc2VendorId($misc2VendorId)
    {
        $this->misc_2_vendor_id = $misc2VendorId;

        return $this;
    }

    /**
     * Get misc2VendorId
     *
     * @return integer
     */
    public function getMisc2VendorId()
    {
        return $this->misc_2_vendor_id;
    }

    /**
     * Set misc3VendorId
     *
     * @param integer $misc3VendorId
     *
     * @return Sale
     */
    public function setMisc3VendorId($misc3VendorId)
    {
        $this->misc_3_vendor_id = $misc3VendorId;

        return $this;
    }

    /**
     * Get misc3VendorId
     *
     * @return integer
     */
    public function getMisc3VendorId()
    {
        return $this->misc_3_vendor_id;
    }

    /**
     * Set salesCommsVendorId
     *
     * @param integer $salesCommsVendorId
     *
     * @return Sale
     */
    public function setSalesCommsVendorId($salesCommsVendorId)
    {
        $this->sales_comms_vendor_id = $salesCommsVendorId;

        return $this;
    }

    /**
     * Get salesCommsVendorId
     *
     * @return integer
     */
    public function getSalesCommsVendorId()
    {
        return $this->sales_comms_vendor_id;
    }

    /**
     * Set vendorDocFees
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorDocFees
     *
     * @return Sale
     */
    public function setVendorDocFees(\Numa\DOADMSBundle\Entity\Vendor $vendorDocFees = null)
    {
        $this->Vendor_Doc_fees = $vendorDocFees;

        return $this;
    }

    /**
     * Get vendorDocFees
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorDocFees()
    {
        return $this->Vendor_Doc_fees;
    }

    /**
     * Set vendorAdminFees
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorAdminFees
     *
     * @return Sale
     */
    public function setVendorAdminFees(\Numa\DOADMSBundle\Entity\Vendor $vendorAdminFees = null)
    {
        $this->Vendor_Admin_fees = $vendorAdminFees;

        return $this;
    }

    /**
     * Get vendorAdminFees
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorAdminFees()
    {
        return $this->Vendor_Admin_fees;
    }

    /**
     * Set vendorInsurance
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorInsurance
     *
     * @return Sale
     */
    public function setVendorInsurance(\Numa\DOADMSBundle\Entity\Vendor $vendorInsurance = null)
    {
        $this->Vendor_Insurance = $vendorInsurance;

        return $this;
    }

    /**
     * Get vendorInsurance
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorInsurance()
    {
        return $this->Vendor_Insurance;
    }

    /**
     * Set vendorLifeIns
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorLifeIns
     *
     * @return Sale
     */
    public function setVendorLifeIns(\Numa\DOADMSBundle\Entity\Vendor $vendorLifeIns = null)
    {
        $this->Vendor_Life_ins = $vendorLifeIns;

        return $this;
    }

    /**
     * Get vendorLifeIns
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorLifeIns()
    {
        return $this->Vendor_Life_ins;
    }

    /**
     * Set vendorDisabilityIns
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorDisabilityIns
     *
     * @return Sale
     */
    public function setVendorDisabilityIns(\Numa\DOADMSBundle\Entity\Vendor $vendorDisabilityIns = null)
    {
        $this->Vendor_Disability_ins = $vendorDisabilityIns;

        return $this;
    }

    /**
     * Get vendorDisabilityIns
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorDisabilityIns()
    {
        return $this->Vendor_Disability_ins;
    }

    /**
     * Set vendorFeverse
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorFeverse
     *
     * @return Sale
     */
    public function setVendorFeverse(\Numa\DOADMSBundle\Entity\Vendor $vendorFeverse = null)
    {
        $this->Vendor_Feverse = $vendorFeverse;

        return $this;
    }

    /**
     * Get vendorFeverse
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorFeverse()
    {
        return $this->Vendor_Feverse;
    }

    /**
     * Set vendorMisc1
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorMisc1
     *
     * @return Sale
     */
    public function setVendorMisc1(\Numa\DOADMSBundle\Entity\Vendor $vendorMisc1 = null)
    {
        $this->Vendor_Misc_1 = $vendorMisc1;

        return $this;
    }

    /**
     * Get vendorMisc1
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorMisc1()
    {
        return $this->Vendor_Misc_1;
    }

    /**
     * Set vendorMisc2
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorMisc2
     *
     * @return Sale
     */
    public function setVendorMisc2(\Numa\DOADMSBundle\Entity\Vendor $vendorMisc2 = null)
    {
        $this->Vendor_Misc_2 = $vendorMisc2;

        return $this;
    }

    /**
     * Get vendorMisc2
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorMisc2()
    {
        return $this->Vendor_Misc_2;
    }

    /**
     * Set vendorMisc3
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorMisc3
     *
     * @return Sale
     */
    public function setVendorMisc3(\Numa\DOADMSBundle\Entity\Vendor $vendorMisc3 = null)
    {
        $this->Vendor_Misc_3 = $vendorMisc3;

        return $this;
    }

    /**
     * Get vendorMisc3
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorMisc3()
    {
        return $this->Vendor_Misc_3;
    }

    /**
     * Set vendorSalesComms
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorSalesComms
     *
     * @return Sale
     */
    public function setVendorSalesComms(\Numa\DOADMSBundle\Entity\Vendor $vendorSalesComms = null)
    {
        $this->Vendor_Sales_comms = $vendorSalesComms;

        return $this;
    }

    /**
     * Get vendorSalesComms
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorSalesComms()
    {
        return $this->Vendor_Sales_comms;
    }
    /**
     * @var integer
     */
    private $delivery_vendor_id;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Delivery;


    /**
     * Set deliveryVendorId
     *
     * @param integer $deliveryVendorId
     *
     * @return Sale
     */
    public function setDeliveryVendorId($deliveryVendorId)
    {
        $this->delivery_vendor_id = $deliveryVendorId;

        return $this;
    }

    /**
     * Get deliveryVendorId
     *
     * @return integer
     */
    public function getDeliveryVendorId()
    {
        return $this->delivery_vendor_id;
    }

    /**
     * Set vendorDelivery
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorDelivery
     *
     * @return Sale
     */
    public function setVendorDelivery(\Numa\DOADMSBundle\Entity\Vendor $vendorDelivery = null)
    {
        $this->Vendor_Delivery = $vendorDelivery;

        return $this;
    }

    /**
     * Get vendorDelivery
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorDelivery()
    {
        return $this->Vendor_Delivery;
    }
    /**
     * @var integer
     */
    private $clean_up_vendor_id;

    /**
     * @var integer
     */
    private $glass_vendor_id;

    /**
     * @var integer
     */
    private $mechanical_1_vendor_id;

    /**
     * @var integer
     */
    private $mechanical_2_vendor_id;

    /**
     * @var integer
     */
    private $other_exp_1_vendor_id;

    /**
     * @var integer
     */
    private $other_exp_2_vendor_id;

    /**
     * @var integer
     */
    private $other_exp_3_vendor_id;

    /**
     * @var integer
     */
    private $other_exp_4_vendor_id;

    /**
     * @var integer
     */
    private $other_exp_5_vendor_id;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Clean_up;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Glass;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Mechanical_1;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Mechanical_2;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Other_exp_1;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Other_exp_2;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Other_exp_3;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Other_exp_4;

    /**
     * @var \Numa\DOADMSBundle\Entity\Vendor
     */
    private $Vendor_Other_exp_5;


    /**
     * Set cleanUpVendorId
     *
     * @param integer $cleanUpVendorId
     *
     * @return Sale
     */
    public function setCleanUpVendorId($cleanUpVendorId)
    {
        $this->clean_up_vendor_id = $cleanUpVendorId;

        return $this;
    }

    /**
     * Get cleanUpVendorId
     *
     * @return integer
     */
    public function getCleanUpVendorId()
    {
        return $this->clean_up_vendor_id;
    }

    /**
     * Set glassVendorId
     *
     * @param integer $glassVendorId
     *
     * @return Sale
     */
    public function setGlassVendorId($glassVendorId)
    {
        $this->glass_vendor_id = $glassVendorId;

        return $this;
    }

    /**
     * Get glassVendorId
     *
     * @return integer
     */
    public function getGlassVendorId()
    {
        return $this->glass_vendor_id;
    }

    /**
     * Set mechanical1VendorId
     *
     * @param integer $mechanical1VendorId
     *
     * @return Sale
     */
    public function setMechanical1VendorId($mechanical1VendorId)
    {
        $this->mechanical_1_vendor_id = $mechanical1VendorId;

        return $this;
    }

    /**
     * Get mechanical1VendorId
     *
     * @return integer
     */
    public function getMechanical1VendorId()
    {
        return $this->mechanical_1_vendor_id;
    }

    /**
     * Set mechanical2VendorId
     *
     * @param integer $mechanical2VendorId
     *
     * @return Sale
     */
    public function setMechanical2VendorId($mechanical2VendorId)
    {
        $this->mechanical_2_vendor_id = $mechanical2VendorId;

        return $this;
    }

    /**
     * Get mechanical2VendorId
     *
     * @return integer
     */
    public function getMechanical2VendorId()
    {
        return $this->mechanical_2_vendor_id;
    }

    /**
     * Set otherExp1VendorId
     *
     * @param integer $otherExp1VendorId
     *
     * @return Sale
     */
    public function setOtherExp1VendorId($otherExp1VendorId)
    {
        $this->other_exp_1_vendor_id = $otherExp1VendorId;

        return $this;
    }

    /**
     * Get otherExp1VendorId
     *
     * @return integer
     */
    public function getOtherExp1VendorId()
    {
        return $this->other_exp_1_vendor_id;
    }

    /**
     * Set otherExp2VendorId
     *
     * @param integer $otherExp2VendorId
     *
     * @return Sale
     */
    public function setOtherExp2VendorId($otherExp2VendorId)
    {
        $this->other_exp_2_vendor_id = $otherExp2VendorId;

        return $this;
    }

    /**
     * Get otherExp2VendorId
     *
     * @return integer
     */
    public function getOtherExp2VendorId()
    {
        return $this->other_exp_2_vendor_id;
    }

    /**
     * Set otherExp3VendorId
     *
     * @param integer $otherExp3VendorId
     *
     * @return Sale
     */
    public function setOtherExp3VendorId($otherExp3VendorId)
    {
        $this->other_exp_3_vendor_id = $otherExp3VendorId;

        return $this;
    }

    /**
     * Get otherExp3VendorId
     *
     * @return integer
     */
    public function getOtherExp3VendorId()
    {
        return $this->other_exp_3_vendor_id;
    }

    /**
     * Set otherExp4VendorId
     *
     * @param integer $otherExp4VendorId
     *
     * @return Sale
     */
    public function setOtherExp4VendorId($otherExp4VendorId)
    {
        $this->other_exp_4_vendor_id = $otherExp4VendorId;

        return $this;
    }

    /**
     * Get otherExp4VendorId
     *
     * @return integer
     */
    public function getOtherExp4VendorId()
    {
        return $this->other_exp_4_vendor_id;
    }

    /**
     * Set otherExp5VendorId
     *
     * @param integer $otherExp5VendorId
     *
     * @return Sale
     */
    public function setOtherExp5VendorId($otherExp5VendorId)
    {
        $this->other_exp_5_vendor_id = $otherExp5VendorId;

        return $this;
    }

    /**
     * Get otherExp5VendorId
     *
     * @return integer
     */
    public function getOtherExp5VendorId()
    {
        return $this->other_exp_5_vendor_id;
    }

    /**
     * Set vendorCleanUp
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorCleanUp
     *
     * @return Sale
     */
    public function setVendorCleanUp(\Numa\DOADMSBundle\Entity\Vendor $vendorCleanUp = null)
    {
        $this->Vendor_Clean_up = $vendorCleanUp;

        return $this;
    }

    /**
     * Get vendorCleanUp
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorCleanUp()
    {
        return $this->Vendor_Clean_up;
    }

    /**
     * Set vendorGlass
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorGlass
     *
     * @return Sale
     */
    public function setVendorGlass(\Numa\DOADMSBundle\Entity\Vendor $vendorGlass = null)
    {
        $this->Vendor_Glass = $vendorGlass;

        return $this;
    }

    /**
     * Get vendorGlass
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorGlass()
    {
        return $this->Vendor_Glass;
    }

    /**
     * Set vendorMechanical1
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorMechanical1
     *
     * @return Sale
     */
    public function setVendorMechanical1(\Numa\DOADMSBundle\Entity\Vendor $vendorMechanical1 = null)
    {
        $this->Vendor_Mechanical_1 = $vendorMechanical1;

        return $this;
    }

    /**
     * Get vendorMechanical1
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorMechanical1()
    {
        return $this->Vendor_Mechanical_1;
    }

    /**
     * Set vendorMechanical2
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorMechanical2
     *
     * @return Sale
     */
    public function setVendorMechanical2(\Numa\DOADMSBundle\Entity\Vendor $vendorMechanical2 = null)
    {
        $this->Vendor_Mechanical_2 = $vendorMechanical2;

        return $this;
    }

    /**
     * Get vendorMechanical2
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorMechanical2()
    {
        return $this->Vendor_Mechanical_2;
    }

    /**
     * Set vendorOtherExp1
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorOtherExp1
     *
     * @return Sale
     */
    public function setVendorOtherExp1(\Numa\DOADMSBundle\Entity\Vendor $vendorOtherExp1 = null)
    {
        $this->Vendor_Other_exp_1 = $vendorOtherExp1;

        return $this;
    }

    /**
     * Get vendorOtherExp1
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorOtherExp1()
    {
        return $this->Vendor_Other_exp_1;
    }

    /**
     * Set vendorOtherExp2
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorOtherExp2
     *
     * @return Sale
     */
    public function setVendorOtherExp2(\Numa\DOADMSBundle\Entity\Vendor $vendorOtherExp2 = null)
    {
        $this->Vendor_Other_exp_2 = $vendorOtherExp2;

        return $this;
    }

    /**
     * Get vendorOtherExp2
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorOtherExp2()
    {
        return $this->Vendor_Other_exp_2;
    }

    /**
     * Set vendorOtherExp3
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorOtherExp3
     *
     * @return Sale
     */
    public function setVendorOtherExp3(\Numa\DOADMSBundle\Entity\Vendor $vendorOtherExp3 = null)
    {
        $this->Vendor_Other_exp_3 = $vendorOtherExp3;

        return $this;
    }

    /**
     * Get vendorOtherExp3
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorOtherExp3()
    {
        return $this->Vendor_Other_exp_3;
    }

    /**
     * Set vendorOtherExp4
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorOtherExp4
     *
     * @return Sale
     */
    public function setVendorOtherExp4(\Numa\DOADMSBundle\Entity\Vendor $vendorOtherExp4 = null)
    {
        $this->Vendor_Other_exp_4 = $vendorOtherExp4;

        return $this;
    }

    /**
     * Get vendorOtherExp4
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorOtherExp4()
    {
        return $this->Vendor_Other_exp_4;
    }

    /**
     * Set vendorOtherExp5
     *
     * @param \Numa\DOADMSBundle\Entity\Vendor $vendorOtherExp5
     *
     * @return Sale
     */
    public function setVendorOtherExp5(\Numa\DOADMSBundle\Entity\Vendor $vendorOtherExp5 = null)
    {
        $this->Vendor_Other_exp_5 = $vendorOtherExp5;

        return $this;
    }

    /**
     * Get vendorOtherExp5
     *
     * @return \Numa\DOADMSBundle\Entity\Vendor
     */
    public function getVendorOtherExp5()
    {
        return $this->Vendor_Other_exp_5;
    }

    /**
     * @var float
     */
    private $gst_delivery;

    /**
     * @var float
     */
    private $gst_clean_up;

    /**
     * @var float
     */
    private $gst_glass;

    /**
     * @var float
     */
    private $gst_mechanical_1;

    /**
     * @var float
     */
    private $gst_mechanical_2;

    /**
     * @var float
     */
    private $gst_other_exp_1;

    /**
     * @var float
     */
    private $gst_other_exp_2;

    /**
     * @var float
     */
    private $gst_other_exp_3;

    /**
     * @var float
     */
    private $gst_other_exp_4;

    /**
     * @var float
     */
    private $gst_other_exp_5;

    /**
     * @var float
     */
    private $gst_protect_pkg;

    /**
     * @var float
     */
    private $gst_warranty;

    /**
     * @var float
     */
    private $gst_doc_fees;

    /**
     * @var float
     */
    private $gst_admin_fees;

    /**
     * @var float
     */
    private $gst_insurance;

    /**
     * @var float
     */
    private $gst_life_ins;

    /**
     * @var float
     */
    private $gst_disability_ins;

    /**
     * @var float
     */
    private $gst_feverse;

    /**
     * @var float
     */
    private $gst_misc_1;

    /**
     * @var float
     */
    private $gst_misc_2;

    /**
     * @var float
     */
    private $gst_misc_3;

    /**
     * @var float
     */
    private $gst_sales_comms;

    /**
     * Set gstDelivery
     *
     * @param float $gstDelivery
     *
     * @return Sale
     */
    public function setGstDelivery($gstDelivery)
    {
        $this->gst_delivery = $gstDelivery;

        return $this;
    }

    /**
     * Get gstDelivery
     *
     * @return float
     */
    public function getGstDelivery()
    {
        return number_format((float)$this->gst_delivery,2, '.', '');
    }

    /**
     * Set gstCleanUp
     *
     * @param float $gstCleanUp
     *
     * @return Sale
     */
    public function setGstCleanUp($gstCleanUp)
    {
        $this->gst_clean_up = $gstCleanUp;

        return $this;
    }

    /**
     * Get gstCleanUp
     *
     * @return float
     */
    public function getGstCleanUp()
    {
        return number_format((float)$this->gst_clean_up,2, '.', '');
    }

    /**
     * Set gstGlass
     *
     * @param float $gstGlass
     *
     * @return Sale
     */
    public function setGstGlass($gstGlass)
    {
        $this->gst_glass = $gstGlass;

        return $this;
    }

    /**
     * Get gstGlass
     *
     * @return float
     */
    public function getGstGlass()
    {
        return number_format((float)$this->gst_glass,2, '.', '');
    }

    /**
     * Set gstMechanical1
     *
     * @param float $gstMechanical1
     *
     * @return Sale
     */
    public function setGstMechanical1($gstMechanical1)
    {
        $this->gst_mechanical_1 = $gstMechanical1;

        return $this;
    }

    /**
     * Get gstMechanical1
     *
     * @return float
     */
    public function getGstMechanical1()
    {
        return number_format((float)$this->gst_mechanical_1,2, '.', '');
    }

    /**
     * Set gstMechanical2
     *
     * @param float $gstMechanical2
     *
     * @return Sale
     */
    public function setGstMechanical2($gstMechanical2)
    {
        $this->gst_mechanical_2 = $gstMechanical2;

        return $this;
    }

    /**
     * Get gstMechanical2
     *
     * @return float
     */
    public function getGstMechanical2()
    {
        return number_format((float)$this->gst_mechanical_2,2, '.', '');
    }

    /**
     * Set gstOtherExp1
     *
     * @param float $gstOtherExp1
     *
     * @return Sale
     */
    public function setGstOtherExp1($gstOtherExp1)
    {
        $this->gst_other_exp_1 = $gstOtherExp1;

        return $this;
    }

    /**
     * Get gstOtherExp1
     *
     * @return float
     */
    public function getGstOtherExp1()
    {
        return number_format((float)$this->gst_other_exp_1,2, '.', '');
    }

    /**
     * Set gstOtherExp2
     *
     * @param float $gstOtherExp2
     *
     * @return Sale
     */
    public function setGstOtherExp2($gstOtherExp2)
    {
        $this->gst_other_exp_2 = $gstOtherExp2;

        return $this;
    }

    /**
     * Get gstOtherExp2
     *
     * @return float
     */
    public function getGstOtherExp2()
    {
        return number_format((float)$this->gst_other_exp_2,2, '.', '');
    }

    /**
     * Set gstOtherExp3
     *
     * @param float $gstOtherExp3
     *
     * @return Sale
     */
    public function setGstOtherExp3($gstOtherExp3)
    {
        $this->gst_other_exp_3 = $gstOtherExp3;

        return $this;
    }

    /**
     * Get gstOtherExp3
     *
     * @return float
     */
    public function getGstOtherExp3()
    {
        return number_format((float)$this->gst_other_exp_3,2, '.', '');
    }

    /**
     * Set gstOtherExp4
     *
     * @param float $gstOtherExp4
     *
     * @return Sale
     */
    public function setGstOtherExp4($gstOtherExp4)
    {
        $this->gst_other_exp_4 = $gstOtherExp4;

        return $this;
    }

    /**
     * Get gstOtherExp4
     *
     * @return float
     */
    public function getGstOtherExp4()
    {
        return number_format((float)$this->gst_other_exp_4,2, '.', '');
    }

    /**
     * Set gstOtherExp5
     *
     * @param float $gstOtherExp5
     *
     * @return Sale
     */
    public function setGstOtherExp5($gstOtherExp5)
    {
        $this->gst_other_exp_5 = $gstOtherExp5;

        return $this;
    }

    /**
     * Get gstOtherExp5
     *
     * @return float
     */
    public function getGstOtherExp5()
    {
        return number_format((float)$this->gst_other_exp_5,2, '.', '');
    }

    /**
     * Set gstProtectPkg
     *
     * @param float $gstProtectPkg
     *
     * @return Sale
     */
    public function setGstProtectPkg($gstProtectPkg)
    {
        $this->gst_protect_pkg = $gstProtectPkg;

        return $this;
    }

    /**
     * Get gstProtectPkg
     *
     * @return float
     */
    public function getGstProtectPkg()
    {
        return number_format((float)$this->gst_protect_pkg,2, '.', '');
    }

    /**
     * Set gstWarranty
     *
     * @param float $gstWarranty
     *
     * @return Sale
     */
    public function setGstWarranty($gstWarranty)
    {
        $this->gst_warranty = $gstWarranty;

        return $this;
    }

    /**
     * Get gstWarranty
     *
     * @return float
     */
    public function getGstWarranty()
    {
        return number_format((float)$this->gst_warranty,2, '.', '');
    }

    /**
     * Set gstDocFees
     *
     * @param float $gstDocFees
     *
     * @return Sale
     */
    public function setGstDocFees($gstDocFees)
    {
        $this->gst_doc_fees = $gstDocFees;

        return $this;
    }

    /**
     * Get gstDocFees
     *
     * @return float
     */
    public function getGstDocFees()
    {
        return number_format((float)$this->gst_doc_fees,2, '.', '');
    }

    /**
     * Set gstAdminFees
     *
     * @param float $gstAdminFees
     *
     * @return Sale
     */
    public function setGstAdminFees($gstAdminFees)
    {
        $this->gst_admin_fees = $gstAdminFees;

        return $this;
    }

    /**
     * Get gstAdminFees
     *
     * @return float
     */
    public function getGstAdminFees()
    {
        return number_format((float)$this->gst_admin_fees,2, '.', '');
    }

    /**
     * Set gstInsurance
     *
     * @param float $gstInsurance
     *
     * @return Sale
     */
    public function setGstInsurance($gstInsurance)
    {
        $this->gst_insurance = $gstInsurance;

        return $this;
    }

    /**
     * Get gstInsurance
     *
     * @return float
     */
    public function getGstInsurance()
    {
        return number_format((float)$this->gst_insurance,2, '.', '');
    }

    /**
     * Set gstLifeIns
     *
     * @param float $gstLifeIns
     *
     * @return Sale
     */
    public function setGstLifeIns($gstLifeIns)
    {
        $this->gst_life_ins = $gstLifeIns;

        return $this;
    }

    /**
     * Get gstLifeIns
     *
     * @return float
     */
    public function getGstLifeIns()
    {
        return number_format((float)$this->gst_life_ins,2, '.', '');
    }

    /**
     * Set gstDisabilityIns
     *
     * @param float $gstDisabilityIns
     *
     * @return Sale
     */
    public function setGstDisabilityIns($gstDisabilityIns)
    {
        $this->gst_disability_ins = $gstDisabilityIns;

        return $this;
    }

    /**
     * Get gstDisabilityIns
     *
     * @return float
     */
    public function getGstDisabilityIns()
    {
        return number_format((float)$this->gst_disability_ins,2, '.', '');
    }

    /**
     * Set gstFeverse
     *
     * @param float $gstFeverse
     *
     * @return Sale
     */
    public function setGstFeverse($gstFeverse)
    {
        $this->gst_feverse = $gstFeverse;

        return $this;
    }

    /**
     * Get gstFeverse
     *
     * @return float
     */
    public function getGstFeverse()
    {
        return number_format((float)$this->gst_feverse,2, '.', '');
    }

    /**
     * Set gstMisc1
     *
     * @param float $gstMisc1
     *
     * @return Sale
     */
    public function setGstMisc1($gstMisc1)
    {
        $this->gst_misc_1 = $gstMisc1;

        return $this;
    }

    /**
     * Get gstMisc1
     *
     * @return float
     */
    public function getGstMisc1()
    {
        return number_format((float)$this->gst_misc_1,2, '.', '');
    }

    /**
     * Set gstMisc2
     *
     * @param float $gstMisc2
     *
     * @return Sale
     */
    public function setGstMisc2($gstMisc2)
    {
        $this->gst_misc_2 = $gstMisc2;

        return $this;
    }

    /**
     * Get gstMisc2
     *
     * @return float
     */
    public function getGstMisc2()
    {
        return number_format((float)$this->gst_misc_2,2, '.', '');
    }

    /**
     * Set gstMisc3
     *
     * @param float $gstMisc3
     *
     * @return Sale
     */
    public function setGstMisc3($gstMisc3)
    {
        $this->gst_misc_3 = $gstMisc3;

        return $this;
    }

    /**
     * Get gstMisc3
     *
     * @return float
     */
    public function getGstMisc3()
    {
        return number_format((float)$this->gst_misc_3,2, '.', '');
    }

    /**
     * Set gstSalesComms
     *
     * @param float $gstSalesComms
     *
     * @return Sale
     */
    public function setGstSalesComms($gstSalesComms)
    {
        $this->gst_sales_comms = $gstSalesComms;

        return $this;
    }

    /**
     * Get gstSalesComms
     *
     * @return float
     */
    public function getGstSalesComms()
    {
        return number_format((float)$this->gst_sales_comms,2, '.', '');
    }
    /**
     * @var string
     */
    private $desc_mechanical_1;

    /**
     * @var string
     */
    private $desc_mechanical_2;

    /**
     * @var string
     */
    private $desc_other_exp_1;

    /**
     * @var string
     */
    private $desc_other_exp_2;

    /**
     * @var string
     */
    private $desc_other_exp_3;

    /**
     * @var string
     */
    private $desc_other_exp_4;

    /**
     * @var string
     */
    private $desc_delivery;

    /**
     * @var string
     */
    private $desc_clean_up;

    /**
     * @var string
     */
    private $desc_glass;


    /**
     * Set descMechanical1
     *
     * @param string $descMechanical1
     *
     * @return Sale
     */
    public function setDescMechanical1($descMechanical1)
    {
        $this->desc_mechanical_1 = $descMechanical1;

        return $this;
    }

    /**
     * Get descMechanical1
     *
     * @return string
     */
    public function getDescMechanical1()
    {
        return $this->desc_mechanical_1;
    }

    /**
     * Set descMechanical2
     *
     * @param string $descMechanical2
     *
     * @return Sale
     */
    public function setDescMechanical2($descMechanical2)
    {
        $this->desc_mechanical_2 = $descMechanical2;

        return $this;
    }

    /**
     * Get descMechanical2
     *
     * @return string
     */
    public function getDescMechanical2()
    {
        return $this->desc_mechanical_2;
    }

    /**
     * Set descOtherExp1
     *
     * @param string $descOtherExp1
     *
     * @return Sale
     */
    public function setDescOtherExp1($descOtherExp1)
    {
        $this->desc_other_exp_1 = $descOtherExp1;

        return $this;
    }

    /**
     * Get descOtherExp1
     *
     * @return string
     */
    public function getDescOtherExp1()
    {
        return $this->desc_other_exp_1;
    }

    /**
     * Set descOtherExp2
     *
     * @param string $descOtherExp2
     *
     * @return Sale
     */
    public function setDescOtherExp2($descOtherExp2)
    {
        $this->desc_other_exp_2 = $descOtherExp2;

        return $this;
    }

    /**
     * Get descOtherExp2
     *
     * @return string
     */
    public function getDescOtherExp2()
    {
        return $this->desc_other_exp_2;
    }

    /**
     * Set descOtherExp3
     *
     * @param string $descOtherExp3
     *
     * @return Sale
     */
    public function setDescOtherExp3($descOtherExp3)
    {
        $this->desc_other_exp_3 = $descOtherExp3;

        return $this;
    }

    /**
     * Get descOtherExp3
     *
     * @return string
     */
    public function getDescOtherExp3()
    {
        return $this->desc_other_exp_3;
    }

    /**
     * Set descOtherExp4
     *
     * @param string $descOtherExp4
     *
     * @return Sale
     */
    public function setDescOtherExp4($descOtherExp4)
    {
        $this->desc_other_exp_4 = $descOtherExp4;

        return $this;
    }

    /**
     * Get descOtherExp4
     *
     * @return string
     */
    public function getDescOtherExp4()
    {
        return $this->desc_other_exp_4;
    }

    /**
     * Set descDelivery
     *
     * @param string $descDelivery
     *
     * @return Sale
     */
    public function setDescDelivery($descDelivery)
    {
        $this->desc_delivery = $descDelivery;

        return $this;
    }

    /**
     * Get descDelivery
     *
     * @return string
     */
    public function getDescDelivery()
    {
        return $this->desc_delivery;
    }

    /**
     * Set descCleanUp
     *
     * @param string $descCleanUp
     *
     * @return Sale
     */
    public function setDescCleanUp($descCleanUp)
    {
        $this->desc_clean_up = $descCleanUp;

        return $this;
    }

    /**
     * Get descCleanUp
     *
     * @return string
     */
    public function getDescCleanUp()
    {
        return $this->desc_clean_up;
    }

    /**
     * Set descGlass
     *
     * @param string $descGlass
     *
     * @return Sale
     */
    public function setDescGlass($descGlass)
    {
        $this->desc_glass = $descGlass;

        return $this;
    }

    /**
     * Get descGlass
     *
     * @return string
     */
    public function getDescGlass()
    {
        return $this->desc_glass;
    }
    /**
     * @var string
     */
    private $discrip_other_exp_5;


    /**
     * Set discripOtherExp5
     *
     * @param string $discripOtherExp5
     *
     * @return Sale
     */
    public function setDiscripOtherExp5($discripOtherExp5)
    {
        $this->discrip_other_exp_5 = $discripOtherExp5;

        return $this;
    }

    /**
     * Get discripOtherExp5
     *
     * @return string
     */
    public function getDiscripOtherExp5()
    {
        return $this->discrip_other_exp_5;
    }
    /**
     * @var string
     */
    private $desc_other_exp_5;


    /**
     * Set descOtherExp5
     *
     * @param string $descOtherExp5
     *
     * @return Sale
     */
    public function setDescOtherExp5($descOtherExp5)
    {
        $this->desc_other_exp_5 = $descOtherExp5;

        return $this;
    }

    /**
     * Get descOtherExp5
     *
     * @return string
     */
    public function getDescOtherExp5()
    {
        return $this->desc_other_exp_5;
    }
}
