<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOADMSBundle\Form\ListingFormOfferTradeInType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\ListingForm;
use Numa\DOADMSBundle\Form\ListingFormType;
use Numa\DOADMSBundle\Form\ListingFormEpriceType;
use Numa\DOADMSBundle\Form\ListingFormOfferType;
use Numa\DOADMSBundle\Form\ListingFormDriveType;

/**
 * ListingForm controller.
 *
 */
class SaveSearchController extends Controller
{

    /**
     * Lists all ListingForm entities.
     *
     */
    public function indexAction()
    {
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();

        return $this->render('NumaDOADMSBundle:SaveSearch:index.html.twig', array(
            'dealer' => $dealer,
        ));
    }

}