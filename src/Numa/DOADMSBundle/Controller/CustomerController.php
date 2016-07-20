<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Form\CustomerType;
use Guzzle\Http\Client;

/**
 * Customer controller.
 *
 */
class CustomerController extends Controller
{

    /**
     * Lists all Customer entities.
     *
     */
    public function indexAction()
    {
        return $this->render('NumaDOADMSBundle:Customer:index.html.twig');
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
            $entity->upload();

            $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
            $entity->setCatalogrecords($dealer);

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('customer', array('id' => $entity->getId())));
        }

        return $this->render('NumaDOADMSBundle:Customer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
        $form   = $this->createCreateForm($entity);

        return $this->render('NumaDOADMSBundle:Customer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
            'entity'      => $entity,
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
        $baseurl = $this->container->get('router')->getContext()->getScheme()."://".$this->container->get('router')->getContext()->getHost();
        $client = new Client($baseurl);

        //getResponse
        $response = $client->get('/api/customer/'.$id)->send();

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
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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
            $this->addFlash("success","Customer: ".$entity->getName()." successfully updated.");
            return $this->redirect($this->generateUrl('customer', array('id' => $id)));
        }

        return $this->render('NumaDOAAdminBundle:Customer:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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

        if (count($form->getErrors(true)==0)) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOADMSBundle:Customer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Customer entity.');
            }

            $em->remove($entity);
            $em->flush();

        }else{

            foreach($form->getErrors(true) as $error){
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
            ->getForm()
        ;
    }


    public function reportXlsAction(Request $request,$id)
    {
        // ask the service for a Excel5
        ///pdf renderer
        $format =         // ask the service for a Excel5
            ///pdf renderer
            //$format = $request->attributes->get('format');
            //die();
        $rendererName = \PHPExcel_Settings::PDF_RENDERER_MPDF;
        $rendererLibrary = 'mPDF';
        $rendererLibraryPath = (dirname(__FILE__) . '/../../../../vendor/mpdf/mpdf'); //works

        if (!\PHPExcel_Settings::setPdfRenderer(
            $rendererName, $rendererLibraryPath
        )) {
            die(
                'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
                '<br />' .
                'at the top of this script as appropriate for your directory structure'
            );
        }
        //disable profiler
        if ($this->has('profiler')) {
            $this->get('profiler')->disable();
        }
        $em = $this->getDoctrine()->getManager();

        $download_path = $this->getParameter('upload_dealer');
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($download_path . 'billing_report.xls');
        //dump($phpExcelObject);
        $phpExcelObject->getProperties()->setCreator("DOA")
            ->setLastModifiedBy("DOA")
            ->setTitle("DOA billing report")
            ->setSubject("DOA billing report")
            ->setDescription("DOA billing report")
        ;
        $phpExcelObject->setActiveSheetIndex(0);


        $currentRow = 7;
        //$phpExcelObject->getActiveSheet()->setCellValue("B" . $currentRow, $dispatchCards->getDateorder() instanceof \DateTime ? $dispatchCards->getDateorder()->format('m/d/Y') : "");
        $phpExcelObject->getActiveSheet()->setCellValue("K" . $currentRow, "aaaa");
        $currentRow++;

        // adding headers
        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=stream-file.xls');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        $writer->save($download_path . 'CustomerDetailsReport_' . "test" . '.xls');

        return $response;

    }

}
