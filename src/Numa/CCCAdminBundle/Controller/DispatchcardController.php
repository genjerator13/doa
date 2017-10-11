<?php

namespace Numa\CCCAdminBundle\Controller;

use Numa\CCCAdminBundle\Entity\Customers;
use Numa\CCCAdminBundle\Entity\Destination;
use Numa\CCCAdminBundle\Entity\Vehtypes;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\CCCAdminBundle\Entity\Dispatchcard;
use Numa\CCCAdminBundle\Form\DispatchcardType;

/**
 * Dispatchcard controller.
 *
 */
class DispatchcardController extends Controller
{

    /**
     * Lists all Dispatchcard entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $customer = $this->get('security.token_storage')->getToken()->getUser(); //get logged customer
        $entities = $em->getRepository('NumaCCCAdminBundle:Dispatchcard')->findLast($customer);
        $page = $request->get('page');
        if (!$page) {
            $page = 1;
        }

        $adapter = new ArrayAdapter($entities);
        $pagerfanta = new Pagerfanta($adapter);
        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }
        if ($customer instanceof Customers) {
            $entities = $em->getRepository('NumaCCCAdminBundle:Dispatchcard')->findBy(array('Customer' => $customer), array('id' => 'DESC'),75);

        }


        return $this->render('NumaCCCAdminBundle:Dispatchcard:index.html.twig', array(
            'entities' => $entities,
            'pagerfanta' =>$pagerfanta,
            'page'=>$page
        ));
    }

    /**
     * Creates a new Dispatchcard entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Dispatchcard();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $onetoone = false;
        $origins = $entity->getOrigin();
        $destinations = $entity->getDestination();
        if ($origins->count() == 1 && $destinations->count() == 1) {
            $onetoone = true;

        }
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();


            if (!$this->get('security.authorization_checker')->isGranted("ROLE_OCR")) {
                $customer = $this->get('security.token_storage')->getToken()->getUser(); //get logged customer
                $entity->setCustomer($customer);
            }

            $origins = $entity->getOrigin();
            $destinations = $entity->getDestination();
            if ($origins->count() > 0 && $destinations->count() > 0) {

                if ($origins->count() == 1 && $destinations->count() == 1) {
                    //1to1
                    $onetoone = true;
                    $dc = clone $entity;
                    $dc->addOrigin($origins->first());
                    $dc->addDestination($destinations->first());
                    $dest = $destinations->first();
                    $dest->setDispatchcard($dc);
                    if($dest instanceof Destination) {
                        if (!$dest->getVehicleType() instanceof Vehtypes) {
                            $dest->setVehicleType($origins->first()->getVehicleType());
                            $dest->setPieces($origins->first()->getPieces());
                            $dest->setWeight($origins->first()->getWeight());
                            $dest->setCodAmount($origins->first()->getCodAmount());
                            $dest->setComments($origins->first()->getComments());
                        }
                    }
                    $em->persist($dc);
                } elseif ($origins->count() > 1) {
                    //multi origins
                    foreach ($origins as $key => $origin) {
                        $dc = new Dispatchcard();
                        $dc = clone $entity;
                        $dc->addOrigin($origin);
                        $dest = clone $destinations->first();
                        $dest->setVehicleType($origin->getVehicleType());
                        $dest->setPo($origin->getPo());
                        $dest->setComments($origin->getComments());
                        $dest->setCodAmount($origin->getCodAmount());
                        $dest->setWeight($origin->getWeight());
                        $dest->setPieces($origin->getPieces());

                        $dest->setDispatchcard($dc);
                        $dc->addDestination($dest);
                        $em->persist($dc);
                    }
                } elseif ($destinations->count() > 1) {
                    //multi destinations
                    foreach ($destinations as $key => $destination) {
                        $dc = new Dispatchcard();
                        $dc = clone $entity;

                        $dc->addDestination($destination);
                        $destination->setDispatchcard($dc);

                        $orgn = clone $origins->first();
                        $dc->addOrigin($orgn);
                        $orgn->setDispatchcard($dc);

                        $em->persist($dc);
                    }
                }
            }
            $em->flush();
        } else {


            $this->addFlash("danger", "There has been error on the form please check all the fields if correct values are entered.<br><a href='javascript: history.go(-1)'>Back to Form</a> ");
            $em = $this->getDoctrine()->getManager();


            if ($onetoone) {
                $customer_names = $em->getRepository('NumaCCCAdminBundle:Customers')->getAllCustomerNamesArray('name');
                $customer_codes = $em->getRepository('NumaCCCAdminBundle:Customers')->getAllCustomerNamesArray('custcode');

                return $this->render($this->getTemplate(), array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'onetoone' => true,
                    'multiO' => false,
                    'multiD' => false,
                    "customer_names" => $customer_names,
                    "customer_codes" => $customer_codes,
                ));
            }
        }

        $params = $request->request->all();
        $this->addFlash("success","Dispatch card successfully created!");
        if(isset($params['save_multi_origin'])){
            //dump($this->generateUrl('dispatchcard_new',array('typed'=>'multiD')));die();
            return $this->redirect($this->generateUrl('dispatchcard_new',array('typed'=>'multiO')));
        }
        if(isset($params['save_multi_dest'])){
            //dump($this->generateUrl('dispatchcard_new',array('typed'=>'multiD')));die();
            return $this->redirect($this->generateUrl('dispatchcard_new',array('typed'=>'multiD')));
        }
        return $this->redirect($this->generateUrl('dispatchcard'));
    }


    /**
     * Creates a form to create a Dispatchcard entity.
     *
     * @param Dispatchcard $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Dispatchcard $entity)
    {

        $form = $this->createForm(DispatchcardType::class, $entity, array(
            'action' => $this->generateUrl('dispatchcard_create'),
            'method' => 'POST',
            'attr'   => array("id"=>"dispatchform")
        ));
        return $form;
    }

    /**
     * Displays a form to create a new Dispatchcard entity.
     *
     */
    public function newAction(Request $request)
    {
        $dispatchCard = new Dispatchcard();
        $origin = new \Numa\CCCAdminBundle\Entity\Origin();
        $origin->setDispatchcard($dispatchCard);

        $destination = new \Numa\CCCAdminBundle\Entity\Destination();
        $destination->setDispatchcard($dispatchCard);
        $dispatchCard->getDestination()->add($destination);
        $dispatchCard->getOrigin()->add($origin);

        $typed = $request->query->get('typed');
        $onetoone = false;
        $multiO = false;
        $multiD = false;
        if ($typed == '1to1') {
            $onetoone = true;
        } elseif ($typed == 'multiO') {
            $multiO = true;
        } elseif ($typed == 'multiD') {
            $multiD = true;
        } else {
            $onetoone = true;
        }

        $form = $this->createCreateForm($dispatchCard);
        $em = $this->getDoctrine()->getManager();
        $customer_names = $em->getRepository('NumaCCCAdminBundle:Customers')->getAllCustomerNamesArray('name');
        $customer_codes = $em->getRepository('NumaCCCAdminBundle:Customers')->getAllCustomerNamesArray('custcode');


        return $this->render($this->getTemplate(), array(
            'entity' => $dispatchCard,
            'form' => $form->createView(),
            'onetoone' => $onetoone,
            'multiO' => $multiO,
            'multiD' => $multiD,
            "customer_names" => $customer_names,
            "customer_codes" => $customer_codes,
        ));
    }

    /**
     * Finds and displays a Dispatchcard entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:Dispatchcard')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dispatchcard entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaCCCAdminBundle:Dispatchcard:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Dispatchcard entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:Dispatchcard')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dispatchcard entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaCCCAdminBundle:Dispatchcard:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Dispatchcard entity.
     *
     * @param Dispatchcard $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Dispatchcard $entity)
    {
        $form = $this->createForm(new DispatchcardType(), $entity, array(
            'action' => $this->generateUrl('dispatchcard_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Dispatchcard entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:Dispatchcard')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dispatchcard entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('dispatchcard_edit', array('id' => $id)));
        }

        return $this->render('NumaCCCAdminBundle:Dispatchcard:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Dispatchcard entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaCCCAdminBundle:Dispatchcard')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Dispatchcard entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('dispatchcard'));
    }

    /**
     * Creates a form to delete a Dispatchcard entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dispatchcard_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    private function isCSRUser(){
        return $this->get('security.authorization_checker')->isGranted("ROLE_OCR");
    }

    private function getTemplate(){
        $template = "new.html.twig";
        if($this->isCSRUser()){
            $template = "new_csr.html.twig";
        }
        return "NumaCCCAdminBundle:Dispatchcard:".$template;

    }

}
