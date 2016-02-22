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
        $url = "http://www.machinefinder.com/dealer_families/6926/machine_feed.xml";
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_exec($handle);
        die();
    }

    public function testAction() {
        $client = new Client();

        $req = $client->get($this->container->get('router')->getContext()->getScheme()."://".$this->container->get('router')->getContext()->getHost().'/api/ads/all.json');
        $response = $req->send();
        //dump($response->json());
        return new JsonResponse($response->json());
        $response = $this->render('NumaDOASiteBundle:Sandbox:test.html.twig', array());

    }

//    public function testAction() {
//        $response = $this->render('NumaDOASiteBundle:Sandbox:test.html.twig', array());
//
//        return $response;
//    }



}


