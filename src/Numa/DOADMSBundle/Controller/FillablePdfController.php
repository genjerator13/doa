<?php

namespace Numa\DOADMSBundle\Controller;

use Doctrine\ORM\EntityManager;
use Numa\DOADMSBundle\Entity\FillablePdf;
use Numa\DOADMSBundle\Entity\FillablePdfField;
use Numa\DOADMSBundle\Entity\Media;
use Numa\DOADMSBundle\Form\FillablePdfType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\DealerComponent;
use Numa\DOADMSBundle\Form\DealerComponentType;
use Numa\DOAModuleBundle\Entity\Component;

/**
 * DealerComponent controller.
 *
 */
class FillablePdfController extends Controller
{

    /**
     * Lists all DealerComponent entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('NumaDOADMSBundle:FillablePdf:index.html.twig');
    }

    /**
     * Creates a new DealerComponent entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DealerComponent();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('dealercomponent'));

        }

        return $this->render('NumaDOADMSBundle:DealerComponent:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DealerComponent entity.
     *
     * @param DealerComponent $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(FillablePdf $entity)
    {
        $form = $this->createForm(new FillablePdfType(), $entity, array(
            'action' => $this->generateUrl('dealercomponent_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DealerComponent entity.
     *
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();
        $allDocs = $em->getRepository(FillablePdf::class)->findBy(array(), array("id" => "DESC"));


        return $this->render('NumaDOADMSBundle:FillablePdf:new.html.twig', array(
            'docs' => $allDocs,
        ));
    }

    /**
     * Finds and displays a DealerComponent entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:DealerComponent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DealerComponent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOADMSBundle:DealerComponent:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DealerComponent entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository(FillablePdf::class)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DealerComponent entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid() && $editForm->isSubmitted()) {
            $em->flush();
            return $this->redirect($this->generateUrl('fillable_pdf_new'));
        }
        return $this->render("@NumaDOADMS/FillablePdf/edit.html.twig", array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a DealerComponent entity.
     *
     * @param DealerComponent $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(FillablePdf $entity)
    {

        $fillablePdfForm = new FillablePdfType();

        $form = $this->createForm($fillablePdfForm, $entity, array(
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing DealerComponent entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOADMSBundle:DealerComponent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DealerComponent entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $em->flush();
            $this->container->get('mymemcache')->deleteDealerCache($entity->getDealer());
            return $this->redirect($this->generateUrl('dealercomponent_edit', array('id' => $id)));
        }

        return $this->render('NumaDOADMSBundle:DealerComponent:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ));
    }

    public function deleteAction(Request $request)
    {

        $rids = $request->request->all();
        $ids = array();

        foreach ($rids as $idx) {
            $ids[] = $idx;

        }

        $em = $this->getDoctrine()->getManager();
        foreach ($ids as $id) {
            $fillablePdf = $em->getRepository(FillablePdf::class)->find($id);
            if($fillablePdf instanceof FillablePdf) {
                $this->get('numa.dms.media')->deleteFillablePdf($fillablePdf);
            }

        }
        die();
    }


    public function mappingAction(Request $request,FillablePdf $fillablePdf){
        $em = $this->getDoctrine()->getManager();
        $this->get('numa.dms.media')->parseFillablePdf($fillablePdf);
        $fillablePdfFields = $em->getRepository(FillablePdfField::class)->findBy(array('FillablePdf'=>$fillablePdf));
        return $this->render('NumaDOADMSBundle:FillablePdf:mapping.html.twig', array(
            'fields' => $fillablePdfFields,
            'entity' => $fillablePdf,

        ));

    }
    /**
     * Creates a form to delete a DealerComponent entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dealercomponent_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }


    /**
     * uploads images and store  a ImageCarousel entity.
     *
     */
    public function uploadAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $files = $request->files->all();
        foreach ($files as $index => $file) {


            if ($file instanceof UploadedFile && $file->isValid()) {
                $media = new Media();
                $fileContent = file_get_contents($file->getPathname());
                $media->setContent(base64_encode($fileContent));
                $media->setName($file->getClientOriginalName());
                $media->setMimetype($file->getClientMimeType());
                $media->getOrigin("fillable_pdf");
                $fillablePdf = new FillablePdf();
                $fillablePdf->setMedia($media);
                $fillablePdf->setName($file->getClientOriginalName());
                $em->persist($media);
                $em->persist($fillablePdf);
                $em->flush();

            }
        }
        $res = array("message" => "success");
        return new JsonResponse($res);

    }


    public function refreshAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $allDocs = $em->getRepository(FillablePdf::class)->findBy(array(), array("id" => "DESC"));

        return $this->render('NumaDOADMSBundle:FillablePdf:fillable_pdf_list.html.twig', array(
            'docs' => $allDocs,

        ));

    }

    public function saveFieldAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $params = $request->request->all();
        $fillablePdfFieldId = $params['fillable_field_id'];
        $billingName = $params['billing_field_name'];
        $fillablePdfField = $em->getRepository(FillablePdfField::class)->find($fillablePdfFieldId);
        $fillablePdfField->setBillingFieldName($billingName);
        $em->flush();
        die();
    }
}
