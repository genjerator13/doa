<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Proxies\__CG__\Numa\DOADMSBundle\Entity\ListingForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CalculatorController extends Controller implements DealerSiteControllerInterface
{

    public $dealer;

    public function initializeDealer($dealer)
    {
        $this->dealer = $dealer;
    }


    public function indexAction(Request $request)
    {
        return $this->render('NumaDOASiteBundle:Calculator:calculator.html.twig', array(
            'dealer' => $this->dealer,
        ));
    }

}

