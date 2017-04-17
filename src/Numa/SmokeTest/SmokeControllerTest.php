<?php

namespace Numa\DOASiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeControllerTest extends WebTestCase
{

    public function testCjvr()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'http://cjvr.dealersonair.com/');
        //dump($crawler);die();
        $this->assertTrue($crawler->filter('html:contains("Search By Body Style")')->count() > 0);
    }
}
