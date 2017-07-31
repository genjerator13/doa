<?php

namespace Numa\DOADMSBundle\Tests\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Tests\Util\containerTrait;
use Numa\DOADMSBundle\Util\QuickbooksCustomerLib;
use Numa\DOADMSBundle\Util\QuickbooksSaleLib;
use Symfony\Bridge\PhpUnit;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuickbooksSaleLibTest extends KernelTestCase
{
    use containerTrait;

    public function testCreateSaleFromBilling(){

        $dealer = $this->em->getRepository(Catalogrecords::class)->find(33);
        $billing = $this->em->getRepository(Billing::class)->find(185);
        $ql = new QuickbooksSaleLib($this->container);
        $ql->setDealer($dealer);

        $qbSale = $ql->insertBillingToQBSaleReceipt($billing);

        $this->assertTrue(1==1);
    }

    public function testCreateCustomer(){
        $dealer = $this->em->getRepository(Catalogrecords::class)->find(33);
        $billing = $this->em->getRepository(Billing::class)->find(185);
        $customer = $billing->getCustomer();
        $ql = new QuickbooksCustomerLib($this->container);
        $ql->setDealer($dealer);

        $qbCustomer = $ql->insertCustomerToQBCustomer($customer);
        dump($qbCustomer);
        $this->assertTrue(1==1);
    }

}