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
        $vin = trim($request->get("vin"));
        $item_id = trim($request->get("item_id"));
        $decodedVin = $this->get("numa.dms.listing")->decodeVin($vin,$item_id);

        return $decodedVin;
    }
}