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
        "A" => array("billing:salesPerson", "Sale Person"),
        "B" => array("billing:customer", "Cust Name"),
        "C" => array("VIN", "Vin"),
        "C" => array("stockNr", "Stock nr"),
        "D" => array("year", "Year"),
        "E" => array("make", "Make"),
        "F" => array("model", "Model"),
        "G" => array("sale:sellingPrice", "Sold For"),
        "H" => array("sale:totalRevenue", "Total Rev"),
    );

    public function setCellValue($letter, $number, $entity, $field)
    {
        $listing = $this->container->get('numa.dms.listing');
        $value = $listing->getProperty($entity->getItem(), $field[0]);
        $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
    }

    public function createTotals($entities){

        $sellingPrice=0;
        $totalRevenue=0;
        foreach ($entities as $entity) {
            if($entity->getItem()->getSale() instanceof Sale) {
                $sellingPrice += $entity->getItem()->getSale()->getSellingPrice();
                $totalRevenue += $entity->getItem()->getSale()->getTotalRevenue();
            }
        }

        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
        $this->phpExcelObject->getActiveSheet()->setCellValue("F".$this->row , "SUB-TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("G".$this->row , $sellingPrice);
        $this->phpExcelObject->getActiveSheet()->setCellValue("H".$this->row , $totalRevenue);

//        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
//        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
//        $this->phpExcelObject->getActiveSheet()->getStyle("G1:".$highestColumn.$highestRow)->getNumberFormat()->setFormatCode('0.00');
    }

    public function createTotalsTotals(){

        $sellingPrice=0;
        $totalRevenue=0;
        foreach ($this->getEntities() as $entity) {
            if($entity->getItem()->getSale() instanceof Sale) {
                $sellingPrice += $entity->getItem()->getSale()->getSellingPrice();
                $totalRevenue += $entity->getItem()->getSale()->getTotalRevenue();
            }
        }

        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
        $this->phpExcelObject->getActiveSheet()->setCellValue("F".$this->row , "TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("G".$this->row , $sellingPrice);
        $this->phpExcelObject->getActiveSheet()->setCellValue("H".$this->row , $totalRevenue);

        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
        $this->phpExcelObject->getActiveSheet()->getStyle("I1:".$highestColumn.$highestRow)->getNumberFormat()->setFormatCode('0.00');
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