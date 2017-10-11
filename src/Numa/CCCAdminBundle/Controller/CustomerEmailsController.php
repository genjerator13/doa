<?php

namespace Numa\CCCAdminBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\CCCAdminBundle\Entity\Customers;
use Numa\CCCAdminBundle\Entity\CustomerEmails;
use Numa\CCCAdminBundle\Form\CustomersType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

/**
 * CustomerEmails controller.
 *
 */
class CustomerEmailsController extends Controller {

    /**
     * Lists all Customers entities.
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $formSubmit=false;
        $searchForm = $this->createFormBuilder()
                ->setAttributes(array("id"=>"cust_filter"))
                ->setMethod("GET")
                //->setAttribute('class', 'form-inline')
                
                ->add('text', TextType::class,array('label'=>'Customer','required'=>false))
                ->add('submit', SubmitType::class,array('label'=>'Search','attr'=>array('class'=>"btn btn-primary")))
                ->getForm();
        $searchForm->handleRequest($request);
        
        
        $qb = $em->createQueryBuilder('qb1');
        $qb->add('select', 'c, ce')
                ->add('from', 'NumaCCCAdminBundle:Customers c')
                ->leftJoin('c.CustomerEmails', 'ce')
                ->where('c.isAdmin is null OR c.isAdmin=0');
                ;
        if ($searchForm->isValid()) {
            $dataSearch = $searchForm->getData();
            //dump($dataSearch['text']);die();
            $qb->andWhere('c.custcode like :name');
            $qb->setParameter(':name', "%".$dataSearch['text']."%");
//            $qb->orWhere('c.username like :username');
//            $qb->setParameter(':username', "%".$dataSearch['text']."%");
            $formSubmit = true;
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
        $emailEditForm = $this->createFormBuilder(array(), array('attr' => array('id' => 'email_edit')));
        for ($i = 1; $i <= 10; $i++) {
            $emailEditForm->add('email' . "_" . $i, 'email');
            $emailEditForm->add('selected'. "_" . $i, 'checkbox',array('label'=>'Selected'));
            
        }
        $emailEditForm->add('customer_id', 'hidden');
        $emailEditForm = $emailEditForm->getForm();
        $emailEditForm->handleRequest($request);
        if ($emailEditForm->isSubmitted()) {
            // data is an array with "name", "email", and "message" keys
            $data = $emailEditForm->getData();
            $i = 1;
            

//            if (!empty($data['email_1']) && !empty($data['customer_id'])) {
//                $customer = $em->getRepository('NumaCCCAdminBundle:Customers')->find($data['customer_id']);
//                $customer->setEmail($data['email_1']);
//                
//                $em->flush();
//                //find a customer by $data['customer_id']
//                //set $data['email_1'] as email                
//            }
            if (!empty($data['customer_id'])) {
                //delete all customer_emails customer_id=$data['customer_id']
                //$customerEmails = $em->getRepository('NumaCCCAdminBundle:CustomerEmails')->findBy(array('customerId', $data['customer_id']));
                $customer = $em->getRepository('NumaCCCAdminBundle:Customers')->find($data['customer_id']);
                $qb = $em->createQueryBuilder();
                $qb->delete('NumaCCCAdminBundle:CustomerEmails', 'cs');
                $qb->andWhere('cs.Customers=:customer');
                $qb->setParameter(':customer', $customer);
                $qb->getQuery()->execute();
                $em->flush();
                
                for ($i = 1; $i <= 10; $i++) {
                    if (!empty($data['email_' . $i])) {
                        $customerEmails = new \Numa\CCCAdminBundle\Entity\CustomerEmails();                        
                        $customerEmails->setCustomers($customer);
                        $customerEmails->setEmail($data['email_' . $i]);
                        $customerEmails->setSelected($data['selected_' . $i]);
                        $em->persist($customerEmails);
                        //dump($data['customer_id']);die();
                    }
                }
                $em->flush();
                return $this->redirect($this->getRequest()->headers->get('referer'));
            }

            //return to refferesr
        }
        return $this->render('NumaCCCAdminBundle:CustomerEmails:index.html.twig', array(
            'entities' => $entities,
            'pagerfanta' => $pagerfanta,
            'emailEditForm' => $emailEditForm->createView(),
            'searchForm' => $searchForm->createView(),
            'formSubmit' => $formSubmit
        ));
    }

    /**
     * Creates a new Customers entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Customers();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('customers_show', array('id' => $entity->getId())));
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
    private function createCreateForm(Customers $entity) {
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
    public function newAction() {
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
    public function showAction($id) {
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
    public function editAction($id) {
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
    private function createEditForm(Customers $entity) {
        $form = $this->createForm(new CustomersType(), $entity, array(
            'action' => $this->generateUrl('customers_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Customers entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:Customers')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customers entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
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
    public function deleteAction(Request $request, $id) {
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
     * Creates a form to delete a Customers entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('customers_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit',  SubmitType::class, array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
