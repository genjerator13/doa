<?php

namespace Numa\CCCAdminBundle\Controller;

use Numa\CCCAdminBundle\Entity\Customers;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class PendingProbillsController extends Controller
{
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted(array('ROLE_SUPER_ADMIN'), null, 'Access Denied!');

        $form = $this->createFormBuilder(null, $options = array('csrf_protection' => false))
            ->add('s3db', FileType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $data = $form->getData();
            $file = $data['s3db'];

            if ($file instanceof UploadedFile) {
                $pending = $this->container->getParameter('pending');

                $uploadedFile = $file->move($pending, $file->getClientOriginalName());
                //$this->proccessPendingProbillsAction($request, $file->getClientOriginalName());
                $url = $this->generateUrl('pending_proccess',array("pendingFilename"=>$file->getClientOriginalName()),true);

                $data = array('status' => 1, 'url' => $url);
                return new \Symfony\Component\HttpFoundation\JsonResponse($data);
            }
            //dump($file);die();
        }


        return $this->render('NumaCCCAdminBundle:PendingProbills:new.html.twig', array(

            'form' => $form->createView(),
        ));
    }

    public function progressAction(){
        $filename = $this->container->getParameter('log') . "progress_pending.txt";

        $contents = "";
        if (file_exists($filename)) {
            $fp = fopen($filename, 'r');


            $contents = fread($fp, filesize($filename));
        }
        $response = new \Symfony\Component\HttpFoundation\JsonResponse(json_decode($contents));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function uploadScansAction(Request $request) {

        $this->denyAccessUnlessGranted(array('ROLE_SUPER_ADMIN'), null, 'Access Denied!');
        $form = $this->createFormBuilder(null, $options = array('csrf_protection' => false))
            ->add('scans', FileType::class,array('multiple'=>true))
            ->add('send', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $files = $data['scans'];

            foreach($files as $file) {
                if ($file instanceof UploadedFile) {
                    $pending = $this->container->getParameter('pending_scans_path');
                    $uploadedFile = $file->move($pending, $file->getClientOriginalName());
                }
            }
        }


        return $this->render('NumaCCCAdminBundle:PendingProbills:new.html.twig', array(

            'form' => $form->createView(),
        ));
    }


    /**
     * Lists all Probills entities.
     *
     */
    public function indexAction(Request $request)
    {
        $formSubmit = false;
        $custcode = $request->get('custcode');
        //$batchid = intval($request->get('batchid'));
        $batchid = 0;
        $searchText = "";
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('NumaCCCAdminBundle:PendingProbill');///??
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
            $formSubmit = true;
        }

        if (!empty($custcode)) {
            $cc = $custcode;
        }

        $securityContext = $this->container->get('security.authorization_checker');

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

        return $this->render('NumaCCCAdminBundle:PendingProbills:index.html.twig', array(
            'batches' => $batches,
            'formSubmit' => $formSubmit,
            'pagerfanta' => $pagerfanta,
            'custcode' => $cc,
            'searchForm' => $searchForm->createView(),
        ));

        //$entities = $query->getResult();
        //$entities = $em->getRepository('NumaCCCAdminBundle:Probills')->findBy(array('customersId' => '1536'));
    }

    public function proccessPendingProbillsAction(Request $request, $pendingFilename)
    {
        //$command = 'php ' . $this->get('kernel')->getRootDir() . '/console numa:dbutil fetchFeed ' . $id;
        $command = 'php ' . $this->get('kernel')->getRootDir() . '/console Numa:CCC:pending insert ' . $pendingFilename;
        //$command = 'php ' . $this->get('kernel')->getRootDir() ."/console numa:CCC:users genjerator13 xxx";
        $process = new \Symfony\Component\Process\Process($command);

        $process->start();
        /*
          $process->run(function ($type, $buffer) {
          if (Process::ERR === $type) {
          echo 'ERR > ' . $buffer;
          } else {
          echo 'OUT > ' . $buffer;
          }
          });
         *
         */
        //echo $process->getOutput();
        //die();
        sleep(3);
        $request->getSession()->getFlashBag()
            ->add('success', 'Upload complet. Extracting pending probills from Database File ');
        return $this->redirectToRoute('command_log_home');
    }

    /**
     * Finds and displays a Probills entity.
     *
     */
    public function scanAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:PendingProbill')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pending Probill entity.');
        }

        $upload_url = $this->container->getParameter('pending_scans_url');
        $image_src = $upload_url. $entity->getWaybill() . ".jpg";

        return $this->render('NumaCCCAdminBundle:PendingProbills:pscan.html.twig', array(
            'image_src' => $image_src));
    }

    /**
     * Finds and displays a Probills entity.
     *
     */
    public function deleteAllAction(Request $request) {
        $this->denyAccessUnlessGranted(array('ROLE_SUPER_ADMIN'), null, 'Access Denied!');
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('NumaCCCAdminBundle:PendingProbill')->deleteAll();

        $pending_url = $this->container->getParameter('pending_scans_path');

        foreach(glob("{$pending_url}/*") as $file)
        {
            if(is_dir($file)) {
            } else {

                unlink($file);
            }
        }
        $request->getSession()->getFlashBag()
            ->add('success', 'All Pending Probills and scan images are deleted');
        return $this->redirectToRoute('pendings');
    }

    /**
     * Finds and displays a Probills entity.
     *
     */
    public function pdfAction($id){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        return  $this->get('Numa.Controiller.Reports')->pendingProbillPdf($id);
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
        $form = $this->createFormBuilder($data)
            ->setAction($this->generateUrl('pendings'))
            ->setMethod("GET")
            ->setAttribute('class', 'form-inline')
            ->add('text', TextType::class,array('label'=>'Waybill','required'=>false))
            ->add('submit', SubmitType::class,array('label'=>'Search','attr'=>array('class'=>"btn btn-primary")))
            ->getForm();

        return $form;
    }

}
