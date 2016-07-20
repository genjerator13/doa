<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Form\BillingType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Billing controller.
 *
 */
class ReportsController extends Controller
{
    /**
     * Lists all Billing entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $date = $request->query->get('dateFrom');
        $date1 = $request->query->get('dateTo');
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($date, $date1);
        return $this->render('NumaDOADMSBundle:Reports:index.html.twig', array(
            'billings' => $entities,
            'dealer'   => $dealer,
        ));
    }
}