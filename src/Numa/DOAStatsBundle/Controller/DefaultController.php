<?php

namespace Numa\DOAStatsBundle\Controller;

use Guzzle\Http\Message\Request;
use Numa\DOAStatsBundle\Entity\GaStats;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NumaDOAStatsBundle:Default:index.html.twig', array('name' => $name));
    }
}
