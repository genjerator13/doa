<?php
namespace Numa\DOADMSBundle\Lib;

class WorkOrderReport extends Report
{
    //"columnLetter" =array("entity property","title")
    public $mapFields = array(
        "A" => array("invoice_nr", "Invoice #"),
        "B" => array("date_billing", "Date"),
        "C" => array("customer:fullName", "Cust Name"),
        "D" => array("total_balance_due", "Amount"),
    );

    public function setCellValue($letter,$number,$entity,$field){
        $value   = $entity->get($field[0]);
        $this->phpExcelObject->getActiveSheet()->setCellValue($number . $letter, $value);
    }

    public function createTotals(){

        $totalBalanceDue=0;
        foreach ($this->getEntities() as $entity) {
            $totalBalanceDue += $entity->getTotalBalanceDue();
        }

        $this->row++;
        $this->phpExcelObject->getActiveSheet()->getStyle($this->row)->getFont()->setBold(true);
        $this->phpExcelObject->getActiveSheet()->setCellValue("C".$this->row , "TOTAL:");
        $this->phpExcelObject->getActiveSheet()->setCellValue("D".$this->row , $totalBalanceDue);

        $highestColumn = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $this->phpExcelObject->setActiveSheetIndex(0)->getHighestRow();
        $this->phpExcelObject->getActiveSheet()->getStyle("D1:".$highestColumn.$highestRow)->getNumberFormat()->setFormatCode('0.00');
    }

    public function createExcelContent()
    {
        parent::createExcelContent();
        $this->createTotals();
    }
}