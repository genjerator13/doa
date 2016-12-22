<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.31
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOADMSBundle\Entity\Sale;

class UnitSalesCostReport extends Report
{
    //"columnLetter" =array("entity property","title")
    public $mapFields = array(
        "A"=>array("stockNr","Stock nr"),
        "B"=>array("vin","VIN #"),
        "C"=>array("year","Year"),
        "D"=>array("make","Make"),
        "E"=>array("model","Model"),
        "F"=>array("sale:warranty","Warranty"),
        "G"=>array("sale:lifeIns","Life Ins"),
        "H"=>array("sale:disabilityIns","Disability Ins"),
        "I"=>array("sale:adminFees","Admin Fee"),
        "J"=>array("sale:docFees","Doc Fee"),
        "K"=>array("sale:protectPkg","Prot Pkg"),
        "L"=>array("sale:insurance","Insur"),
        "M"=>array("sale:feverse","Reserve"),
        "N"=>array("sale:misc1","Misc 1"),
        "O"=>array("sale:misc2","Misc 2"),
        "P"=>array("sale:misc3","Misc 3"),
        "Q"=>array("sale:salesComms","Sales Com"),
        "R"=>array("sale:totalSaleCost","TSC"),

    );

    public function setCellValue($letter,$number,$entity,$field){
       $listing = $this->container->get('numa.dms.listing');
       $value   = $listing->getProperty($entity,$field[0]);
       $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
        if ($number > "E" && $letter > 1) {
            if (is_numeric($value)) {
                $this->phpExcelObject->getActiveSheet()->getStyle($number . $letter)->getNumberFormat()->setFormatCode('0.00');
            }
        }
    }

    public function createTotals(){

        $warranty=0;
        $lifeIns=0;
        $disabilityIns=0;
        $adminFees=0;
        $docFees=0;
        $protectPkg=0;
        $insurance=0;
        $feverse=0;
        $misc1=0;
        $misc2=0;
        $misc3=0;
        $salesComms=0;
        $totalSaleCost=0;
        foreach ($this->getEntities() as $entity) {
            if($entity->getSale() instanceof Sale) {
                $warranty += $entity->getSale()->getWarranty();
                $lifeIns += $entity->getSale()->getLifeIns();
                $disabilityIns += $entity->getSale()->getDisabilityIns();
                $adminFees += $entity->getSale()->getAdminFees();
                $docFees += $entity->getSale()->getDocFees();
                $protectPkg += $entity->getSale()->getProtectPkg();
                $insurance += $entity->getSale()->getInsurance();
                $feverse += $entity->getSale()->getFeverse();
                $misc1 += $entity->getSale()->getMisc1();
                $misc2 += $entity->getSale()->getMisc2();
                $misc3 += $entity->getSale()->getMisc3();
                $salesComms += $entity->getSale()->getSalesComms();
                $totalSaleCost += $entity->getSale()->getTotalSaleCost();
            }
        }

        $this->row++;
        $this->phpExcelObject->getActiveSheet()->setCellValue("E".$this->row , "TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("F".$this->row , $warranty);
        $this->phpExcelObject->getActiveSheet()->setCellValue("G".$this->row , $lifeIns);
        $this->phpExcelObject->getActiveSheet()->setCellValue("H".$this->row , $disabilityIns);
        $this->phpExcelObject->getActiveSheet()->setCellValue("I".$this->row , $adminFees);
        $this->phpExcelObject->getActiveSheet()->setCellValue("J".$this->row , $docFees);
        $this->phpExcelObject->getActiveSheet()->setCellValue("K".$this->row , $protectPkg);
        $this->phpExcelObject->getActiveSheet()->setCellValue("L".$this->row , $insurance);
        $this->phpExcelObject->getActiveSheet()->setCellValue("M".$this->row , $feverse);
        $this->phpExcelObject->getActiveSheet()->setCellValue("N".$this->row , $misc1);
        $this->phpExcelObject->getActiveSheet()->setCellValue("O".$this->row , $misc2);
        $this->phpExcelObject->getActiveSheet()->setCellValue("P".$this->row , $misc3);
        $this->phpExcelObject->getActiveSheet()->setCellValue("Q".$this->row , $salesComms);
        $this->phpExcelObject->getActiveSheet()->setCellValue("R".$this->row , $totalSaleCost);

    }

    public function createExcelContent()
    {
        parent::createExcelContent();
        $this->createTotals();
    }
}