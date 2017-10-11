<?php

namespace Numa\CCCAdminBundle\Controller;


use Numa\CCCAdminBundle\Entity\Customers;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\CCCAdminBundle\Entity\Probills;
use Numa\CCCAdminBundle\Form\ProbillsType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Adapter\ArrayAdapter;
use Ps\PdfBundle\Annotation\Pdf;

/**
 * Probills controller.
 *
 */
class ProbillsController extends Controller {

    /**
     * Lists all Probills entities.
     *
     */
    public function indexAction(Request $request) {
        $formSubmit = false;
        $custcode = $request->get('custcode');
        //$batchid = intval($request->get('batchid'));
        $batchid = 0;
        $searchText = "";
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('NumaCCCAdminBundle:Probills');///??
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cc="";
        if($user instanceof Customers) {
            $cc = $user->getCustcode();
        }

        $searchForm = $this->createSearchForm();
        $searchForm->handleRequest($request);
        
        if ($searchForm->isValid()) {
            $data = $searchForm->getData();
            $searchText = $data['text'];
            $batchid = $data['batch'];  
            $formSubmit = true;
        }
        
        if (!empty($custcode)) {
            $cc = $custcode;
        }
        $securityContext = $this->container->get('security.authorization_checker');
        //dump($securityContext->isGranted("ROLE_SUPER_ADMIN"));die();
        if ($securityContext->isGranted("ROLE_SUPER_ADMIN") || $securityContext->isGranted("ROLE_OCR") ) {
            $query = $repository->findAllByBatch($batchid, $searchText);
        } else {
            $query = $repository->findAllByCustomer($user, $batchid, $searchText);
        }

        $batches = $this->getDoctrine()->getRepository('NumaCCCAdminBundle:batchx')->findAll();
        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($query));
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



        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('NumaCCCAdminBundle:Probills:index.html.twig', array(
                    'batches' => $batches,
                    'formSubmit' => $formSubmit,
                    'pagerfanta' => $pagerfanta,
                    'custcode' => $cc,
                    'searchForm' => $searchForm->createView(),
        ));

        //$entities = $query->getResult();
        //$entities = $em->getRepository('NumaCCCAdminBundle:Probills')->findBy(array('customersId' => '1536'));
    }

    /**
     * Creates a form to search, filter Probills
     *
     * @param Probills $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSearchForm() {
        $data = array();
        $em = $this->getDoctrine()->getManager();
        $batches = $this->getDoctrine()->getRepository('NumaCCCAdminBundle:batchx')->findAll();
        foreach ($batches as $key => $batch) {
            $from = "";
            if($batch->getStarted() instanceof \DateTime){
                $from = $batch->getStarted()->format('d/m/Y');
            }
            
            $to = "";
            if($batch->getClosed() instanceof \DateTime){
                $to = $batch->getClosed()->format('d/m/Y');
            }
            $data[$batch->getId()] = $from
                    ." - ". $to;
        }
        dump($data);die();
        $form = $this->createFormBuilder($data)
                ->setAction($this->generateUrl('probills'))
                ->setMethod("GET")
                ->setAttribute('class', 'form-inline')
                ->add('batch', ChoiceType::class,array('choices'=>$data, 'label'=>'Batch','required'=>false,'empty_data'=>'All'))
                ->add('text', TextType::class ,array('label'=>'Waybill','required'=>false))
                ->add('submit', SubmitType::class,array('label'=>'Search','attr'=>array('class'=>"btn btn-primary")))
                ->getForm();

        return $form;
    }

    /**
     * Creates a new Probills entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Probills();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('probills_show', array('id' => $entity->getId())));
        }

        return $this->render('NumaCCCAdminBundle:Probills:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Probills entity.
     *
     * @param Probills $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Probills $entity) {
        $form = $this->createForm(new ProbillsType(), $entity, array(
            'action' => $this->generateUrl('probills_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Probills entity.
     *
     */
    public function newAction() {
        $entity = new Probills();
        $form = $this->createCreateForm($entity);

        return $this->render('NumaCCCAdminBundle:Probills:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Probills entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:Probills')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Probills entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaCCCAdminBundle:Probills:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Finds and displays a Probills entity.
     *
     */
    public function scanAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:Probills')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Probills entity.');
        }

        $upload_url = $this->container->getParameter('scans_url');
        $batch = $em->getRepository('NumaCCCAdminBundle:BatchX')->find($entity->getBatchId());
