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

class SaleReport extends Report
{
    //"columnLetter" =array("entity property","title")
    public $mapFields = array(
        "A"=>array("billing:salesPerson","Sale Person"),
        "B"=>array("customer","Cust Name"),
        "C"=>array("VIN","Vin"),
        "C"=>array("stockNr","Stock nr"),
        "D"=>array("year","Year"),
        "E"=>array("make","Make"),
        "F"=>array("model","Model"),
        "G"=>array("sale:invoiceDateFormated","Selling Price"),
        "H"=>array("sale:id","Total Rev"),
    );

    public function setCellValue($letter,$number,$entity,$field){
       $listing = $this->container->get('numa.dms.listing');
       $value   = $listing->getProperty($entity,$field[0]);
       $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
    }

    public function createExcelContent()
    {
        $salesPersonArray = $this->prepareEntities();
        dump($salesPersonArray);
        $this->createExcelHeaders();
        foreach ($this->mapFields as $key => $field) {
            $this->row = 2;
            foreach ($this->entities as $entity) {
                //dump($entity);die();
                $this->setCellValue($this->row, $key, $entity, $field);
                $this->row++;
            }
        }
        die();
    }

    public function prepareEntities(){
        $res = array();
        $em = $this->container->get('doctrine.orm.entity_manager');

        foreach($this->entities as $entity){
            $sale = $entity->getSale();
            if($sale instanceof Sale) {
                dump($sale);
                $res[]['sales_person'] = $sale->getSalesPerson();
            }
        }
    }
}