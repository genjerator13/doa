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
     * @var string
     */
    private $discrip1;

    /**
     * @var string
     */
    private $discrip2;

    /**
     * @var string
     */
    private $discrip3;

    /**
     * @var string
     */
    private $discrip4;

    /**
     * @var string
     */
    private $discrip5;

    /**
     * @var string
     */
    private $discrip6;

    /**
     * @var string
     */
    private $discrip7;

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
     * Set discrip1
     *
     * @param string $discrip1
     *
     * @return Sale
     */
    public function setDiscrip1($discrip1)
    {
        $this->discrip1 = $discrip1;

        return $this;
    }

    /**
     * Get discrip1
     *
     * @return string
     */
    public function getDiscrip1()
    {
        return $this->discrip1;
    }

    /**
     * Set discrip2
     *
     * @param string $discrip2
     *
     * @return Sale
     */
    public function setDiscrip2($discrip2)
    {
        $this->discrip2 = $discrip2;

        return $this;
    }

    /**
     * Get discrip2
     *
     * @return string
     */
    public function getDiscrip2()
    {
        return $this->discrip2;
    }

    /**
     * Set discrip3
     *
     * @param string $discrip3
     *
     * @return Sale
     */
    public function setDiscrip3($discrip3)
    {
        $this->discrip3 = $discrip3;

        return $this;
    }

    /**
     * Get discrip3
     *
     * @return string
     */
    public function getDiscrip3()
    {
        return $this->discrip3;
    }

    /**
     * Set discrip4
     *
     * @param string $discrip4
     *
     * @return Sale
     */
    public function setDiscrip4($discrip4)
    {
        $this->discrip4 = $discrip4;

        return $this;
    }

    /**
     * Get discrip4
     *
     * @return string
     */
    public function getDiscrip4()
    {
        return $this->discrip4;
    }

    /**
     * Set discrip5
     *
     * @param string $discrip5
     *
     * @return Sale
     */
    public function setDiscrip5($discrip5)
    {
        $this->discrip5 = $discrip5;

        return $this;
    }

    /**
     * Get discrip5
     *
     * @return string
     */
    public function getDiscrip5()
    {
        return $this->discrip5;
    }

    /**
     * Set discrip6
     *
     * @param string $discrip6
     *
     * @return Sale
     */
    public function setDiscrip6($discrip6)
    {
        $this->discrip6 = $discrip6;

        return $this;
    }

    /**
     * Get discrip6
     *
     * @return string
     */
    public function getDiscrip6()
    {
        return $this->discrip6;
    }

    /**
     * Set discrip7
     *
     * @param string $discrip7
     *
     * @return Sale
     */
    public function setDiscrip7($discrip7)
    {
        $this->discrip7 = $discrip7;

        return $this;
    }

    /**
     * Get discrip7
     *
     * @return string
     */
    public function getDiscrip7()
    {
        return $this->discrip7;
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
     * @var string
     */
    private $supplier;

    /**
     * @var string
     */
    private $supplier1;

    /**
     * @var string
     */
    private $supplier2;


    /**
     * Set supplier
     *
     * @param string $supplier
     *
     * @return Sale
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier
     *
     * @return string
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Set supplier1
     *
     * @param string $supplier1
     *
     * @return Sale
     */
    public function setSupplier1($supplier1)
    {
        $this->supplier1 = $supplier1;

        return $this;
    }

    /**
     * Get supplier1
     *
     * @return string
     */
    public function getSupplier1()
    {
        return $this->supplier1;
    }

    /**
     * Set supplier2
     *
     * @param string $supplier2
     *
     * @return Sale
     */
    public function setSupplier2($supplier2)
    {
        $this->supplier2 = $supplier2;

        return $this;
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
    private $gst;

    /**
     * @var float
     */
    private $gst1;

    /**
     * @var float
     */
    private $gst2;

    /**
     * @var float
     */
    private $gst3;

    /**
     * @var float
     */
    private $gst4;

    /**
     * @var float
     */
    private $gst5;

    /**
     * @var float
     */
    private $gst6;

    /**
     * @var float
     */
    private $gst7;

    /**
     * @var float
     */
    private $gst8;

    /**
     * @var float
     */
    private $gst9;


    /**
     * Set gst
     *
     * @param float $gst
     *
     * @return Sale
     */
    public function setGst($gst)
    {
        $this->gst = $gst;

        return $this;
    }

    /**
     * Get gst
     *
     * @return float
     */
    public function getGst()
    {
        return number_format((float)$this->gst,2, '.', '');
    }

    /**
     * Set gst1
     *
     * @param float $gst1
     *
     * @return Sale
     */
    public function setGst1($gst1)
    {
        $this->gst1 = $gst1;

        return $this;
    }

    /**
     * Get gst1
     *
     * @return float
     */
    public function getGst1()
    {
        return number_format((float)$this->gst1,2, '.', '');
    }

    /**
     * Set gst2
     *
     * @param float $gst2
     *
     * @return Sale
     */
    public function setGst2($gst2)
    {
        $this->gst2 = $gst2;

        return $this;
    }

    /**
     * Get gst2
     *
     * @return float
     */
    public function getGst2()
    {
        return number_format((float)$this->gst2,2, '.', '');
    }

    /**
     * Set gst3
     *
     * @param float $gst3
     *
     * @return Sale
     */
    public function setGst3($gst3)
    {
        $this->gst3 = $gst3;

        return $this;
    }

    /**
     * Get gst3
     *
     * @return float
     */
    public function getGst3()
    {
        return number_format((float)$this->gst3,2, '.', '');
    }

    /**
     * Set gst4
     *
     * @param float $gst4
     *
     * @return Sale
     */
    public function setGst4($gst4)
    {
        $this->gst4 = $gst4;

        return $this;
    }

    /**
     * Get gst4
     *
     * @return float
     */
    public function getGst4()
    {
        return number_format((float)$this->gst4,2, '.', '');
    }

    /**
     * Set gst5
     *
     * @param float $gst5
     *
     * @return Sale
     */
    public function setGst5($gst5)
    {
        $this->gst5 = $gst5;

        return $this;
    }

    /**
     * Get gst5
     *
     * @return float
     */
    public function getGst5()
    {
        return number_format((float)$this->gst5,2, '.', '');
    }

    /**
     * Set gst6
     *
     * @param float $gst6
     *
     * @return Sale
     */
    public function setGst6($gst6)
    {
        $this->gst6 = $gst6;

        return $this;
    }

    /**
     * Get gst6
     *
     * @return float
     */
    public function getGst6()
    {
        return number_format((float)$this->gst6,2, '.', '');
    }

    /**
     * Set gst7
     *
     * @param float $gst7
     *
     * @return Sale
     */
    public function setGst7($gst7)
    {
        $this->gst7 = $gst7;

        return $this;
    }

    /**
     * Get gst7
     *
     * @return float
     */
    public function getGst7()
    {
        return number_format((float)$this->gst7,2, '.', '');
    }

    /**
     * Set gst8
     *
     * @param float $gst8
     *
     * @return Sale
     */
    public function setGst8($gst8)
    {
        $this->gst8 = $gst8;

        return $this;
    }

    /**
     * Get gst8
     *
     * @return float
     */
    public function getGst8()
    {
        return number_format((float)$this->gst8,2, '.', '');
    }

    /**
     * Set gst9
     *
     * @param float $gst9
     *
     * @return Sale
     */
    public function setGst9($gst9)
    {
        $this->gst9 = $gst9;

        return $this;
    }

    /**
     * Get gst9
     *
     * @return float
     */
    public function getGst9()
    {
        return number_format((float)$this->gst9,2, '.', '');
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
        $this->unit_tax_other = number_format((float)$this->getGst()+$this->getGst1()+$this->getGst2()+$this->getGst3()+$this->getGst4()+$this->getGst5()+$this->getGst6()+$this->getGst7()+$this->getGst8()+$this->getGst9(),2, '.', '');
        return $this->unit_tax_other;
    }

//    public function __toString()
//    {
//        return $this->id."";
//        // TODO: Implement __toString() method.
//    }
}
