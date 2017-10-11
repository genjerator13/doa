<?php

namespace Numa\CCCAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\CCCAdminBundle\Entity\LtDispatch;
use Numa\CCCAdminBundle\Form\LtDispatchType;

/**
 * LtDispatch controller.
 *
 */
class LtDispatchController extends Controller
{
    /**
     * Lists all LtDispatch entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ltDispatches = $em->getRepository('NumaCCCAdminBundle:LtDispatch')->findAll();

        return $this->render('ltdispatch/index.html.twig', array(
            'ltDispatches' => $ltDispatches,
        ));
    }

    /**
     * Creates a new LtDispatch entity.
     *
     */
    public function newAction(Request $request)
    {
        $ltDispatch = new LtDispatch();
        $form = $this->createForm(new LtDispatchType(), $ltDispatch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ltDispatch);
            $em->flush();

            return $this->redirectToRoute('largetruckdispatch_show', array('id' => $ltdispatch->getId()));
        }

        return $this->render('ltdispatch/new.html.twig', array(
            'ltDispatch' => $ltDispatch,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a LtDispatch entity.
     *
     */
    public function showAction(LtDispatch $ltDispatch)
    {
        $deleteForm = $this->createDeleteForm($ltDispatch);

        return $this->render('ltdispatch/show.html.twig', array(
            'ltDispatch' => $ltDispatch,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing LtDispatch entity.
     *
     */
    public function editAction(Request $request, LtDispatch $ltDispatch)
    {
        $deleteForm = $this->createDeleteForm($ltDispatch);
        $editForm = $this->createForm(new LtDispatchType(), $ltDispatch);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ltDispatch);
            $em->flush();

            return $this->redirectToRoute('largetruckdispatch_edit', array('id' => $ltDispatch->getId()));
        }

        return $this->render('ltdispatch/edit.html.twig', array(
            'ltDispatch' => $ltDispatch,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a LtDispatch entity.
     *
     */
    public function deleteAction(Request $request, LtDispatch $ltDispatch)
    {
        $form = $this->createDeleteForm($ltDispatch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ltDispatch);
            $em->flush();
        }

        return $this->redirectToRoute('largetruckdispatch_index');
    }

    /**
     * Creates a form to delete a LtDispatch entity.
     *
     * @param LtDispatch $ltDispatch The LtDispatch entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LtDispatch $ltDispatch)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('largetruckdispatch_delete', array('id' => $ltDispatch->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
