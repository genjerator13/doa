<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.31
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOADMSBundle\Entity\Sale;

class UnitProfitReport extends Report
{
    //"columnLetter" =array("entity property","title")
    public $mapFields = array(
//        "A"=>array("vendor","Vendor"),
        "A"=>array("stockNr","Stock nr"),
        "B"=>array("vin","VIN #"),
        "C"=>array("sale:totalRevenue","Total Rev"),
        "D"=>array("sale:totalUnitCost","Unit Cost"),
        "E"=>array("sale:tradeIn","Trade In"),
        "F"=>array("sale:totalSaleCost","Sale Cost"),
        "G"=>array("sale:revenueThisUnit","Rev This Unit"),

    );

    public function setCellValue($letter,$number,$entity,$field){
       $listing = $this->container->get('numa.dms.listing');
       $value   = $listing->getProperty($entity,$field[0]);
       $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
    }

    public function createTotals(){

        $totalRevenue=0;
        $totalUnitCost=0;
        $totalSaleCost=0;
        $revenueThisUnit=0;
        $tradeIn=0;
        foreach ($this->getEntities() as $entity) {
            if($entity->getSale() instanceof Sale) {
                $totalRevenue += $entity->getSale()->getTotalRevenue();
                $totalUnitCost += $entity->getSale()->getTotalUnitCost();
                $totalSaleCost += $entity->getSale()->getTotalSaleCost();
                $revenueThisUnit += $entity->getSale()->getRevenueThisUnit();
                $tradeIn += $entity->getSale()->getTradeIn();
            }
        }

        $this->row++;
        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
        $this->phpExcelObject->getActiveSheet()->setCellValue("B".$this->row , "TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("C".$this->row , $totalRevenue);
        $this->phpExcelObject->getActiveSheet()->setCellValue("D".$this->row , $totalUnitCost);
        $this->phpExcelObject->getActiveSheet()->setCellValue("E".$this->row , $tradeIn);
        $this->phpExcelObject->getActiveSheet()->setCellValue("F".$this->row , $totalSaleCost);
        $this->phpExcelObject->getActiveSheet()->setCellValue("G".$this->row , $revenueThisUnit);

        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
        $this->phpExcelObject->getActiveSheet()->getStyle("C1:".$highestColumn.$highestRow)->getNumberFormat()->setFormatCode('0.00');
    }

    public function createExcelContent()
    {
        parent::createExcelContent();
        $this->createTotals();
    }
}