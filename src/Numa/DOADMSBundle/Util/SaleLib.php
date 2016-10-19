<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Sale;

class SaleLib
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

    public function createSaleByBillingTradeIn(Billing $billing)
    {
//        dump($billing->getItem());die();
        if (!empty($billing->getSalePrice()) || !empty($billing->getWarranty()) || !empty($billing->getAdminFee()) || !empty($billing->getBankRegistrationFee()) || !empty($billing->getProtectionPkg()) || !empty($billing->getInsurance())) {
            $em = $this->container->get('doctrine.orm.entity_manager');
            //check if vin exists already
            $item = $billing->getItem();
            if($item instanceof Item) {
                $sale = $item->getSale();
//                dump($item->getSaleId());
                if (!$sale instanceof Sale) {
                    $sale = new Sale();
//                    $sale->setItem($item);
                    $em->persist($sale);
                }
                $sale->setVin($item->getVIN());
                $sale->setStockNr($item->getStockNr());
                $sale->setSellingPrice($billing->getSalePrice());
                $sale->setWarranty1($billing->getWarranty());
                $sale->setAdminFees1($billing->getAdminFee());
                $sale->setDocFees1($billing->getBankRegistrationFee());
                $sale->setProtectPkg1($billing->getProtectionPkg());
                $sale->setInsurance1($billing->getInsurance());
                $em->flush($sale);
                $item->setSaleId($sale->getId());
                $em->flush($item);
            }
        }
    }
}