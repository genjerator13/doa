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
        $listing = $this->container->get('numa.dms.listing');
        $value = $listing->getProperty($entity, $field[0]);
        $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);

        if ($field[0] == "photo") {
            $photo = $this->container->get("numa.dms.images")->getAbsoluteImagePathFromItem($entity);
            $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, "");

            if (!empty($photo)) {
                if ($this->container->get("numa.dms.images")->isLocalImage($photo)) {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
                    $objDrawing->setPath($photo);
                    $objDrawing->setOffsetX(5);                       //setOffsetX works properly
                    $objDrawing->setOffsetY(5);                       //setOffsetY works properly
                    $objDrawing->setCoordinates($number . $letter);        //set image to cell
                    $objDrawing->setWidth(120);                 //set width, height
                    $objDrawing->setHeight(80);
                    $objDrawing->setWorksheet($this->phpExcelObject->getActiveSheet());
                    $this->phpExcelObject->getActiveSheet()->getColumnDimension("A")->setWidth(120);
                    $this->phpExcelObject->getActiveSheet()->getRowDimension($letter)->setRowHeight(80);
                } else {
                    $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $photo);
                    $this->phpExcelObject->getActiveSheet()->getCell($number . $letter)->getHyperlink()->setUrl($photo);
                }
            }
        }

    }

    public function createExcelContent()
    {
        parent::createExcelContent();
        $this->phpExcelObject->getActiveSheet()->getColumnDimension("A")->setWidth(120);
    }


}