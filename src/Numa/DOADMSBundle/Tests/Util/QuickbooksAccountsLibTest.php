<?php

namespace Numa\DOADMSBundle\Tests\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Tests\Util\containerTrait;
use Numa\DOADMSBundle\Util\QuickbooksAccountLib;
use Symfony\Bridge\PhpUnit;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuickbooksAccountLibTest extends KernelTestCase
{
    use containerTrait;

    public function testListAllAcoounts(){

        $dealer = $this->em->getRepository(Catalogrecords::class)->find(33);
        $ql = new QuickbooksAccountLib($this->container);
        $ql->setDealer($dealer);

        $list = $ql->listAllAccounts($dealer);
        dump($list);
        $this->assertGreaterThan(1,count($list));
    }

}