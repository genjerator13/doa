<?php

namespace Numa\DOAModuleBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Lib\DashboardDMSControllerInterface;
use Numa\DOAModuleBundle\Entity\Component;
use Numa\DOAModuleBundle\Entity\PageComponent;
use Numa\DOAModuleBundle\Form\ComponentType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOAModuleBundle\Entity\Page;
use Numa\DOAModuleBundle\Form\PageType;


/**
 * Page controller.
 *
 */
class PageController extends Controller implements DashboardDMSControllerInterface, DealerSiteControllerInterface
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



    /**
     * Lists all Page entities.
     *
     */


    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $dealer = $this->get('security.token_storage')->getToken()->getUser();
//        $entities = $em->getRepository('NumaDOAModuleBundle:Page')->findPagesByDealer($dealer->getId());
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $url = $this->get('Numa.Dms.User')->getCurrentSiteHostWWW($dealer->getSiteUrl());

        $render = 'NumaDOAModuleBundle:Page:index.html.twig';
        if($this->dashboard =='DMS'){
            $render = 'NumaDOAModuleBundle:Page:DMSindex.html.twig';
        }

        $dealer_id="";
        if($dealer instanceof Catalogrecords){
            $dealer_id=$dealer->getId();
        }
        return $this->render($render, array(
            'url' => $url,
            'dashboard' => $this->dashboard,
            'dealer_id' => $dealer_id,
        ));
    }
    /**
     * Creates a new Page entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Page();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setIsManual(true);
            $em->persist($entity);

            $component = new Component();
            $component->setName("page_content");
            $component->setType("HTML");

            $pageComponent = new PageComponent();
            $pageComponent->setComponent($component);
            $pageComponent->setPage($entity);

            $entity->addPageComponent($pageComponent);

            $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
            $url = $dealer->getSiteUrl();
            $entity->setDealer($dealer);

            $em->persist($component);
            $em->persist($entity);
            $em->persist($pageComponent);
            $em->flush();
            //die();


            $this->addFlash("success","Page is successfully added. ");
            $redirect = 'page';
            if($this->dashboard =='DMS'){
                $redirect = 'dms_page';
            }
            return $this->redirect($this->generateUrl($redirect, array('id' => $entity->getId())));
        }

        return $this->render('NumaDOAModuleBundle:Page:new.html.twig', array(
            'url'=> $url,
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Page entity.
     *
     * @param Page $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Page $entity)
    {
        $action = 'page_create';
        if(!empty($this->dashboard)){
            $action = 'dms_page_create';
        }
        $form = $this->createForm(new PageType(), $entity, array(
            'action' => $this->generateUrl($action),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Page entity.
     *
     */
    public function newAction(Request $request)
    {
        $entity = new Page();
        $form   = $this->createCreateForm($entity);
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $url = $this->get('Numa.Dms.User')->getHost($request);

        return $this->render('NumaDOAModuleBundle:Page:new.html.twig', array(
            'url'=>$url,
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Page entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAModuleBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAModuleBundle:Page:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAModuleBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $component = $entity->getComponent();
        $url = $this->get('Numa.Dms.User')->getHost($request);

        return $this->render('NumaDOAModuleBundle:Page:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'dashboard' => $this->dashboard,
            'dealer' => $this->dealer,
            'url' => $url,
        ));
    }

    /**
    * Creates a form to edit a Page entity.
    *
    * @param Page $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Page $entity)
    {
        $action = 'page_update';

        if(!empty($this->dashboard)){
            $action = 'dms_page_update';
        }
        $form = $this->createForm(new PageType(), $entity, array(
            'action' => $this->generateUrl($action, array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Page entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAModuleBundle:Page')->find($id);
        //$oldAds = $em->getRepository('NumaDOAModuleBundle:PageAds')->findBy(array('Page'=>$entity));
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
//            if(!empty($oldAds)) {
//
//                foreach ($oldAds as $oldPA) {
//                    $em->remove($oldPA);
//                }
//            }

            $em->flush();
            $this->addFlash("success","Page ".$id." is successfully edited. ");
            $redirect = 'page';
            if($this->dashboard =='DMS'){
                $redirect = 'dms_page';
            }
            return $this->redirect($this->generateUrl($redirect, array('id' => $id)));
        }

        return $this->render('NumaDOAModuleBundle:Page:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'dashboard' => $this->dashboard,
        ));
    }
    /**
     * Deletes a Page entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAModuleBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('dms_page'));
    }

    /**
     * Creates a form to delete a Page entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dms_page_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function loadAdsAction($id){
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAModuleBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        return $this->render('NumaDOAModuleBundle:Page:pageAds.html.twig', array(
            'entity'      => $entity,
        ));
    }
}
