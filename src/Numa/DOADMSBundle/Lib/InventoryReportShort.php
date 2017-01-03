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

        if ($field[0] == "photo") {
            $photo = $this->container->get("numa.dms.images")->getAbsoluteImagePathFromItem($entity);
            $value = $photo;
            //$signature = "/var/www/doa/web/upload/itemsimages/_2455_1449251113_car-4.jpg";    //Path to signature .jpg file
            if (!empty($photo)) {
                if ($this->container->get("numa.dms.images")->isLocalImage($photo)) {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
//                    $objDrawing->setName('Customer Signature');        //set name to image
//                    $objDrawing->setDescription('Customer Signature'); //set description to image


                    $objDrawing->setPath($photo);


                    $objDrawing->setOffsetX(5);                       //setOffsetX works properly
                    $objDrawing->setOffsetY(5);                       //setOffsetY works properly
                    $objDrawing->setCoordinates($number . $letter);        //set image to cell
                    $objDrawing->setWidth(120);                 //set width, height
                    $objDrawing->setHeight(80);
                    $objDrawing->setWorksheet($this->phpExcelObject->getActiveSheet());
                    $this->phpExcelObject->getActiveSheet()->getColumnDimension("A")->setWidth(120);

                    $this->phpExcelObject->getActiveSheet()->getRowDimension($letter)->setRowHeight(80);

                    $value = "";
                } else {

                }
            }
        }
        $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
    }

    public function createExcelContent()
    {
        parent::createExcelContent();
        $this->phpExcelObject->getActiveSheet()->getColumnDimension("A")->setWidth(120);

        //$this->phpExcelObject->getActiveSheet()->getRowDimension(1)->setRowHeight(80);
//die();
    }


}