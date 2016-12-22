<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.31
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOADMSBundle\Entity\Sale;

class PurchaseReport extends Report
{
    //"columnLetter" =array("entity property","title")
    public $mapFields = array(
        "A"=>array("vendor","Vendor"),
        "B"=>array("vin","VIN #"),
        "C"=>array("stockNr","Stock nr"),
        "D"=>array("year","Year"),
        "E"=>array("make","Make"),
        "F"=>array("model","Model"),
        "G"=>array("sale:invoiceDateFormated","Inv Date"),
        "H"=>array("sale:id","Inv #"),
        "I"=>array("sale:invoiceAmt","Inv Amt"),
        "J"=>array("sale:totalUnitCost","Total Cost Unit"),

    );

    public function setCellValue($letter,$number,$entity,$field){
       $listing = $this->container->get('numa.dms.listing');
       $value   = $listing->getProperty($entity,$field[0]);
       $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
    }

    public function createTotals(){

        $totalInvoiceAmt=0;
        $totalUnitCost=0;
        foreach ($this->getEntities() as $entity) {
            if($entity->getSale() instanceof Sale) {
                $totalInvoiceAmt += $entity->getSale()->getInvoiceAmt();
                $totalUnitCost += $entity->getSale()->getTotalUnitCost();
            }
        }

        $this->row++;
        $this->phpExcelObject->getActiveSheet()->setCellValue("H".$this->row , "TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("I".$this->row , $totalInvoiceAmt);
        $this->phpExcelObject->getActiveSheet()->setCellValue("j".$this->row , $totalUnitCost);

        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
        $this->phpExcelObject->getActiveSheet()->getStyle("I1:".$highestColumn.$highestRow)->getNumberFormat()->setFormatCode('0.00');
    }

    public function createExcelContent()
    {
        parent::createExcelContent();
        $this->createTotals();
    }
}