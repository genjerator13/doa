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
    public $inventoryPurchaseFields = array(
        "B"=>array("item_id","Listing ID"),
        "C"=>array("item:year","Year"),
        "D"=>array("item:make","Make"),
        "E"=>array("item:model","Model"),
        //"F"=>array("stock","Stock #"),
    );
    public function billingReportXls($entities)
    {

        $rendererName = \PHPExcel_Settings::PDF_RENDERER_MPDF;
        $rendererLibrary = 'mPDF';
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
        $em = $this->container->get("doctrine.orm.entity_manager");

        $download_path = $this->container->getParameter('upload_dealer');
        $phpExcelObject = $this->container->get('phpexcel')->createPHPExcelObject();
        //dump($phpExcelObject);
        $phpExcelObject->getProperties()->setCreator("DOA")
            ->setLastModifiedBy("DOA")
            ->setTitle("DOA billing report")
            ->setSubject("DOA billing report")
            ->setDescription("DOA billing report")
        ;
        $phpExcelObject->setActiveSheetIndex(0);


        $currentRow = 7;
        //$phpExcelObject->getActiveSheet()->setCellValue("B" . $currentRow, $dispatchCards->getDateorder() instanceof \DateTime ? $dispatchCards->getDateorder()->format('m/d/Y') : "");
        $phpExcelObject->getActiveSheet()->setCellValue("K" . $currentRow, "aaaa");

        foreach($this->inventoryPurchaseFields as $key=>$field){
            $phpExcelObject->getActiveSheet()->setCellValue($key . "2", $field[1]);
        }

        foreach($this->inventoryPurchaseFields as $key=>$field){
            $i=3;
            foreach($entities as $entity) {
                //dump($field);
                $phpExcelObject->getActiveSheet()->setCellValue($key . $i, $entity->get($field[0]));
                $i++;
            }
        }
       // die();
            //dump($entities);die();
        // adding headers
        // create the writer
        $writer = $this->container->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->container->get('phpexcel')->createStreamedResponse($writer);
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=billing_report.xls');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $writer = $this->container->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        $writer->save($download_path . 'CustomerDetailsReport_' . "test" . '.xls');

        return $response;

    }
}