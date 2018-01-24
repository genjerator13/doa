<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.31
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\Sale;

class SaleReport extends Report
{
    //"columnLetter" =array("entity property","title")
    public $mapFields = array(
        "A" => array("billing:dateBilling", "Invoice Date"),
        "B" => array("billing:salesPerson", "Sale Person"),
        "C" => array("billing:customer", "Cust Name"),
        "D" => array("VIN", "Vin"),
        "E" => array("stockNr", "Stock nr"),
        "F" => array("year", "Year"),
        "G" => array("make", "Make"),
        "H" => array("model", "Model"),
        "I" => array("sale:sellingPrice", "Sold For"),
        "J" => array("sale:totalRevenue", "Total Rev"),
        "K" => array("billing:otherMisc1", "PST Total"),
        "L" => array("billing:otherMisc2", "GST Total"),
    );

    public function setCellValue($letter, $number, $entity, $field)
    {

        $listing = $this->container->get('numa.dms.listing');
        $value = $listing->getProperty($entity->getItem(), $field[0]);
        if($value instanceof \DateTime){
            $value = $value->format("Y-m-d");
        }
        $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
    }

    public function createTotals($entities){

        $sellingPrice=0;
        $totalRevenue=0;
        $totalPST=0;
        $totalGST=0;
        foreach ($entities as $entity) {
            if($entity->getItem()->getSale() instanceof Sale) {
                $sellingPrice += $entity->getItem()->getSale()->getSellingPrice();
                $totalRevenue += $entity->getItem()->getSale()->getTotalRevenue();
                $totalPST += $entity->getItem()->getSale()->getRelatedTaxes1();
                $totalGST += $entity->getItem()->getSale()->getRelatedTaxes2();
            }
        }

        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
        $this->phpExcelObject->getActiveSheet()->setCellValue("H".$this->row , "SUB-TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("I".$this->row , $sellingPrice);
        $this->phpExcelObject->getActiveSheet()->setCellValue("J".$this->row , $totalRevenue);
        $this->phpExcelObject->getActiveSheet()->setCellValue("K".$this->row , $totalPST);
        $this->phpExcelObject->getActiveSheet()->setCellValue("L".$this->row , $totalGST);

//        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
//        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
//        $this->phpExcelObject->getActiveSheet()->getStyle("G1:".$highestColumn.$highestRow)->getNumberFormat()->setFormatCode('0.00');
    }

    public function createTotalsTotals(){

        $sellingPrice=0;
        $totalRevenue=0;
        $totalPST=0;
        $totalGST=0;
        foreach ($this->getEntities() as $entity) {
            if($entity->getItem()->getSale() instanceof Sale) {
                $sellingPrice += $entity->getItem()->getSale()->getSellingPrice();
                $totalRevenue += $entity->getItem()->getSale()->getTotalRevenue();
                $totalPST += $entity->getItem()->getSale()->getRelatedTaxes1();
                $totalGST += $entity->getItem()->getSale()->getRelatedTaxes2();
            }
        }

        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
        $this->phpExcelObject->getActiveSheet()->setCellValue("H".$this->row , "TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("I".$this->row , $sellingPrice);
        $this->phpExcelObject->getActiveSheet()->setCellValue("J".$this->row , $totalRevenue);
        $this->phpExcelObject->getActiveSheet()->setCellValue("K".$this->row , $totalPST);
        $this->phpExcelObject->getActiveSheet()->setCellValue("L".$this->row , $totalGST);

        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
        $this->phpExcelObject->getActiveSheet()->getStyle("H1:".$highestColumn.$highestRow)->getNumberFormat()->setFormatCode('0.00');
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
            $this->createTotals($salesPerson);
            $this->row += 2;
        }

        $this->createTotalsTotals();
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
}