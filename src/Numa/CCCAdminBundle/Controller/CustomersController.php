<?php

namespace Numa\CCCAdminBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\CCCAdminBundle\Entity\Customers;
use Numa\CCCAdminBundle\Form\CustomersType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

/**
 * Customers controller.
 *
 */
class CustomersController extends Controller
{

    /**
     * Lists all Customers entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $searchForm = $this->createFormBuilder()
            //->setAction($this->generateUrl('customers'))
            ->setMethod("GET")
            //->setAttribute('class', 'form-inline')

            ->add('text', TextType::class, array('label' => '', 'required' => false))
            ->add('submit', SubmitType::class, array('label' => 'Filter', 'attr' => array('class' => "btn btn-primary")))
            ->getForm();
        $searchForm->handleRequest($request);


        $qb = $em->createQueryBuilder('qb1');
        $qb->add('select', 'c, ce')
            ->add('from', 'NumaCCCAdminBundle:Customers c')
            ->leftJoin('c.CustomerEmails', 'ce')
            ->andWhere('(c.isAdmin is null OR c.isAdmin=0) ') //AND (c.activate IS NULL OR c.activate=1)
            ->orderBy('c.custcode');
        if ($searchForm->isValid()) {
            $dataSearch = $searchForm->getData();
            //dump($dataSearch['text']);die();
            $qb->andWhere('c.custcode like :custcode');
            $qb->setParameter(':custcode', "%" . $dataSearch['text'] . "%");
        }
        $query = $qb->getQuery();
        $entities = $query->getResult();

        $adapter = new ArrayAdapter($entities);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(15);
        $page = $request->get('page');
        if (!$page) {
            $page = 1;
        }

        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('NumaCCCAdminBundle:Customers:index.html.twig', array(
            'entities' => $entities,
            'pagerfanta' => $pagerfanta,
            'searchForm' => $searchForm->createView()
        ));
    }

    /**
     * Creates a new Customers entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Customers();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            // encode the password
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($entity);
            $encodedPassword = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
            $entity->setPassword($encodedPassword);
            $em->flush();
            $this > $this->addFlash("success", "Customer " . $entity->getCustcode() . " Created");
            return $this->redirect($this->generateUrl('customers', array('id' => $entity->getId())));
        }

        return $this->render('NumaCCCAdminBundle:Customers:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Customers entity.
     *
     * @param Customers $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Customers $entity)
    {
        $form = $this->createForm(new CustomersType(), $entity, array(
            'action' => $this->generateUrl('customers_create'),
            'method' => 'POST',
        ));

        $form->add('submit',  SubmitType::class, array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Customers entity.
     *
     */
    public function newAction()
    {
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
    public function showAction($id)
    {
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
    public function editAction($id)
    {
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
    private function createEditForm(Customers $entity)
    {
        $form = $this->createForm(CustomersType::class, $entity, array(
            'action' => $this->generateUrl('customers_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit',  SubmitType::class, array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Customers entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:Customers')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customers entity.');
        }
        $originalPassword = $entity->getPassword();
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if($editForm->getClickedButton()->getName()=='delete_rate'){

            }
            $plainPassword = $editForm->get('password')->getData();

            if($editForm->getClickedButton()->getName()=='delete_rate'){
                $entity->setRatePdf(null);
                $entity->setRatePdfFile(null);
            }else{
                $entity->upload();
            }
            ////
            if (!empty($plainPassword)) {
                // encode the password
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($entity);
                $encodedPassword = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
                $entity->setPassword($encodedPassword);

            } else {

                $entity->setPassword($originalPassword);
            }

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
    public function deleteAction(Request $request, $id)
    {
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
     * Deletes a Customers entity.
     *
     */
    public function activateAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaCCCAdminBundle:Customers')->find($id);
        $activate = $request->attributes->get('activate');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customers entity.');
        }
        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            throw $this->createAccessDeniedException('Unable to activate / deactivate the customer');
        }
        $entity->setActivate($activate);
        $em->flush();
        $text = "deactivated";
        if($activate){
            $text = "activated";
        }
        $this > $this->addFlash("success", "Customer " . $entity->getCustcode() . " is ".$text);


        return $this->redirect($this->generateUrl('customers'));
    }

    /**
     * Creates a form to delete a Customers entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('customers_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit',  SubmitType::class, array('label' => 'Delete'))
            ->getForm();
    }
}
