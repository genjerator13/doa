<?php

namespace Numa\DOAAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\ItemField;
use Numa\DOAAdminBundle\Form\ItemType;
use Symfony\Component\Yaml\Parser;

/**
 * Item controller.
 *
 */
class ItemController extends Controller
{

    /**
     * Lists all Item entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOAAdminBundle:Item')->findAll();

        return $this->render('NumaDOAAdminBundle:Item:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Lists all Item entities.
     *
     */
    public function additemAction()
    {
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
    public function createAction(Request $request)
    {
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
    private function createCreateForm(Item $entity)
    {
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
    public function newAction(Request $request, $cat_id, $item_id = null)
    {

        $entity = new Item();
        $em = $this->getDoctrine()->getManager();
        //get category by request parameter
        $category = $em->getRepository('NumaDOAAdminBundle:Category')->findOneById($cat_id);

        //get edited item
        if ($item_id != null) {
            $item = $em->getRepository('NumaDOAAdminBundle:Item'); //->findOneById(1347);
        }

        //$yaml = new Parser();
        //$value = $yaml->parse(file_get_contents($this->get('kernel')->locateResource('@NumaDOAAdminBundle/ItemFields.yml')));
        //$fieldsAll = $value['All'];
        //$fields = $fieldsAll + $value[$category->getName()];

        //get all listing fields for the category + default listing fields
        $fields = $em->getRepository('NumaDOAAdminBundle:ListingField')->findBy(array('category_sid' => array(0, $cat_id)));
        if (!empty($fields)) {
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
                    print_r(array(
                        'sql'        => $query->getSQL(),
                        'parameters' => $query->getParameters(),
                    ));
                    print_r($field->getId());

                    $products = $qb->getQuery()->setMaxResults(1)->getResult();


                    if (!empty($products[0])) {
                        print_r($products[0]);echo $cat_id.":::".$field->getId();
                        $itemField->setFieldStringValue($products[0]['field_string_value']);
                    }
                }
                $itemField->setFieldName($field->getCaption());
                $itemField->setFieldType($field->getType());
                $entity->addItemField($itemField);
            }
        }

        $entity->setCategory($category);
        $form = $this->createForm(new ItemType(), $entity, array(
            'method' => 'POST',
        ));

        $form->add('category_id', 'hidden', array('data' => $cat_id))
            ->add('Itemfield', 'collection', array('type' => new \Numa\DOAAdminBundle\Form\ItemFieldType()))
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
        } else {

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
    public function editAction(request $request, $id)
    {
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
    private function createEditForm(Item $entity)
    {
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
    public function deleteAction(Request $request, $id)
    {
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

}
