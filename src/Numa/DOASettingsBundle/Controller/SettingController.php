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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOASettingsBundle:Setting')->findAll();
        $settingLib = $this->get("numa.settings");
        $sections= $settingLib->getSections();
        $settings = array();
        foreach($entities as $setting){
            $settings[$setting->getSection()][]=$setting;
        }
        
        return $this->render('NumaDOASettingsBundle:Setting:index.html.twig', array(
            'entities' => $entities,
            'sections' => $sections,
            'settings' => $settings,
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

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->addFlash("Success","Setting added: ".$entity->getName());
            return $this->redirect($this->generateUrl('setting'));
        }

        return $this->render('NumaDOASettingsBundle:Setting:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Setting entity.
     *
     * @param Setting $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Setting $entity)
    {
        $form = $this->createForm(new SettingType(), $entity, array(
            'action' => $this->generateUrl('setting_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Setting entity.
     *
     */
    public function newAction()
    {
        $entity = new Setting();
        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOASettingsBundle:Setting:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Setting entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOASettingsBundle:Setting')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Setting entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOASettingsBundle:Setting:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Setting entity.
    *
    * @param Setting $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Setting $entity)
    {
        $form = $this->createForm(new SettingType(), $entity, array(
            'action' => $this->generateUrl('setting_update', array('id' => $entity->getId())),

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

        $entity = $em->getRepository('NumaDOASettingsBundle:Setting')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Setting entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('setting_edit', array('id' => $id)));
        }

        return $this->render('NumaDOASettingsBundle:Setting:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
            ->getForm()
        ;
    }
}
