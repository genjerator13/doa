<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 20.7.16.
 * Time: 15.04
 */

namespace Numa\DOADMSBundle\Lib;


use Doctrine\Common\Collections\Collection;
use Numa\DOAAdminBundle\Entity\Item;

class ReportService
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
     * creates purchase report
     * @param $entities
     * @return Response
     *
     */
    public function billingReportPurchaseXls($entities)
    {
//        $phpExcelObject = $this->createPHPExcelObject("DOA","DOA Purchase report","DOA Purchase report","DOA Purchase report");
//        $phpExcelObject = $this->createExcelContent($entities,$this->inventoryPurchaseFields,$phpExcelObject);
//        return $this->createExcelResponse($phpExcelObject,"Customer_Details_Report.xls");
        $filename = "Customer_Details_Report.xls";
        $purchaseReport = new PurchaseReport($this->container);
        $purchaseReport->setEntities($entities);
        return $purchaseReport->createExcelResponse($filename);
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

    /**
     * creates UnitProfit report
     * @param $entities
     * @return Response
     *
     */
    public function billingUnitProfitReportXls($entities)
    {
        $filename = "Customer_Details_Report.xls";
        $unitProfitReport = new UnitProfitReport($this->container);
        $unitProfitReport->setEntities($entities);
        return $unitProfitReport->createExcelResponse($filename);
    }

    /**
     * creates Inventory report
     * @param $entities
     * @return Response
     *
     */
    public function billingReportInventoryXls($entities)
    {
        $filename = "Customer_Details_Report.xls";
        $inventoryReport = new InventoryReport($this->container);
        $inventoryReport->setEntities($entities);
        return $inventoryReport->createExcelResponse($filename);
    }

    /**
     * creates InventoryShort report
     * @param $entities
     * @return Response
     *
     */
    public function billingReportInventoryShortXls($entities)
    {
        $filename = "Customer_Details_Report.xls";
        $inventoryReportShort = new InventoryReportShort($this->container);
        $inventoryReportShort->setEntities($entities);
        return $inventoryReportShort->createExcelResponse($filename);
    }

    /**
     * creates UnitRevenue report
     * @param $entities
     * @return Response
     *
     */
    public function billingUnitRevenueReportXls($entities)
    {
        $filename = "Customer_Details_Report.xls";
        $unitRevenueReport = new UnitRevenueReport($this->container);
        $unitRevenueReport->setEntities($entities);
        return $unitRevenueReport->createExcelResponse($filename);
    }

    /**
     * creates UnitSalesCost report
     * @param $entities
     * @return Response
     *
     */
    public function billingUnitSalesCostReportXls($entities)
    {
        $filename = "Customer_Details_Report.xls";
        $unitSalesCostReport = new UnitSalesCostReport($this->container);
        $unitSalesCostReport->setEntities($entities);
        return $unitSalesCostReport->createExcelResponse($filename);
    }
}