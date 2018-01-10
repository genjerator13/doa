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

    public function listingStats(){

        $em = $this->container->get('doctrine.orm.entity_manager');
        $dealer = $this->container->get('Numa.Dms.User')->getSignedDealerOrPrincipal();


        $totalListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1, 0, 0, $dealer);
        $totalViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1, 0, 0, $dealer);

        $totalCarListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1, 0, 1, $dealer);
        $totalCarViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1, 0, 1, $dealer);

        $totalMarineListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1, 0, 2, $dealer);
        $totalMarineViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1, 0, 2, $dealer);

        $totalMotoListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1, 0, 3, $dealer);
        $totalMotoViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1, 0, 3, $dealer);

        $totalRvsListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1, 0, 4, $dealer);
        $totalRvsViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1, 0, 4, $dealer);

        $totalAgsListings = $em->getRepository('NumaDOAAdminBundle:Item')->countAllListings(1, 0, 13, $dealer);
        $totalAgsViews = $em->getRepository('NumaDOAAdminBundle:Item')->countAllViews(1, 0, 13, $dealer);

        $stats =
            array(
                'totalListings' => $totalListings,
                'totalViews' => $totalViews,
                'totalCarListings' => $totalCarListings,
                'totalCarViews' => $totalCarViews,
                'totalMotoListings' => $totalMotoListings,
                'totalMotoViews' => $totalMotoViews,
                'totalMarineListings' => $totalMarineListings,
                'totalMarineViews' => $totalMarineViews,
                'totalRvsListings' => $totalRvsListings,
                'totalRvsViews' => $totalRvsViews,
                'totalAgsListings' => $totalAgsListings,
                'totalAgsViews' => $totalAgsViews
            );

        return $stats;
    }

    public function calculatePurchases($dealersIds,$date_start,$date_end)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $countPurchased = 0;
        $totalPurchaseCost = 0;

        if (!empty($dealersIds)) {
            $totalPurchases = $em->getRepository('NumaDOADMSBundle:Sale')->getCountSaleMadePeriod($date_start, $date_end, $dealersIds);
            $countPurchased = count($totalPurchases);

            foreach ($totalPurchases as $sale) {
                if ($sale instanceof Sale) {
                    $totalPurchaseCost += $sale->getTotalUnitCost();
                }
            }
        }
        return array('countPurchased'=>$countPurchased,
                     'totalPurchaseCost'=>$totalPurchaseCost);
    }

    public function calculateSales($dealersIds, $date_start, $date_end){
        $em = $this->container->get('doctrine.orm.entity_manager');

        $countSales = 0;

        $totalSalesGross = 0;
        $totalSalesCost = 0;
        $totalSalesRevenue = 0;
        if (!empty($dealersIds)) {
            $totalBillings = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($date_start, $date_end, $dealersIds);
            $countSales = count($totalBillings);
            foreach ($totalBillings as $billing) {
                $sale = $billing->getItem()->getSale();
                if ($sale instanceof Sale) {
                    $totalSalesCost += $sale->getTotalSaleCost();
                    $totalSalesGross += $sale->getTotalRevenue();
                    if (!empty($billing->getItem()->getSold())) {
                        $totalSalesRevenue += $sale->getRevenueThisUnit();
                    }
                }
            }
        }
        $stats=array(
            'countSales'=>$countSales,
            'totalSalesGross'=>$totalSalesGross,
            'totalSalesCost'=>$totalSalesCost,
            'totalSalesRevenue'=>$totalSalesRevenue,
        );
        return $stats;
    }

    public function calculatePurchasesByCurrentMonth($dealer){

        $month_start = new \DateTime('first day of this month');
        $month_end = new \DateTime('last day of this month');
        return $this->calculatePurchases($dealer,$month_start,$month_end);
    }


    public function calculateSalesByCurrentMonth($dealer){

        $month_start = new \DateTime('first day of this month');
        $month_end = new \DateTime('last day of this month');
        return $this->calculateSales($dealer,$month_start,$month_end);
    }


    public function dashboardStats($request)
    {
        $dealersIds = $this->container->get('Numa.Dms.User')->getAvailableDealersIds();

        $dateFrom = $request->query->get('dateFrom');
        $dateTo = $request->query->get('dateTo');

        $startPeriod = new \DateTime($dateFrom);
        $endPeriod = new \DateTime($dateTo);
        if (empty($dateFrom) && empty($dateTo)) {
            $startPeriod = new \DateTime('first day of january');
            $endPeriod = new \DateTime('last day of december');
            $dateFrom = $startPeriod->format('Y-m-d');
            $dateTo = $endPeriod->format('Y-m-d');
        }

        $purchasesByPeriod = $this->calculatePurchases($dealersIds,$startPeriod,$endPeriod);
        $salesByPeriod     = $this->calculateSales($dealersIds,$startPeriod,$endPeriod);

        $purchaseCurrentMonth = $this->calculatePurchasesByCurrentMonth($dealersIds);
        $salesCurrentMonth = $this->calculateSalesByCurrentMonth($dealersIds);

        $stats =
            array(
                'countPurchased' => $purchaseCurrentMonth['countPurchased'],
                'countSales' => $salesCurrentMonth['countSales'],
                'totalPurchaseCost' => $purchaseCurrentMonth['totalPurchaseCost'],
                'totalSaleGross' => $salesCurrentMonth['totalSalesGross'],
                'totalSaleCost' => $salesCurrentMonth['totalSalesCost'],
                'totalSaleRevenue' => $salesCurrentMonth['totalSalesRevenue'],
                'countPurchasedYear' => $purchasesByPeriod['countPurchased'],
                'countSalesYear' => $salesByPeriod['countSales'],
                'totalPurchaseCostYear' => $purchasesByPeriod['totalPurchaseCost'],
                'totalSaleGrossYear' => $salesByPeriod['totalSalesGross'],
                'totalSaleCostYear' => $salesByPeriod['totalSalesCost'],
                'totalSaleRevenueYear' => $salesByPeriod['totalSalesRevenue'],
                'date_start' => $dateFrom,
                'date_end' => $dateTo,
            );
        return $stats;
    }

    public function allStats($request){

        $dealer = $this->container->get('Numa.Dms.User')->getSignedDealer();

        $listing = $this->listingStats($dealer);
        $dashboardStats = $this->dashboardStats($request);
        return array_merge($listing,$dashboardStats);
    }
}