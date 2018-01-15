<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.31
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOADMSBundle\Entity\Sale;

class InventoryReport extends Report
{
    //"columnLetter" =array("entity property","title")
    public $mapFields = array(
        "A"=>array("stockNr","Stock nr"),
        "B"=>array("vin","VIN #"),
        "C"=>array("year","Year"),
        "D"=>array("make","Make"),
        "E"=>array("model","Model"),
        "F"=>array("trim","Trim"),
        "G"=>array("mileage","Mileage"),
        "H"=>array("sale:totalUnitCost","Total Cost Unit"),
        "J"=>array("price","Selling Price"),

    );

    public function setCellValue($letter,$number,$entity,$field){
       $listing = $this->container->get('numa.dms.listing');
       $value   = $listing->getProperty($entity,$field[0]);
       $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
    }

    public function createTotals(){

        $totalUnitCost=0;
        $totalSellingPrice=0;
        foreach ($this->getEntities() as $entity) {
            $totalSellingPrice += $entity->getPrice();
            if($entity->getSale() instanceof Sale) {
                $totalUnitCost += $entity->getSale()->getTotalUnitCost();
            }
        }

        $this->row++;
        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
        $this->phpExcelObject->getActiveSheet()->setCellValue("G".$this->row , "TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("H".$this->row , $totalSellingPrice);
        $this->phpExcelObject->getActiveSheet()->setCellValue("J".$this->row , $totalUnitCost);

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