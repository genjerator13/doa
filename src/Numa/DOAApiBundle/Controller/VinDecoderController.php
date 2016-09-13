<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Guzzle\Http\Client;

class VinDecoderController extends Controller
{

    public function decodeVinAction(Request $request){
        $vin = $request->get("vin");
        //getserializer
        $serializer = $this->get('jms_serializer');
        //create api client
        $baseurl = $this->container->get('router')->getContext()->getScheme()."://".$this->container->get('router')->getContext()->getHost();
        $client = new Client($baseurl);

        //getResponse
        $response = $client->get('https://api.edmunds.com/api/vehicle/v2/vins/'.$vin.'?&fmt=json&api_key=t42a3577zdfuy63qu6fr7wu3')->send();

        //deserialize response
        $entity = $serializer->deserialize(json_encode($response->json()), 'Numa\DOADMSBundle\Entity\Customer', 'json');
        dump($response->json());die();

    }
}