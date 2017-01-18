<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12.4.16.
 * Time: 10.25
 */

namespace Numa\Lib;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\Sale;
use Numa\DOAAdminBundle\Entity\Item;

class Stats
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
    public function dashboardStats($request){
        $em = $this->container->get('doctrine.orm.entity_manager');
        $dealer = $this->container->get('Numa.Dms.User')->getSignedDealer();

        $totalListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1,0,0,$dealer);
        $totalViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1,0,0,$dealer);

        $totalCarListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1,0,1,$dealer);
        $totalCarViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1,0,1,$dealer);

        $totalMarineListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1,0,2,$dealer);
        $totalMarineViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1,0,2,$dealer);

        $totalMotoListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1,0,3,$dealer);
        $totalMotoViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1,0,3,$dealer);

        $totalRvsListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1,0,4,$dealer);
        $totalRvsViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1,0,4,$dealer);

        $totalAgsListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1,0,13,$dealer);
        $totalAgsViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1,0,13,$dealer);

        $start = new \DateTime('first day of this month');
        $end = new \DateTime('last day of this month');

        $dateFrom = $request->query->get('dateFrom');
        $dateTo = $request->query->get('dateTo');
        $startYear = new \DateTime($dateFrom);
        $endYear = new \DateTime($dateTo);
        if(empty($dateFrom) && empty($dateTo)){
            $startYear = new \DateTime('first day of january');
            $endYear = new \DateTime('last day of december');
            $dateFrom = $startYear->format('Y-m-d');
            $dateTo = $endYear->format('Y-m-d');
        }

        $countPurchased = 0;
        $countSales = 0;
        $totalPurchaseCost = 0;
        $totalSaleGross = 0;
        $totalSaleCost = 0;
        $totalSaleRevenue = 0;

        $countPurchasedYear = 0;
        $countSalesYear = 0;
        $totalPurchaseCostYear = 0;
        $totalSaleGrossYear = 0;
        $totalSaleCostYear = 0;
        $totalSaleRevenueYear = 0;

        $totalSales = array();
        $totalBillings = array();
        $totalSalesYear = array();
        $totalBillingsYear = array();
        
        if($dealer instanceof Catalogrecords){
            $totalSales = $em->getRepository('NumaDOADMSBundle:Sale')->getCountSaleMadePeriod($start,$end,$dealer->getId());
            $totalBillings = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($start,$end,$dealer->getId());
            $totalSalesYear = $em->getRepository('NumaDOADMSBundle:Sale')->getCountSaleMadePeriod($startYear,$endYear,$dealer->getId());
            $totalBillingsYear = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startYear,$endYear,$dealer->getId());

            $countPurchased = count($totalSales);
            $countSales = count($totalBillings);

            $countPurchasedYear = count($totalSalesYear);
            $countSalesYear = count($totalBillingsYear);

            foreach($totalSales as $sale){
                if($sale instanceof Sale){
                    $totalSaleGross += $sale->getTotalRevenue();
                    $totalSaleCost  += $sale->getTotalSaleCost();
                    $totalPurchaseCost += $sale->getTotalUnitCost();
                    if(!empty($sale->getSellingPrice()) && $sale->getSellingPrice() > 0){
                        $totalSaleRevenue += $sale->getRevenueThisUnit();
                    }
                }
            }
            foreach($totalSalesYear as $sale){
                if($sale instanceof Sale){
                    $totalSaleGrossYear += $sale->getTotalRevenue();
                    $totalSaleCostYear += $sale->getTotalSaleCost();
                    $totalPurchaseCostYear += $sale->getTotalUnitCost();
                    if(!empty($sale->getSellingPrice()) && $sale->getSellingPrice() > 0 ){
                        $totalSaleRevenueYear += $sale->getRevenueThisUnit();
                    }
                }
            }
        }

        $stats =
            array(
                'totalListings' => $totalListings,
                'totalViews' => $totalViews,
                'totalCarListings'=>$totalCarListings,
                'totalCarViews'=>$totalCarViews,
                'totalMotoListings'=>$totalMotoListings,
                'totalMotoViews'=>$totalMotoViews,
                'totalMarineListings'=>$totalMarineListings,
                'totalMarineViews'=>$totalMarineViews,
                'totalRvsListings'=>$totalRvsListings,
                'totalRvsViews'=>$totalRvsViews,
                'totalAgsListings'=>$totalAgsListings,
                'totalAgsViews'=>$totalAgsViews,
                'countPurchased' => $countPurchased,
                'countSales' => $countSales,
                'totalPurchaseCost' => $totalPurchaseCost,
                'totalSaleGross' => $totalSaleGross,
                'totalSaleCost' => $totalSaleCost,
                'totalSaleRevenue' => $totalSaleRevenue,
                'countPurchasedYear' => $countPurchasedYear,
                'countSalesYear' => $countSalesYear,
                'totalPurchaseCostYear' => $totalPurchaseCostYear,
                'totalSaleGrossYear' => $totalSaleGrossYear,
                'totalSaleCostYear' => $totalSaleCostYear,
                'totalSaleRevenueYear' => $totalSaleRevenueYear,
                'date_start' => $dateFrom,
                'date_end' => $dateTo,
            );
        return $stats;
    }
}