<?php

namespace Numa\DOAAdminBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOAAdminBundle\Entity\ImageCarousel;
use Numa\DOAAdminBundle\Form\ImageCarouselType;

/**
 * ImageCarousel controller.
 *
 */
class ImageCarouselController extends Controller
{

    /**
     * Lists all ImageCarousel entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOAAdminBundle:ImageCarousel')->findAll();

        return $this->render('NumaDOAAdminBundle:ImageCarousel:index.html.twig', array(
            'entities' => $entities,
            'addVideoForm' => $this->addVideoForm()->createView()
        ));
    }

    /**
     * Creates a new ImageCarousel entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ImageCarousel();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->upload();
            $em->persist($entity);
            $em->flush();
            $this->addFlash("New image is added to carousel", 'success');
            return $this->redirect($this->generateUrl('imagecarousel'));
        } else {
            dump($form);
        }
        die();

        return $this->render('NumaDOAAdminBundle:ImageCarousel:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ImageCarousel entity.
     *
     * @param ImageCarousel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ImageCarousel $entity)
    {
        $form = $this->createForm(new ImageCarouselType(), $entity, array(
            'action' => $this->generateUrl('imagecarousel_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ImageCarousel entity.
     *
     */
    public function newAction()
    {
        $entity = new ImageCarousel();
        $form = $this->createCreateForm($entity);

        return $this->render('NumaDOAAdminBundle:ImageCarousel:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ImageCarousel entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:ImageCarousel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ImageCarousel entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:ImageCarousel:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ImageCarousel entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:ImageCarousel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ImageCarousel entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAAdminBundle:ImageCarousel:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a ImageCarousel entity.
     *
     * @param ImageCarousel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ImageCarousel $entity)
    {
        $form = $this->createForm(new ImageCarouselType(), $entity, array(
            'action' => $this->generateUrl('imagecarousel_update', array('id' => $entity->getId())),

            //'attr'=>array('class'=>'dropzone'),
        ));
        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing ImageCarousel entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAAdminBundle:ImageCarousel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ImageCarousel entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('imagecarousel_edit', array('id' => $id)));
        }

        return $this->render('NumaDOAAdminBundle:ImageCarousel:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ImageCarousel entity.
     *
     */
    public function uploadAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        $file = $request->files->get('file');

        if ($file instanceof UploadedFile && $file->isValid()) {
            $imagecarousel = new ImageCarousel();
            $imagecarousel->setTitle($file->getClientOriginalName());
            $imagecarousel->setSrc($file->getClientOriginalName());
            $em->persist($imagecarousel);
            $em->flush();
            $file->move($imagecarousel->getUploadRootDir(), $file->getClientOriginalName());
        }
        die();
    }


    public function deleteAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAAdminBundle:ImageCarousel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ImageCarousel entity.');
        }
        $em->remove($entity);
        $em->flush();


        return $this->redirect($this->generateUrl('imagecarousel'));
    }

    /**
     * Creates a form to delete a ImageCarousel entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('imagecarousel_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }


    public function addVideoForm()
    {

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('imagecarousel_add_video'))
            ->add('url', TextType::class, array('label' => 'Youtube video URL:', 'attr' => array('class' => 'col-md-6')))
            ->add('send', SubmitType::class, array('label' => 'Add'))
            ->getForm();
        return $form;

    }

    public function addVideoAction(Request $request)
    {

        $form = $this->addVideoForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $imageCarousel = new ImageCarousel();
            $imageCarousel->setActive(true);
            $imageCarousel->setSrc($data['url']);
            $imageCarousel->setUrl($data['url']);

            $em->persist($imageCarousel);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('imagecarousel'));
    }


}
