<?php

namespace Numa\DOADMSBundle\Controller;

use mikehaertl\pdftk\Pdf;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\BillingDoc;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Entity\FillablePdf;
use Numa\DOADMSBundle\Form\CustomerType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Form\BillingType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Billing controller.
 *
 */
class BillingController extends Controller
{

    /**
     * Lists all Billing entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $dealerIds = $this->get('Numa.Dms.User')->getAvailableDealersIds();


        return $this->render('NumaDOADMSBundle:Billing:indexDataGrid.html.twig', array(

            'dealersId' => $dealerIds
        ));
    }

    public function index2Action()
    {
        $em = $this->getDoctrine()->getManager();
        $dealerIds = $this->get('Numa.Dms.User')->getAvailableDealersIds();
        $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDealers($dealerIds);

        return $this->render('NumaDOADMSBundle:Billing:index_full.html.twig', array(
            'entities' => $entities,
            'dealersId' => $dealerIds
        ));
    }


    /**
     * Creates a new Billing entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Billing();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        $customer = $this->get("numa.dms.customer")->getCustomer($entity->getCustomerId());
        $dealer = $customer->getDealer();
        $entity->setDealer($dealer);

        if (empty($entity->getItemId()) && !($entity->getWorkOrder())) {
            $form->addError(new FormError('Vehicle not found, please fill the stock # or VIN #'));
        }

        if ($form->isValid()) {

            if (!empty($entity->getItemId())) {
                $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($entity->getItemId());
                $exists = $em->getRepository('NumaDOADMSBundle:Billing')->findOneBy(array("active" => 1, "item_id" => $item->getId()));
                //dump($exists);die();
                if ($exists instanceof Billing) {
                    return false;
                }
                $entity->setItem($item);
            }
            if (empty($entity->getDateBilling())) {
                $entity->setDateBilling(new \DateTime('today'));
            }
            $entity->setCustomer($customer);
            $em->persist($entity);
            $em->flush();
            $qbSale = $this->doQB($entity);
            $message = "The billing has been successfully updated.";
            if ($qbSale instanceof \QuickBooks_IPP_Object_SalesReceipt) {
                $message = "The billing has been successfully created and updated to quickbooks.";
            }
            $message .= $this->tradeinMessage($em,$entity);
            $this->addFlash("success", $message);
            $rData = $request->request->get('numa_doadmsbundle_billing');
            $print = $rData['s'] == "PRINT";


            if ($print) {
                return $this->redirect($this->generateUrl('billing_print', array('id' => $entity->getId())));
            }
            return $this->redirect($this->generateUrl('customer_edit', array('id' => $entity->getCustomerId())));
        }
        $customerForm = $this->createCustomerForm(new Customer());


        $billingTemplate = $this->get('numa.settings')->getStripped('billing_template', array(), $dealer);
        return $this->render('NumaDOADMSBundle:Billing:new.html.twig', array(
            'entity' => $entity,
            'dealer' => $dealer,
            'customer' => $customer,
            'template' => $billingTemplate,
            'customerForm' => $customerForm->createView(),
            'form' => $form->createView(),
        ));
    }

    public function tradeinMessage($em,$entity){
        //tradein check
        $message ="";
        if(!empty($entity->getTidVin())) {
            $currentItem = $em->getRepository("NumaDOAAdminBundle:Item")->findOneBy(array('VIN' => $entity->getTidVin()));

            if (($currentItem instanceof Item && $currentItem->isArchived()) || !$currentItem instanceof Item) {
                $message = " The trade in listing has been created: VIN = ". $entity->getTidVin();
            }else{
                $message = " The trade in listing has NOT been created: VIN = ". $entity->getTidVin()." .There is already a listing in the database with the same VIN";
            }
        }
        return $message;
    }
    /**
     * Creates a form to create a Billing entity.
     *
     * @param Billing $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Billing $entity)
    {
        $form = $this->createForm(new BillingType(), $entity, array(
            'action' => $this->generateUrl('billing_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));
        $form->add('s', 'hidden', array("mapped" => false));
        return $form;
    }

    private function createCustomerForm(Customer $entity)
    {
        $form = $this->createForm(new CustomerType(), $entity, array(
            'method' => 'POST',
            'attr' => array('ng-submit' => 'submitCustomer(customer_id)')
        ));
        //'ng-controller'=>'billingCtrl',
        //$form->add("Submit","submit",array("attr"=>array("class"=>"btn btn-success")));
        $form->remove("file_import_source");
        return $form;
    }


    /**
     * Displays a form to create a new Billing entity.
     *
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Billing();

        $customer = $this->get("numa.dms.customer")->getCustomer($id);

//        $dealer = $this->get("Numa.Dms.User")->getSignedDealer();
        $dealer = $customer->getDealer();
        $entity->setCustomerId($id);
        //$maxInvoiceNr = $em->getRepository('NumaDOADMSBundle:Billing')->maxInvoiceNr($entity->getDealerId());
        $maxInvoiceNr = strtoupper($em->getRepository('NumaDOADMSBundle:Billing')->generateInvoiceNumber($entity->getDealerId()));

        if ($dealer instanceof Catalogrecords) {
            $entity->setDealer($dealer);
        }

        $form = $this->createCreateForm($entity);
        $billingTemplate = $this->get('numa.settings')->getStripped('billing_template', array(), $dealer);
        $qbo = $this->get("numa.quickbooks")->init();
        $customerForm = $this->createCustomerForm(new Customer());
        return $this->render($this->getBillingTemplate(false), array(
            'entity' => $entity,
            'customerForm' => $customerForm->createView(),
            'customer' => $customer,
            'dealer' => $dealer,
            'form' => $form->createView(),
            'max_invoive_nr' => $maxInvoiceNr,
            'template' => $billingTemplate,
            'qbo' => $qbo,
        ));
    }

    public function newncAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Billing();

        $maxInvoiceNr = strtoupper($em->getRepository('NumaDOADMSBundle:Billing')->generateInvoiceNumber($entity->getDealerId()));

        $dealer = $this->get("numa.dms.user")->getSignedDealer();
        if ($dealer instanceof Catalogrecords) {
            $entity->setDealer($dealer);
        }

        $form = $this->createCreateForm($entity);
        $billingTemplate = $this->get('numa.settings')->getStripped('billing_template', array(), $dealer);
        $qbo = $this->get("numa.quickbooks")->init();
        $customerForm = $this->createCustomerForm(new Customer());
        return $this->render($this->getBillingTemplate(false), array(
            'entity' => $entity,
            'dealer' => $dealer,
            'customerForm' => $customerForm->createView(),
            'form' => $form->createView(),
            'max_invoive_nr' => $maxInvoiceNr,
            'template' => $billingTemplate,
            'qbo' => $qbo,
        ));
    }

    /**
     * Displays a form to edit an existing Billing entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $this->get("numa.dms.billing")->getBilling($id);
        $customer = $entity->getCustomer();
        $dealer = $entity->getDealer();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Billing entity.');
        }

        $editForm = $this->createEditForm($entity);
        $billingTemplate = $this->get('numa.settings')->getStripped('billing_template', array(), $dealer);

        $qbo = $this->get("numa.quickbooks")->init();
        $customerForm = $this->createCustomerForm(new Customer());
        $fillablePdfs = $em->getRepository(FillablePdf::class)->findByState($dealer);

        $billingDocs = $em->getRepository(BillingDoc::class)->findBy(array("Billing" => $entity));
        $bd = array();
        foreach ($billingDocs as $billingDoc) {
            $bd[] = $billingDoc->getFillablePdf()->getId();
        }

        return $this->render($this->getBillingTemplate(false), array(
            'entity' => $entity,
            'customer' => $customer,
            'customerForm' => $customerForm->createView(),
            'dealer' => $dealer,
            'item' => $entity->getItem(),
            'id' => $id,
            'form' => $editForm->createView(),
            'template' => $billingTemplate,
            'fillablePdfs' => $fillablePdfs,
            'billingDocs' => $bd,
            'qbo' => $qbo
        ));
    }

    private function getBillingTemplate($view = true)
    {
        $dealer = $this->get("numa.dms.user")->getSignedDealer();
        $billingTemplate = $this->get('numa.settings')->getStripped('billing_template', array(), $dealer);

        //NumaDOADMSBundle:Billing/Block:purchaserInfo.html.twig
        $tt = "new";
        if ($view) {
            $tt = "view";
        }
        $defTemplate = "NumaDOADMSBundle:Billing:" . $tt . ".html.twig";
        $template = "NumaDOADMSBundle:Billing/".$billingTemplate.":" . $tt . ".html.twig";

        if (! $this->get('templating')->exists($template) ) {
            $template = $defTemplate;
        }

        return $template;
    }

    /**
     * Creates a form to edit a Billing entity.
     *
     * @param Billing $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Billing $entity)
    {
        $form = $this->createForm(new BillingType(), $entity, array(
            'action' => $this->generateUrl('billing_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));
        $form->add('s', 'hidden', array("mapped" => false));

        return $form;
    }

    /**
     * Creates a form for fillable pdfs checkboxes
     *
     * @param Billing $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createFillingPdfsForm()
    {
//        $em = $this->getDoctrine()->getManager();
//        $fillablePdfs = $em->getRepository(FillablePdf::class)->findAll();
//        $form = $this->createForm(new BillingType(), $entity, array(
//            'action' => $this->generateUrl('billing_update', array('id' => $entity->getId())),
//            'method' => 'POST',
//        ));
//
//        $form->add('submit', 'submit', array('label' => 'Update'));
//        $form->add('s', 'hidden',array("mapped" => false));
//
//        return $form;
    }

    /**
     * Edits an existing Billing entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get("numa.dms.billing")->getBilling($id);

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $qbSale = $this->doQB($entity);
            $rData = $request->request->get('numa_doadmsbundle_billing');

            $print = $rData['s'] == "PRINT";
            $data = $editForm->getData();
            $pdfs = $request->request->get('pdfs');
            if (is_array($pdfs)) {
                $billingDoc = $em->getRepository(BillingDoc::class)->findBy(array("Billing" => $entity));
                foreach ($billingDoc as $bd) {
                    $em->remove($bd);
                }
                $em->flush();
                foreach ($pdfs as $pdf) {
                    $fillablePdf = $em->getRepository(FillablePdf::class)->find($pdf);
                    if ($fillablePdf instanceof FillablePdf) {
                        $billing_doc = new BillingDoc();
                        $billing_doc->setBilling($entity);
                        $billing_doc->setFillablePdf($fillablePdf);
                        $em->persist($billing_doc);
                    }
                }
            }
            $em->flush();

            if ($print) {
                return $this->redirect($this->generateUrl('billing_print', array('id' => $id)));
            }
            $message = "The billing has been successfully updated";
            if ($qbSale instanceof \QuickBooks_IPP_Object_SalesReceipt) {
                $message = "The billing has been successfully updated and updated to quickbooks";
            }
            $message .= $this->tradeinMessage($em,$entity);
            $this->addFlash("success", $message);
            return $this->redirect($this->generateUrl('billing_edit', array('id' => $id)));
        }
        $qbo = $this->get("numa.quickbooks")->init();

        $customerForm = $this->createCustomerForm(new Customer());
        return $this->render('NumaDOADMSBundle:Billing:new.html.twig', array(
            'entity' => $entity,
            'id' => $entity->getId(),
            'customer' => $entity->getCustomer(),
            'customerForm' => $customerForm->createView(),
            'dealer' => $entity->getDealer(),
            'item' => $entity->getItem(),
            'form' => $editForm->createView(),
            'qbo' => $qbo
        ));
    }

    /**
     * Deletes a Billing entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        $redirect = $request->query->get('redirect');
        $em = $this->getDoctrine()->getManager();
        $entity = $this->get("numa.dms.billing")->getBilling($id);

        $dealer = $this->get("numa.dms.user")->getSignedDealer();
        if ((!$securityContext->isGranted('ROLE_ADMIN') && !$securityContext->isGranted('ROLE_DMS_USER')) ||
            ($securityContext->isGranted('ROLE_DMS_USER') && $dealer instanceof Catalogrecords && $entity->getDealerId() != $dealer->getId())
        ) {
            throw $this->createAccessDeniedException("Only administrator may delete this Billing.");
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Billing entity.');
        }
        //Delete Sale
//        if(!empty($entity->getItem())){
//            $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($entity->getItem());
//            if(!empty($entity->getItem()->getSaleId())){
//                $sale = $em->getRepository('NumaDOADMSBundle:Sale')->find($entity->getItem()->getSaleId());
//                $item->setSaleId(null);
//                $em->remove($sale);
//            }
//        }
        $em->remove($entity);
        $em->flush();

        if ($redirect == "dms_reports") {
            return $this->redirect($this->generateUrl('dms_reports'));
        }
        return $this->redirect($this->generateUrl('customer'));
    }

    /**
     * Print a Billing entity.
     *
     */
    public function printAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $billing = $this->get("numa.dms.billing")->getBilling($id);

