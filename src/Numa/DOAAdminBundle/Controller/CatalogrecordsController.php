<?php

namespace Numa\DOAAdminBundle\Controller;

use Numa\DOAAdminBundle\Entity\Coupon;
use Numa\DOAAdminBundle\Form\DealerBillingType;
use Numa\DOAAdminBundle\Form\DealerCouponsType;
use Numa\DOAAdminBundle\Form\DealerFeedsType;
use Numa\DOAAdminBundle\Form\DealerSiteType;
use Numa\DOAAdminBundle\Form\ItemDefaultType;
use Numa\DOADMSBundle\Lib\DashboardDMSControllerInterface;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Form\CatalogrecordsType;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
 * Catalogrecords controller.
 *
 */
class CatalogrecordsController extends Controller implements DashboardDMSControllerInterface, DealerSiteControllerInterface
{

    public $dashboard;

    public function initializeDashboard($dashboard)
    {
        $this->dashboard = $dashboard;
    }

    public $dealer;

    public function initializeDealer($dealer)
    {
        $this->dealer = $dealer;

    }


    /**
     * Lists all Catalogrecords entities.
     *
     */
    public function indexAction(Request $request)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN', 'ROLE_DEALER_ADMIN'), null, 'Access Denied!');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findAll();
        $uploadForm = $this->createImportCSVForm();


