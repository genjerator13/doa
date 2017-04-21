<?php

namespace Numa\DOASiteBundle\Tests\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
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

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        //dump($client);die();
        $this->assertTrue($crawler->filter('html:contains("Search By Body Style")')->count() > 0);
    }

    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/login');

        $this->assertTrue($crawler->filter('html:contains("Sign In")')->count() > 0);
    }

    public function testFeaturedDivTitle()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('html:contains("Featured Ads")')->count() > 0);
    }


    /**
     * @dataProvider urlDefaultSiteProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlDefaultSiteProvider()
    {
        return array(
            array('/'),
            array('/parts'),
            array('/service'),
            array('/contactus'),
            array('/search-advanced'),
            array('/categories'),
            array('/seller/search'),
        );
    }
    /**
     * @dataProvider dealerProvider
     */
//    public function testDealerHomeIsSuccessful($dealer)
//    {
//        dump($dealer);die();
//        $client = self::createClient();
//        $client->request('GET', $url);
//
//        $this->assertTrue($client->getResponse()->isSuccessful());
//    }
//    public function dealerProvider(){
//        $dealers = $this->em->getRepository(Catalogrecords::class)->findAll();
//        return $dealers;
//    }

}