        $billingTemplate = $this->get('numa.settings')->getStripped('billing_template', array(), $billing->getDealer());
        $html = $this->renderView(
            $this->getBillingTemplate(),
            array('billing' => $billing,
                'id' => $billing->getId(),
                'customer' => $billing->getCustomer(),
                'dealer' => $billing->getDealer(),
                'item' => $billing->getItem(),
                'template' => $billingTemplate)
        );


        //$mpdf = new \mPDF("", "A4", 0, "", 5, 5, 10, 5);
        $defaultConfigO = new \Mpdf\Config\ConfigVariables();
        $defaultConfig = $defaultConfigO->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        if(!is_array($fontDirs)){
            $fontDirs = array($fontDirs);
        }
        $customfontDir = array($this->get('kernel')->getRootDir() . '/../web/fonts');
        $defaultFontConfigO = new \Mpdf\Config\FontVariables();//)->getDefaults();
        $defaultFontConfig = $defaultFontConfigO->getDefaults();

        $fontData = $defaultFontConfig['fontdata'];


        $mpdf = new \Mpdf\Mpdf(array('fontdata' => $fontData + array(
                'scriptina' => array(
                    'R' => 'brtswfte.ttf',
                )),'default_font' => 'Verdana','fontDir' => array_merge($fontDirs, $customfontDir),'format' => 'A4', "margin_left" => 5, "margin_right" => 5, "margin_top" => 3, "margin_bottom" => 3));
        $mpdf->shrink_tables_to_fit = 1;
        $mpdf->useOnlyCoreFonts = true;    // false is default