//        //$batch = $entity->getBatchX();
//        dump($entity->getBatchId());
//        dump($batch->getClosed());die();
        //$dir = strtoupper($batch->getClosed()->format('Md-Y'));
        $image_src = $upload_url . "/" .$batch->getScansFolder()."/" . $entity->getWaybill() . ".jpg";

        return $this->render('NumaCCCAdminBundle:Probills:scan.html.twig', array(
                    'image_src' => $image_src));
    }

    /**
     * Displays a form to edit an existing Probills scan .
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:Probills')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Probills entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaCCCAdminBundle:Probills:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Probills entity.
     *
     * @param Probills $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Probills $entity) {
        $form = $this->createForm(new ProbillsType(), $entity, array(
            'action' => $this->generateUrl('probills_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Probills entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:Probills')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Probills entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('probills_edit', array('id' => $id)));
        }

        return $this->render('NumaCCCAdminBundle:Probills:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Probills entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaCCCAdminBundle:Probills')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Probills entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('probills'));
    }

    /**
     * 
     *
     */
    public function singleReportAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $probill = $em->getRepository('NumaCCCAdminBundle:Probills')->find($id);
        $customer = $this->get('security.token_storage')->getToken()->getUser();
        $path = $this->get('kernel')->getRootDir() . "/../web/";
        if (!$probill) {
            throw $this->createNotFoundException('Unable to find Probills entity.');
        }

        $html = $this->renderView(
                'NumaCCCAdminBundle:Probills:fullReport.pdf.twig', array(
            'probills' => $probill,
            'customer' => $customer,
            'path' => $path,
                )
        );

        return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
            'Content-Type' => 'application/pdf',
                //'Content-Disposition' => 'attachment; filename="' . $entity->getWaybill() . "_" . $entity->getCreatedAt() . '.pdf"'
                )
        );
    }

//    public function fullReportAction(Request $request) {
//        $cc = $request->get('custcode');
//        $cc = preg_replace("/[^a-zA-Z0-9]+/", "", $cc);
//
//        $em = $this->getDoctrine()->getManager();
//        //get all probills for the customer
//        $customer = $em->getRepository('NumaCCCAdminBundle:Customers')->findOneBy(array('custcode' => $cc));
//        if (!$customer) {
//            throw $this->createNotFoundException('Unable to find such customer.');
//        }
//        $path = $this->get('kernel')->getRootDir() . "/../web/";
//        if ($this->container->has('profiler')) {
//            $this->container->get('profiler')->disable();
//        }
//        $probills = $em->getRepository('NumaCCCAdminBundle:Probills')->findAllByCustomer($customer);
//        $totals = $em->getRepository('NumaCCCAdminBundle:Probills')->getTotals($probills);
//        $html = $this->renderView(
//                'NumaCCCAdminBundle:Probills:fullReport.pdf.twig', array(
//            'probills' => $totals,
//            'customer' => $customer,
//            'path' => $path,
//                )
//        );
//
//        return new Response(
//                $this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
//            'Content-Type' => 'application/pdf',
//                //'Content-Disposition' => 'attachment; filename="'.$customer->getCustCode().'.pdf"'
//                )
//        );
//    }
//
//    public function batchReportAction(Request $request, $batchid) {
//        $em = $this->getDoctrine()->getManager();
//        //get all probills for the customer
//
//        $path = $this->get('kernel')->getRootDir() . "/../web/";
//
//
//        //if admin only
//        $user = $this->get('security.context')->getToken()->getUser();
//
//        if ($user->getIsAdmin()) {
//            $customers = $em->getRepository('NumaCCCAdminBundle:Probills')->findAllCustomersInBatch($batchid);
//        } else {
//            $customers = $user;
//        }
//        //die(count($customers)."::::");
//        $html = $this->renderView(
//                'NumaCCCAdminBundle:reports:headerPdf.pdf.twig', array(
//            'path' => $path
//                )
//        );
//
//        foreach ($customers as $key => $customer) {
//
//
//            $probills = $em->getRepository('NumaCCCAdminBundle:Probills')->findAllByCustomer($customer);
//            $totals = $em->getRepository('NumaCCCAdminBundle:Probills')->getTotals($probills);
//            dump("batchReportAction");die();
//            $batch = $em->getRepository('NumaCCCAdminBundle:batchX')->find($batchid);
//            $html .= $this->renderView(
//                    'NumaCCCAdminBundle:reports:fullReportContent.pdf.twig', array(
//                'probills' => $totals,
//                'customer' => $customer,
//                'batch' => $batch,
//                'path' => $path,
//                    )
//            );
//        }
//        $html .= $this->renderView(
//                'NumaCCCAdminBundle:reports:footerPdf.pdf.twig'
//        );
//
//        return new Response($html);
//
//        /*
//          return new Response(
//          $this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
//          'Content-Type' => 'application/pdf',
//          //'Content-Disposition' => 'attachment; filename="'.$customer->getCustCode().'.pdf"'
//          )
//          );
//         * 
//         */
//    }

    /**
     * Creates a form to delete a Probills entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('probills_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
