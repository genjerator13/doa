<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.31
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOADMSBundle\Entity\Sale;

class InventoryReportShort extends Report
{
    //"columnLetter" =array("entity property","title")
    public $mapFields = array(
        "A" => array("photo", "Photo"),
        "B" => array("stockNr", "Stock nr"),
        "C" => array("vin", "VIN #"),
        "D" => array("year", "Year"),
        "E" => array("make", "Make"),
        "F" => array("model", "Model"),

    );

    public function setCellValue($letter, $number, $entity, $field)
    {
        $this->setCellValueWithPhoto($letter, $number, $entity, $field);
    }

    public function createExcelContent()
    {
        parent::createExcelContent();
        $this->phpExcelObject->getActiveSheet()->getColumnDimension("A")->setWidth(120);
    }


}