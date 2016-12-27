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
        "F"=>array("sale:totalUnitCost","Total Cost Unit"),

    );

    public function setCellValue($letter,$number,$entity,$field){
       $listing = $this->container->get('numa.dms.listing');
       $value   = $listing->getProperty($entity,$field[0]);
       $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
    }

    public function createTotals(){

        $totalUnitCost=0;
        foreach ($this->getEntities() as $entity) {
            if($entity->getSale() instanceof Sale) {
                $totalUnitCost += $entity->getSale()->getTotalUnitCost();
            }
        }

        $this->row++;
        $this->phpExcelObject->getActiveSheet()->setCellValue("E".$this->row , "TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("F".$this->row , $totalUnitCost);

        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
        $this->phpExcelObject->getActiveSheet()->getStyle("F1:".$highestColumn.$highestRow)->getNumberFormat()->setFormatCode('0.00');
    }

    public function createExcelContent()
    {
        parent::createExcelContent();
        $this->createTotals();
    }
}