<?php

namespace Numa\DOAAdminBundle\Controller;

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

/**
 * Item controller.
 *
 */
class ItemController extends Controller {

    public function index2Action() {
        $source = new Entity('NumaDOAAdminBundle:Item');

        $grid = $this->get('grid');
        //$tableAlias = $source->getTableAlias();
        $grid->setSource($source);

        //main column
        $maincolumn = new BlankColumn();
        $grid->addColumn($maincolumn);
        $controller = $this;
        $maincolumn->manipulateRenderCell(
                function($value, $row, $router) use ($controller) {
            $res = array();

            $id = $row->getField('id');
            $em = $controller->getDoctrine()->getManager();

            $fields = $em->getRepository('NumaDOAAdminBundle:ItemField')->findBy(array('item_id' => $id));

            $res['id'] = $id;
            $res['category'] = $row->getField('Category.name');
            if (empty($res['category'])) {
                
            }
            $res['username'] = $row->getField('User.username');
            $res['dealer'] = $row->getField('Dealer.name');
            $res['active'] = $row->getField('active');
            $res['moderation_status'] = $row->getField('moderation_status');
            $res['views'] = $row->getField('views');
            $res['activation_date'] = $row->getField('activation_date');
            // $res['date_created'] = $row->getField('date_created');

            foreach ($fields as $field) {
                if (strtolower($field->getFieldType()) == 'array') {
                    $res[$field->getFieldName()][] = $field->getFieldStringValue();
                } else {
                    $res[$field->getFieldName()] = $field->getFieldStringValue();
                }
            }

            if (empty($res['Image List'])) {
                $res['Image List'] = "";
            }
            if (empty($res['Year'])) {
                $res['Year'] = "";
            }

            if (empty($res['Make'])) {
                $res['Make'] = "";
            }

            if (empty($res['activation_date'])) {
                $res['activation_date'] = " ";
            } else {
                $res['activation_date'] = $res['activation_date']->format('Y-m-d');
            }


            echo $controller->renderView("NumaDOAAdminBundle:Item:itemDetailsGrid.html.twig", array("details" => $res));
        }
        );

        //actions in row and mass actions
        //$grid->addRowAction(new RowAction('Show', 'items'));
        $yourMassAction = new MassAction('Delete', 'NumaDOAAdminBundle:Item:massDelete');
        $grid->addMassAction($yourMassAction);
        $yourMassAction = new MassAction('Activate', 'NumaDOAAdminBundle:Item:massActivate');
        $grid->addMassAction($yourMassAction);
        $yourMassAction = new MassAction('Deactivate', 'NumaDOAAdminBundle:Item:massDeactivate');
        $grid->addMassAction($yourMassAction);
        $yourMassAction = new MassAction('Approve', 'NumaDOAAdminBundle:Item:massApprove');
        $grid->addMassAction($yourMassAction);
        $yourMassAction = new MassAction('Reject', 'NumaDOAAdminBundle:Item:massReject');
        $grid->addMassAction($yourMassAction);
        $yourMassAction = new MassAction('Assign Package', 'Numa\DOAAdminBundle\Controller\ItemController::additemAction');
        $grid->addMassAction($yourMassAction);

        //$grid->isTitleSectionVisible = false;
        //hide certain columns
        //$grid->hideColumns('id');
        //$grid->hideColumns('Category.name');
        //$grid->hideColumns('User.UserGroup.name');
        //$grid->hideColumns('User.username');
        //$grid->hideColumns('active');
        //$grid->hideColumns('moderation_status');
        //$grid->hideColumns('views');
        //$grid->hideColumns('activation_date');

        return $grid->getGridResponse('NumaDOAAdminBundle:Item:index.html.twig');
    }

