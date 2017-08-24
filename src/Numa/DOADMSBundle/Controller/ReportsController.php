<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

    private function createFilterForm(){

        $form = $this->createFormBuilder()
            ->add('dateFrom', TextType::class,array('required'=>false,'attr'=>array("class"=>"datepicker form-control")))
            ->add('dateTo', TextType::class,array('required'=>false,'attr'=>array("class"=>"datepicker form-control")))
            ->add('filter', SubmitType::class,array('attr'=>array("id"=>"filter-result","class"=>"btn btn-success")))
            ->add('report', SubmitType::class,array('attr'=>array("id"=>"create","class"=>"btn btn-primary")))
            ->setMethod("GET")
            ->getForm();

        return $form;
    }

    public function listAction(Request $request)
    {
        return $this->render('NumaDOADMSBundle:Reports:list.html.twig');
    }

    public function purchaseAction(Request $request)
    {

        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFilterForm();
        $form->handleRequest($request);
        $startDate = $form->getData()["dateFrom"];
        $endDate = $form->getData()["dateTo"];

        $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findPurchasedByDate($startDate, $endDate, $dealer->getId());
        if($form->isSubmitted()){
            $create = $form->get('report')->isClicked();
            if($create) {
                return $this->get('Numa.Reports')->billingReportPurchaseXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:purchase.html.twig', array(
            'form'=>$form->createView(),
            'entities' => $entities,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'title'=>"Purchase Report",
        ));
    }

    public function salesAction(Request $request)
    {
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFilterForm();
        $form->handleRequest($request);
        $startDate = $form->getData()["dateFrom"];
        $endDate = $form->getData()["dateTo"];

        $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findSoldByDate($startDate, $endDate, $dealer->getId());
        if($form->isSubmitted()){
            $create = $form->get('report')->isClicked();
            if($create) {
                return $this->get('Numa.Reports')->billingReportSalesXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:sales.html.twig', array(
            'title'=>"Sales Report",
            'entities' => $entities,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'form'=>$form->createView(),
        ));
    }

    public function salesCommissionAction(Request $request)
    {
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFilterForm();
        $form->handleRequest($request);
        $startDate = $form->getData()["dateFrom"];
        $endDate = $form->getData()["dateTo"];

        $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findSoldByDate($startDate, $endDate, $dealer->getId());
        if($form->isSubmitted()){
            $create = $form->get('report')->isClicked();
            if($create) {
                return $this->get('Numa.Reports')->billingReportSalesCommisionXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:sales.html.twig', array(
            'entities' => $entities,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'form'=>$form->createView(),
            'title'=>"Sales Commission Report",
        ));
    }

    public function unitProfitAction(Request $request)
    {
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFilterForm();
        $form->handleRequest($request);
        $startDate = $form->getData()["dateFrom"];
        $endDate = $form->getData()["dateTo"];

        $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findPurchasedByDate($startDate, $endDate, $dealer->getId(),true);
        if($form->isSubmitted()){
            $create = $form->get('report')->isClicked();
            if($create) {
                return $this->get('Numa.Reports')->billingUnitProfitReportXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:purchase.html.twig', array(
            'entities' => $entities,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'form'=>$form->createView(),
            'title'=>"Unit Profit Report",
        ));
    }

    public function inventoryAction(Request $request)
    {
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFilterForm();
        $form->handleRequest($request);
        $startDate = $form->getData()["dateFrom"];
        $endDate = $form->getData()["dateTo"];

        $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findPurchasedByDate($startDate, $endDate, $dealer->getId(),false);
        if($form->isSubmitted()){
            $create = $form->get('report')->isClicked();
            if($create) {
                return $this->get('Numa.Reports')->billingReportInventoryXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:purchase.html.twig', array(
            'entities' => $entities,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'form'=>$form->createView(),
            'title'=>"Inventory Report",
        ));
    }

    public function inventorySalesCopyAction(Request $request)
    {
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFilterForm();
        $form->handleRequest($request);
        $startDate = $form->getData()["dateFrom"];
        $endDate = $form->getData()["dateTo"];

        $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findPurchasedByDate($startDate, $endDate, $dealer->getId(),false);
        if($form->isSubmitted()){
            $create = $form->get('report')->isClicked();
            if($create) {
                return $this->get('Numa.Reports')->billingReportInventoryShortXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:purchase.html.twig', array(
            'entities' => $entities,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'form'=>$form->createView(),
            'title'=>"Inventory Report",
        ));
    }

    public function inventoryPhotoSalesCopyAction(Request $request)
    {
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFilterForm();
        $form->handleRequest($request);
        $startDate = $form->getData()["dateFrom"];
        $endDate = $form->getData()["dateTo"];

        $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findPurchasedByDate($startDate, $endDate, $dealer->getId(),false);
        if($form->isSubmitted()){
            $create = $form->get('report')->isClicked();
            if($create) {
                return $this->get('Numa.Reports')->billingReportInventoryShortPhotoXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:purchase.html.twig', array(
            'entities' => $entities,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'form'=>$form->createView(),
            'title'=>"Inventory Sales Copy With Photo Report",
        ));
    }

    public function inventoryPhotoAction(Request $request)
    {
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFilterForm();
        $form->handleRequest($request);
        $startDate = $form->getData()["dateFrom"];
        $endDate = $form->getData()["dateTo"];

        $entities = $em->getRepository('NumaDOADMSBundle:Sale')->findPurchasedByDate($startDate, $endDate, $dealer->getId(),false);
        if($form->isSubmitted()){
            $create = $form->get('report')->isClicked();
            if($create) {
                return $this->get('Numa.Reports')->billingReportInventoryPhotoXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:sales.html.twig', array(
            'entities' => $entities,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'form'=>$form->createView(),
            'title'=>"Inventory Photo Report",
        ));
    }

    public function unitRevenueAction(Request $request)
    {
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFilterForm();
        $form->handleRequest($request);
        $startDate = $form->getData()["dateFrom"];
        $endDate = $form->getData()["dateTo"];

        $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startDate, $endDate, $dealer->getId());
        if($form->isSubmitted()){
            $create = $form->get('report')->isClicked();
            if($create) {
                return $this->get('Numa.Reports')->billingUnitRevenueReportXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:sales.html.twig', array(
            'entities' => $entities,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'form'=>$form->createView(),
            'title'=>"Unit Revenue Report",
        ));
    }

    public function unitSalesCostAction(Request $request)
    {
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFilterForm();
        $form->handleRequest($request);
        $startDate = $form->getData()["dateFrom"];
        $endDate = $form->getData()["dateTo"];

        $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startDate, $endDate, $dealer->getId());
        if($form->isSubmitted()){
            $create = $form->get('report')->isClicked();
            if($create) {
                return $this->get('Numa.Reports')->billingUnitSalesCostReportXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:sales.html.twig', array(
            'entities' => $entities,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'form'=>$form->createView(),
            'title'=>"Unit Sales Cost Report",
        ));
    }

    public function workOrderAction(Request $request)
    {
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFilterForm();
        $form->handleRequest($request);
        $startDate = $form->getData()["dateFrom"];
        $endDate = $form->getData()["dateTo"];
        $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDateNoItem($startDate, $endDate, $dealer->getId());

        if($form->isSubmitted()){
            $create = $form->get('report')->isClicked();
            if($create) {
                return $this->get('Numa.Reports')->billingWorkOrderXls($entities);
            }
        }
        return $this->render('NumaDOADMSBundle:Reports:purchase.html.twig', array(
            'entities' => $entities,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'form'=>$form->createView(),
            'title'=>"Work Order Report",
        ));
    }

    public function financeInsuranceAction(Request $request)
    {
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFilterForm();
        $form->handleRequest($request);
        $startDate = $form->getData()["dateFrom"];
        $endDate = $form->getData()["dateTo"];
        $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($startDate, $endDate, $dealer->getId());

        if($form->isSubmitted()){
            $create = $form->get('report')->isClicked();
            if($create) {
                return $this->get('Numa.Reports')->billingReportFinanceInsuranceXls($entities);
            }
        }

        return $this->render('NumaDOADMSBundle:Reports:sales.html.twig', array(
            'entities' => $entities,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'form'=>$form->createView(),
            'title'=>"Work Order Report",
        ));
    }
}