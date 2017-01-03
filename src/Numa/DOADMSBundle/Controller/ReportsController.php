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
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        if (empty($dealer)) {
            $entities = null;
            $em->flush();
            $this->addFlash("danger", "You must be logged in as a Dealer!");
        } else {
            $securityContext = $this->container->get('security.authorization_checker');
            if ($securityContext->isGranted('ROLE_DEALER_PRINCIPAL')) {
                $dealers = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findBy(array('dealer_group_id' => $dealer->getId()));
                $dealer_ids = array();
                foreach ($dealers as $dealer) {
                    $dealer_ids[] = $dealer->getId();
                }
                $dealers = implode(",", $dealer_ids);
                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($date, $date1, $dealers);

            } else {
                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate2($date, $date1, $dealer->getId());
                //dump($entities);die();
            }

            if ($request->query->has('purchase')) {
                return $this->get('Numa.Reports')->billingReportPurchaseXls($entities);
            }

            if ($request->query->has('unitProfit')) {
                return $this->get('Numa.Reports')->billingUnitProfitReportXls($entities);
            }

            if ($request->query->has('inventory')) {
                return $this->get('Numa.Reports')->billingReportInventoryXls($entities);
            }

            if ($request->query->has('inventoryShort')) {
                /* inventory report sales copy */
                return $this->get('Numa.Reports')->billingReportInventoryShortXls($entities);
            }

            if ($request->query->has('unitRevenue')) {
                return $this->get('Numa.Reports')->billingUnitRevenueReportXls($entities);
            }

            if ($request->query->has('unitSalesCost')) {
                return $this->get('Numa.Reports')->billingUnitSalesCostReportXls($entities);
            }

            if ($request->query->has('sales')) {
                return $this->get('Numa.Reports')->billingReportSalesXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:index.html.twig', array(
            'billings' => $entities,
        ));
    }
}