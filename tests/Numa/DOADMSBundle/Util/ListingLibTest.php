<?php

namespace Numa\DOADMSBundle\Tests\Util;

use Numa\DOAAdminBundle\Entity\Category;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Util\ListingLib;
use Symfony\Bridge\PhpUnit;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ListingLibTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $container;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();
        $this->container = static::$kernel->getContainer();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testGetMetaTitle(){
        $ll = new ListingLib(null);
        $cat = $this->em->getRepository(Category::class)->find(1);
        $item = new Item();
        $item->setMake("Ford");
        $item->setModel("Fiesta");
        $item->setYear("1999");
        $item->setTrim("SV Crew Cab LWB 5AT 4WD");
        $item->setCategory($cat);
        //dump($cat);die();
        $title = $ll->getMetaTitle($item);

        $this->assertEquals("1999 Ford Fiesta SV Crew Cab LWB 5AT 4WD", $title);

        $item = new Item();
        $item->setMake("Ford");
        $item->setModel("Fiesta");
        $item->setYear("1999");
        $item->setTrim("SV Crew Cab LWB 5AT 4WD");

        $cat = $this->em->getRepository(Category::class)->find(4);
        $title = $ll->getMetaTitle($item);

        $this->assertEquals("1999 Ford Fiesta", $title);

        $item = new Item();
        $item->setMake("Ford");
        $item->setModel("Fiesta");
        $item->setYear("1999");
        $item->setFloorPlan("flor plan");
        $item->setCategory($cat);

        $title = $ll->getMetaTitle($item);

        $this->assertEquals("1999 Ford Fiesta flor plan", $title);
    }

    public function testCreateListingByBillingTradeIn(){
        $billing = new Billing();
        $billing->setTidMake("Ford");
        $billing->setTidModel("Fiesta");
        $billing->setTidKm(1234);
        $billing->setTidVin("12345678x");
        $billing->setTidYear(1999);

        $cat = $this->em->getRepository(Category::class)->find(1);
        $item = new Item();
        $item->setCategory($cat);

        $billing->setItem($item);

        $ll = new ListingLib($this->container);
        $ok = $ll->createListingByBillingTradeIn($billing,false);

        $this->assertTrue($ok);

        $billing = new Billing();
        //$billing->setTidMake("Ford");
        $billing->setTidModel("Fiesta");
        $billing->setTidKm(1234);
        $billing->setTidVin("123456789y");
        $billing->setTidYear(1999);
        $billing->setItem($item);
        $ok = $ll->createListingByBillingTradeIn($billing,false);

        $this->assertFalse($ok);
    }
}