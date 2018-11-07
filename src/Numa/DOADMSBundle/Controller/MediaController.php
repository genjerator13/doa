<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    public function printBuyerGuideAction(Request $request,Item $item)
    {

        $pdf =  $this->get('numa.dms.media')->printBGuide($item);
        $tmpfile = sys_get_temp_dir()."/buyersGuide.pdf";

        $pdf->saveAs($tmpfile);
        $response = new BinaryFileResponse($tmpfile);
        $response->headers->set('Content-Type', 'application/pdf');
        return $response;

    }

//    public function renderMedia(Media $){
//        return $this->get('numa.dms.media')->
//    }

}
