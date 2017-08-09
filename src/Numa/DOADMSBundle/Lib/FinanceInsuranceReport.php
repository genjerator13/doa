<?php

namespace Numa\DOADMSBundle\Lib;


use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\Sale;

class FinanceInsuranceReport extends Report
{
    //"columnLetter" =array("entity property","title")
    public $mapFields = array(
        "A" => array("billing:salesPerson", "Sales Person"),
        "B" => array("billing:customer", "Customer"),
        "C" => array("StockNr", "Stock #"),
        "D" => array("billing:warranty", "Warranty"),
        "E" => array("billing:protectionPkg", "Protect Pkg"),
        "F" => array("billing:lifeInsurance", "Life Insurance"),
        "G" => array("billing:DisabilityInsurance", "Disability Insurance"),
        "H" => array("billing:insurance", "Insurance"),
        "I" => array("billing:adminFee", "Admin Fee"),
        "J" => array("billing:BankRegistrationFee", "Bank Commission"),
        "K" => array("billing:tax1", "Other 1"),
        "L" => array("billing:tax2", "Other 2"),
        "M" => array("billing:tax3", "Other 3"),
        "N" => array("total", "Total"),
    );

    public function setCellValue($letter, $number, $entity, $field)
    {
        $item = $entity->getItem();
        if ($item instanceof Item) {
            $sale = $item->getSale();

        }
        $warranty = 0;
        $protectionPkg = 0;
        $lifeInsurance = 0;
        $disabilityIns = 0;
        $insurance = 0;
        $adminFees = 0;
        $other1 = 0;
        $other2 = 0;
        $other3 = 0;
        $bankCommision = 0;
        if ($sale instanceof Sale) {
            $warranty = $sale->getWarranty1() - $sale->getWarranty();
            $protectionPkg = $sale->getProtectPkg1() - $sale->getProtectPkg();
            $lifeInsurance = $sale->getLifeInsur() - $sale->getLifeIns();
            $disabilityIns = $sale->getDisabilityIns1() - $sale->getDisabilityIns();
            $insurance = $sale->getInsurance1() - $sale->getInsurance();
            $adminFees = $sale->getAdminFees1() - $sale->getAdminFees();
            $other1 = $sale->getOther1() - $sale->getMisc1();
            $other2 = $sale->getOther2() - $sale->getMisc2();
            $other3 = $sale->getOther3() - $sale->getMisc3();
            $bankCommision = $sale->getBankCommis();
        }

        if ($number == "D") {

            $value = $warranty;
        } elseif ($number == "E") {
            $value = $protectionPkg;
        } elseif ($number == "F") {
            $value = $lifeInsurance;
        } elseif ($number == "G") {
            $value = $disabilityIns;
        } elseif ($number == "H") {
            $value = $insurance;
        } elseif ($number == "I") {
            $value = $adminFees;
        } elseif ($number == "K") {
            $value = $other1;
        } elseif ($number == "L") {
            $value = $other2;
        } elseif ($number == "M") {
            $value = $other3;
        } elseif ($number == "N") {
            $total = $warranty + $protectionPkg + $lifeInsurance + $disabilityIns + $insurance + $adminFees + $other1 + $other2 + $other3 + $bankCommision;
            $value = $total;
        } else {
            $listing = $this->container->get('numa.dms.listing');
            $value = $listing->getProperty($entity->getItem(), $field[0]);

        }
        $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
    }

    public function createTotalsTotals(){

        $sellingPrice=0;
        $totalRevenue=0;
        $totalSalesComms=0;
        foreach ($this->getEntities() as $entity) {
            if($entity->getItem()->getSale() instanceof Sale) {
                $sellingPrice += $entity->getItem()->getSale()->getSellingPrice();
                $totalRevenue += $entity->getItem()->getSale()->getTotalRevenue();
                $totalSalesComms += $entity->getItem()->getSale()->getSalesComms();
            }
        }

        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
        $this->phpExcelObject->getActiveSheet()->setCellValue("F".$this->row , "TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("G".$this->row , $sellingPrice);
        $this->phpExcelObject->getActiveSheet()->setCellValue("H".$this->row , $totalRevenue);
        $this->phpExcelObject->getActiveSheet()->setCellValue("I".$this->row , $totalSalesComms);

        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
        $this->phpExcelObject->getActiveSheet()->getStyle("G1:".$highestColumn.$highestRow)->getNumberFormat()->setFormatCode('0.00');
    }

    public function createExcelContent()
    {
        $salesPersonArray = $this->prepareEntities();
        $this->createExcelHeaders();
        $this->row = 2;
//        dump($salesPersonArray);die();
        foreach ($salesPersonArray as $salesPerson) {
            foreach ($salesPerson as $item) {
                foreach ($this->mapFields as $key => $field) {
                    $this->setCellValue($this->row, $key, $item, $field);
                }
                $this->row++;
            }
            //$this->createTotals($salesPerson);
            //$this->row += 2;
        }

        //$this->createTotalsTotals();
    }

    public function prepareEntities()
    {
        $res = array();
        $em = $this->container->get('doctrine.orm.entity_manager');

        foreach ($this->entities as $entity) {
            if ($entity instanceof Billing) {
                $res[$entity->getSalesPerson()][] = $entity;
            }
        }
        return $res;
    }

    public function createTotals($entities){

//        $sellingPrice=0;
//        $totalRevenue=0;
//        $totalSalesComms=0;
//        foreach ($entities as $entity) {
//            if($entity->getItem()->getSale() instanceof Sale) {
//                $sellingPrice += $entity->getItem()->getSale()->getSellingPrice();
//                $totalRevenue += $entity->getItem()->getSale()->getTotalRevenue();
//                $totalSalesComms += $entity->getItem()->getSale()->getSalesComms();
//            }
//        }
//
//        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
//        $this->phpExcelObject->getActiveSheet()->setCellValue("F".$this->row , "SUB-TOTAL:");
//        $this->phpExcelObject->getActiveSheet()->setCellValue("G".$this->row , $sellingPrice);
//        $this->phpExcelObject->getActiveSheet()->setCellValue("H".$this->row , $totalRevenue);
//        $this->phpExcelObject->getActiveSheet()->setCellValue("I".$this->row , $totalSalesComms);

//        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
//        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
//        $this->phpExcelObject->getActiveSheet()->getStyle("G1:".$highestColumn.$highestRow)->getNumberFormat()->setFormatCode('0.00');
    }
}