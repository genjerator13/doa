<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.31
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\Sale;

class Sale2Report extends Report
{
    //"columnLetter" =array("entity property","title")
    public $mapFields = array(
        "A" => array("billing:dateBilling", "INVOICE DATE"),
        "B" => array("year", "YEAR"),
        "C" => array("make", "MAKE"),
        "D" => array("model", "MODEL"),
        "E" => array("billing:salePrice", "SALE PRICE"),
        "F" => array("billing:docFee", "DOC FEE"),
        "G" => array("billing:tosTotal", "TOTAL"),
        "H" => array("billing:lessTradeIn", "LESS TRADE IN"),
        "I" => array("billing:DifferencePayable", "DIFF PAYABLE"),
        "J" => array("billing:otherMisc1", "GST"),
        "K" => array("billing:otherMisc2", "PST"),
//        "L" => array("sale:otherMisc2", "OTHER 1"),
//        "M" => array("sale:otherMisc2", "OTHER 2"),
//        "N" => array("sale:otherMisc2", "OTHER 3"),
       // "O" => "TOTAL REC'D",
    );


    public function setCellValue($letter,$number,$entity,$field){
        $listing = $this->container->get('numa.dms.listing');
        $value   = $listing->getProperty($entity->getItem(),$field[0]);
        if($value instanceof \DateTime){
            $value = $value->format("Y-m-d");
        }elseif(empty($value)){
            $value=0;
        }
        $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
    }



    public function createExcelContent()
    {

        $this->createExcelHeaders();
        $this->phpExcelObject->getActiveSheet()->setCellValue(
            "O1",
            "TOTAL REC'D"
        );
        foreach ($this->mapFields as $key => $field) {
            $this->row = 2;
            foreach ($this->entities as $entity) {
                //dump($entity);die();
                $this->setCellValue($this->row, $key, $entity, $field);
                $this->totalColumnFormula($this->row);
                $this->row++;

            }

        }


    }

    public function totalColumnFormula($row){
        $this->phpExcelObject->getActiveSheet()->setCellValue(
                "O$row",
                "=SUM(E$row:K$row)"
            );
    }


}