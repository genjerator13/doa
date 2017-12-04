<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\Customer;
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
        $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDealers($dealerIds);

        return $this->render('NumaDOADMSBundle:Billing:index_full.html.twig', array(
            'entities' => $entities,
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
                $exists = $em->getRepository('NumaDOADMSBundle:Billing')->findOneBy(array("item_id" => $item->getId()));
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
            $message = "The billing has been successfully updated";
            if ($qbSale instanceof \QuickBooks_IPP_Object_SalesReceipt) {
                $message = "The billing has been successfully created and updated to quickbooks";
            }

            $this->addFlash("success", $message);

            if (!empty($form->getClickedButton()) && $form->getClickedButton()->getName() == "submitAndPrint") {
                return $this->redirect($this->generateUrl('billing_print', array('id' => $entity->getId())));
            }
            return $this->redirect($this->generateUrl('customer_edit', array('id' => $entity->getCustomerId())));
        }
        $customerForm = $this->createCustomerForm(new Customer());
        return $this->render('NumaDOADMSBundle:Billing:new.html.twig', array(
            'entity' => $entity,
            'dealer' => $dealer,
            'customer' => $customer,
            'customerForm' => $customerForm->createView(),
            'form' => $form->createView(),
        ));
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

        return $form;
    }

    private function createCustomerForm(Customer $entity)
    {
        $form = $this->createForm(new CustomerType(), $entity, array(
            'method' => 'POST',
            'attr' => array('ng-submit'=>'submitCustomer(customer_id)')
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
            'customerForm' =>$customerForm->createView(),
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
        return $this->render($this->getBillingTemplate(false), array(
            'entity' => $entity,
            'customer' => $customer,
            'customerForm' => $customerForm->createView(),
            'dealer' => $dealer,
            'item' => $entity->getItem(),
            'id' => $id,
            'form' => $editForm->createView(),
            'template' => $billingTemplate,
            'qbo' => $qbo
        ));
    }

    private function getBillingTemplate($view = true)
    {
        $dealer = $this->get("numa.dms.user")->getSignedDealer();
        $billingTemplate = $this->get('numa.settings')->get('billing_template', array(), $dealer);

        $tt = "new";
        if ($view) {
            $tt = "view";
        }
        $template = "NumaDOADMSBundle:Billing:" . $tt . ".html.twig";

//        if(strip_tags($billingTemplate)=="template2"){
//            $template = "NumaDOADMSBundle:Billing:".$tt."_template2.html.twig";
//        }
//        else
//        if(strip_tags($billingTemplate)=="template3"){
//            $template = "NumaDOADMSBundle:Billing:".$tt."_template3.html.twig";
//        }

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

        return $form;
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
            $em->flush();

            $qbSale = $this->doQB($entity);
            if (!empty($editForm->getClickedButton()) && $editForm->getClickedButton()->getName() == "submitAndPrint") {
                return $this->redirect($this->generateUrl('billing_print', array('id' => $id)));
            }
            $message = "The billing has been successfully updated";
            if ($qbSale instanceof \QuickBooks_IPP_Object_SalesReceipt) {
                $message = "The billing has been successfully updated and updated to quickbooks";
            }

            $this->addFlash("success", $message);
            return $this->redirect($this->generateUrl('billing_edit', array('id' => $id)));
        }
        $qbo = $this->get("numa.quickbooks")->init();

        return $this->render('NumaDOADMSBundle:Billing:new.html.twig', array(
            'entity' => $entity,
            'id' => $entity->getId(),
            'customer' => $entity->getCustomer(),
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

//        return new Response(
//            $html,
//            200
//        );
        $mpdf = new \Mpdf\Mpdf(array("margin_left"=>5,"margin_right"=>5,"margin_top"=>5,"margin_bottom"=>5));
        //$mpdf = new \mPDF("","A4",0,"",5,5,10,10);

        $mpdf->useOnlyCoreFonts = true;    // false is default
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("Bill of Sale");
        $mpdf->SetAuthor($billing->getDealer()->getName());
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="BillOfSale_' . $billing->getId() . ".pdf");
        //$mpdf->Output("BillOfSale_" . $billing->getId() );
        $mpdf->Output("BillOfSale_" . $billing->getId() . ".pdf", "D");
        return new Response();
    }

    public function printBlankAction()
    {
        $billingTemplate = $this->get('numa.settings')->getStripped('billing_template', array());
        $dealer = $this->get("numa.dms.user")->getSignedDealer();
        $html = $this->renderView(
            $this->getBillingTemplate(),
            array( 'template' => $billingTemplate,'dealer'=>$dealer)
        );



//        return new Response(
//            $html,
//            200
//        );
        $mpdf = new \mPDF("", "A4", 0, "", 5, 5, 10, 5);
        $mpdf->shrink_tables_to_fit = 1;
        $mpdf->useOnlyCoreFonts = true;    // false is default
        $mpdf->SetProtection(array('print'));
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
}
