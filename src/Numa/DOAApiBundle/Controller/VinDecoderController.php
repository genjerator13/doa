<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAApiBundle\Controller;

use Numa\DOAAdminBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Guzzle\Http\Client;

class VinDecoderController extends Controller
{

    public function decodeVinAction(Request $request)
    {
        $vin = trim($request->get("vin"));
        $item_id = trim($request->get("item_id"));
        $decodedVin = $this->get("numa.dms.listing")->decodeVin($vin, $item_id);

        return $decodedVin;
    }

    public function decodeVinOneVehicleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $item_id = trim($request->get("item_id"));
        $num = trim($request->get("num"));

        $item = $em->getRepository(Item::class)->find($item_id);
        if ($item instanceof Item) {
            $decodedvin = $item->getVindecoder();
            $aDecodedvin = json_decode($decodedvin,true);
            if(!empty($aDecodedvin[$num])) {
                $json = json_encode($aDecodedvin[$num]);
                $item->setVindecoder($json);
                $em->flush();
            }
            die();
        }

    }
}