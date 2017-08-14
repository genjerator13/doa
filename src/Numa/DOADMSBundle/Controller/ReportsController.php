<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        $bydate = $request->attributes->get('bydate');
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
            //$em->flush();
            $this->addFlash("danger", "You must be logged in as a Dealer!");
        } else {
            $securityContext = $this->container->get('security.authorization_checker');
            $dealer_id = $dealer->getId();

            if ($securityContext->isGranted('ROLE_DEALER_PRINCIPAL')) {
                $dealer_id = $this->get('numa.dms.user')->getAvailableDealersIds();
            }
            $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id);
            //$entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startDate, $endDate, $dealer_id);

            if ($request->query->get('report') == "purchase") {
                return $this->get('Numa.Reports')->billingReportPurchaseXls($entities);
            }

            if ($request->query->get('report') == "sale") {
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startDate, $endDate, $dealer_id);
                return $this->get('Numa.Reports')->billingReportSalesXls($entities);
            }

            if ($request->query->get('report') == "sales-commission") {
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startDate, $endDate, $dealer_id);
                return $this->get('Numa.Reports')->billingReportSalesCommisionXls($entities);
            }

            if ($request->query->get('report') == "unit-profit") {
                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, true);
                return $this->get('Numa.Reports')->billingUnitProfitReportXls($entities);
            }

            if ($request->query->get('report') == "inventory") {
                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, false);
                return $this->get('Numa.Reports')->billingReportInventoryXls($entities);
            }

            if ($request->query->get('report') == "inventory-sales-copy") {
                /* inventory report sales copy */
                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, false);
                return $this->get('Numa.Reports')->billingReportInventoryShortXls($entities);
            }

            if ($request->query->get('report') == "inventory-photo-sales-copy") {
                /* inventory report sales copy */
                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, false);
                return $this->get('Numa.Reports')->billingReportInventoryShortPhotoXls($entities);
            }

            if ($request->query->get('report') == "inventory-photo") {
                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, false);
                return $this->get('Numa.Reports')->billingReportInventoryPhotoXls($entities);
            }

            if ($request->query->get('report') == "unit-revenue") {
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id, true);
                return $this->get('Numa.Reports')->billingUnitRevenueReportXls($entities);
            }

            if ($request->query->get('report') == "unit-sales-cost") {
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id, true);
                return $this->get('Numa.Reports')->billingUnitSalesCostReportXls($entities);
            }

            if ($request->query->get('report') == "work-order") {
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateNoItem($startDate, $endDate, $dealer_id);
                return $this->get('Numa.Reports')->billingWorkOrderXls($entities);
            }

            if ($request->query->get('report') == "finance-insurance") {

                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startDate, $endDate, $dealer_id);
                return $this->get('Numa.Reports')->billingReportFinanceInsuranceXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:index.html.twig', array(
            'billings' => $entities,
            'date_start' => $date,
            'date_end' => $date1,
        ));
    }

    public function purchaseSaleIndexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $date = $request->query->get('dateFrom');
        $date1 = $request->query->get('dateTo');
        $bydate = $request->attributes->get('bydate');
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
            $dealer_id = $dealer->getId();

            if ($securityContext->isGranted('ROLE_DEALER_PRINCIPAL')) {
                $dealer_id = $this->get('numa.dms.user')->getAvailableDealersIds();
            }
            //$entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id);
            //$entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startDate, $endDate, $dealer_id);
            //$entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id,true,"invoice");
            $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id,null,"bill_of_sale");

            if ($request->query->get('report') == "purchase") {
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id,true,"invoice");
                return $this->get('Numa.Reports')->billingReportPurchaseXls($entities);
            }

            if ($request->query->get('report') == "sale") {
                //$entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startDate, $endDate, $dealer_id,null,"bill_of_sale");
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id,null,"bill_of_sale");
                return $this->get('Numa.Reports')->billingReportSalesXls($entities);
            }

            if ($request->query->get('report') == "sales-commission") {
//                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startDate, $endDate, $dealer_id);

                //$entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startDate, $endDate, $dealer_id,null,"bill_of_sale");
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id,null,"bill_of_sale");
                return $this->get('Numa.Reports')->billingReportSalesCommisionXls($entities);
            }

            if ($request->query->get('report') == "unit-profit") {

//                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, true);
                //$entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id,null,"bill_of_sale");
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startDate, $endDate, $dealer_id,null,"bill_of_sale");

                return $this->get('Numa.Reports')->billingUnitProfitReportXls($entities);
            }
            if ($request->query->get('report') == "unit-revenue") {
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id, true,"bill_of_sale");
                return $this->get('Numa.Reports')->billingUnitRevenueReportXls($entities);
            }

            if ($request->query->get('report') == "unit-sales-cost") {
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id, true,"bill_of_sale");
                return $this->get('Numa.Reports')->billingUnitSalesCostReportXls($entities);
            }

            if ($request->query->get('report') == "work-order") {
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateNoItem($startDate, $endDate, $dealer_id,null,"bill_of_sale");
                return $this->get('Numa.Reports')->billingWorkOrderXls($entities);
            }

            if ($request->query->get('report') == "finance-insurance") {

                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id,null,"bill_of_sale");
                return $this->get('Numa.Reports')->billingReportFinanceInsuranceXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:ps_index.html.twig', array(
            'billings' => $entities,
            'date_start' => $date,
            'date_end' => $date1,
        ));
    }

    public function InventoryIndexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $date = $request->query->get('dateFrom');
        $date1 = $request->query->get('dateTo');
        $bydate = $request->attributes->get('bydate');
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
            //$em->flush();
            $this->addFlash("danger", "You must be logged in as a Dealer!");
        } else {
            $securityContext = $this->container->get('security.authorization_checker');
            $dealer_id = $dealer->getId();

            if ($securityContext->isGranted('ROLE_DEALER_PRINCIPAL')) {
                $dealer_id = $this->get('numa.dms.user')->getAvailableDealersIds();
            }
            //$entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id);
            //$entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startDate, $endDate, $dealer_id);
            $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id,true,"invoice");

            if ($request->query->get('report') == "inventory") {
//                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, false);
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id,false,"invoice");
                return $this->get('Numa.Reports')->billingReportInventoryXls($entities);
            }

            if ($request->query->get('report') == "inventory-sales-copy") {
                /* inventory report sales copy */
//                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, false);
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id,false,"invoice");

                return $this->get('Numa.Reports')->billingReportInventoryShortXls($entities);
            }

            if ($request->query->get('report') == "inventory-photo-sales-copy") {
                /* inventory report sales copy */
//                $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, false);

                //$entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, false);
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id,false,"invoice");

                return $this->get('Numa.Reports')->billingReportInventoryShortPhotoXls($entities);
            }

            if ($request->query->get('report') == "inventory-photo") {
                //$entities = $em->getRepository('NumaDOADMSBundle:Sale')->findByDate($startDate, $endDate, $dealer_id, false);
                $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateReports($startDate, $endDate, $dealer_id,false,"invoice");


                return $this->get('Numa.Reports')->billingReportInventoryPhotoXls($entities);
            }
        }

        return $this->render('NumaDOADMSBundle:Reports:i_index.html.twig', array(
            'billings' => $entities,
            'date_start' => $date,
            'date_end' => $date1,
        ));
    }

    private function createFilterForm(){

        $form = $this->createFormBuilder()
            ->add('dateFrom', TextType::class)
            ->add('dateTo', TextType::class)
            ->add('filter', SubmitType::class)
            ->add('filterBy', ChoiceType::class)
            ->add('report', ChoiceType::class)
            ->add('openReport', SubmitType::class)
            ->getForm();

        return $form;
    }
}