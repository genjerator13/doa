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

/**
 * Item controller.
 *
 */
class ItemController extends Controller {

    /**
     * Lists all Item entities.
     *
     */
    public function indexAction() {
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
                    $res['active'] = $row->getField('active');
                    $res['moderation_status'] = $row->getField('moderation_status');
                    $res['views'] = $row->getField('views');
                    $res['activation_date'] = $row->getField('activation_date');
                    
                    foreach ($fields as $field) {
                        if ($field->getFieldType() == 'array') {
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
                    }else{
                        $res['activation_date'] = $res['activation_date']->format('Y-m-d');
                    }

                    echo $controller->renderView("NumaDOAAdminBundle:Item:itemDetailsGrid.html.twig", array("details" => $res));
                }
        );

        //actions in row and mass actions
        //$grid->addRowAction(new RowAction('Show', 'items'));
        $yourMassAction = new MassAction('Activate', 'Numa\DOAAdminBundle\Controller\ItemController::test');
        $grid->addMassAction($yourMassAction);
        $yourMassAction = new MassAction('Deactivate', 'Numa\DOAAdminBundle\Controller\ItemController::deactivateAction');
        $grid->addMassAction($yourMassAction);
        $yourMassAction = new MassAction('Approve', 'Numa\DOAAdminBundle\Controller\ItemController::approveAction');
        $grid->addMassAction($yourMassAction);
        $yourMassAction = new MassAction('Reject', 'Numa\DOAAdminBundle\Controller\ItemController::rejectAction');
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
    
    static function test ($primaryKeys, $allPrimaryKeys, $session, $parameters){
        print_r($primaryKeys);
        die();
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

        //get all listing fields for the category + default listing fields
        $fields = $em->getRepository('NumaDOAAdminBundle:ListingField')->findBy(array('category_sid' => array(0, $cat_id)));
        if (!empty($fields) && empty($item_id)) {
            //TO DO remove all existing item fields
            /*
            $oldItemFields = $em->getRepository('NumaDOAAdminBundle:ItemField')->findBy(array('item_id'=>$item_id));
            foreach($oldItemFields as $oldone){
                $em->remove($oldone);
            }
             * 
             */
            foreach ($fields as $key => $field) {
                $itemField = new ItemField();
                //check if item field has value for the listing_field
                if ($item_id != null) {
                    $qb = $item->createQueryBuilder('i')
                            ->select('if.field_string_value,if.field_name')
                            ->where('i.id = :iid')
                            ->join('i.ItemField', 'if')
                            ->join('if.Listingfield', 'ls')
                            ->andWhere('ls.id = :lsid')
                            ->setParameter('iid', $item_id)
                            ->setParameter('lsid', $field->getId());
                    $query = $qb->getQuery();

                    $products = $qb->getQuery()->setMaxResults(1)->getResult();


                    if (!empty($products[0])) {
                        //print_r($products[0]);echo $cat_id.":::".$field->getId();
                        $itemField->setFieldStringValue($products[0]['field_string_value']);
                    }
                }

                $itemField->setFieldName($field->getCaption());
                $itemField->setFieldType($field->getType());
                $entity->addItemField($itemField);
            }
        }

        $entity->setCategory($category);
        $form = $this->createForm(new ItemType($this->getDoctrine()->getEntityManager()), $entity, array(
            'method' => 'POST',
        ));

        $form->add('category_id', 'hidden', array('data' => $cat_id))
                ->add('Itemfield', 'collection', array('type' => new \Numa\DOAAdminBundle\Form\ItemFieldType($this->getDoctrine()->getEntityManager())))
                ->add('Submit', 'submit');
        $form->handleRequest($request);

        if ($form->isValid()) {
            //foreach ($entity as $itemField) {
            //$em->persist($itemField);
            //$em->flush();
            //}
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('items_show', array('id' => $entity->getId())));
        } 
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
    public function editAction(request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }
        return $this->newAction($request, $entity->getImportFeed()->getListingType(), $id);

        /*
          $originalItemFields = array();
          $form = $this->createForm(new ItemType(), $entity);
          $form->handleRequest($request);

          if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($entity);
          $em->flush();

          return $this->redirect($this->generateUrl('items_show', array('id' => $entity->getId())));
          }
          return $this->render('NumaDOAAdminBundle:Item:new.html.twig', array(
          'entity' => $entity,
          'form' => $form ->createView(),
          'category' => $entity->getCategory(),
          ));
         */
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

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Item entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

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

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $entity->setActive(1);
        $entity->setActivationDate(new \DateTime());
        $em->flush();

        return $this->redirect($this->generateUrl('items', array('id' => $id)));
    }
    
    /**
     * deactivate a Item entity.
     *
     */
    public function deactivateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $entity->setActive(0);
        
        $em->flush();

        return $this->redirect($this->generateUrl('items', array('id' => $id)));
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

}