        return $this->render('NumaDOAAdminBundle:Catalogrecords:index.html.twig', array(
            'entities' => $entities,
            'uploadForm' => $uploadForm->createView(),
            'dashboard' => $this->dashboard,
        ));

    }

    /**
     * Creates a new Catalogrecords entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Catalogrecords();
        $dashboard = $request->get('_dashboard');
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);

            $em->flush();
            $entity->upload();
            $em->flush();
            $this->get('Numa.DMSUtils')->generatePagesForDealer($entity->getId());
            $redirect = 'catalogs';
            if ($dashboard == 'DMS') {
                $redirect = 'dms_catalogs';
            }
            return $this->redirect($this->generateUrl($redirect, array('id' => $entity->getId())));
        }

        return $this->render('NumaDOAAdminBundle:Catalogrecords:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'dashboard' => $this->dashboard,
        ));
    }

    /**
     * Creates a form to create a Catalogrecords entity.
     *
     * @param Catalogrecords $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Catalogrecords $entity)
    {
        $action = 'catalogs_create';
        if (!empty($this->dashboard)) {
            $action = 'dms_catalogs_create';
        }
        $form = $this->createForm(new CatalogrecordsType(), $entity, array(
            'action' => $this->generateUrl($action),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-default left',)));

        return $form;
    }

    /**
     * Creates a form to create a Catalogrecords entity.
     *
     * @param Catalogrecords $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createImportCSVForm()
    {
        $data = array();
        $form = $this->createFormBuilder($data)
            ->setAction($this->generateUrl('catalog_import_csv'))
            ->add('upload', 'file', array('label' => 'CSV File to Submit'))
            ->add('ImportCSV', 'submit', array('label' => 'Import CSV'))
            ->getForm();

        return $form;
    }

    /**
     * Displays a form to create a new Catalogrecords entity.
     *
     */
    public function newAction(Request $request)
    {
        $entity = new Catalogrecords();
        $dashboard = $request->get('_dashboard');
        $form = $this->createCreateForm($entity);

        return $this->render('NumaDOAAdminBundle:Catalogrecords:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'dashboard' => $dashboard,
        ));
    }

    /**
     * Finds and displays a Catalogrecords entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogrecords entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Catalogrecords:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Catalogrecords entity.
     *
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);
        $securityContext = $this->container->get('security.authorization_checker');
        $dealer = $this->get("Numa.Dms.User")->getSignedDealer();
        if (!$securityContext->isGranted('ROLE_ADMIN') && $dealer instanceof Catalogrecords) {

            if ($dealer->getId() != $id) {
                throw $this->createAccessDeniedException('You cannot access this page!');
            }
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogrecords entity.');
        }


        $editForm = $this->createEditForm($entity);
        $siteForm = $this->createDealerSiteForm($entity);
        $itemDefaultForm = $this->createItemDefaultForm($entity);
        $couponsForm = $this->createEditCouponsForm($entity);
        $feedsForm = $this->createDealerFeedsForm($entity);
        $billingForm = $this->createDealerBillingForm($entity);

        $deleteForm = $this->createDeleteForm($id);
        $qbo = $this->get("numa.quickbooks")->init();

        return $this->render('NumaDOAAdminBundle:Catalogrecords:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'site_form' => $siteForm->createView(),
            'billing_form' => $billingForm->createView(),
            'itemDefaultForm' => $itemDefaultForm->createView(),
            'coupons_form' => $couponsForm->createView(),
            'feeds_form' => $feedsForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'dashboard' => $this->dashboard,
            'qbo' => $qbo,
        ));
    }

    /**
     * Creates a form to edit a Catalogrecords entity.
     *
     * @param Catalogrecords $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditCouponsForm(Catalogrecords $entity)
    {
        $securityContext = $this->container->get('security.context');
        $catalogForm = new DealerCouponsType();

        //$catalogForm->setSecurityContext($securityContext);
        $limitCoupons = 4;
        $countCoupons = 0;
        if (!empty($entity->getCoupon())) {
            $countCoupons = $entity->getCoupon()->count();
        }

        if ($countCoupons <= $limitCoupons) {

            for ($i = 0; $i < $limitCoupons - $countCoupons; $i++) {
                $coupon = new Coupon();
                $coupon->setCatalogrecords($entity);

                $entity->addCoupon($coupon);
            }
        }
        $action = 'coupons_update';
        if (strtoupper($this->dashboard) == 'DMS') {
            $action = 'dms_coupons_update';
        }
        $form = $this->createForm($catalogForm, $entity, array(
            'action' => $this->generateUrl($action, array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary left',)));
        return $form;
    }

    /**
     * Creates a form to edit a Catalogrecords entity.
     *
     * @param Catalogrecords $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Catalogrecords $entity)
    {
        $securityContext = $this->container->get('security.context');
        $catalogForm = new CatalogrecordsType();
        $catalogForm->setSecurityContext($securityContext);
        $action = 'catalogs_update';

        if (strtoupper($this->dashboard) == 'DMS') {
            $action = 'dms_catalogs_update';
        }

        $form = $this->createForm($catalogForm, $entity, array(
            'action' => $this->generateUrl($action, array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary left',)));

        return $form;
    }

    /**
     * Creates a form to edit a Catalogrecords entity.
     *
     * @param Catalogrecords $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDealerSiteForm(Catalogrecords $entity)
    {
        $securityContext = $this->container->get('security.context');
        $catalogForm = new DealerSiteType();
        $catalogForm->setSecurityContext($securityContext);
        $action = 'dms_catalogs_site_update';

        $form = $this->createForm($catalogForm, $entity, array(
            'action' => $this->generateUrl($action, array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        // $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary left',)));


        return $form;
    }

    /**
     * Creates a form to edit a Catalogrecords entity.
     *
     * @param Catalogrecords $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDealerBillingForm(Catalogrecords $entity)
    {
        $securityContext = $this->container->get('security.context');
        $catalogForm = new DealerBillingType();
        $catalogForm->setSecurityContext($securityContext);
        $action = 'dms_catalogs_billing_update';

        $form = $this->createForm($catalogForm, $entity, array(
            'action' => $this->generateUrl($action, array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        // $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary left',)));


        return $form;
    }

    /**
     * Creates a form to edit a Catalogrecords entity.
     *
     * @param Catalogrecords $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createItemDefaultForm(Catalogrecords $entity)
    {
        $securityContext = $this->container->get('security.context');
        $catalogForm = new ItemDefaultType();
        $catalogForm->setSecurityContext($securityContext);
        $action = 'dms_catalogs_item_default_update';

        $form = $this->createForm($catalogForm, $entity, array(
            'action' => $this->generateUrl($action, array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        // $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary left',)));


        return $form;
    }

    /**
     * Creates a form to edit a Catalogrecords entity.
     *
     * @param Catalogrecords $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDealerFeedsForm(Catalogrecords $entity)
    {
        $securityContext = $this->container->get('security.context');
        $catalogForm = new DealerFeedsType();
        $catalogForm->setSecurityContext($securityContext);
        $action = 'dms_catalogs_feeds_update';

        $form = $this->createForm($catalogForm, $entity, array(
            'action' => $this->generateUrl($action, array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        // $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary left',)));


        return $form;
    }

    /**
     * Edits an existing Catalogrecords entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);
        $oldDealersCategories = $entity->getDealerCategories();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogrecords entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $siteForm = $this->createDealerSiteForm($entity);
        $editForm->handleRequest($request);
        $itemDefaultForm = $this->createItemDefaultForm($entity);
        $feedsForm = $this->createDealerFeedsForm($entity);
        $billingForm = $this->createDealerBillingForm($entity);

        if ($editForm->isValid()) {
            if ($entity instanceof Catalogrecords) {
                if (!empty($oldDealersCategories)) {
                    foreach ($oldDealersCategories as $oldDC) {
                        $em->remove($oldDC);
                    }
                }

                $entity->upload();

                $rq = $request->get("numa_doaadminbundle_catalogrecords");
                $pass = $rq["password"];

                if (!empty($pass)) {
                    $factory = $this->container->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($entity);
                    $plainPassword = $entity->getPassword();
                    $encodedPassword = $encoder->encodePassword($plainPassword, $entity->getSalt());
                    $entity->setPassword($encodedPassword);
                }

                $em->flush();
                $this->container->get('mymemcache')->deleteDealerCache($entity);
                $this->addFlash("success", "Dealer: " . $entity->getName() . " successfully updated.");
                $securityContext = $this->container->get('security.context');
//                if ($securityContext->isGranted('ROLE_DEALER_ADMIN') || $securityContext->isGranted('ROLE_BUSINES') ) {
//                    return $this->redirect($this->generateUrl('catalogs_edit', array('id' => $id)));
//                }
                if ($securityContext->isGranted('ROLE_DEALER_ADMIN') || $securityContext->isGranted('ROLE_BUSINES')) {
                    return $this->redirect($this->generateUrl('dms_profile_edit', array('id' => $id)));
                } else {
                    $redirect = 'catalogs';
                    if (strtoupper($this->dashboard) == 'DMS') {
                        $redirect = 'dms_catalogs';
                    }
                    return $this->redirect($this->generateUrl($redirect, array('id' => $id)));
                }
            }
        } else {
            dump($editForm->getErrors(true));
        }
        return $this->render('NumaDOAAdminBundle:Catalogrecords:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'site_form' => $siteForm->createView(),
            'billing_form' => $billingForm->createView(),
            'feeds_form' => $feedsForm->createView(),
            'itemDefaultForm' => $itemDefaultForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'dashboard' => $this->dashboard,
        ));
    }

    /**
     * Edits an existing Dealers Coupons
     *
     */
    public function updateCouponsAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($id);
        $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);

        $siteForm = $this->createDealerSiteForm($entity);
        $editForm = $this->createEditForm($entity);
        $couponsForm = $this->createEditCouponsForm($entity);
        $couponsForm->handleRequest($request);

        if ($couponsForm->isValid()) {
            if ($entity instanceof Catalogrecords) {


                foreach ($entity->getCoupon() as $coupon) {
                    $coupon->upload();
                }
                $em->flush();
                $redirect = 'catalogs_edit';
                if (strtoupper($this->dashboard) == 'DMS') {
                    $redirect = 'dms_catalogs_edit';
                }
                return $this->redirect($this->generateUrl($redirect, array('id' => $id)));
            }
        } else {
            dump($couponsForm->getErrors(true));
        }

        return $this->render('NumaDOAAdminBundle:Catalogrecords:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'coupons_form' => $couponsForm->createView(),
            'site_form' => $siteForm->createView(),

        ));
    }

    /**
     * Edits an existing Dealers Site parameters
     *
     */
    public function updateSiteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($id);
        $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);

        $editForm = $this->createEditForm($entity);
        $siteForm = $this->createDealerSiteForm($entity);
        $siteForm->handleRequest($request);

        if ($siteForm->isValid()) {
            if ($entity instanceof Catalogrecords) {

                $em->flush();
                $redirect = 'dms_catalogs_edit';

                return $this->redirect($this->generateUrl($redirect, array('id' => $id)));
            }
        }

        return $this->render('NumaDOAAdminBundle:Catalogrecords:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'site_form' => $siteForm->createView(),

        ));
    }

    /**
     * Edits an existing Item Default parameters
     *
     */
    public function updateItemDefaultAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($id);
        $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);

        $editForm = $this->createEditForm($entity);
        $itemDefaultForm = $this->createItemDefaultForm($entity);
        $itemDefaultForm->handleRequest($request);

        if ($itemDefaultForm->isValid()) {
            if ($entity instanceof Catalogrecords) {

                $em->flush();
                $redirect = 'dms_catalogs_edit';

                return $this->redirect($this->generateUrl($redirect, array('id' => $id)));
            }
        }

        return $this->render('NumaDOAAdminBundle:Catalogrecords:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'itemDefaultForm' => $itemDefaultForm->createView(),

        ));
    }

    /**
     * Edits an existing Dealers Site parameters
     *
     */
    public function updateFeedsAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($id);
        $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);

        $editForm = $this->createEditForm($entity);
        $feedsFrom = $this->createDealerFeedsForm($entity);
        $feedsFrom->handleRequest($request);

        if ($feedsFrom->isValid()) {
            if ($entity instanceof Catalogrecords) {

                $em->flush();
                $redirect = 'dms_catalogs_edit';

                return $this->redirect($this->generateUrl($redirect, array('id' => $id)));
            }
        }

        return $this->render('NumaDOAAdminBundle:Catalogrecords:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'feeds_form' => $feedsFrom->createView(),

        ));
    }

    /**
     * Edits an existing Dealers Billing parameters
     *
     */
    public function updateBillingAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($id);
        $entity = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);

        $editForm = $this->createEditForm($entity);
        $billingForm = $this->createDealerBillingForm($entity);
        $billingForm->handleRequest($request);

        if ($billingForm->isValid()) {
            if ($entity instanceof Catalogrecords) {

                $em->flush();
                $redirect = 'dms_catalogs_edit';

                return $this->redirect($this->generateUrl($redirect, array('id' => $id)));
            }
        }

        return $this->render('NumaDOAAdminBundle:Catalogrecords:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'billing_form' => $billingForm->createView(),

        ));
    }


    /**
     * Deletes a Catalogrecords entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted(array('ROLE_ADMIN', 'ROLE_DEALER_ADMIN'), null, 'Access Denied!');

        $em = $this->getDoctrine()->getManager();
        $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->removeDealer($id);


        $redirect = 'catalogs';
        if (strtoupper($this->dashboard) == 'DMS') {
            $redirect = 'dms_catalogs';
        }
        return $this->redirect($this->generateUrl($redirect));
    }

    /**
     * Creates a form to delete a Catalogrecords entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {

        $redirect = 'catalogs_delete';
        if (strtoupper($this->dashboard) == 'DMS') {
            $redirect = 'dms_catalogs_delete';
        }
        return $this->createFormBuilder()
            ->setAction($this->generateUrl($redirect, array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-danger left',)))
            ->getForm();
    }

    public function proccessImportCSVAction(Request $request)
    {
        // Check if we are posting stuff
        $uploadForm = $this->createImportCSVForm();
        $uploadForm->handleRequest($request);

        if ($uploadForm->isValid()) {
            // If form is valid
            // Get file
            $file = $request->files->get('form');
            $fileUpload = $file['upload'];
            $res = array();
            if ($fileUpload->getMimeType() == 'text/plain' &&
                (strtolower(($fileUpload->guessExtension()) == 'csv' || strtolower($fileUpload->guessExtension()) == 'txt'))
            ) {
                $file = $fileUpload->move($this->container->getParameter('upload_feed'), $fileUpload->getClientOriginalName());

                if (($handle = fopen($file->getRealPath(), "r")) !== FALSE) {
                    $rowCount = 0;

                    while (($row = fgetcsv($handle)) !== FALSE) {
                        //var_dump($row); // process the row.
                        if ($rowCount > 0) {
                            foreach ($header as $key => $value) {
                                $tmp[$value] = $row[$key];
                            }
                            $res[] = $tmp;
                        } else {
                            $header = $row;
                        }
                        $rowCount++;
                    }
                }
            } else {

            }

            $em = $this->getDoctrine()->getManager();
            $updated = 0;
            $new = 0;
            foreach ($res as $key => $row) {
                $fields = Catalogrecords::$maping;
                $newDealer = new Catalogrecords();
                foreach ($fields as $key => $fieldDB) {
                    $fn = 'set' . $fieldDB;
                    //var_dump($fn);
                    if (is_callable(array($newDealer, $fn)) && !empty($row[$key])) {
                        $newDealer->$fn($row[$key]);
                    }
                }
                if ($newDealer->getEmail()) {
                    $existing = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findOneBy(array('email' => $newDealer->getEmail()));
                    if (!empty($existing)) {
                        $existing = $newDealer;
                        $updated++;
                    } else {
                        $new++;
                        $em->persist($newDealer);
                    }
                } else {
                    return $this->redirectToRoute('catalogs');
                }
            }

            $em->flush();


        }
        $this->addFlash('success', 'CSV imported: ' . $updated . ' :updated   ' . $new . ' :new');
        return $this->redirectToRoute('catalogs');
    }

    /**
     * Activates the dealer and creates pages for him
     * @param $id Dealer id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activateDealerAction($id)
    {
        $em = $this->container->get("doctrine.orm.entity_manager");
        $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($id);

        if (!empty($dealer)) {
            $dealer->setDmsStatus("activated");
            $em->flush();
        }

        //generate all the pages
        $this->container->get("Numa.DMSUtils")->generatePagesForDealer($id);

        return $this->redirect($this->generateUrl('dms_catalogs'));

    }

    
}
