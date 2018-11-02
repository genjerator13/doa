<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAApiBundle\Controller;

use Numa\DOADMSBundle\Entity\ListingForm;

use Numa\DOADMSBundle\Entity\Notification;
use Numa\DOADMSBundle\Entity\SaveSearch;
use Numa\DOADMSBundle\Form\ListingFormContactType;
use Numa\DOADMSBundle\Form\ListingFormDriveType;
use Numa\DOADMSBundle\Form\ListingFormEpriceType;
use Numa\DOADMSBundle\Form\ListingFormFinanceType;
use Numa\DOADMSBundle\Form\ListingFormOfferTradeInType;
use Numa\DOADMSBundle\Form\ListingFormOfferType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class NotificationRESTController extends Controller implements DealerSiteControllerInterface
{

    public $dealer;

    public function initializeDealer($dealer)
    {
        $this->dealer = $dealer;
    }


    /**
     * @Rest\View
     */
    public function allAction()
    {
        $listingForm = $this->getDoctrine()->getRepository(Notification::class)->findAll();
        return $listingForm;
    }

    /**
     * @Rest\View
     */
    public function byDealerAction($dealer_id)
    {
        $listingForm = $this->getDoctrine()->getRepository(Notification::class)->findBy(array('dealer_id' => $dealer_id),array("id"=>"desc"));
        return $listingForm;
    }


}