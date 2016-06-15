<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Proxies\__CG__\Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Numa\Util\Util as Util;
//use Guzzle
use Guzzle\Http\Client;
use Lsw\GuzzleBundle\LswGuzzleBundle;

class PageController extends Controller implements DealerSiteControllerInterface
{

    public $dealer;
    public $components;

    public function initializeDealer($dealer)
    {
        $this->dealer = $dealer;
    }

    public function initializePageComponents($components)
    {
        $this->components;
    }

    public function showAction($url)
    {
        $em = $this->getDoctrine()->getManager();
        $url = trim($url, "/");
        if ($this->dealer instanceof Catalogrecords) {

            $pages = $em->getRepository("NumaDOAModuleBundle:Page")->findCustomPageByUrl($this->dealer->getId(), $url);
        }
        dump($url);die();
        $response = $this->render('NumaDOASiteBundle:Page:index.html.twig',
            array("dealer"=>$this->dealer,"components"=>$this->components ));
        return $response;
    }

}


