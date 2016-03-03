<?php

namespace Numa\DOAModuleBundle\Controller;

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
class AdController extends Controller
{

    /**
     * Lists all Ad entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOAModuleBundle:Ad')->findAll();

        return $this->render('NumaDOAModuleBundle:Ad:index.html.twig', array(
            'entities' => $entities,
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

            $em->flush();
            if ($entity instanceof Ad) {
            }
            if ($request->isXmlHttpRequest()) {
                $pa = new PageAds();
                $pa->setAd($entity);
                $page = $em->getRepository('NumaDOAModuleBundle:Page')->find($entity->getPageId());
                $pa->setPage($page);

                $entity->addPageAd($pa);
                $em->flush();
                $response = new JsonResponse(
                    array(
                        'message' => 'Success',
                        400));

                return $response;
            }
            return $this->redirect($this->generateUrl('ad_show', array('id' => $entity->getId())));
        }

        return $this->render('NumaDOAModuleBundle:Ad:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
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
        $form = $this->createForm(new AdType(), $entity, array(
            'action' => $this->generateUrl('ad_create'),
            'method' => 'POST',
        ));
        $form->remove('Pages');
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

        $form = $this->createCreateForm($entity);

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
        $form = $this->createForm(new AdType(), $entity, array(
            'action' => $this->generateUrl('ad_update', array('id' => $entity->getId())),
            'method' => 'POST',
            'csrf_protection' => false,
        ));
        $form->remove('Pages');
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
            }
            return $this->redirect($this->generateUrl('ad_edit', array('id' => $id)));
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

        // }
        dump("aaaa");
        die();
        return $this->redirect($this->generateUrl('ad'));
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
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ad_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
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