        $mpdf->SetTitle("Bill of Sale");
        $mpdf->SetAuthor($billing->getDealer()->getName());
        $mpdf->SetDisplayMode('fullpage');
//        return new Response($html,200);
//        dump($html);
//        die();
        $mpdf->WriteHTML($html);
        $tmpFiles = array();
        $billingDocs = $this->get("numa.dms.media")->renderBillingDocs($billing);
        if (!empty($billingDocs)) {
            $i = 0;


            $alphas = range('A', 'Z');
            foreach ($billingDocs as $bd) {
                $tmpfile = sys_get_temp_dir() . "/billing_doc_" . $alphas[$i] . ".pdf";
                $tmpfiles[$alphas[$i]] = $tmpfile;
                $i++;
                $bd->saveAs($tmpfile);
            }

//            $terms = $this->get("numa.dms.media")->renderTermConditions($billing);
//            $tmpfiles[$alphas[$i++]] = $terms;

            $origBos = $this->get("numa.dms.media")->renderOriginalBillOfSale($billing, $this->getBillingTemplate(), $billingTemplate);
            $tmpfiles[$alphas[$i++]] = $origBos;

            $pdf = new Pdf($tmpfiles);
            $i = 0;
            foreach ($tmpfiles as $tempfile) {
                $pdf->cat(1, 'end', $alphas[$i]);
                $i++;
            }

            $tmpfile = tempnam(sys_get_temp_dir(), 'pdf');
            $pdf->saveAs($tmpfile);
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename="BillOfSale_' . $billing->getId() . '.pdf"');
            @readfile($tmpfile);
        } else {


            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename="BillOfSale_' . $billing->getId() . ".pdf");
            //$mpdf->Output("BillOfSale_" . $billing->getId() );
            $mpdf->Output("BillOfSale_" . $billing->getId() . ".pdf", "D");
            return new Response();
        }
    }

    public function printBlankAction()
    {
        $billingTemplate = $this->get('numa.settings')->getStripped('billing_template', array());
        $dealer = $this->get("numa.dms.user")->getSignedDealer();
        $html = $this->renderView(
            $this->getBillingTemplate(),
            array('template' => $billingTemplate, 'dealer' => $dealer, "blank" => true)
        );



//        return new Response(
//            $html,
//            200
//        );
        //$mpdf = new \mPDF("", "A4", 0, "", 5, 5, 10, 5);
        $mpdf = new \Mpdf\Mpdf(array('format' => 'A4', "margin_left" => 5, "margin_right" => 5, "margin_top" => 3, "margin_bottom" => 3));

        $mpdf->shrink_tables_to_fit = 1;
        $mpdf->useOnlyCoreFonts = true;    // false is default

        $mpdf->SetTitle("Bill of Sale");
        //$mpdf->SetAuthor($billing->getDealer()->getName());
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="BillOfSale_blank' . ".pdf");
        $mpdf->Output("BillOfSale_blank" . ".pdf", "D");
        return new Response();
    }


    /**
     * Print Inside a Billing entity.
     *
     */
    public function printInsideAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $billing = $em->getRepository('NumaDOADMSBundle:Billing')->find($id);
        $html = $this->renderView(
            $this->getBillingTemplate(),
            array('billing' => $billing,
                'id' => $billing->getId(),
                'customer' => $billing->getCustomer(),
                'dealer' => $billing->getDealer(),
                'item' => $billing->getItem())
        );

        $response = new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
            )
        );
        $response->headers->set('Content-Type', 'application/pdf');
        return $response;
    }


    /**
     * Creates a form to delete a Billing entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('billing_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    private function doQB(Billing $billing)
    {
        if ($billing->getQbPostInclude() && $billing->getActive()) {

            $qbBSale = $this->get('numa.dms.quickbooks.sale')->insertBillingToQBSaleReceipt($billing);
            if ($qbBSale instanceof \QuickBooks_IPP_Object_SalesReceipt) {

            }
            return $qbBSale;
        }
    }


    public function massDeleteAction(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_ADMIN') or $securityContext->isGranted('ROLE_DMS_USER')) {
            $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);
            $this->get("Numa.Dms.Listing")->deleteItems($ids);
        }
        die();
    }
}
