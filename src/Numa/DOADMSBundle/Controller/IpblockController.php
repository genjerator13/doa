<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOADMSBundle\Entity\Ipblock;
use Numa\DOADMSBundle\Entity\ListingForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\Note;
use Numa\DOADMSBundle\Form\NoteType;

/**
 * Note controller.
 *
 */
class IpblockController extends Controller
{

    /**
     * Lists all Note entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('NumaDOADMSBundle:Ipblock:index.html.twig', array(

        ));
    }

    /**
     * Finds and displays a Note entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Note')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Note entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Note:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing Note entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Note')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Note entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Note:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Note entity.
    *
    * @param Note $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Note $entity)
    {
        $form = $this->createForm(new NoteType(), $entity, array(
            'action' => $this->generateUrl('note_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Note entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Note')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Note entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('note_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:Note:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Note entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:Note')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Note entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('note'));
    }

    /**
     * Creates a form to delete a Note entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('note_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function massBlockAction(Request $request) {

        $ids = $this->get("Numa.UiGrid")->getSelectedIds($request);

        $em = $this->getDoctrine()->getManager();
        $lfs = $em->getRepository(ListingForm::class)->findBy(array('id'=>explode(",",$ids)));
        foreach ($lfs as $index => $lf) {
            $lf->setIpBlocked(true);
            //check if ipblock already has the IP
            $existingIp = $em->getRepository(Ipblock::class)->findOneBy(array("ip"=>$lf->getIp()));
            if(!$existingIp instanceof Ipblock){
                $ip = new Ipblock();
                $ip->setIp($lf->getIp());
                $em->persist($ip);
            }
        }
        $em->flush();
        die();
    }


}
