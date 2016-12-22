<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.31
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOADMSBundle\Entity\Sale;

class UnitRevenueReport extends Report
{
    //"columnLetter" =array("entity property","title")
    public $mapFields = array(
        "A" => array("stockNr", "Stock nr"),
        "B" => array("vin", "VIN #"),
        "C" => array("year", "Year"),
        "D" => array("make", "Make"),
        "E" => array("model", "Model"),
        "F" => array("sale:sellingPrice", "Selling Price"),
        "G" => array("sale:warranty1", "Warranty"),
        "H" => array("sale:lifeInsur", "Life Ins"),
        "I" => array("sale:disabilityIns1", "Disability Ins"),
        "J" => array("sale:adminFees1", "Admin Fee"),
        "K" => array("sale:docFees1", "Doc Fee"),
        "L" => array("sale:protectPkg1", "Prot Pkg"),
        "M" => array("sale:insurance1", "Insur"),
        "N" => array("sale:bankCommis", "Bank Comm"),
        "O" => array("sale:other1", "Other 1"),
        "P" => array("sale:other2", "Other 2"),
        "Q" => array("sale:other3", "Other 3"),
        "R" => array("sale:totalRevenue", "Total Rev"),

    );

    public function setCellValue($letter, $number, $entity, $field)
    {
        $listing = $this->container->get('numa.dms.listing');
        $value = $listing->getProperty($entity, $field[0]);
        $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
        if ($number > "E" && $letter > 1) {
            if (is_numeric($value)) {
                $this->phpExcelObject->getActiveSheet()->getStyle($number . $letter)->getNumberFormat()->setFormatCode('0.00');
            }
        }
    }


    public function createTotals()
    {

        $sellingPrice = 0;
        $warranty1 = 0;
        $lifeInsur = 0;
        $disabilityIns1 = 0;
        $adminFees1 = 0;
        $docFees1 = 0;
        $protectPkg1 = 0;
        $insurance1 = 0;
        $bankCommis = 0;
        $other1 = 0;
        $other2 = 0;
        $other3 = 0;
        $totalRevenue = 0;
        foreach ($this->getEntities() as $entity) {
            if ($entity->getSale() instanceof Sale) {
                $sellingPrice += $entity->getSale()->getSellingPrice();
                $warranty1 += $entity->getSale()->getWarranty1();
                $lifeInsur += $entity->getSale()->getLifeInsur();
                $disabilityIns1 += $entity->getSale()->getDisabilityIns1();
                $adminFees1 += $entity->getSale()->getAdminFees1();
                $docFees1 += $entity->getSale()->getDocFees1();
                $protectPkg1 += $entity->getSale()->getProtectPkg1();
                $insurance1 += $entity->getSale()->getInsurance1();
                $bankCommis += $entity->getSale()->getBankCommis();
                $other1 += $entity->getSale()->getOther1();
                $other2 += $entity->getSale()->getOther2();
                $other3 += $entity->getSale()->getOther3();
                $totalRevenue += $entity->getSale()->getTotalRevenue();
            }
        }

        $this->row++;
//        $this->phpExcelObject->getActiveSheet()->getStyle("F2:H3")->getNumberFormat()->setFormatCode('0.00');
        $this->phpExcelObject->getActiveSheet()->setCellValue("E" . $this->row, "TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("F" . $this->row, $sellingPrice);
        $this->phpExcelObject->getActiveSheet()->setCellValue("G" . $this->row, $warranty1);
        $this->phpExcelObject->getActiveSheet()->setCellValue("H" . $this->row, $lifeInsur);
        $this->phpExcelObject->getActiveSheet()->setCellValue("I" . $this->row, $disabilityIns1);
        $this->phpExcelObject->getActiveSheet()->setCellValue("J" . $this->row, $adminFees1);
        $this->phpExcelObject->getActiveSheet()->setCellValue("K" . $this->row, $docFees1);
        $this->phpExcelObject->getActiveSheet()->setCellValue("L" . $this->row, $protectPkg1);
        $this->phpExcelObject->getActiveSheet()->setCellValue("M" . $this->row, $insurance1);
        $this->phpExcelObject->getActiveSheet()->setCellValue("N" . $this->row, $bankCommis);
        $this->phpExcelObject->getActiveSheet()->setCellValue("O" . $this->row, $other1);
        $this->phpExcelObject->getActiveSheet()->setCellValue("P" . $this->row, $other2);
        $this->phpExcelObject->getActiveSheet()->setCellValue("Q" . $this->row, $other3);
        $this->phpExcelObject->getActiveSheet()->setCellValue("R" . $this->row, $totalRevenue);
    }

    public function createExcelContent()
    {
        parent::createExcelContent();
        $this->createTotals();
    }
}