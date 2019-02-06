<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOADMSBundle\Entity\Leasing;
use Numa\DOADMSBundle\Form\LeasingType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class IconfiguratorController extends Controller implements DealerSiteControllerInterface
{

    public $dealer;

    public function initializeDealer($dealer)
    {
        $this->dealer = $dealer;

    }


    public function indexAction(Request $request)
    {
        return $this->render('NumaDOASiteBundle:iconf:index.html.twig', array(
            'dealer' => $this->dealer,
        ));
    }

}
