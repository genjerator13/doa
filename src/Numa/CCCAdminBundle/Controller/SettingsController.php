<?php

namespace Numa\CCCAdminBundle\Controller;

use Numa\CCCAdminBundle\Form\SettingsType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\CCCAdminBundle\Entity\Customers;
use Numa\CCCAdminBundle\Entity\Settings;
use Numa\CCCAdminBundle\Form\CustomersType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

/**
 * CustomerEmails controller.
 *
 */
class SettingsController extends Controller {

   
    public function indexAction(Request $request) {
        $emailTemplateForm = $this->makeSetting($request, 'email_template');
        //$emailFromForm = $this->makeSetting($request, 'email_from');
        $emailSubjectForm = $this->makeSetting($request, 'email_subject');
        $forms = array();
        $forms[]=$emailSubjectForm->createView();
        $forms[]=$emailTemplateForm->createView();
        //$forms[]=$emailTemplateForm->createView();

        //$forms[]=$emailFromForm->createView();
        return $this->render('NumaCCCAdminBundle:Settings:index.html.twig', array(  
            'forms'=>$forms
        ));
    }
    
    public function makeSetting(Request $request, $name=""){
        $em = $this->getDoctrine()->getManager();
        $settingE = $em->getRepository('NumaCCCAdminBundle:Settings')->findOneBy(array('name'=>$name));        

        if(empty($settingE)){
            $settingE = new Settings();
            $settingE->setName($name); 
            $em->persist($settingE);            
        }

        $formSetting = $this->createTemplateForm($settingE,$name);
        $formSetting->handleRequest($request);

        if ($formSetting->isValid()) {
            $em = $this->getDoctrine()->getManager();            
            $em->flush();           
        }
        return $formSetting;
    }

    /**
     * Creates a form to create a Customers entity.
     *
     * @param Customers $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createTemplateForm(Settings $entity,$name) {
        $settingType = new \Numa\CCCAdminBundle\Form\SettingsType($name);
        $settingType->setName($name);
        $form = $this->createForm(SettingsType::class, $entity, array(
            'attr'  => array('name'=>$name),
            'action' => $this->generateUrl('settings'),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Save'));

        return $form;
    }

    /**
     * Displays a form to create a new Customers entity.
     *
     */
    public function newAction() {
        $entity = new Customers();
        $form = $this->createCreateForm($entity);

        return $this->render('NumaCCCAdminBundle:Customers:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Customers entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:Customers')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customers entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaCCCAdminBundle:Customers:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Customers entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:Customers')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customers entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaCCCAdminBundle:Customers:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Customers entity.
     *
     * @param Customers $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Customers $entity) {
        $form = $this->createForm(new CustomersType(), $entity, array(
            'action' => $this->generateUrl('customers_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Customers entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:Customers')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customers entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('customers_edit', array('id' => $id)));
        }

        return $this->render('NumaCCCAdminBundle:Customers:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Customers entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaCCCAdminBundle:Customers')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Customers entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('customers'));
    }

    /**
     * Creates a form to delete a Customers entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('customers_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', SubmitType::class, array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
