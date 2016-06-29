<?php

namespace Numa\DOAAdminBundle\Controller;

use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\ItemField;
use Numa\DOAAdminBundle\Entity\Listingfield;
use Numa\DOADMSBundle\Lib\DashboardDMSControllerInterface;
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
class ImportmappingController extends Controller implements DashboardDMSControllerInterface {

    public $dashboard;
    public function initializeDashboard($dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     * Lists all Importmapping entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('NumaDOAAdminBundle:Importmapping')->findAll();
        return $this->render('NumaDOAAdminBundle:Importmapping:index.html.twig', array(
                    'entities' => $entities,
                    'dashboard' => $this->dashboard,
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
        $error = array();
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

        $importmappingCollection = new Importmappings();
        if (!empty($entities)) {
            foreach ($entities as $entity) {
                $entity->setFeedSid($id);
                $importmappingCollection->addImportmappingRow($entity);
            }
        } else {
            $remoteFeed = new RemoteFeed($id);

            $props = $remoteFeed->getRemoteProperties();

            if (!empty($props)) {
                foreach ($props as $prop) {
                    $im = new Importmapping();
                    $im->setDescription($prop);
                    $im->setSid($prop);
                    $im->setProperty($prop);
                    $test = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneByProperty($prop, $feed->getListingType());

                    if (!empty($test)) {
                        $im->setListingField($test);
                    }

                    $importmappingCollection->addImportmappingRow($im);
                }
            } else {
                $error[] = "No Properties fetched from the feed";
            }
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
                    'errors' => $error,
        ));
    }

    public function fetchAction(Request $request = null, $id) {

        $em = $this->getDoctrine()->getManager();

        //$command = new \Numa\DOAAdminBundle\Command\DBUtilsCommand();
        //$command->setContainer($this->container);
        //$resultCode = $command->fetchFeed($id, $em);
        $command = 'numa:dbutil fetchFeed ' . $id;
        $commandLog = new \Numa\DOAAdminBundle\Entity\CommandLog();
        $commandLog->setCommand($command);
        $commandLog->setCategory('fetch');
        $commandLog->setStartedAt(new \DateTime());
        $commandLog->setStatus('pending');

        $commandLog->setCommand($command);
        $em->persist($commandLog);
        $em->flush();
        //$process = new \Symfony\Component\Process\Process($command);
        //$process->start();
        $request->getSession()->getFlashBag()
                ->add('success', 'Feed' . $id . ' added to queue. Click on -Start command Queue- in order to start fetching the feed');
        $action = 'command_log_home';
        if(!empty($this->dashboard)){
            $action = 'dms_command_log_home';
        }
        return $this->redirectToRoute($action);
    }

    public function renderFetch($items) {
        //return "aaaa";
        return $this->render('NumaDOAAdminBundle:Importmapping:fetch.html.twig');
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
            $listingField = $mapping->getListingfield();
            //$type = $listingField->getType();
            $listingFieldList = $listingField->getListingFieldLists();
            $mapvalues = $mapping->getValueMapValues();

            $mapvaluesJson = json_decode($mapvalues, true);
        }
        //prinr_($mapvalues);
        return $this->render('NumaDOAAdminBundle:Importmapping:addMappingValue.html.twig', array('list' => $listingFieldList, 'mapvalues' => $mapvaluesJson, 'first' => $first));
    }

    public function resetAction(Request $request = null,$id){

        $feedId = intval($id);
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('NumaDOAAdminBundle:Importmapping')->resetMappings($feedId);
        return $this->redirectToRoute("import_mapping_feed",array("id"=>$id));
    }

}
