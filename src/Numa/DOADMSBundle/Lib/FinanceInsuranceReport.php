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
        $item = $entity;

        $calc=$this->calculate($entity);

        if ($number == "D") {
            $value = $calc['warranty'];
        } elseif ($number == "E") {
            $value = $calc['protectionPkg'];

        } elseif ($number == "F") {
            $value = $calc['lifeInsurance'];

        } elseif ($number == "G") {
            $value = $calc['disabilityIns'];
        } elseif ($number == "H") {
            $value = $calc['insurance'];
        } elseif ($number == "I") {
            $value = $calc['adminFees'];
        }elseif ($number == "J") {
            $value = $calc['bankCommission'];
        }
        elseif ($number == "K") {
            $value = $calc['other1'];
        } elseif ($number == "L") {
            $value = $calc['other2'];
        } elseif ($number == "M") {
            $value = $calc['other3'];
        } elseif ($number == "N") {
            $value = $calc['total'];
        } else {
            $listing = $this->container->get('numa.dms.listing');
            $value = $listing->getProperty($entity, $field[0]);

        }
        $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
    }

    public function createTotalsTotals()
    {

        $sellingPrice = 0;
        $totalRevenue = 0;
        $totalSalesComms = 0;
        foreach ($this->getEntities() as $entity) {
            if ($entity->getSale() instanceof Sale) {
                $sellingPrice += $entity->getSale()->getSellingPrice();
                $totalRevenue += $entity->getSale()->getTotalRevenue();
                $totalSalesComms += $entity->getSale()->getSalesComms();
            }
        }

        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
        $this->phpExcelObject->getActiveSheet()->setCellValue("F" . $this->row, "TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("G" . $this->row, $sellingPrice);
        $this->phpExcelObject->getActiveSheet()->setCellValue("H" . $this->row, $totalRevenue);
        $this->phpExcelObject->getActiveSheet()->setCellValue("I" . $this->row, $totalSalesComms);

//        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
//        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
//        $this->phpExcelObject->getActiveSheet()->getStyle("G1:".$highestColumn.$highestRow)->getNumberFormat()->setFormatCode('0.00');
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
            $this->createTotals($salesPerson,"SUB TOTAL");
            $this->row += 2;
        }

        $this->createTotals($this->entities,"TOTAL");
    }

    public function prepareEntities()
    {
        $res = array();
        $em = $this->container->get('doctrine.orm.entity_manager');

        foreach ($this->entities as $entity) {
            if ($entity instanceof Item) {
                if($entity->getBilling()->first() instanceof Billing){}
                $res[$entity->getBilling()->first()->getSalesPerson()][] = $entity;
            }
        }
        return $res;
    }

    public function createTotals($entities,$title="SUB TOTAL")
    {

        $calcAll = array();
        $calcAll['warranty'] =0;
        $calcAll['protectionPkg'] =0;
        $calcAll['lifeInsurance'] =0;
        $calcAll['disabilityIns'] =0;
        $calcAll['insurance'] =0;
        $calcAll['adminFees'] =0;
        $calcAll['bankCommission'] =0;
        $calcAll['other1'] =0;
        $calcAll['other2'] =0;
        $calcAll['other3'] =0;
        $calcAll['total'] =0;
        foreach ($entities as $entity) {
            $calc = $this->calculate($entity);
            $calcAll['warranty'] += $calc['warranty'];
            $calcAll['protectionPkg'] += $calc['protectionPkg'];
            $calcAll['lifeInsurance'] += $calc['lifeInsurance'];
            $calcAll['disabilityIns'] += $calc['disabilityIns'];
            $calcAll['insurance'] += $calc['insurance'];
            $calcAll['adminFees'] += $calc['adminFees'];
            $calcAll['bankCommission'] += $calc['bankCommission'];
            $calcAll['other1'] += $calc['other1'];
            $calcAll['other2'] += $calc['other2'];
            $calcAll['other3'] += $calc['other3'];
            $calcAll['total'] += $calc['total'];
        }

        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
        $this->phpExcelObject->getActiveSheet()->setCellValue("B" . $this->row, $title.":");
        $this->phpExcelObject->getActiveSheet()->setCellValue("D" . $this->row, $calcAll['warranty']);
        $this->phpExcelObject->getActiveSheet()->setCellValue("E" . $this->row, $calcAll['protectionPkg']);
        $this->phpExcelObject->getActiveSheet()->setCellValue("F" . $this->row, $calcAll['lifeInsurance']);
        $this->phpExcelObject->getActiveSheet()->setCellValue("G" . $this->row, $calcAll['disabilityIns']);
        $this->phpExcelObject->getActiveSheet()->setCellValue("H" . $this->row, $calcAll['insurance']);
        $this->phpExcelObject->getActiveSheet()->setCellValue("I" . $this->row, $calcAll['adminFees']);
        $this->phpExcelObject->getActiveSheet()->setCellValue("J" . $this->row, $calcAll['bankCommission']);
        $this->phpExcelObject->getActiveSheet()->setCellValue("K" . $this->row, $calcAll['other1']);
        $this->phpExcelObject->getActiveSheet()->setCellValue("L" . $this->row, $calcAll['other2']);
        $this->phpExcelObject->getActiveSheet()->setCellValue("M" . $this->row, $calcAll['other3']);
        $this->phpExcelObject->getActiveSheet()->setCellValue("N" . $this->row, $calcAll['total']);
        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
        $this->phpExcelObject->getActiveSheet()->getStyle("G1:" . $highestColumn . $highestRow)->getNumberFormat()->setFormatCode('0.00');
    }
    public function calculate(Item $item)
    {
        $warranty = 0;
        $protectionPkg = 0;
        $lifeInsurance = 0;
        $disabilityIns = 0;
        $insurance = 0;
        $adminFees = 0;
        $other1 = 0;
        $other2 = 0;
        $other3 = 0;
        $bankCommission = 0;
        $ret = array();
        if ($item instanceof Item) {
            $sale = $item->getSale();
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
                $bankCommission = $sale->getBankCommis();
                $total = $warranty + $protectionPkg + $lifeInsurance + $disabilityIns + $insurance + $adminFees + $other1 + $other2 + $other3 + $bankCommission;
            }
        }
        $ret['warranty'] = $warranty;
        $ret['protectionPkg'] = $protectionPkg;
        $ret['lifeInsurance'] = $lifeInsurance;
        $ret['disabilityIns'] = $disabilityIns;
        $ret['insurance'] = $insurance;
        $ret['adminFees'] = $adminFees;
        $ret['other1'] = $other1;
        $ret['other2'] = $other2;
        $ret['other3'] = $other3;
        $ret['bankCommission'] = $bankCommission;
        $ret['total'] = $total;
        return $ret;
    }
}