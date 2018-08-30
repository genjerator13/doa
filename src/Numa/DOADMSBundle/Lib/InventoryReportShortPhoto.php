<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.31
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOADMSBundle\Entity\Sale;

class InventoryReportShortPhoto extends Report
{
    //"columnLetter" =array("entity property","title")
    public $mapFields = array(
        "A" => array("photo", "Photo"),
        "B" => array("stockNr", "Stock nr"),
        "C" => array("vin", "VIN #"),
        "D" => array("year", "Year"),
        "E" => array("make", "Make"),
        "F" => array("model", "Model"),
        "G" => array("bodyStyle", "Body Style"),
        "H" => array("exteriorColor", "Exterior Color"),
        "I" => array("mileage", "Mileage"),
        "J" => array("price", "Selling Price"),

    );

    public function createTotals()
    {

        $totalSellingPrice = 0;
        foreach ($this->getEntities() as $entity) {
            $totalSellingPrice += $entity->getPrice();
        }

        $this->row++;
        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
        $this->phpExcelObject->getActiveSheet()->setCellValue("I" . $this->row, "TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("J" . $this->row, $totalSellingPrice);

        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
        $this->phpExcelObject->getActiveSheet()->getStyle("J1:" . $highestColumn . $highestRow)->getNumberFormat()->setFormatCode('0.00');
    }

    public function setCellValue($letter, $number, $entity, $field)
    {
        $this->setCellValueWithPhoto($letter, $number, $entity, $field);
    }

    public function createExcelContent()
    {
        parent::createExcelContent();
        $this->createTotals();
    }
}