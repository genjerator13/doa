<?php

namespace Numa\DOASettingsBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\CommandLog;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOASettingsBundle\Entity\Setting;
use Numa\DOASettingsBundle\Form\SettingType;

/**
 * Setting controller.
 *
 */
class SettingController extends Controller
{

    /**
     * Lists all Setting entities.
     *
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $dashboard = $request->get('_dashboard');
        $settingLib = $this->get("numa.settings");
        $dealer = $this->get('Numa.Dms.User')->getSignedUser();
        $entities = $em->getRepository('NumaDOASettingsBundle:Setting')->getSettingsForUser($dealer);
        $sections = $settingLib->getSections($dealer);

        $settings = array();
        foreach ($entities as $setting) {
            $settings[$setting->getSection()][] = $setting;
        }

        return $this->render('NumaDOASettingsBundle:Setting:index.html.twig', array(
            'entities' => $entities,
            'sections' => $sections,
            'settings' => $settings,
            'dashboard' => $dashboard,
        ));
    }

    /**
     * Creates a new Setting entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Setting();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $dashboard = $request->get('_dashboard');

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if(strtoupper($dashboard)=="DMS") {
                $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
                $entity->setDealer($dealer);
            }
            $em->persist($entity);
            $em->flush();
            $this->addFlash("Success", "Setting added: " . $entity->getName());
            $redirect = 'setting';
            if($dashboard =='DMS'){
                $redirect = 'dms_setting';
            }

            return $this->redirect($this->generateUrl($redirect));
        }

        return $this->render('NumaDOASettingsBundle:Setting:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Setting entity.
     *
     * @param Setting $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Setting $entity,$dashboard = "")
    {
        $action = 'setting_create';
        if(!empty($dashboard)){
            $action = 'dms_setting_create';
        }
        $form = $this->createForm(new SettingType(), $entity, array(
            'action' => $this->generateUrl($action),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Setting entity.
     *
     */
    public function newAction(Request $request)
    {
        $entity = new Setting();
        $dashboard = $request->get('_dashboard');
        $form = $this->createCreateForm($entity,$dashboard);

        return $this->render('NumaDOASettingsBundle:Setting:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Setting entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOASettingsBundle:Setting')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Setting entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOASettingsBundle:Setting:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Setting entity.
     *
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dashboard = $request->get('_dashboard');
        $entity = $em->getRepository('NumaDOASettingsBundle:Setting')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Setting entity.');
        }

