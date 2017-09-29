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

class AdsController extends Controller
{
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ad = $em->getRepository("NumaDOAModuleBundle:Ad")->find($id);
        $response = $this->render('NumaDOASiteBundle:Ads:single.html.twig',
            array('ad' => $ad)
        );
        return $response;
    }

    public function rightsidebarAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $ad = $em->getRepository("NumaDOAModuleBundle:Ad")->find($id);
        $response = $this->render('NumaDOASiteBundle:Ads:right-sidebar.html.twig',
            array('ad' => $ad)
        );
        return $response;
    }
}


