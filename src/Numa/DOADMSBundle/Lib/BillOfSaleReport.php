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
        "D" => array("stockNr", "STOCK#"),
        "E" => array("vin", "VIN"),
        "F" => array("billing:salePrice", "SALE PRICE"),
        "G" => array("billing:adminFee", "DOC FEE"),
        "H" => array("billing:tosTotal", "TOTAL"),
        "I" => array("billing:lessTradeIn", "LESS TRADE IN"),
        "J" => array("billing:DifferencePayable", "DIFF PAYABLE"),
        "K" => array("billing:otherMisc1", "PST"),
        "L" => array("billing:otherMisc2", "GST"),

        //p for total
        "M" => array("billing:lessDeposit", "LESS DEPOSITE"),
        "N" => array("billing:LifeInsurance", "LIFE INSURANCE"),
        "O" => array("billing:DisabilityInsurance", "DISABILITY INSURANCE"),
        "P" => array("billing:total", "PAY ON DELIVERY"),
        "Q" => array("billing:bankRegistrationFee", "OTHER FEE"),
        "R" => array("sale:other1", "OTHER 1"),
        "S" => array("sale:other2", "OTHER 2"),
        "T" => array("sale:other3", "OTHER 3"),
        "U" => array("billing:TotalBalanceDue", "TOTAL BALANCE DUE"),
        "V" => array("billing:Customer:", "CUST NAME"),
        "X" => array("billing:CustomerAddress:", "CUST ADDRESS"),
        "Y" => array("billing:CustomerCity:", "CUST CITY"),
        "Z" => array("billing:CustomerPhone:", "CUST PHONE"),
        "AA" => array("billing:CustomerEmail:", "CUST EMAIL"),

        "AB" => array("billing:tidMake", "TRADE IN MAKE"),
        "AC" => array("billing:tidModel", "TRADE IN MODEL"),
        "AD" => array("billing:tidYear", "TRADE IN YEAR"),
        "AE" => array("billing:tidVin", "TRADE IN VIN"),
        "AF" => array("billing:LienOnTradeIn", "LIEAN ON TRADE IN"),
        "AG" => array("billing:LessTradeInTax", "LESS TRADE IN TAX"),
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

//
//
//    public function createExcelContent()
//    {
//
//        $this->createExcelHeaders();
//        $this->phpExcelObject->getActiveSheet()->setCellValue(
//            "P1",
//            "PAY ON DELIVERY"
//        );
//        foreach ($this->mapFields as $key => $field) {
//            $this->row = 2;
//            foreach ($this->entities as $entity) {
//                //dump($entity);die();
//                $this->setCellValue($this->row, $key, $entity, $field);
//                $this->totalColumnFormula($this->row);
//                $this->row++;
//
//            }
//
//        }
//
//
//    }

    public function totalColumnFormula($row){
        $this->phpExcelObject->getActiveSheet()->setCellValue(
                "P$row",
                "=SUM(I$row:O$row)"
            );
    }


}