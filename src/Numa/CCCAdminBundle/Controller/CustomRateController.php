<?php

namespace Numa\CCCAdminBundle\Controller;

use Numa\CCCAdminBundle\Entity\Customers;
use Numa\CCCAdminBundle\Entity\CustomRateRate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\CCCAdminBundle\Entity\CustomRate;
use Numa\CCCAdminBundle\Form\CustomRateType;

/**
 * CustomRate controller.
 *
 */
class CustomRateController extends Controller
{
    /**
     * Lists all CustomRate entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $customRates = $em->getRepository('NumaCCCAdminBundle:CustomRate')->findAll();

        return $this->render('NumaCCCAdminBundle:customrate:index.html.twig', array(
            'customRates' => $customRates,
        ));
    }

    /**
     * Creates a new CustomRate entity.
     *
     */
    public function newAction(Request $request)
    {
        $customRate = new CustomRate();
        $form = $this->createForm(new CustomRateType(), $customRate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $customRate->upload();

            $em->persist($customRate);
            $em->flush();
            $this>$this->addFlash("success","Custom Rate ".$customRate->getId()." has been Created");
            return $this->redirectToRoute('customrate_index', array('id' => $customRate->getId()));
        }

        return $this->render('NumaCCCAdminBundle:customrate:new.html.twig', array(
            'customRate' => $customRate,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CustomRate entity.
     *
     */
    public function showAction(CustomRate $customRate)
    {
        $deleteForm = $this->createDeleteForm($customRate);

        return $this->render('NumaCCCAdminBundle:customrate:show.html.twig', array(
            'customRate' => $customRate,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CustomRate entity.
     *
     */
    public function editAction(Request $request, CustomRate $customRate)
    {
        $deleteForm = $this->createDeleteForm($customRate);
        $editForm = $this->createForm(new CustomRateType(), $customRate);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository(CustomRate::class)->removeAllRates($customRate->getId());//findBy(array("custom_rate_id"=>$customRate->getId()));
            $em->persist($customRate);
            $em->flush();
            $this>$this->addFlash("success","Custom Rate ".$customRate->getId()." has been updated");
            return $this->redirectToRoute('customrate_index');
        }

        return $this->render('NumaCCCAdminBundle:customrate:edit.html.twig', array(
            'customRate' => $customRate,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CustomRate entity.
     *
     */
    public function deleteAction(Request $request, CustomRate $customRate)
    {
        $form = $this->createDeleteForm($customRate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($customRate);
            $em->flush();
        }

        return $this->redirectToRoute('customrate_index');
    }

    /**
     * Creates a form to delete a CustomRate entity.
     *
     * @param CustomRate $customRate The CustomRate entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CustomRate $customRate)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('customrate_delete', array('id' => $customRate->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
