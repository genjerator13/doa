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

class Stats
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
    public function dashboardStats(){
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
        $end = new \DateTime('tomorrow');

        $startYear = new \DateTime('first day of this year');
        $endYear = new \DateTime('last day of december');

        $totalSaleMade = 0;
        $countSaleMade = 0;
        $totalPurchaseCost = 0;
        $grossSalesRevenue = 0;
        $salesCost = 0;
        $netSalesRevenue = 0;

        $totalSaleMadeYear = 0;
        $countSaleMadeYear = 0;
        $totalPurchaseCostYear = 0;
        $grossSalesRevenueYear = 0;
        $salesCostYear = 0;
        $netSalesRevenueYear = 0;

        if($dealer instanceof Catalogrecords){
            $totalSaleMade = $em->getRepository('NumaDOADMSBundle:Sale')->getCountSaleMadePeriod($start,$end,$dealer->getId());
            $totalSaleMadeYear = $em->getRepository('NumaDOADMSBundle:Sale')->getCountSaleMadePeriod($startYear,$endYear,$dealer->getId());

            $countSaleMade = count($totalSaleMade);
            foreach($totalSaleMade as $sale){
                if($sale instanceof Sale){
                    $totalPurchaseCost += $sale->getTotalUnitCost();
                    $grossSalesRevenue += $sale->getTotalRevenue();
                    $salesCost += $sale->getTotalSaleCost();
                    $netSalesRevenue += $sale->getRevenueThisUnit();
                }

            }

            $countSaleMadeYear = count($totalSaleMadeYear);
            foreach($totalSaleMadeYear as $saleYear){
                if($saleYear instanceof Sale){
                    $totalPurchaseCostYear += $saleYear->getTotalUnitCost();
                    $grossSalesRevenueYear += $saleYear->getTotalRevenue();
                    $salesCostYear += $saleYear->getTotalSaleCost();
                    $netSalesRevenueYear += $saleYear->getRevenueThisUnit();
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
                'countSaleMade' => $countSaleMade,
                'totalPurchaseCost' => $totalPurchaseCost,
                'grossSalesRevenue' => $grossSalesRevenue,
                'salesCost' => $salesCost,
                'netSalesRevenue' => $netSalesRevenue,
                'countSaleMadeYear' => $countSaleMadeYear,
                'totalPurchaseCostYear' => $totalPurchaseCostYear,
                'grossSalesRevenueYear' => $grossSalesRevenueYear,
                'salesCostYear' => $salesCostYear,
                'netSalesRevenueYear' => $netSalesRevenueYear,
            );
        return $stats;
    }
}