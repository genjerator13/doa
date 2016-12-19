<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 20.7.16.
 * Time: 15.04
 */

namespace Numa\DOADMSBundle\Lib;


use Doctrine\Common\Collections\Collection;

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
        "A"=>array("Vendor","Vendor"),
        "B"=>array("item:vin","VIN #"),
        "G"=>array("invoice_date","Inv Date"),
        "H"=>array("invoice_nr","Inv #"),
        "I"=>array("invoice_amt","Inv Amt"),
        "J"=>array("total_cost_unit","Total Cost Unit"),
        "L"=>array("id","ID"),
    );

    public $inventorySalesFields = array(
        "A"=>array("customer","Customer Name"),
        "B"=>array("date_billing","Date"),
        "C"=>array("invoice_nr","Invoice #"),
        "D"=>array("tid_year","Year"),
        "E"=>array("tid_make","Make"),
        "F"=>array("tid_model","Model"),
        "G"=>array("item:stock_nr","Stock #"),
        "H"=>array("tid_vin","Vin #"),
        "I"=>array("sale_price","Sale Price"),
        "J"=>array("less_trade_in","Less Trade In"),
        "K"=>array("lien_on_trade_in","Lien On Trade In"),
        "L"=>array("total_due","Total Due"),
    );

    /**
     * Creates php excel object for the reports
     * @param string $creator
     * @param string $title
     * @param string $subject
     * @param string $desc
     * @return mixed phpexcelobject
     */
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
        $phpExcelObject->getProperties()->setCreator($creator)
            ->setLastModifiedBy($creator)
            ->setTitle($title)
            ->setSubject($subject)
            ->setDescription($desc)
        ;
        $phpExcelObject->setActiveSheetIndex(0);
        return $phpExcelObject;
    }

    /**
     * creates excel response from the given phpexcelobject
     * @param $phpExcelObject
     * @param $filename response file name
     * @return Response
     */
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

    /**
     * Creates excel headers from the map array
     * @param $map
     * @param $phpExcelObject
     * @return $phpExcelObject
     */
    public function createExcelHeaders($map,$phpExcelObject){
        foreach($map as $key=>$field){
            $phpExcelObject->getActiveSheet()->setCellValue($key . "1", $field[1]);
        }
        return $phpExcelObject;
    }

    /**
     * Creates excel content from the map array and entities
     * @param $entities Collection
     * @param $map array
     * @param $phpExcelObject
     * @return $phpExcelObject
     */
    public function createExcelContent($entities,$map,$phpExcelObject){
        $phpExcelObject = $this->createExcelHeaders($map,$phpExcelObject);
        foreach($map as $key=>$field){
            $i=2;
            foreach($entities as $entity) {
//                dump($entity);die();
                $phpExcelObject->getActiveSheet()->setCellValue($key . $i, $entity->get($field[0]));
                $i++;
            }
        }
        return $phpExcelObject;
    }

    /**
     * creates purchase report
     * @param $entities
     * @return Response
     *
     */
    public function billingReportPurchaseXls($entities)
    {
        $phpExcelObject = $this->createPHPExcelObject("DOA","DOA Purchase report","DOA Purchase report","DOA Purchase report");
        $phpExcelObject = $this->createExcelContent($entities,$this->inventoryPurchaseFields,$phpExcelObject);
        return $this->createExcelResponse($phpExcelObject,"Customer_Details_Report.xls");
    }

    /**
     * Creatres Sale report
     * @param $entities
     * @return Response
     */
    public function billingReportSalesXls($entities)
    {
        $phpExcelObject = $this->createPHPExcelObject("DOA","DOA Sales report","DOA Sales report","DOA sales report");
        $phpExcelObject = $this->createExcelContent($entities,$this->inventorySalesFields,$phpExcelObject);
        return $this->createExcelResponse($phpExcelObject,"Customer_Sales_Report.xls");
    }
}