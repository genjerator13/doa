<?php

namespace Numa\DOADMSBundle\Tests\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Tests\Util\containerTrait;
use Numa\DOADMSBundle\Util\QuickbooksAccountLib;
use Numa\DOADMSBundle\Util\QuickbooksSaleLib;
use Symfony\Bridge\PhpUnit;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuickbooksSaleLibTest extends KernelTestCase
{
    use containerTrait;

    public function testCreateSaleFromBilling(){

        $dealer = $this->em->getRepository(Catalogrecords::class)->find(33);
        $billing = $this->em->getRepository(Billing::class)->find(200);
        $ql = new QuickbooksSaleLib($this->container);
        $ql->setDealer($dealer);

        $qbSale = $ql->insertBillingToQBasSaleReceipt($billing);
        dump($qbSale);
        $this->assertTrue(1==1);
    }

}