    /**
     * Lists all User entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $source = new Entity('NumaDOAAdminBundle:Item');

        $grid = $this->get('grid');
        $grid->setLimits(array(10, 20, 50));
        $imageColumn = new BlankColumn();
        $imageColumn->setTitle("Image");
        $grid->addColumn($imageColumn, 1);
        //$tableAlias = $source->getTableAlias();
        $grid->setSource($source);
        $entities = $em->getRepository('NumaDOAAdminBundle:Item')->findAll();
        //main column

        $controller = $this;
        $imageColumn->manipulateRenderCell(
                function($value, $row, $router) use ($controller) {
            $em = $controller->getDoctrine()->getManager();
            $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($row->getField('id'));


            $image = $item->getImage();

            echo $controller->renderView("NumaDOAAdminBundle:Item:imageCell.html.twig", array('image' => $image, 'id' => $row->getField('id')));
        }
        );
        $yourMassAction = new MassAction('Delete', 'NumaDOAAdminBundle:Item:massDelete');
        $grid->addMassAction($yourMassAction);
        $yourMassAction = new MassAction('Activate', 'NumaDOAAdminBundle:Item:massActivate');
        $grid->addMassAction($yourMassAction);
        $yourMassAction = new MassAction('Deactivate', 'NumaDOAAdminBundle:Item:massDeactivate');
        $grid->addMassAction($yourMassAction);
        $yourMassAction = new MassAction('Approve', 'NumaDOAAdminBundle:Item:massApprove');
        $grid->addMassAction($yourMassAction);
        $yourMassAction = new MassAction('Reject', 'NumaDOAAdminBundle:Item:massReject');
        $grid->addMassAction($yourMassAction);
        $yourMassAction = new MassAction('Assign Package', 'Numa\DOAAdminBundle\Controller\ItemController::additemAction');
        $grid->addMassAction($yourMassAction);
        return $grid->getGridResponse('NumaDOAAdminBundle:Item:indexGrid.html.twig');
    }

    public function massActivateAction($primaryKeys, $allPrimaryKeys) {
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

    public function massDeactivateAction($primaryKeys, $allPrimaryKeys) {
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

    public function massApproveAction($primaryKeys, $allPrimaryKeys) {
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

    public function massRejectAction($primaryKeys, $allPrimaryKeys) {
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

    public function massDeleteAction($primaryKeys, $allPrimaryKeys) {
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
    public function additemAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOAAdminBundle:Category')->findAll();

        return $this->render('NumaDOAAdminBundle:Item:additem.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Item entity.
     *
     */
    public function createAction(Request $request) {
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
            dump($resultCode);die();
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
    private function createCreateForm(Item $entity) {
        $form = $this->createForm(new ItemType(), $entity, array(
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
    public function newAction(Request $request, $cat_id, $item_id = null) {

        $entity = new Item();
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

                    $listingField = $qb->getQuery()->setMaxResults(1)->getOneOrNullResult();

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
            //die();
            //remove all existing item fields TO DO add this to ItemField repository            
            $oldItemFields = $em->getRepository('NumaDOAAdminBundle:ItemField')->findBy(array('item_id' => $item_id, 'field_type' => 'boolean'));
            //dump($oldItemFields);die();
            foreach ($oldItemFields as $oldone) {
                $em->remove($oldone);
            }
            $em->flush();
        }
        $entity->setCategory($category);

        $securityContext = $this->container->get('security.context');
        $form = $this->createForm(new ItemType($this->getDoctrine()->getEntityManager(), $securityContext, $this->getUser(), $category), $entity, array(
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
                        $command = new \Numa\DOAAdminBundle\Command\DBUtilsCommand();
            $command->setContainer($this->container);
            $resultCode = $command->makeHomeTabs(false);
            $em->flush();
            //dump($request->get("redirect"));die();
            if ($request->get("redirect") == "images") {
                return $this->redirect($this->generateUrl('item_images', array('id' => $entity->getId())));
            }
            return $this->redirect($this->generateUrl('items_edit', array('id' => $entity->getId())));
        }

        return $this->switchTemplateByCategory($cat_id, $entity, $form, $category);
    }

    private function switchTemplateByCategory($cat_id, $entity, $form, $category) {

        return $this->render('NumaDOAAdminBundle:Item:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'category' => $category,
        ));
    }

    /**
     * Finds and displays a Item entity.
     *
     */
    public function showAction($id) {
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
    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

        if (!$entity) {
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
        $form = $this->createForm(new ItemType($this->getDoctrine()->getEntityManager(), $securityContext, $this->getUser()), $entity, array(
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            //refresh tabs
            $command = new \Numa\DOAAdminBundle\Command\DBUtilsCommand();
            $command->setContainer($this->container);
            $resultCode = $command->makeHomeTabs(false);

            $em->flush();
        }
        return $this->switchTemplateByCategory($category, $entity, $form, $entity->getCategory());
    }

    /**
     * Creates a form to edit a Item entity.
     *
     * @param Item $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Item $entity) {
        $form = $this->createForm(new ItemType(), $entity, array(
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
    public function updateAction(Request $request, $id) {
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
            dump($resultCode);die();
            return $this->redirect($this->generateUrl('items_edit', array('id' => $id)));
        }

        return $this->render('NumaDOAAdminBundle:Item:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Item entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $em->remove($entity);
        $em->flush();
        //}

        return $this->redirect($this->generateUrl('items'));
    }

    /**
     * Activate a Item entity.
     *
     */
    public function activateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $activation = $request->get('active');
        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);
        $securityContext = $this->container->get('security.context');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        //if business login and dealer listing
        $return = $this->redirect($this->generateUrl('items', array('id' => $id)));
        if ($securityContext->isGranted('ROLE_BUSINES')) {

            if ($entity->getDealer() instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords &&
                    $entity->getDealer()->getId() != $this->getUser()->getId()) {
                throw $this->createAccessDeniedException('You cannot access this page!');
            } else {

                $url = $this->getRequest()->headers->get("referer");
                $return = $this->redirect($url);
            }
        }


        $entity->setActive(1);
        $entity->setActivationDate(new \DateTime());
        $em->flush();
        return $return;
    }

    /**
     * deactivate a Item entity.
     *
     */
    public function deactivateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);
        $securityContext = $this->container->get('security.context');
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }
        //if business login and dealer listing
        $return = $this->redirect($this->generateUrl('items', array('id' => $id)));
        if ($securityContext->isGranted('ROLE_BUSINES')) {

            if ($entity->getDealer() instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords &&
                    $entity->getDealer()->getId() != $this->getUser()->getId()) {
                throw $this->createAccessDeniedException('You cannot access this page!');
            } else {

                $url = $this->getRequest()->headers->get("referer");
                $return = $this->redirect($url);
            }
        }
        $entity->setActive(0);

        $em->flush();

        return $return;
    }

    /**
     * reject a Item entity.
     *
     */
    public function rejectAction(Request $request, $id) {
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
    public function approveAction(Request $request, $id) {
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
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('items_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm();
    }

    public function changeCategoryAction(Request $request, $id) {
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

        if ($form->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('items_edit', array('id' => $id)));
        }
    }

}
