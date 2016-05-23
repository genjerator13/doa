<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Numa\Util\Util as Util;
//use Guzzle
use Guzzle\Http\Client;
use Lsw\GuzzleBundle\LswGuzzleBundle;
class SandboxController extends Controller {

    public function indexAction() {
        $data = array('key' => '16ab1a10-2daf-0130-dd76-005056be005f', 'password' => 'arkansas22');
        $data = array('key' => 'c0bf5ed0-2453-0133-0595-005056be005e', 'password' => 'arkansas22');
        $data = array('key' => 'acd95d50-8bc3-0133-346d-005056be003c', 'password' => 'arkansas22');
        $url = "http://www.machinefinder.com/dealer_families/6926/machine_feed.xml";
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_exec($handle);
        die();
    }

    public function test2Action() {
        $client = new Client($this->container->get('router')->getContext()->getScheme()."://".$this->container->get('router')->getContext()->getHost());

        $req = $client->get('/api/customer/all.json');
        $response = $req->send();
        //dump($this->container->get('router')->getContext()->getScheme()."://".$this->container->get('router')->getContext()->getHost());
        $restClient = $this->container->get('circle.restclient');

        $test = $restClient->get($this->container->get('router')->getContext()->getScheme()."://".$this->container->get('router')->getContext()->getHost().'/api/ads/all.json');
        //$test->;
        return new JsonResponse($response->json());
        $response = $this->render('NumaDOASiteBundle:Sandbox:test.html.twig', array());

    }

    public function testAction() {

        $em=$this->getDoctrine()->getManager();
        $customer = $em->getRepository('NumaDOAStatsBundle:Stats')->find(7);
//        dump($customer->getLastnoteadded());die();
        $response = $this->render('NumaDOASiteBundle:Sandbox:test.html.twig', array());

        return $response;
    }
    public function test3Action() {

        $em=$this->getDoctrine()->getManager();
        $date = date("Y-m-d h:i:sa");
        $day10 = strtotime($date . ' -1 day');

        $timestamp = strtotime($date);
        $customer = $em->getRepository('NumaDOAModuleBundle:Page')->findPageComponentByPageId(5);

        dump($customer);die();
        $response = $this->render('NumaDOAStatsBundle:Default:index.html.twig', array());
        return $response;
    }


}


