<?php

namespace Numa\DOASiteBundle\Tests\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DealerSiteTest extends WebTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $url;
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();
        $this->url ="http://doa.local";
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @dataProvider urlDefaultSiteProvider
     */
    public function checkDealer(Catalogrecords $dealer)
    {
        //
        $url = $dealer->getSiteUrl();
        if(!empty($url)) {
            $url ="http://".$url;
            $client = self::createClient();
            $client->request('GET', $url);
            
            $this->assertTrue($client->getResponse()->isSuccessful());
        }
    }

    public function testPageIsSuccessful()
    {
        $client = self::createClient();
        $container = $client->getContainer();
        $em=$container->get("doctrine.orm.default_entity_manager");

        $dealers = $em->getRepository(Catalogrecords::class)->findAll();
        foreach($dealers as $dealer){
            $this->checkDealer($dealer);
        }

    }
}
