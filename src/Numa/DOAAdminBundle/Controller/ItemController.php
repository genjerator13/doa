<?php

namespace Numa\DOAAdminBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Numa\DOAAdminBundle\Entity\Listingfield;
use Numa\DOADMSBundle\Entity\Vendor;
use Numa\DOADMSBundle\Lib\DashboardDMSControllerInterface;
use Numa\DOAModuleBundle\Entity\Seo;
use Numa\DOADMSBundle\Entity\Sale;
use Numa\DOAModuleBundle\Form\SeoType;
use Numa\DOADMSBundle\Form\SaleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\ItemField;
use Numa\DOAAdminBundle\Form\ItemType;
use Symfony\Component\Yaml\Parser;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ArrayColumn;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use Doctrine\Common\Collections\Criteria;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;

/**
 * Item controller.
 *
 */
class ItemController extends Controller implements DashboardDMSControllerInterface, DealerSiteControllerInterface
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


//    /**
//     * Lists all User entities.
//     *
//     */
//    public function indexAction()
//    {
//        //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Access Denied!');
//
//        $em = $this->getDoctrine()->getManager();
//        $source = new Entity('NumaDOAAdminBundle:Item');
//
//        $source->manipulateRow(
//            function ($row) {
//
//                if ($row->getField('active') && $row->getField('featured')) {
//                    $row->setClass('featured');
//                }
//                return $row;
//            }
//        );
//
//        $grid = $this->get('grid');
//
//        //$grid->setDefaultOrderOrder("date_created", "desc");
//        $grid->setLimits(array(10, 20, 50));
//        $imageColumn = new BlankColumn();
//        $imageColumn->setTitle("Image");
//        $grid->addColumn($imageColumn, 1);
//        //$tableAlias = $source->getTableAlias();
//        $grid->setSource($source);
//
//        //main column
//
//        $controller = $this;
//        $imageColumn->manipulateRenderCell(
//            function ($value, $row, $router) use ($controller) {
//                $em = $controller->getDoctrine()->getManager();
//                $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($row->getField('id'));
//
//
//                $image = $item->getImage2();
//
//                echo $controller->renderView("NumaDOAAdminBundle:Item:imageCell.html.twig", array('image' => $image, 'id' => $row->getField('id')));
//                echo $controller->renderView("NumaDOAAdminBundle:Item:imageCell.html.twig", array('image' => $image, 'id' => $row->getField('id')));
//            }
//        );
//
//        $yourMassAction = new MassAction('Delete', 'NumaDOAAdminBundle:Item:massDelete');
//        $grid->addMassAction($yourMassAction);
//        $yourMassAction = new MassAction('Activate', 'NumaDOAAdminBundle:Item:massActivate');
//        $grid->addMassAction($yourMassAction);
//        $yourMassAction = new MassAction('Deactivate', 'NumaDOAAdminBundle:Item:massDeactivate');
//        $grid->addMassAction($yourMassAction);
//        $yourMassAction = new MassAction('Approve', 'NumaDOAAdminBundle:Item:massApprove');
//        $grid->addMassAction($yourMassAction);
//        $yourMassAction = new MassAction('Make Featured', 'NumaDOAAdminBundle:Item:massFeature');
//        $grid->addMassAction($yourMassAction);
//        $yourMassAction = new MassAction('Reject', 'NumaDOAAdminBundle:Item:massReject');
//        $grid->addMassAction($yourMassAction);
//        $yourMassAction = new MassAction('Assign Package', 'Numa\DOAAdminBundle\Controller\ItemController::additemAction');
//        $grid->addMassAction($yourMassAction);
//
//        return $grid->getGridResponse('NumaDOAAdminBundle:Item:indexGrid.html.twig');
//
//    }

    public function massActivateAction($primaryKeys, $allPrimaryKeys)
    {
        $em = $this->getDoctrine()->getManager();
        foreach ($primaryKeys as $id) {
            $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

            if ($entity) {
                $entity->setActive(true);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('items'));
    }

    public function massDeactivateAction($primaryKeys, $allPrimaryKeys)
    {
        $em = $this->getDoctrine()->getManager();
        foreach ($primaryKeys as $id) {
            $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

            if ($entity) {
                $entity->setActive(false);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('items'));
    }

    public function massApproveAction($primaryKeys, $allPrimaryKeys)
    {
        $em = $this->getDoctrine()->getManager();
        foreach ($primaryKeys as $id) {
            $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

            if ($entity) {
                $entity->setModerationStatus(1);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('items'));
    }

    public function massFeatureAction($primaryKeys, $allPrimaryKeys)
    {
        $em = $this->getDoctrine()->getManager();
        foreach ($primaryKeys as $id) {
            $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

            if ($entity) {
                $entity->setActive(1);
                $entity->setFeatured(1);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('items'));
    }

    public function massRejectAction($primaryKeys, $allPrimaryKeys)
    {
        $em = $this->getDoctrine()->getManager();
        foreach ($primaryKeys as $id) {
            $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

            if ($entity) {
                $entity->setModerationStatus(0);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('items'));
    }

    public function massDeleteAction($primaryKeys, $allPrimaryKeys)
    {
        $em = $this->getDoctrine()->getManager();
        foreach ($primaryKeys as $id) {
            $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

            if ($entity) {
                $em->remove($entity);
                $em->flush();
            }
        }
        return $this->redirect($this->generateUrl('items'));
    }

    /**
     * Lists all Item entities.
     *
     */
    public function additemAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dashboard = $request->get('_dashboard');
        $entities = $em->getRepository('NumaDOAAdminBundle:Category')->findAll();

        return $this->render('NumaDOAAdminBundle:Item:additem.html.twig', array(
            'entities' => $entities,
            'dashboard' => $dashboard,
        ));
    }

    /**
     * Creates a new Item entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Item();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $command = new \Numa\DOAAdminBundle\Command\DBUtilsCommand();
            $command->setContainer($this->container);
            $resultCode = $command->makeHomeTabs(false);

            return $this->redirect($this->generateUrl('items_show', array('id' => $entity->getId())));
        }

        return $this->render('NumaDOAAdminBundle:Item:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Item entity.
     *
     * @param Item $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Item $entity)
    {
        $form = $this->createForm(new ItemType(null, null, null, null, $this->container), $entity, array(
            'action' => $this->generateUrl('items_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Item entity.
     *
     */
    public function newAction(Request $request, $cat_id, $item_id = null)
    {
        $entity = new Item();
        $dashboard = $request->get('_dashboard');
        $em = $this->getDoctrine()->getManager();
        //get category by request parameter
        $category = $em->getRepository('NumaDOAAdminBundle:Category')->findOneById($cat_id);
        //get edited item
        if ($item_id != null) {
            $item = $em->getRepository('NumaDOAAdminBundle:Item'); //->findOneById(1347);
            $entity = $em->getRepository('NumaDOAAdminBundle:Item')->findOneById($item_id);
        }

        $fields = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findBy(array('category_sid' => array(0, $cat_id)));

        if (!empty($fields)) {
            foreach ($fields as $key => $field) {
                //dump($field);
                $itemField = new ItemField();
                //check if item field has value for the listing_field if edit (exists)

                if ($item_id != null) {
                    $qb = $item->createQueryBuilder('i')
                        ->select('if.field_integer_value,if.field_string_value,if.field_boolean_value,if.field_name,ls.id as field_id')
                        ->where('i.id = :iid')
                        ->join('i.ItemField', 'if')
                        ->join('if.Listingfield', 'ls')
                        ->andWhere('ls.id = :lsid')
                        ->setParameter('iid', $item_id)
                        ->setParameter('lsid', $field->getId());
                    $query = $qb->getQuery();

                    $listingField = $query->setMaxResults(1)->getOneOrNullResult();

                    if (!empty($listingField)) {
                        $itemField->setFieldStringValue($listingField['field_string_value']);
                        $itemField->setFieldIntegerValue($listingField['field_integer_value']);
                        $itemField->setFieldBooleanValue($listingField['field_boolean_value']);
                    }
                }
                $itemField->setListingfield($field);
                $itemField->setFieldName($field->getCaption());
                $itemField->setFieldType($field->getType());

                if (strtolower($field->getCaption()) != 'image list') {
                    $entity->addItemField($itemField);
                }


            }

            //remove all existing item fields TO DO add this to ItemField repository            
            $oldItemFields = $em->getRepository('NumaDOAAdminBundle:ItemField')->findBy(array('item_id' => $item_id, 'field_type' => 'boolean'));
            foreach ($oldItemFields as $oldone) {
                $em->remove($oldone);
            }

            $em->flush();
        }
        
        $entity->setCategory($category);

        $entity->sortItemFieldsBy();

        $securityContext = $this->container->get('security.context');

        $form = $this->createForm(new ItemType($this->getDoctrine()->getManager(), $securityContext, $this->get('Numa.Dms.User')->getSignedDealer(), $category), $entity, array(
            'method' => 'POST',
        ));

        $seo = $em->getRepository('NumaDOAModuleBundle:Seo')->findOneBy(array('table_name' => 'item', 'table_id' => $entity->getId()));

        if (empty($seo)) {
            $seo = new Seo();
        }
        $entity->setSeo($seo);
        $seoForm = $this->createForm(new SeoType(), $seo, array(
            'method' => 'POST',
        ));
        $seoFormView = $seoForm->createView();


        $form->handleRequest($request);

        if ($form->isValid()) {

            if (!empty($entity->getVIN()) && !$this->isGranted('ROLE_NODMS_USER')) {
                $decodedvin = $this->get("numa.dms.listing")->vindecoder($entity);
                $entity->setVindecoder($decodedvin);
                $this->get("numa.dms.listing")->insertFromVinDecoder($entity);
            }

            $em->persist($entity);
            $command = new \Numa\DOAAdminBundle\Command\DBUtilsCommand();
            $command->setContainer($this->container);
            $resultCode = $command->makeHomeTabs(false);


            $em->flush();
            // to QB
            $suffix='.';
            $qb = $this->isSeccesfullyUpdatedToQB($entity);
            if ($qb){
                $suffix  =" and it has been posted to Quickbooks.";
            }
            $this->addFlash("success", "Listing: #" . $entity->getId() . " successfully inserted".$suffix);

            if ($request->get("redirect") == "images") {
                $redirect = 'item_images';
                if (strtoupper($this->dashboard) == 'DMS') {
                    $redirect = 'dms_item_images';
                }
                return $this->redirect($this->generateUrl($redirect, array('id' => $entity->getId())));
            } else {
                $redirect = 'items_edit';
                if (strtoupper($this->dashboard) == 'DMS') {
                    $redirect = 'dms_items_edit';
                }
                return $this->redirect($this->generateUrl($redirect, array('id' => $entity->getId())));
            }
        }
        //sale form

        $entity->setSeo($seo);
        $dealer =  $this->get('Numa.Dms.User')->getSignedDealer();
        $entity->setDealer($dealer);

        $qbo = $this->get("numa.quickbooks")->init();
        $params = array(
            'entity' => $entity,
            'form' => $form->createView(),
            'category' => $category,
            'seo' => $seoFormView,
            'dashboard' => $dashboard,
            'qbo'=>$qbo
        );
        return $this->switchTemplateByCategory($cat_id, $params);
    }

    private function switchTemplateByCategory($cat_id, $params)
    {

        return $this->render('NumaDOAAdminBundle:Item:new.html.twig', $params);
    }

    /**
     * Finds and displays a Item entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Item:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Item entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $dashboard = $request->get('_dashboard');
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);
        if (!$entity instanceof Item) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $feed = $entity->getImportFeed();

        if (!empty($feed)) {
            $category = $feed->getListingType(); //use category entered in feed
        }

        $catRequest = $request->request->get("numa_doaadminbundle_item");
        if (!empty($catRequest['Category'])) {
            $category = $catRequest['Category'];
        } elseif ($entity->getCategory() instanceof \Numa\DOAAdminBundle\Entity\Category) {

            $category = $entity->getCategoryId();
        }
        //get category by request parameter
        $categoryEntity = $em->getRepository('NumaDOAAdminBundle:Category')->findOneById($category);


        $entity->setCategory($categoryEntity);

        $securityContext = $this->container->get('security.context');

        $fields = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findAllByType('boolean', array(0, $categoryEntity->getId()));
        if (!empty($fields)) {
            //lop trough all the listing fields
            foreach ($fields as $key => $field) {
                if ($field instanceof Listingfield) {
                }

                //check if item field has value for the listing_field if edit (exists)

                if ($id != null) {

                    $qb = $em->getRepository('NumaDOAAdminBundle:ItemField')->createQueryBuilder('if')
                        ->select('if')
                        ->where('if.item_id = :iid')
                        ->andWhere('if.field_id = :lsid')
                        ->setParameter('iid', $id)
                        ->setParameter('lsid', $field->getId());
                    $query = $qb->getQuery();

                    $itemField = $query->setMaxResults(1)->getOneOrNullResult();

                    if (!$itemField instanceof ItemField) {
                        $itemField = new ItemField();
                    }
                } else {
                    $itemField = new ItemField();
                }

                $itemField->setListingfield($field);
                $itemField->setFieldName($field->getCaption());
                $itemField->setFieldType($field->getType());
                $itemField->setFieldId($field->getId());
                $itemField->setListingfield($field);
                $itemField->setFeedId($entity->getFeedId());

                if (strtolower($field->getCaption()) != 'image list') {
                    //check if the listing field is already there
                    $itemFieldAlreadySet = new ArrayCollection();
                    if ($itemField instanceof ItemField) {
                        //dump($itemField->getFieldId());
                        $criteria = Criteria::create()
                            ->where(Criteria::expr()->eq("fieldId", $itemField->getFieldId()))
                            ->orWhere(Criteria::expr()->eq("fieldName", $itemField->getFieldName()))
                            ->setFirstResult(0)
                            ->setMaxResults(1);
                        $itemFieldAlreadySet = $entity->getItemField()->matching($criteria);
                    }

                    if ($itemFieldAlreadySet->isEmpty() || empty($itemField)) {
                        $entity->addItemField($itemField);
                    }
                }

            }
        }
        $entity->sortItemFieldsBy();

        //seo
        if (!empty($entity->getId())) {
            $seo = $em->getRepository('NumaDOAModuleBundle:Seo')->findOneBy(array('table_name' => 'item', 'table_id' => $entity->getId()));
            if (empty($seo)) {
                $seo = new Seo();
            }

            $entity->setSeo($seo);

            $seoForm = $this->createForm(new SeoType(), $seo, array(
                'method' => 'POST',
            ));
            $seoFormView = $seoForm->createView();
        }

        $form = $this->createForm(new ItemType($this->getDoctrine()->getManager(), $securityContext, $this->getUser()), $entity, array(
            'method' => 'POST',
            'allow_extra_fields' => true
        ));

        $saleForm = $this->createForm(new SaleType(), $entity->getSale(), array(
            'method' => 'POST',
        ));
        $oldVin = $entity->getVIN();


        $form->handleRequest($request);

        if ($form->isValid()) {



            $sale = $entity->getSale();
            $sale->setItem($entity);

            if (!empty($entity->getVIN()) && $oldVin != $entity->getVIN() && !$this->isGranted("ROLE_NODMS_USER")) {
                $decodedvin = $this->get("numa.dms.listing")->vindecoder($entity);

                $entity->setVindecoder($decodedvin);
                $this->get("numa.dms.listing")->insertFromVinDecoder($entity);
            }

            if (empty($id)) {

                $em->persist($entity);
            }

            $seoPost = $request->get("numa_doamodulebundle_seo");
            $seoService = $this->container->get("Numa.Seo");

            $seo = $seoService->prepareSeo($entity, $seoPost);
            $suffix = ".";

            $em->flush();

            // to QB
            $item=$em->getRepository(Item::class)->find($entity->getId());
            $qb = $this->isSeccesfullyUpdatedToQB($item);

            if ($qb){
                $suffix  =" and it has been posted to Quickbooks.";
            }

            $sale = $item->getSale();
            
            if($item->getQbPostInclude() && $sale instanceof Sale && $sale->getVendor() instanceof Vendor) {

                $okInsertPO = $this->get("numa.dms.quickbooks.purchase.order")->insertItemPO($entity);
                $okInsertBills =$this->get("numa.dms.quickbooks.bill")->insertItemBills($entity);

            }
            $this->addFlash("success", "Listing: #" . $entity->getId() . " successfully updated".$suffix);

            if ($form->getClickedButton() != null && $form->getClickedButton()->getName() == "submitAndPrint") {
                return $this->redirect($this->generateUrl('sale_print_inside', array('id' => $entity->getId())));
            }
            $redirect = 'items_edit';
            if (strtoupper($this->dashboard) == 'DMS') {
                $redirect = 'dms_items_edit';
            }
            return $this->redirectToRoute($redirect, array("id" => $entity->getId()));
        }

        $qbo = $this->get("numa.quickbooks")->init();
        $params = array(
            'entity' => $entity,
            'form' => $form->createView(),
            'category' => $entity->getCategory(),
            'seo' => $seoFormView,
            'dashboard' => $this->dashboard,
            'qbo'=>$qbo
        );

        return $this->switchTemplateByCategory($category, $params);


    }

    /**
     * Creates a form to edit a Item entity.
     *
     * @param Item $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Item $entity)
    {
        $form = $this->createForm(new ItemType(null, null, null, null, $this->container), $entity, array(
            'action' => $this->generateUrl('items_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Item entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            //update hometabs
            $command = new \Numa\DOAAdminBundle\Command\DBUtilsCommand();
            $command->setContainer($this->container);
            $resultCode = $command->makeHomeTabs(false);

            $redirect = 'items_edit';
            if (strtoupper($this->dashboard) == 'DMS') {
                $redirect = 'dms_items_edit';
            }
            return $this->redirect($this->generateUrl($redirect, array('id' => $id)));
        }

        return $this->render('NumaDOAAdminBundle:Item:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'dashboard' => $dashboard,
        ));
    }

    /**
     * Deletes a Item entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_BUSINES') || $securityContext->isGranted('ROLE_ADMIN') || $securityContext->isGranted('ROLE_SUPER_ADMIN')) {
            if ($securityContext->isGranted('ROLE_BUSINES') && $entity->getDealer()->getId() != $this->getUser()->getId() && !$securityContext->isGranted('ROLE_DEALER_ADMIN')) {
                throw $this->createAccessDeniedException('You cannot delete this listing!');
            }
        }
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $em->remove($entity);
        $em->flush();
        //}
        if ($securityContext->isGranted('ROLE_BUSINES')) {
            $referer = $request->headers->get('referer');

            return $this->redirect($referer);
        }
        return $this->redirect($this->generateUrl('items'));
    }

    /**
     * Activate a Item entity.
     *
     */
    public function activateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $activation = $request->get('active');
        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);
        $securityContext = $this->container->get('security.authorization_checker');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        //if business login and dealer listing
        $return = $this->redirect($this->generateUrl('items', array('id' => $id)));
        if ($securityContext->isGranted('ROLE_BUSINES')) {

            if (!$securityContext->isGranted('ROLE_DEALER_ADMIN') && ($entity->getDealer() instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords &&
                    $entity->getDealer()->getId() != $this->getUser()->getId())
            ) {

                throw $this->createAccessDeniedException('You cannot access this page!');
            } else {

                $url = $this->getRequest()->headers->get("referer");
                $return = $this->redirect($url);
            }
        }
        $redirect = $request->query->get('redirect');
        if ($redirect == 'item') {
            $return = $this->redirectToRoute('items_edit', array('id' => $id));
        }


        $entity->setActive(1);
        $entity->setActivationDate(new \DateTime());
        $em->flush();
        return $return;
    }

    /**
     * @param Request $request
     * Activates elected listings in datagrid on listing list page
     */
    public function massActivate2Action(Request $request)
    {
        $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository("NumaDOAAdminBundle:Item")->activate($ids, true);
        die();
    }

    /**
     * @param Request $request
     * Deactivates elected listings in datagrid on listing list page
     */
    public function massDeactivate2Action(Request $request)
    {

        $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository("NumaDOAAdminBundle:Item")->activate($ids, 0);
        die();
    }

    /**
     * @param Request $request
     * Activates elected listings in datagrid on listing list page
     */
    public function massMakeFeatured2Action(Request $request)
    {
        $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository("NumaDOAAdminBundle:Item")->makeFeatured($ids, true);
        die();
    }

    /**
     * @param Request $request
     * Activates elected listings in datagrid on listing list page
     */
    public function kijijiAddAction(Request $request)
    {
        $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository("NumaDOAAdminBundle:Item")->includeKijiji($ids, true);
        die();
    }

    /**
     * @param Request $request
     * Activates elected listings in datagrid on listing list page
     */
    public function kijijiRemoveAction(Request $request)
    {
        $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository("NumaDOAAdminBundle:Item")->includeKijiji($ids, 0);
        die();
    }

    /**
     * @param Request $request
     * Kijiji selected listings in datagrid on listing list page
     */
    public function massMakeKijijiAction(Request $request)
    {
        $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);
        $this->get('listing_api')->prepareKijijiFromIds($ids);
        die();
    }

    /**
     * @param Request $request
     * Add selected listings in datagrid on listing list page
     */
    public function massAddToQBAction(Request $request)
    {
        $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);
        $this->get('numa.dms.quickbooks.item')->addItemToQB($ids);
        die();
    }

    /**
     * @param Request $request
     * Add selected listings in datagrid on listing list page
     */
    public function massAddToQBPOAction(Request $request)
    {
        $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);
        $this->get('numa.dms.quickbooks.purchase.order')->addToQBPO($ids);
        die();
    }

    /**
     * @param Request $request
     * Deactivates elected listings in datagrid on listing list page
     */
    public function massDelete2Action(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_ADMIN')) {
            $this->container->get('mymemcache')->delete('featured_' . $this->dealer);
            $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);
            $this->get("Numa.Dms.Listing")->deleteItems($ids);
        }
        die();
    }

    /**
     * @param Request $request
     * Activates elected listings in datagrid on listing list page
     */
    public function massRecoverAction(Request $request)
    {
        $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository("NumaDOAAdminBundle:Item")->recover($ids);
        die();
    }

    /**
     * deactivate an Item entity.
     *
     */
    public function deactivateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }
        //if business login and dealer listing
        $return = $this->redirect($this->generateUrl('items', array('id' => $id)));
        if ($securityContext->isGranted('ROLE_BUSINES')) {

            if (!$securityContext->isGranted('ROLE_DEALER_ADMIN') && $entity->getDealer() instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords &&
                $entity->getDealer()->getId() != $this->getUser()->getId()
            ) {
                throw $this->createAccessDeniedException('You cannot access this page!');
            } else {

                $url = $this->getRequest()->headers->get("referer");
                $return = $this->redirect($url);
            }
        }
        $this->container->get('mymemcache')->delete('featured_' . $this->dealer);

        $redirect = $request->query->get('redirect');
        if ($redirect == 'item') {
            $return = $this->redirectToRoute('items_edit', array('id' => $id));
        }
        $entity->setActive(0);

        $em->flush();

        return $return;
    }

    /**
     * reject a Item entity.
     *
     */
    public function rejectAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $entity->setModerationStatus(0);

        $em->flush();

        return $this->redirect($this->generateUrl('items', array('id' => $id)));
    }

    /**
     * approve a Item entity.
     *
     */
    public function approveAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $entity->setModerationStatus(1);

        $em->flush();

        return $this->redirect($this->generateUrl('items', array('id' => $id)));
    }

    /**
     * Creates a form to delete a Item entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('items_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    public function changeCategoryAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $securityContext = $this->container->get('security.context');

        $form = $this->createForm(new ItemType($em, $securityContext, $this->getUser()), $entity, array(
            'method' => 'POST',
        ));

        $form->handleRequest($request);


        $em->flush();
        $redirect = 'items_edit';
        if (strtoupper($this->dashboard) == 'DMS') {
            $redirect = 'dms_items_edit';
        }
        return $this->redirect($this->generateUrl($redirect, array('id' => $id)));
        //}
    }

    private function isSeccesfullyUpdatedToQB(Item $item){
        if($item->getQbPostInclude() ){
            $qbItem = $this->get('numa.dms.quickbooks.item')->insertVehicleItem($item);
            if($qbItem instanceof \QuickBooks_IPP_Object_Item){
                return true;
            }
        }
        return false;
    }
}
