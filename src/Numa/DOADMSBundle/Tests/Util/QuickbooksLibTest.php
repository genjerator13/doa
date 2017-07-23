<?php

namespace Numa\DOADMSBundle\Tests\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Tests\Util\containerTrait;
use Numa\DOADMSBundle\Util\QuickbooksLib;
use Symfony\Bridge\PhpUnit;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuickbooksAccountLibTest extends KernelTestCase
{
    use containerTrait;
//
//    public function testCreateQBBill(){
//
//        $dealer = $this->em->getRepository(Catalogrecords::class)->find(33);
//        $ql = new QuickbooksLib($this->container);
//
//        $ql->setDealer($dealer);
//        //dump($this->container);die();
//        $item = $this->em->getRepository(Item::class)->find(32622);
//        $ql->insertItemBills($item);
//        //$this->assertEquals("SV Crew Cab LWB 5AT 4WD", $title);
//    }
//    public function testCreateQBBill2(){
//
//        $dealer = $this->em->getRepository(Catalogrecords::class)->find(33);
//        $ql = new QuickbooksLib($this->container);
//
//        $ql->setDealer($dealer);
//        //dump($this->container);die();
//        $item = $this->em->getRepository(Item::class)->find(32500);
//        $ql->insertItemBills($item);
//        //$this->assertEquals("SV Crew Cab LWB 5AT 4WD", $title);
//    }

}