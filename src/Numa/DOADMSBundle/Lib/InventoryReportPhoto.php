<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.31
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOADMSBundle\Entity\Sale;

class InventoryReportPhoto extends Report
{
    //"columnLetter" =array("entity property","title")

    public $mapFields = array(
        "A" => array("photo", "Photo"),
        "B" => array("stockNr", "Stock nr"),
        "C" => array("vin", "VIN #"),
        "D" => array("year", "Year"),
        "E" => array("make", "Make"),
        "F" => array("model", "Model"),
        "G" => array("bodyStyle", "Boy Style"),
        "H"=>array("sale:totalUnitCost","Total Cost Unit"),
    );

    public function setCellValue($letter, $number, $entity, $field)
    {
        $this->setCellValueWithPhoto($letter, $number, $entity, $field);
    }

    public function createTotals(){

        $totalUnitCost=0;
        foreach ($this->getEntities() as $entity) {
            if($entity->getSale() instanceof Sale) {
                $totalUnitCost += $entity->getSale()->getTotalUnitCost();
            }
        }

        $this->row++;
        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
        $this->phpExcelObject->getActiveSheet()->setCellValue("G".$this->row , "TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("H".$this->row , $totalUnitCost);

        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
        $this->phpExcelObject->getActiveSheet()->getStyle("G1:".$highestColumn.$highestRow)->getNumberFormat()->setFormatCode('0.00');
    }

    public function createExcelContent()
    {
        parent::createExcelContent();
        $this->createTotals();
    }
}