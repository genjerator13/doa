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

class BillOfSaleReport extends Report
{
    //"columnLetter" =array("entity property","title")
    public $mapFields = array(
        "A" => array("billing:dateBilling", "INVOICE DATE"),
        "B" => array("year", "YEAR"),
        "C" => array("make", "MAKE"),
        "D" => array("model", "MODEL"),
        "E" => array("billing:salePrice", "SALE PRICE"),
        "F" => array("billing:adminFee", "DOC FEE"),
        "G" => array("billing:tosTotal", "TOTAL"),
        "H" => array("billing:lessTradeIn", "LESS TRADE IN"),
        "I" => array("billing:DifferencePayable", "DIFF PAYABLE"),
        "J" => array("billing:otherMisc1", "PST"),
        "K" => array("billing:otherMisc2", "GST"),
        "L" => array("billing:bankRegistrationFee", "OTHER FEE"),
        "M" => array("sale:other1", "OTHER 1"),
        "N" => array("sale:other2", "OTHER 2"),
        "O" => array("sale:other3", "OTHER 3"),
        "Q" => array("billing:Customer:", "Cust Name"),
        "R" => array("billing:CustomerAddress:", "Cust Address"),
        "S" => array("billing:CustomerCity:", "Cust City"),
        "T" => array("billing:CustomerPhone:", "Cust Phone"),
        "U" => array("billing:CustomerEmail:", "Cust Email"),
        "V" => array("billing:lessDeposit", "Less deposit"),
        "W" => array("billing:tidMake", "Trade-in Make"),
        "X" => array("billing:tidModel", "Trade-In Model"),
        "Y" => array("billing:tidYear", "Trade-in Year"),
        "Z" => array("billing:tidVin", "Trade-in Vin"),
        "AA" => array("billing:LienOnTradeIn", "Lien On Trade In"),
        "AB" => array("billing:LessTradeInTax", "Less Trade In Tax"),
        //"P" => array("customer:fullName", "Cust Name"),
        //"Q" => array("id", "Item id"),
       // "O" => "TOTAL REC'D",
        //- Customer Name
        //- Customer Address
        //- Customer City
        //- Customer Postal
        //- Customer Phone
        //- Customer email
        //- Less Deposit
        //- Trade-in Make
        //- Trade-In Model
        //- Trade-in Year
        //- Trade-in Vin
        //- Lien On Trade In
        //- Less Trade-in Tax
        //- Less Deposit
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
            "P1",
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
                "P$row",
                "=SUM(I$row:O$row)"
            );
    }


}