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
        $totalPurchaseCost = 0;
        $totalSaleGross = 0;
        $totalItems = array();
        $totalSales = array();
        if($dealer instanceof Catalogrecords){
            $totalSales = $em->getRepository('NumaDOADMSBundle:Sale')->getCountSaleMadePeriod($start,$end,$dealer->getId());
            $totalItems = $em->getRepository('NumaDOAAdminBundle:Item')->findByDate($start,$end,$dealer->getId());

            foreach($totalItems as $item){
                if($item instanceof Item){
                    $totalPurchaseCost += $item->getPrice();
                }
            }

            foreach($totalSales as $sale){
                if($sale instanceof Sale){
                    $totalSaleGross += $sale->getTotalSaleCost();
                }
            }
        }

        $countPurchased = count($totalItems);
        $countSales = count($totalSales);
        $totalPurchaseCost = 0;
        $grossSalesRevenue = 0;
        $salesCost = 0;
        $netSalesRevenue = 0;

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
                'salesCost' => $salesCost,
                'netSalesRevenue' => $netSalesRevenue,
            );
        return $stats;
    }
}