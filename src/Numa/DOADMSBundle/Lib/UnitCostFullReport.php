<?php

namespace Numa\DOADMSBundle\Lib;


use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\Sale;

class UnitCostFullReport extends Report
{

    public $mapFields = array(
        "A" => array("stockNr", "Stock nr"),
        "B" => array("VIN", "Vin"),
        "C" => array("year", "Year"),
        "D" => array("make", "Make"),
        "E" => array("model", "Model"),
        "F"=>array("sale:invoiceNr","Inv #"),
        "G"=>array("sale:invoiceAmt","Inv Amt"),
        "H" => array("billing:otherMisc1", "PST"),
        "I" => array("billing:otherMisc2", "GST"),
        "J" => array("sale:delivery", "Delivery"),
        "K" => array("sale:gstDelivery", "GST Delivery"),
        "L" => array("sale:vendorDelivery", "Vendor Delivery"),
        "M" => array("sale:lotPak", "Lot Pak"),
        "N" => array("sale:tagFee", "Tag Fee"),
        "O" => array("sale:cleanUp", "Clean Up"),
        "P" => array("sale:gstCleanUp", "GST"),
        "Q" => array("sale:VendorCleanUp", "Vendor"),
        "R" => array("sale:glass", "Glass"),
        "S" => array("sale:gstGlass", "GST"),
        "T" => array("sale:VendorGlass", "Vendor"),
        "U" => array("sale:bodyShop", "Body Shop"),
        "V" => array("sale:gstBodyShop", "GST"),
        "W" => array("sale:VendorBodyShop", "Vendor"),
        "X" => array("sale:mechanical1", "Mechanic 1"),
        "Y" => array("sale:gstMechanic1", "GST"),
        "Z" => array("sale:VendorMechanic1", "Vendor"),
        "AA" => array("sale:mechanical2", "Mechanic 2"),
        "AB" => array("sale:gstMechanic2", "GST"),
        "AC" => array("sale:VendorMechanic2", "Vendor"),
        "AD" => array("sale:otherExp1", "Other Exp 1"),
        "AE" => array("sale:gstOtherExp1", "GST"),
        "AF" => array("sale:VendorOtherExp2", "Vendor"),
        "AG" => array("sale:otherExp2", "Other Exp 2"),
        "AH" => array("sale:gstOtherExp2", "GST"),
        "AI" => array("sale:VendorOtherExp2", "Vendor"),
        "AJ" => array("sale:otherExp3", "Other Exp 3"),
        "AK" => array("sale:gstOtherExp3", "GST"),
        "AL" => array("sale:VendorOtherExp3", "Vendor"),
        "AM" => array("sale:otherExp4", "Other Exp 4"),
        "AN" => array("sale:gstOtherExp4", "GST"),
        "AO" => array("sale:VendorOtherExp4", "Vendor"),
        "AP" => array("sale:otherExp5", "Other Exp 5"),
        "AR" => array("sale:gstOtherExp5", "GST"),
        "AS" => array("sale:VendorOtherExp5", "Vendor"),
        "AT" => array("sale:otherExp6", "Other Exp 6"),
        "AU" => array("sale:gstOtherExp6", "GST"),
        "AV" => array("sale:VendorOtherExp6", "Vendor"),
        "AW" => array("sale:otherExp7", "Other Exp 7"),
        "AX" => array("sale:gstOtherExp7", "GST"),
        "AY" => array("sale:VendorOtherExp7", "Vendor"),

//        "I" => array("billing:delivery", "Tag Fee"),
//        "I" => array("billing:delivery", "Clean Up"),
//
//        "A" => array("billing:salesPerson", "Sales Person"),
//        "B" => array("billing:customer", "Cust Name"),
//
//
//        "G" => array("sale:sellingPrice", "Sold For"),
//        "H" => array("sale:totalRevenue", "Total Rev"),
//        "I" => array("sale:salesComms", "Sales Comm"),
    );

    public function setCellValue($letter, $number, $entity, $field)
    {
        $listing = $this->container->get('numa.dms.listing');
        $value = $listing->getProperty($entity, $field[0]);
        $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
    }

    public function createTotals($entities){

//        $sellingPrice=0;
//        $totalRevenue=0;
//        $totalSalesComms=0;
//        foreach ($entities as $entity) {
//            if($entity->getItem()->getSale() instanceof Sale) {
//                $sellingPrice += $entity->getItem()->getSale()->getSellingPrice();
//                $totalRevenue += $entity->getItem()->getSale()->getTotalRevenue();
//                $totalSalesComms += $entity->getItem()->getSale()->getSalesComms();
//            }
//        }
////total
//        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
//        $this->phpExcelObject->getActiveSheet()->setCellValue("F".$this->row , "SUB-TOTAL:");
//        $this->phpExcelObject->getActiveSheet()->setCellValue("G".$this->row , $sellingPrice);
//        $this->phpExcelObject->getActiveSheet()->setCellValue("H".$this->row , $totalRevenue);
//        $this->phpExcelObject->getActiveSheet()->setCellValue("I".$this->row , $totalSalesComms);

//        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
//        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
//        $this->phpExcelObject->getActiveSheet()->getStyle("G1:".$highestColumn.$highestRow)->getNumberFormat()->setFormatCode('0.00');
    }

    public function createTotalsTotals(){

//        $sellingPrice=0;
//        $totalRevenue=0;
//        $totalSalesComms=0;
//        foreach ($this->getEntities() as $entity) {
//            if($entity->getItem()->getSale() instanceof Sale) {
//                $sellingPrice += $entity->getItem()->getSale()->getSellingPrice();
//                $totalRevenue += $entity->getItem()->getSale()->getTotalRevenue();
//                $totalSalesComms += $entity->getItem()->getSale()->getSalesComms();
//            }
//        }
//
//        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
//        $this->phpExcelObject->getActiveSheet()->setCellValue("F".$this->row , "TOTAL:");
//        $this->phpExcelObject->getActiveSheet()->setCellValue("G".$this->row , $sellingPrice);
//        $this->phpExcelObject->getActiveSheet()->setCellValue("H".$this->row , $totalRevenue);
//        $this->phpExcelObject->getActiveSheet()->setCellValue("I".$this->row , $totalSalesComms);
//
//        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
//        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
//        $this->phpExcelObject->getActiveSheet()->getStyle("G1:".$highestColumn.$highestRow)->getNumberFormat()->setFormatCode('0.00');
    }

//    public function createExcelContent()
//    {
//        $salesPersonArray = $this->prepareEntities();
//        $this->createExcelHeaders();
//        $this->row = 2;
//        dump($salesPersonArray);die();
//        foreach ($salesPersonArray as $salesPerson) {
//            foreach ($salesPerson as $item) {
//                foreach ($this->mapFields as $key => $field) {
//                    $this->setCellValue($this->row, $key, $item, $field);
//                }
//                $this->row++;
//            }
//            $this->createTotals($salesPerson);
//            $this->row += 2;
//        }
//
//        $this->createTotalsTotals();
//    }
//
//    public function prepareEntities()
//    {
//        $res = array();
//        $em = $this->container->get('doctrine.orm.entity_manager');
//
//        foreach ($this->entities as $entity) {
//            if ($entity instanceof Billing) {
//                $res[$entity->getSalesPerson()][] = $entity;
//            }
//        }
//        return $res;
//    }
}