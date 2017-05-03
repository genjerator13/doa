<?php

namespace Numa\DOAModuleBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Proxies\__CG__\Numa\DOAAdminBundle\Entity\ImageCarousel;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOAModuleBundle\Entity\Component;
use Numa\DOAModuleBundle\Form\ComponentType;

/**
 * Component controller.
 *
 */
class ComponentController extends Controller
{

    /**
     * Lists all Component entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOAModuleBundle:Component')->findAll();

        return $this->render('NumaDOAModuleBundle:Component:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Component entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Component();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('component'));

        }

        return $this->render('NumaDOAModuleBundle:Component:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Component entity.
     *
     * @param Component $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Component $entity)
    {
        $form = $this->createForm(new ComponentType(), $entity, array(
            'action' => $this->generateUrl('component_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Component entity.
     *
     */
    public function newAction()
    {
        $entity = new Component();
        $form = $this->createCreateForm($entity);

        return $this->render('NumaDOAModuleBundle:Component:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Component entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAModuleBundle:Component')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Component entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaDOAModuleBundle:Component:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Component entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAModuleBundle:Component')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Component entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $entities = $em->getRepository("NumaDOAAdminBundle:ImageCarousel")->findByComponent($entity);
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        $dealer_id = 0;
        if($dealer instanceof Catalogrecords){
            $dealer_id = $dealer->getId();
        }
        $uploadDir = Component::getUploadDir($dealer_id,$id);
        //clear the cache
        $this->get('Numa.DMSUtils')->clearCache();
        if(strtolower($entity->getType())=="carousel"){
            return $this->render('NumaDOAModuleBundle:Component:carousel_edit.html.twig', array(
                'uploadDir' => $uploadDir,
                'entity' => $entity,
                'entities' => $entities,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }elseif(strtolower($entity->getType())=="image" || strtolower($entity->getType())=="image_object"){
            return $this->render('NumaDOAModuleBundle:Component:image_edit.html.twig', array(
                'uploadDir' => $uploadDir,
                'entity' => $entity,
                'entities' => $entities,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }

        return $this->render('NumaDOAModuleBundle:Component:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Component entity.
     *
     * @param Component $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Component $entity)
    {
        $securityContext = $this->get('security.authorization_checker');
        $componentType = new ComponentType($securityContext);
        $componentType->setSecurityContext($securityContext);
        $form = $this->createForm($componentType, $entity, array(
            'action' => $this->generateUrl('component_update', array('id' => $entity->getId())),
            'attr' => array('class' => '', 'id' => 'my-awesome-dropzone'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Component entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaDOAModuleBundle:Component')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Component entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('component_edit', array('id' => $id)));
        }

        return $this->render('NumaDOAModuleBundle:Component:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Component entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NumaDOAModuleBundle:Component')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Component entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('component'));
    }

    /**
     * Creates a form to delete a Component entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('component_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * uploads images and store  a ImageCarousel entity.
     *
     */
    public function uploadAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dc = $request->query->get('dc');

        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        $file = $request->files->get('file');
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        if($dc==1) {
            $path = $dealer->getId() . "/dcomponent/" . $id;
            $upload = $this->container->getParameter('upload_dealer') . $path;
        }else{
            $path = $dealer->getId() . "/component/" . $id;
            $upload = $this->container->getParameter('upload_dealer') . $path;
        }

        if ($file instanceof UploadedFile && $file->isValid()) {
            $this->get("Numa.Settings")->createDealerComponentUploadFolders($dealer->getId(),$id);
            $file->move($upload,$file->getClientOriginalName() );
            $component = $em->getRepository("NumaDOAModuleBundle:Component")->find($id);
            if($dc==1){
                $component = $em->getRepository("NumaDOADMSBundle:DealerComponent")->find($id);
            }
            $set = $component->getSettings();
            $setJson = json_decode($set,true);
            $imageCarousel = new ImageCarousel();
            $imageCarousel->setDealer($dealer);
            if($dc==1) {
                $imageCarousel->setDealerComponent($component);
            }else{
                $imageCarousel->setComponent($component);
            }
            $imageCarousel->setSrc($path."/".$file->getClientOriginalName());
            $imageCarousel->setActive(true);
            $imageCarousel->setTitle($file->getClientOriginalName());
            //$setJson[] = $path."/".$file->getClientOriginalName();
            //$component->setSettings(json_encode($setJson));
            $em->persist($imageCarousel);
            $em->flush();

        }
        $res = array("message"=>"success");
        return new JsonResponse($res);

    }

    public function refreshCarouselAction(Request $request,$id){
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        //get component by dealer and component id
        $dealerComponent = $request->query->get('dc');
        $em = $this->getDoctrine()->getManager();

        if($dealerComponent==1){
            $dC = $em->getRepository('NumaDOADMSBundle:DealerComponent')->find($id);
            $entities = $em->getRepository('NumaDOAAdminBundle:ImageCarousel')->findByDealerComponent($dealerComponent);
        }else{
            $c = $em->getRepository('NumaDOAModuleBundle:Component')->find($id);
            $entities = $em->getRepository('NumaDOAAdminBundle:ImageCarousel')->findByComponent($c);
        }

        $uploadDir = Component::getUploadDir($dealer->getId(),$id);
        return $this->render('NumaDOAAdminBundle:ImageCarousel:carousel_list.html.twig', array(
            'entities' => $entities,
            'uploadDir'=> $uploadDir
        ));

    }
}
