<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\ListingForm;
use Numa\DOADMSBundle\Form\ListingFormType;
use Numa\DOADMSBundle\Form\ListingFormEpriceType;
use Numa\DOADMSBundle\Form\ListingFormOfferType;
use Numa\DOADMSBundle\Form\ListingFormDriveType;

/**
 * ListingForm controller.
 *
 */
class ListingFormController extends Controller
{

    /**
     * Lists all ListingForm entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOADMSBundle:ListingForm')->findAll();

        return $this->render('NumaDOADMSBundle:ListingForm:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ListingForm entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ListingForm();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $routeName = $request->get('_route');
            if($routeName == 'listingform_create_drive'){
                $entity->setType('drive');
            }
            elseif($routeName == 'listingform_create_eprice') {
                $entity->setType('eprice');
            }
            else{
                $entity->setType('offer');
            }
            $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
            $entity->setDealer($dealer);

//            $customer = $em->getRepository('NumaDOADMSBundle:Customer')->findOneBy(array('email'=>$email,'dealer_id'=>$this->dealer->getId()));
//
//            if(empty($customer)){
//                $customer = new Customer();
//                $customer->setFirstName($data->getCustName());
//                $customer->setLastName($data->getCustLastName());
//                $customer->setEmail($email);
//                $customer->setCatalogrecords($this->dealer);
//                $customer->setHomePhone($data->getPhone());
//                $em->persist($customer);
//            }
//            $entity->setCustomer($customer);

            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('listingform'));

        }

        return $this->render('NumaDOADMSBundle:ListingForm:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ListingForm entity.
     *
     * @param ListingForm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ListingForm $entity)
    {
        $form = $this->createForm(new ListingFormType(), $entity, array(
            'action' => $this->generateUrl('listingform_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to create a ListingForm entity.
     *
     * @param ListingForm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateDriveForm(ListingForm $entity)
    {
        $form = $this->createForm(new ListingFormDriveType(), $entity, array(
            'action' => $this->generateUrl('listingform_create_drive'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }

    /**
     * Displays a form to create a new ListingForm entity.
     *
     */
    public function newDriveAction()
    {
        $entity = new ListingForm();
        $form   = $this->createCreateDriveForm($entity);

        return $this->render('NumaDOADMSBundle:ListingForm:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    /**
     * Creates a form to create a ListingForm entity.
     *
     * @param ListingForm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateOfferForm(ListingForm $entity)
    {
        $form = $this->createForm(new ListingFormOfferType(), $entity, array(
            'action' => $this->generateUrl('listingform_create_offer'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ListingForm entity.
     *
     */
    public function newOfferAction()
    {
        $entity = new ListingForm();
        $form   = $this->createCreateOfferForm($entity);

        return $this->render('NumaDOADMSBundle:ListingForm:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ListingForm entity.
     *
     * @param ListingForm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateEpriceForm(ListingForm $entity)
    {
        $form = $this->createForm(new ListingFormEpriceType(), $entity, array(
            'action' => $this->generateUrl('listingform_create_eprice'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ListingForm entity.
     *
     */
    public function newEpriceAction()
    {
        $entity = new ListingForm();
        $form   = $this->createCreateEpriceForm($entity);

        return $this->render('NumaDOADMSBundle:ListingForm:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }



    /**
     * Finds and displays a ListingForm entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:ListingForm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListingForm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:ListingForm:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ListingForm entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:ListingForm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListingForm entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:ListingForm:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ListingForm entity.
    *
    * @param ListingForm $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ListingForm $entity)
    {
        $form = $this->createForm(new ListingFormType(), $entity, array(
            'action' => $this->generateUrl('listingform_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ListingForm entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:ListingForm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListingForm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('listingform_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:ListingForm:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ListingForm entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:ListingForm')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ListingForm entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('listingform'));
    }

    /**
     * Creates a form to delete a ListingForm entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('listingform_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
