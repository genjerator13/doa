<?php

namespace Numa\DOAModuleBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Lib\DashboardDMSControllerInterface;
use Numa\DOAModuleBundle\Entity\PageAds;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOAModuleBundle\Entity\Ad;
use Numa\DOAModuleBundle\Form\AdType;

/**
 * Ad controller.
 *
 */
class AdController extends Controller implements DashboardDMSControllerInterface
{

    public $dashboard;

    public function initializeDashboard($dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     * Lists all Ad entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $dealer = $this->container->get("numa.dms.user")->getSignedDealer();
        if($dealer instanceof Catalogrecords){
            $entities = $em->getRepository('NumaDOAModuleBundle:Ad')->findBy(array('dealer_id' => $dealer->getId()));
        }
        else{
            $entities = $em->getRepository('NumaDOAModuleBundle:Ad')->findBy(array('dealer_id' => NULL));
        }

        return $this->render('NumaDOAModuleBundle:Ad:index.html.twig', array(
            'entities' => $entities,
            'dashboard' => $this->dashboard,
        ));
    }

    /**
     * Creates a new Ad entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Ad();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->upload();
            $em->persist($entity);

            $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
            $entity->setCatalogrecords($dealer);
            $em->flush();
            if ($entity instanceof Ad) {
            }
            if ($request->isXmlHttpRequest()) {

                $ids = array();
                foreach ($entity->getPages() as $page) {
                    $ids[] = $page->getId();
                }

                if (!in_array($entity->getPageId(), $ids)) {
                    $pa = new PageAds();
                    $pa->setAd($entity);
                    $page = $em->getRepository('NumaDOAModuleBundle:Page')->find($entity->getPageId());
                    $pa->setPage($page);
                    $entity->addPageAd($pa);
                }


                $em->flush();
                $response = new JsonResponse(
                    array(
                        'message' => 'Success',
                        400));

                return $response;
            }

            $redirect = 'ad_index';
            if (strtoupper($this->dashboard) == 'DMS') {
                $redirect = 'dms_ad_index';
            }
            return $this->redirect($this->generateUrl($redirect, array('id' => $entity->getId())));
        }

        return $this->render('NumaDOAModuleBundle:Ad:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'dashboard' => $this->dashboard,
        ));
    }

    /**
     * Creates a form to create a Ad entity.
     *
     * @param Ad $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ad $entity)
    {
        $redirect = 'ad_create';
        if (strtoupper($this->dashboard) == 'DMS') {
            $redirect = 'dms_ad_create';
        }
        $form = $this->createForm(new AdType(), $entity, array(
            'action' => $this->generateUrl($redirect),
            'method' => 'POST',
        ));
        //$form->remove('Pages');
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Ad entity.
     *
     */
    public function newAction()
    {
        $entity = new Ad();

        $form = $this->createCreateForm($entity);


        return $this->render('NumaDOAModuleBundle:Ad:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'dashboard' => $this->dashboard,
        ));
    }

    /**
     * Displays a form to create a new Ad entity.
     *
     */
    public function newAjaxAction($pageid)
    {
        $entity = new Ad();
        $pageid = intval($pageid);
        $entity->setPageId($pageid);
//        $pa = new PageAds();
//        $pa->setAd($entity);
//
//
//        $em = $this->getDoctrine()->getManager();
//        $page = $em->getRepository('NumaDOAModuleBundle:Page')->find($pageid);
//        $pa->setPage($page);
//        $entity->setPages($pa);
        $form = $this->createCreateForm($entity);
//        $form->
        return $this->render('NumaDOAModuleBundle:Ad:newAjax.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ad entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAModuleBundle:Ad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAModuleBundle:Ad:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ad entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAModuleBundle:Ad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ad entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAModuleBundle:Ad:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'dashboard' => $this->dashboard,
        ));
    }

    /**
     * Displays a form to edit an existing Ad entity.
     *
     */
    public function editAjaxAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAModuleBundle:Ad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ad entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAModuleBundle:Ad:editAjax.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Ad entity.
     *
     * @param Ad $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Ad $entity)
    {
        $redirect = 'ad_update';
        if (strtoupper($this->dashboard) == 'DMS') {
            $redirect = 'dms_ad_update';
        }
        $form = $this->createForm(new AdType(), $entity, array(
            'action' => $this->generateUrl($redirect, array('id' => $entity->getId())),
            'method' => 'POST',
            'csrf_protection' => false,
        ));
        //$form->remove('Pages');
        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Ad entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAModuleBundle:Ad')->find($id);
        $oldAds = $em->getRepository('NumaDOAModuleBundle:PageAds')->findBy(array('Ad' => $entity));
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ad entity.');
        }


        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        //dump($previousCollections);die();
        if ($editForm->isValid() || $request->isXmlHttpRequest()) {


            if ($request->isXmlHttpRequest()) {
                $entity->upload();
                $em->flush();
                $response = new JsonResponse(
                    array(
                        'message' => 'Success',
                        400));

                return $response;
            } else {

                if (!empty($oldAds)) {
                    foreach ($oldAds as $oldPA) {
                        $em->remove($oldPA);
                    }
                }
                $entity->upload();
                $em->flush();
                $this->addFlash("success", "Ad: #" . $entity->getId() . " successfully updated.");
            }
            $redirect = 'ad_edit';
            if (strtoupper($this->dashboard) == 'DMS') {
                $redirect = 'dms_ad_edit';
            }
            return $this->redirect($this->generateUrl($redirect, array('id' => $id)));
        } else {


            die();
        }

        return $this->render('NumaDOAModuleBundle:Ad:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ad entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAModuleBundle:Ad')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ad entity.');
        }
        $pas = $em->getRepository('NumaDOAModuleBundle:PageAds')->findBy(array('ad_id' => $entity->getId()));

        foreach ($pas as $pa) {

            $em->remove($pa);
        }

        $em->flush();


        $em->remove($entity);
        $em->flush();


        $redirect = 'ad_index';
        if (strtoupper($this->dashboard) == 'DMS') {
            $redirect = 'dms_ad_index';
        }
        return $this->redirect($this->generateUrl($redirect));
    }

    /**
     * Creates a form to delete a Ad entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $redirect = 'ad_delete';
        if (strtoupper($this->dashboard) == 'DMS') {
            $redirect = 'dms_ad_delete';
        }

        return $this->createFormBuilder()
            ->setAction($this->generateUrl($redirect, array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm();
    }

    /**
     * Increase click on the ad.
     *
     */
    public function clickAjaxAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAModuleBundle:Ad')->find($id);
        $entity instanceof Ad;
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ad entity.');
        }


        if ($request->isXmlHttpRequest()) {
            $entity->setClicks($entity->getClicks() + 1);
            $em->flush();
            $response = new JsonResponse(
                array(
                    'message' => 'Success',
                    400));

            return $response;
        }
        throw $this->createAccessDeniedException('ERROR');
    }
}