        $editForm = $this->createEditForm($entity,$dashboard);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOASettingsBundle:Setting:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'dashboard' => $dashboard,
        ));
    }

    /**
     * Creates a form to edit a Setting entity.
     *
     * @param Setting $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Setting $entity,$dashboard = "")
    {
        $action = 'setting_update';

        if(!empty($dashboard)){
            $action = 'dms_setting_update';
        }

        $form = $this->createForm(new SettingType(), $entity, array(
            'action' => $this->generateUrl($action, array('id' => $entity->getId())),

        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Setting entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dashboard = $request->get('_dashboard');
        $entity = $em->getRepository('NumaDOASettingsBundle:Setting')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Setting entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->addFlash("success", "Setting: " . $entity->getName() . " successfully updated.");
            $redirect = 'setting_edit';
            if($dashboard =='DMS'){
                $redirect = 'dms_setting_edit';
            }
            return $this->redirect($this->generateUrl($redirect, array('id' => $id)));
        }

        return $this->render('NumaDOASettingsBundle:Setting:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'dashboard' => $dashboard,
        ));
    }

    /**
     * Deletes a Setting entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOASettingsBundle:Setting')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Setting entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('setting'));
    }

    /**
     * Creates a form to delete a Setting entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('setting_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Clear http and memcache
     *
     */
    public function clearCacheAction()
    {
        $command = 'php ' . $this->get('kernel')->getRootDir() . '/console numa:dbutil cacheclear';


        $process = new \Symfony\Component\Process\Process($command);
        $process->start();

        $this->addFlash('success', "Http cache is cleared.");
        return $this->redirect($this->generateUrl('setting'));
    }

    /**
     * make all cover images
     *
     */
    public function makeCoverImagesAction()
    {
        $command = 'php ' . $this->get('kernel')->getRootDir() . '/console numa:dbutil photos';
        $process = new \Symfony\Component\Process\Process($command);
        $process->start();


        $this->addFlash('success', "Generating cover photos in progress.");
        return $this->redirect($this->generateUrl('setting'));
    }

    /**
     * make kijiji feed for all dealers
     *
     */
    public function makeKijijiAllAction()
    {
        $this->get("numa.dms.utils")->kijiji();
        return $this->redirect($this->generateUrl('dms_setting'));
    }
    /**
     * make autotrader feed for all dealers
     *
     */
    public function makeAutotraderAllAction()
    {
        $this->get("numa.dms.utils")->kijiji();
        return $this->redirect($this->generateUrl('dms_setting'));
    }


    /**
     * make kijiji feed for all dealers
     *
     */
    public function makeKijijiCurrentAction()
    {
        $dealer = $this->get("numa.dms.user")->getSignedDealer();
        $this->get("numa.dms.utils")->kijiji($dealer);
        return $this->redirect($this->generateUrl('dms_setting'));
    }

    /**
     * make autotrader feed for all dealers
     *
     */
    public function makeAutotraderCurrentAction()
    {
        $dealer = $this->get("numa.dms.user")->getSignedDealer();
        $this->get("numa.dms.utils")->kijiji($dealer);
        return $this->redirect($this->generateUrl('dms_setting'));
    }

    /**
     * Finds and displays a Setting entity.
     *
     */
    public function refreshHometabsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $lastCommand = $em->getRepository("NumaDOAAdminBundle:CommandLog")->findOneBy(array('category' => "elasticsearch"), array('id' => 'desc'));

        if ($lastCommand instanceof CommandLog) {
            if ($lastCommand->isRunning()) {
                die();
            }
        }
        $command = 'php ' . $this->get('kernel')->getRootDir() . '/console fos:elastica:populate';
        $commandLog = new CommandLog();
        $commandLog->setCategory('elasticsearch');
        $commandLog->setStartedAt(new \DateTime());
        $commandLog->setStatus('started');
        $commandLog->setCommand($command);
        $em->persist($commandLog);
        $em->flush();
        $process = new \Symfony\Component\Process\Process($command);
        $process->start();
        $commandLog->setEndedAt(new \DateTime());
        $commandLog->setStatus('finished');
        $em->flush();
        $em->clear();

        $this->addFlash('success', "Elasticsearch populate done.");
        return $this->redirect($this->generateUrl('dms_setting'));
    }

    /**
     * Ealsticksearch populate.
     *
     */
    public function populateAction()
    {
        $this->get("numa.dms.utils")->populateElasticSearch();
        return $this->redirect($this->generateUrl('dms_setting'));
    }

    /**
     * Ealsticksearch start.
     *
     */
    public function startElasticSearchAction()
    {
        $this->get("numa.dms.utils")->startElasticSearchService();
        return $this->redirect($this->generateUrl('dms_setting'));
    }

    public function archiveItemsAction(){
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository('NumaDOAAdminBundle:Item')->findSoldForArchive('-5 minutes');
        foreach($items as $item){
            $this->get('numa.dms.listing')->archiveItem($item);
        }
        $em->flush();
        return $this->redirect($this->generateUrl('dms_setting'));
    }

    public function setSoldDateItemsAction(){
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository('NumaDOAAdminBundle:Item')->findBy(array('sold' => true, 'sold_date' => null));
        foreach($items as $item){
            $this->get('numa.dms.listing')->setSoldDateItem($item);
        }
        $em->flush();
        return $this->redirect($this->generateUrl('dms_setting'));
    }
}
