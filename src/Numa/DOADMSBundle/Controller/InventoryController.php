<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Item;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Form\CustomerType;
use Guzzle\Http\Client;

/**
 * Customer controller.
 *
 */
class InventoryController extends Controller
{

    /**
     * Lists all Customer entities.
     *
     */
    public function indexAction(Request $request)
    {
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $dealerPrincipal = $this->get('Numa.Dms.User')->getSignedDealerPrincipal();
        $qbo = $this->container->get("numa.quickbooks")->init();

        return $this->render('NumaDOADMSBundle:Inventory:index.html.twig', array(
            'dealer' => $dealer,
            'dealerPrincipal' => $dealerPrincipal,
            'qbo' => $qbo,
        ));
    }

    /**
     * Lists all Customer entities.
     *
     */
    public function viewAction()
    {
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $js = "view";
        return $this->render('NumaDOADMSBundle:Inventory:index.html.twig', array(
            'js' => $js,
            'dealer' => $dealer
        ));
    }

    /**
     * Lists all Customer entities.
     *
     */
    public function costAction()
    {
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $js = "cost";
        return $this->render('NumaDOADMSBundle:Inventory:index.html.twig', array(
            'js' => $js,
            'dealer' => $dealer
        ));
    }

    /**
     * Lists all Customer entities.
     *
     */
    public function salesAction()
    {
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $js = "sales";
        return $this->render('NumaDOADMSBundle:Inventory:index.html.twig', array(
            'js' => $js,
            'dealer' => $dealer
        ));
    }

    /**
     * Lists all listings for kijiji
     *
     */
    public function kijijiAction()
    {
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $js = "kijiji";
        return $this->render('NumaDOADMSBundle:Inventory:index.html.twig', array(
            'js' => $js,
            'dealer' => $dealer
        ));
    }

    /**
     * Lists all Customer entities.
     *
     */
    public function archivedAction()
    {
        $dealer = $this->get('Numa.Dms.User')->getAvailableDealersIds();
        return $this->render('NumaDOADMSBundle:Inventory:indexArchive.html.twig', array(
            'dealer' => $dealer
        ));
    }

    /**
     * Creates a new Customer entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Customer();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('customer', array('id' => $entity->getId())));
        }

        return $this->render('NumaDOADMSBundle:Customer:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Customer entity.
     *
     * @param Customer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Customer $entity)
    {
        $form = $this->createForm(new CustomerType(), $entity, array(
            'action' => $this->generateUrl('customer_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Customer entity.
     *
     */
    public function newAction()
    {
        $entity = new Customer();
        $form = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:Customer:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Customer entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:Customer:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Customer entity.
     *
     */
    public function editAction($id)
    {
        //getserializer
        $serializer = $this->get('jms_serializer');
        //create api client
        $baseurl = $this->container->get('router')->getContext()->getScheme() . "://" . $this->container->get('router')->getContext()->getHost();
        $client = new Client($baseurl);

        //getResponse
        $response = $client->get('/api/customer/' . $id)->send();

        //deserialize response
        $entity = $serializer->deserialize(json_encode($response->json()), 'Numa\DOADMSBundle\Entity\Customer', 'json');
        $em = $this->getDoctrine()->getManager();
        //$entity = $em->getRepository('NumaDOADMSBundle:Customer')->find($id);

        //dump($entity);die();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:Customer:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Customer entity.
     *
     * @param Customer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Customer $entity)
    {
        $form = $this->createForm(new CustomerType(), $entity, array(
            'action' => $this->generateUrl('customer_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Customer entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->upload();
            $em->flush();
            $this->addFlash("success", "Customer: " . $entity->getName() . " successfully updated.");
            return $this->redirect($this->generateUrl('customer', array('id' => $id)));
        }

        return $this->render('NumaDOAAdminBundle:Customer:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Customer entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if (count($form->getErrors(true) == 0)) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:Customer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Customer entity.');
            }

            $em->remove($entity);
            $em->flush();

        } else {

            foreach ($form->getErrors(true) as $error) {
                dump($error->getMessage());
            }

        }
        die();
        return $this->redirect($this->generateUrl('customer'));
    }

    /**
     * Creates a form to delete a Customer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('customer_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

}
