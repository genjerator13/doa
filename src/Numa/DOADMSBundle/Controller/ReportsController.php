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
        if(empty($dealer)){
            $entities = null;
            $em->flush();
            $this->addFlash("danger","You must be logged in like Dealer!");
        }
        else{
        $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($date, $date1, $dealer->getId());
        if($request->query->has('purchase')){
            return  $this->get('Numa.Reports')->billingReportPurchaseXls($entities);
        }

        if($request->query->has('inventory')){
            return  $this->get('Numa.Reports')->billingReportInventoryXls($entities);
        }

        if($request->query->has('sales')){
            return  $this->get('Numa.Reports')->billingReportSalesXls($entities);
        }
        }
        return $this->render('NumaDOADMSBundle:Reports:index.html.twig', array(
            'billings' => $entities,
            'dealer'   => $dealer,
        ));
    }
}