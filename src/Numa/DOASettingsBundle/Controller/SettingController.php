<?php

namespace Numa\DOASettingsBundle\Controller;

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
        $entities = $em->getRepository('NumaDOASettingsBundle:Setting')->findAll();
        $settingLib = $this->get("numa.settings");
        $sections = $settingLib->getSections();
        if(strtoupper($dashboard)=="DMS"){
            $dealer = $this->get('security.token_storage')->getToken()->getUser();
            $entities = $em->getRepository('NumaDOASettingsBundle:Setting')->findBy(array('Dealer'=>$dealer));
            $sections = $settingLib->getSections($dealer);
        }

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

        $command = 'echo \'flush_all\' | nc localhost 11211';
        $process = new \Symfony\Component\Process\Process($command);
        $process->start();


        $this->addFlash('success', "Http cache is cleared.");
        return $this->redirect($this->generateUrl('setting'));
    }

    /**
     * Finds and displays a Setting entity.
     *
     */
    public function refreshHometabsAction()
    {
        $command = 'php ' . $this->get('kernel')->getRootDir() . '/console numa:dbutil hometabs';
        $process = new \Symfony\Component\Process\Process($command);
        $process->run();

        $this->addFlash('success', "Tabs on homepage refreshed.");
        return $this->redirect($this->generateUrl('setting'));
    }
}
