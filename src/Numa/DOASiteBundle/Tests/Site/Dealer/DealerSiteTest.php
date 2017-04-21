<?php

namespace Numa\DOASiteBundle\Tests\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAModuleBundle\Entity\Page;
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
        $this->url = "http://doa.local";
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @dataProvider urlDefaultSiteProvider
     */
    public function testDealerSites($url)
    {

        $client = self::createClient();
        $client->request('GET', $url);
            dump($url);
        $this->assertTrue($client->getResponse()->isSuccessful());

    }

    public function urlDefaultSiteProvider()
    {
        $client = self::createClient();
        $container = $client->getContainer();
        $em = $container->get("doctrine.orm.default_entity_manager");

        $dealer = $em->getRepository(Catalogrecords::class)->find(33);
        $urls = array();
        //foreach ($dealers as $dealer) {
            $pages = $em->getRepository(Page::class)->findPagesByDealer($dealer->getId());
            $url ="";
            $url = $dealer->getSiteUrl();
            if (!empty($url)) {
                $url = "http://" . $url;

                foreach ($pages as $page) {
                    $pageurl = "";
                    $pageurl = $page->getUrl();
                    if (!empty($pageurl)) {
                        $urlp = $url . $pageurl;
                        $urls[] = array($urlp);
                    }
                }
            }
        //}
        //dump($urls);die();
        return $urls;
    }
}
