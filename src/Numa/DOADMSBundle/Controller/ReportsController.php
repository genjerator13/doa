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

        $startDate = 0;
        $endDate = 0;
        if (!empty($date)) {
            $startDate = new \DateTime($date);
        }
        if (!empty($date1)) {
            $endDate = new \DateTime($date1);
        }

        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        if (empty($dealer)) {
            $entities = null;
            $this->addFlash("danger", "You must be logged in as a Dealer!");
        } else {
            $securityContext = $this->container->get('security.authorization_checker');
            if ($securityContext->isGranted('ROLE_DEALER_PRINCIPAL')) {
                $dealerPrincipal = $this->container->get("numa.dms.user")->getSignedDealerPrincipal();
                $dealers = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->getDealersByDealerGroup($dealerPrincipal->getId());
                $dealer_ids = array();
                foreach ($dealers as $dealer) {
                    $dealer_ids[] = $dealer->getId();
                }
                $dealer_id = implode(",", $dealer_ids);
            }else{
                $dealer_id = $dealer->getId();
            }

            $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id);

            if ($request->query->has('purchase')) {
                return $this->get('Numa.Reports')->billingReportPurchaseXls($entities);
            }

            if ($request->query->has('sales')) {
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startDate, $endDate, $dealer_id);
                return $this->get('Numa.Reports')->billingReportSalesXls($entities);
            }

            if ($request->query->has('unitProfit')) {
                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, true);
                return $this->get('Numa.Reports')->billingUnitProfitReportXls($entities);
            }

            if ($request->query->has('inventory')) {
                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, false);
                return $this->get('Numa.Reports')->billingReportInventoryXls($entities);
            }

            if ($request->query->has('inventoryShort')) {
                /* inventory report sales copy */
                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, false);
                return $this->get('Numa.Reports')->billingReportInventoryShortXls($entities);
            }

            if ($request->query->has('inventoryPhoto')) {
                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, false);
                return $this->get('Numa.Reports')->billingReportInventoryPhotoXls($entities);
            }

            if ($request->query->has('unitRevenue')) {
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id, true);
                return $this->get('Numa.Reports')->billingUnitRevenueReportXls($entities);
            }

            if ($request->query->has('unitSalesCost')) {
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id, true);
                return $this->get('Numa.Reports')->billingUnitSalesCostReportXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:index.html.twig', array(
            'billings' => $entities,
            'date_start' => $date,
            'date_end' => $date1,
        ));
    }
}