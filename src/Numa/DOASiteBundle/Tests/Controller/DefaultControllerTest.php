<?php

namespace Numa\DOASiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

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

    public function testFeaturedDivs()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertGreaterThan(
            0,
            $crawler->filter('h3.panel-title')->count()
        );
    }

    public function testFeaturedItems()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertGreaterThan(
            9,
            $crawler->filter('span.price')->count()
        );
    }

//    public function testFeatured()
//    {
//        $products = $this->em
//            ->getRepository('NumaDOAAdminBundle:Item')
//            ->findOneById(32195)
//        ;
//        dump($products);die();
//
//        $this->assertEquals(1, count($products));
//    }

//    public function testLoginForm()
//    {
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/user/login');
//        $form = $crawler->selectButton('Sign in')->form();
//        $form['_username'] = 'Lucas';
//        $form['_password'] = 'Hey there!';
//        $crawler = $client->submit($form);
//        dump($crawler);die();
//        $this->assertTrue($crawler->filter('html:contains("Sign In")')->count() > 0);
//    }

}
