<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOADMSBundle\Entity\Notification;
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
class NotificationController extends Controller
{

    /**
     * Lists all ListingForm entities.
     *
     */
    public function indexAction()
    {
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();

        return $this->render('NumaDOADMSBundle:Notification:index.html.twig', array(
            'dealer' => $dealer,
        ));
    }

    /**
     * @param Request $request
     * Deactivates elected listings in datagrid on listing list page
     */
    public function massDeleteAction(Request $request) {

        $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);

        $em = $this->getDoctrine()->getManager();

        $qb = $em->getRepository(Notification::class)->delete($ids);
        die();
    }

}