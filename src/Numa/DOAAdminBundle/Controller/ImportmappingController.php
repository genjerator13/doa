<?php

namespace Numa\DOAAdminBundle\Controller;

use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\ItemField;
use Numa\DOAAdminBundle\Entity\Listingfield;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\Importmapping;
use Numa\DOAAdminBundle\Entity\Importmappings;
use Numa\DOAAdminBundle\Form\ImportmappingType;
use Numa\DOAAdminBundle\Form\ImportmappingRowType;
use Numa\DOAAdminBundle\Lib\RemoteFeed;
use Numa\DOAAdminBundle\Entity\Repository;
use Doctrine\Common\Util\Debug as Debug;
use Symfony\Component\HttpFoundation\Response;

/**
 * Importmapping controller.
 *
 */
class ImportmappingController extends Controller {

    /**
     * Lists all Importmapping entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('NumaDOAAdminBundle:Importmapping')->findAll();
        return $this->render('NumaDOAAdminBundle:Importmapping:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Importmapping entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Importmapping();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('import_mapping_show', array('id' => $entity->getId())));
        }

        return $this->render('NumaDOAAdminBundle:Importmapping:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Importmapping entity.
     *
     * @param Importmapping $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Importmapping $entity) {
        $form = $this->createForm(new ImportmappingType(), $entity, array(
            'action' => $this->generateUrl('import_mapping_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Importmapping entity.
     *
     */
    public function newAction() {
        $entity = new Importmapping();
        $form = $this->createCreateForm($entity);

        return $this->render('NumaDOAAdminBundle:Importmapping:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Importmapping entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Importmapping')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Importmapping entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Importmapping:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Importmapping entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Importmapping')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Importmapping entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Importmapping:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Importmapping entity.
     *
     * @param Importmapping $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Importmapping $entity) {
        $form = $this->createForm(new ImportmappingType(), $entity, array(
            'action' => $this->generateUrl('import_mapping_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Importmapping entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:Importmapping')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Importmapping entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('import_mapping_edit', array('id' => $id)));
        }

        return $this->render('NumaDOAAdminBundle:Importmapping:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Importmapping entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOAAdminBundle:Importmapping')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Importmapping entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('import_mapping'));
    }

    /**
     * Creates a form to delete a Importmapping entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('import_mapping_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    public function feedAction(Request $request = null, $id) {

        $em = $this->getDoctrine()->getManager();
        //get maping by feedid
        $entities = $em->getRepository('NumaDOAAdminBundle:Importmapping')->findBy(array('feed_sid' => $id));
        //get feed
        $feed = $em->getRepository('NumaDOAAdminBundle:Importfeed')->findOneById($id);
        //get listing field by universal category 0
        $fields = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findBy(array('category_sid' => array(0, $feed->getListingType())), array('caption' => 'ASC'));
        $listingfields = array();
        foreach ($fields as $field) {
            $listingfields['listing'][$field->getId()] = $field->getCaption();
        }
        //$listingfields['preferredChoices'] = array('596');//????
        //\Doctrine\Common\Util\Debug::dump($feed->getListingType());
        //\Doctrine\Common\Util\Debug::dump($listingfields);
        $importmappingCollection = new Importmappings();
        if (!empty($entities)) {
            foreach ($entities as $entity) {
                $entity->setFeedSid($id);
                $importmappingCollection->addImportmappingRow($entity);
            }
        } else {
            $remoteFeed = new RemoteFeed($id);
            $props = $remoteFeed->getRemoteProperties();

            foreach ($props as $prop) {
                $im = new Importmapping();
                $im->setDescription($prop);
                $im->setSid($prop);
                $im->setProperty($prop);
                $test = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneByProperty($prop, $feed->getListingType());

                if (!empty($test)) {
                    $im->setListingFields($test);
                }

                $importmappingCollection->addImportmappingRow($im);
            }
            //$form->add('sid', 'choice', array('choices' => $props,'empty_value' => 'Choose an option','required'=>true));
        }

        $collection = $this->createForm(new ImportmappingRowType($feed->getListingType(), $listingfields, $em), $importmappingCollection);

        $collection->add('feed_sid', 'hidden', array('data' => $id));
        $collection->handleRequest($request);

        if ($collection->isValid()) {

            foreach ($collection->getData()->getImportmappingRow() as $entity) {
                $entity->setFeedSid($id);
                $em->persist($entity);
            }
            $em->flush();

            if (!$request->isXmlHttpRequest()) {
                return $this->redirect($this->generateUrl('importfeed'));
            }
        }

        return $this->render('NumaDOAAdminBundle:Importmapping:feed.html.twig', array(
                    'form' => $collection->createView(),
                    'feed' => $feed,
        ));
    }

    public function fetchAction(Request $request = null, $id) {
        //echo "Memory usage in fetchAction before: " . (memory_get_usage() / 1024) . " KB" . PHP_EOL . "<br>";
        $time = time();
        $em = $this->getDoctrine()->getManager();

        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        $em->clear();
        $createdItems = array();
        $feed_id = $id;
        //$uniqueField = $feed->getUniqueField();
        $remoteFeed = new Remotefeed($id);
        $items = $remoteFeed->getRemoteItems();
        unset($remoteFeed);
        //get import feed by id
        //$feed = $em->getRepository('NumaDOAAdminBundle:Importfeed')->find($id);
        //get mapping by feed id
        $mapping = $em->getRepository('NumaDOAAdminBundle:Importmapping')->findBy(array('feed_sid' => $feed_id));
        //get mold items by feed id
        //$itemsOld = $em->getRepository('NumaDOAAdminBundle:Item')->findBy(array('feed_id' => $feed_id));
        //remove old items
        //$em->getRepository('NumaDOAAdminBundle:Item')->removeItemsByFeed($feed_id);        
        //walk trough XML feed
        $upload_url = $this->container->getParameter('upload_url');
        $upload_path = $this->container->getParameter('upload_path');

        //echo "Memory usage in fetchAction inside1: " . (memory_get_usage() / 1024) . " KB" . PHP_EOL . "<br>";
        $count = 0;

        foreach ($items as $importItem) {
            $item = $em->getRepository('NumaDOAAdminBundle:Item')->importRemoteItem($importItem, $mapping, $feed_id, $upload_url, $upload_path);

            if (!empty($item)) {
                $createdItems[] = $item;
            }
            unset($item);
            //echo "Memory usage in fetchAction inloop: " . $count . "::" . (memory_get_usage() / 1024) . " KB" . PHP_EOL . "<br>";
            $count++;
            if ($count % 100 == 0) {
                $em->flush();
                $em->clear();
            }
//             if ($count  >= 500) {
//                 $time = time() - $time;
//                 echo $time."Memory usage before: " . (memory_get_usage() / 1024) . " KB" . PHP_EOL;
//                die();
//             }
        }

        //unset($feed);
        $em->flush();
        $em->clear();
        unset($items);
        unset($mapping);
        $time = time() - $time;

        //update hometabs
        $command = new \Numa\DOAAdminBundle\Command\DBUtilsCommand();
        $command->setContainer($this->container);
        $resultCode = $command->makeHomeTabs(false);
        echo $time . ":::" . count($createdItems);
        //echo "Memory usage before: " . (memory_get_usage() / 1024) . " KB" . PHP_EOL;
        return $this->render('NumaDOAAdminBundle:Importmapping:fetch.html.twig', array('items' => $createdItems));
    }

    public function mapvaluesAction(Request $request = null) {
        $mapid = intval($request->request->get('mapid'));
        $json = array();
        if (!empty($mapid)) {
            $em = $this->getDoctrine()->getManager();
            $mapping = $em->getRepository('NumaDOAAdminBundle:Importmapping')->find($mapid);

            $json = $mapping->getValueMapValues();
        }
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function addMapValuesAction(Request $request = null) {
        $mapid = intval($request->request->get('mapid'));
        $init = $request->request->get('init');
        $first = false;
        if (!empty($init)) {
            $first = true;
        }
        $listingFieldList = array();
        $mapvalues = array();
        if (!empty($mapid)) {
            $em = $this->getDoctrine()->getManager();

            $mapping = $em->getRepository('NumaDOAAdminBundle:Importmapping')->find($mapid);
            //\Doctrine\Common\Util\Debug::dump($mapping);
            $listingField = $mapping->getListingFields();
            //$type = $listingField->getType();
            $listingFieldList = $listingField->getListingFieldLists();
            $mapvalues = $mapping->getValueMapValues();

            $mapvaluesJson = json_decode($mapvalues, true);
        }
        //prinr_($mapvalues);
        return $this->render('NumaDOAAdminBundle:Importmapping:addMappingValue.html.twig', array('list' => $listingFieldList, 'mapvalues' => $mapvaluesJson, 'first' => $first));
    }

}
