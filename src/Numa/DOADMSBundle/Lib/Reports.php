<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 20.7.16.
 * Time: 15.04
 */

namespace Numa\DOADMSBundle\Lib;


class Reports
{
    protected $container;

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }
    //"columnLetter" =array("entity property","title")
    public $inventoryPurchaseFields = array(
        "B"=>array("item_id","Listing ID"),
        "C"=>array("tid_year","Year"),
        "D"=>array("tid_make","Make"),
        "E"=>array("tid_model","Model"),
        "F"=>array("item:stock_nr","Stock #"),
        "G"=>array("tid_vin","Vin #"),
        "H"=>array("invoice_nr","Invoice #"),
        "I"=>array("date_billing","Invoice Date"),
        "J"=>array("amount","Invoice Amount"),
        "K"=>array("less_trade_in","Trade In Value"),
        "L"=>array("lien_on_trade_in","Lien On Trade In"),
    );

    public $inventorySalesFields = array(
        "B"=>array("customer","Customer Name"),
        "C"=>array("date_billing","Date"),
        "D"=>array("invoice_nr","Invoice #"),
        "E"=>array("tid_year","Year"),
        "F"=>array("tid_make","Make"),
        "G"=>array("tid_model","Model"),
        "H"=>array("item:stock_nr","Stock #"),
        "I"=>array("tid_vin","Vin #"),
        "J"=>array("sale_price","Sale Price"),
        "K"=>array("less_trade_in","Less Trade In"),
        "L"=>array("lien_on_trade_in","Lien On Trade In"),
        "M"=>array("total_due","Total Due"),
    );

    public function createPHPExcelObject($creator="",$title="",$subject="",$desc=""){
        $rendererName = \PHPExcel_Settings::PDF_RENDERER_MPDF;
        $rendererLibraryPath = (dirname(__FILE__) . '/../../../../vendor/mpdf/mpdf'); //works

        if (!\PHPExcel_Settings::setPdfRenderer(
            $rendererName, $rendererLibraryPath
        )) {
            die(
                'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
                '<br />' .
                'at the top of this script as appropriate for your directory structure'
            );
        }
        //disable profiler
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }


        $phpExcelObject = $this->container->get('phpexcel')->createPHPExcelObject();
        //dump($phpExcelObject);
        $phpExcelObject->getProperties()->setCreator($creator)
            ->setLastModifiedBy($creator)
            ->setTitle($title)
            ->setSubject($subject)
            ->setDescription($desc)
        ;
        $phpExcelObject->setActiveSheetIndex(0);
        return $phpExcelObject;
    }

    public function createExcelResponse($phpExcelObject,$filename){

        $download_path = $this->container->getParameter('upload_dealer');

        $writer = $this->container->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->container->get('phpexcel')->createStreamedResponse($writer);
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename='.$filename);
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $writer = $this->container->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        $writer->save($download_path . $filename);

        return $response;
    }
    public function createExcelHeaders($map,$phpExcelObject){
        foreach($this->inventorySalesFields as $key=>$field){
            $phpExcelObject->getActiveSheet()->setCellValue($key . "2", $field[1]);
        }
        return $phpExcelObject;
    }
    public function createExcelContent($entities,$map,$phpExcelObject){
        $phpExcelObject = $this->createExcelHeaders($map,$phpExcelObject);
        foreach($map as $key=>$field){
            $i=3;
            foreach($entities as $entity) {
                //dump($field);
                $phpExcelObject->getActiveSheet()->setCellValue($key . $i, $entity->get($field[0]));
                $i++;
            }
        }
        return $phpExcelObject;
    }

    public function billingReportPurchaseXls($entities)
    {
        $phpExcelObject = $this->createPHPExcelObject("DOA","DOA Purchase report","DOA Purchase report","DOA Purchase report");
        $phpExcelObject = $this->createExcelContent($entities,$this->inventoryPurchaseFields,$phpExcelObject);
        return $this->createExcelResponse($phpExcelObject,"Customer_Details_Report.xls");
    }


    public function billingReportSalesXls($entities)
    {
        $phpExcelObject = $this->createPHPExcelObject("DOA","DOA Sales report","DOA Sales report","DOA sales report");
        $phpExcelObject = $this->createExcelContent($entities,$this->inventorySalesFields,$phpExcelObject);
        return $this->createExcelResponse($phpExcelObject,"Customer_Sales_Report.xls");
    }
}