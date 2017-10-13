<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of services
 *
 * @author genjerator
 */

namespace Numa\CCCAdminBundle\Lib;

use Numa\CCCAdminBundle\Entity\Customers;
use Numa\CCCAdminBundle\Entity\CustomRate;
use Numa\CCCAdminBundle\Entity\CustomRateValue;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class CustomerServices {
    use ContainerAwareTrait;



    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getCustomPdf(Customers $customer)
    {
        $pdf="";
        $cust=false;
        if (!empty($customer->getRatePdf())) {
            $pdf= $customer->getRatePdf();
            $cust=true;
        }


        $ratecode = $customer->getRatelevel();
        $em  = $this->container->get('doctrine');

        $rateCustom = $em->getRepository(CustomRate::class)->findoneByRatecode($ratecode);

        if(!empty($rateCustom[0]) && $rateCustom[0] instanceof CustomRate){
            $pdf=$rateCustom[0]->getSrc();
        }

        return $this->getDocumentUrl($pdf,$cust);

        //$cRate = $em->getRepository('NumaCCCAdminBundle:CustomRate')->findOneBy("rate_id",$rate);
    }

    public function getDocumentUrl($pdf,$cust=false){
        $cr = new CustomRate();
        $cr->setSrc($pdf);
        if($cust){
            $cr->setUploadDir("upload/customer");
        }
        return $cr;
    }

    public function createCustomRatesValues(CustomRate $customRate){
        $em  = $this->container->get('doctrine.orm.entity_manager');

        if(!empty($customRate->getCustommadeRate())){
            $csvArray = explode(",",$customRate->getCustommadeRate());
            $em->getRepository(CustomRate::class)->removeAllCustomRateValues($customRate->getId());

            foreach($csvArray as $csv){
                $crv = new CustomRateValue();
                $crv->setCustomRate($customRate);
                $crv->setName($csv);
                $em->persist($crv);

            }

            $em->flush();
            return true;
        }
        return false;
    }


}
