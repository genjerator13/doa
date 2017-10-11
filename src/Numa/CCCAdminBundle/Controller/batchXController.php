<?php

namespace Numa\CCCAdminBundle\Controller;

use Numa\CCCAdminBundle\Form\batchXNoFilesType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\CCCAdminBundle\Entity\batchX;
use Numa\CCCAdminBundle\Form\batchXType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
//use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Configuration;
use Numa\CCCAdminBundle\Entity\Probills;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Process\Process;

/**
 * batchX controller.
 *
 */
class batchXController extends Controller {

    /**
     * Lists all batchX entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaCCCAdminBundle:batchX')->findBy(array(), array('id' => 'DESC'), 50);

        return $this->render('NumaCCCAdminBundle:batchX:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new batchX entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new batchX();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            //create folder in upload scans
            //$upload_url = $this->container->getParameter('scans_url');
            $upload_path = $this->container->getParameter('scans_path');
            //$dir = strtoupper($entity->getId());
            $dir = $entity->getScansFolder();

            $pathDir = $upload_path ."/". $dir;

            if (!is_dir($pathDir)) {
                //mkdir($pathDir, 0777, true);
            }
            
            $this->uploadNewsletter($request, $entity);
            
            $url = $this->generateUrl('batchx_proccess', array('id' => $entity->getId()), true);

            $data = array('status' => 1, 'url' => $url);
            return new \Symfony\Component\HttpFoundation\JsonResponse($data);
            //return $this->redirect($this->generateUrl('batchx_show', array('id' => $entity->getId())));
        }

        return $this->render('NumaCCCAdminBundle:batchX:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a batchX entity.
     *
     * @param batchX $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(batchX $entity) {
        $form = $this->createForm(batchXType::class, $entity, array(
            'action' => $this->generateUrl('batchx_create'),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new batchX entity.
     *
     */
    public function newAction() {
        $entity = new batchX();
        $form = $this->createCreateForm($entity);

        return $this->render('NumaCCCAdminBundle:batchX:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a batchX entity.
     *
     */
    public function showAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        //$id =  $request->get('id');
        $message = $request->get('$message');

        $entity = $em->getRepository('NumaCCCAdminBundle:batchX')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find batchX entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NumaCCCAdminBundle:batchX:show.html.twig', array(
                    'entity' => $entity,
                    'message' => $message,
        ));
    }
    /**
     * Displays a form to edit an existing batchx entity.
     *
     */
    public function beditAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:batchX')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find batchX entity.');
        }

        $editForm = $this->createBeditForm($entity);

        return $this->render('NumaCCCAdminBundle:batchX:bedit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ));
    }
    /**
     * Displays a form to add newsletter
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:batchX')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find batchX entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('NumaCCCAdminBundle:batchX:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a batchX entity.
     *
     * @param batchX $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(batchX $entity) {
        $form = $this->createForm(batchXType::class, $entity, array(
            'action' => $this->generateUrl('batchx_update', array('id' => $entity->getId())),
            'method' => 'POST'
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Creates a form to edit a batchX entity.
     *
     * @param batchX $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createBeditForm(batchX $entity) {
        $form = $this->createForm(new batchXNoFilesType(), $entity, array(
            'action' => $this->generateUrl('batchx_bupdate', array('id' => $entity->getId())),
            'method' => 'POST'
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));
        $form->remove('file');
        $form->remove('newsletter');
        return $form;
    }

    /**
     * Edits an existing batchX entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaCCCAdminBundle:batchX')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find batchX entity.');
        }
        $editForm = $this->createEditForm($entity);

        //$editForm->handleRequest($request);
        $this->uploadNewsletter($request, $entity);
//        if ($editForm->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($entity);
//            $em->flush();
//        }

        return $this->render('NumaCCCAdminBundle:batchX:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing Customers entity.
     *
     */
    public function bupdateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NumaCCCAdminBundle:batchX')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find batch entity.');
        }

        $editForm = $this->createBeditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {



            $em->flush();

            return $this->redirect($this->generateUrl('batchx_bedit', array('id' => $id)));
        }

        return $this->render('NumaCCCAdminBundle:batchX:bedit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ));
    }

    private function uploadNewsletter($request, $entity) {
        //update newsfeed
        $files = $request->files->get('numa_cccadminbundle_batchx');
        if(empty($files['newsletter'])){
            return;
        }
        $file = $files['newsletter'];

        if (!empty($file)) {
            if ($file->getMimeType() == "application/pdf") {
                $file2 = $file->move($entity->getUploadRootDir(), "newsletter." . $file->getClientOriginalExtension());
            } else {
//            $this->addFlash(
//                    'error', 'Newsletter has to be PDF only');
            }
            if (file_exists($entity->getUploadRootDir() . "newsletter." . $file->getClientOriginalExtension()) && !empty($file2)) {
                $this->addFlash(
                        'success', 'Newsletter file has been uploaded!'
                );
                return $this->redirect($this->generateUrl('batchx'));
            } else {
                $this->addFlash(
                        'error', 'Newsletter is not uploaded, the file has to be PDF!'
                );
            }
        } else {
            $this->addFlash(
                    'error', 'No newsletter file is choosen'
            );
        }

    }

    /**
     * Deletes a batchX entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaCCCAdminBundle:batchX')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find batchX entity.');
        }

        $em->remove($entity);
        //remove all the probills from the batch
        $probills = $em->getRepository('NumaCCCAdminBundle:Probills')->findBy(array('batchId' => $id));
        foreach ($probills as $probill) {
            $em->remove($probill);
        }
        $em->flush();
        // }

        return $this->redirect($this->generateUrl('batchx'));
    }

    /**
     * Creates a form to delete a batchX entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('batchx_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    public function proccessProbillsAction(Request $request, $id) {
        //$command = 'php ' . $this->get('kernel')->getRootDir() . '/console numa:dbutil fetchFeed ' . $id;        
        $command = 'php ' . $this->get('kernel')->getRootDir() . '/console Numa:dbc ' . $id;
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
                ->add('success', 'Upload complet. Extracting data from Database File from batch Id ' . $id);
        return $this->redirectToRoute('command_log_home');
    }

    public function proccessProgressAction(Request $request, $id) {
        $filename = $this->container->getParameter('log') . "progress_" . $id . ".txt";
        //die($filename);
        $contents = "";
        if (file_exists($filename)) {
            $fp = fopen($filename, 'r');


            $contents = fread($fp, filesize($filename));
        }
        $response = new \Symfony\Component\HttpFoundation\JsonResponse(json_decode($contents));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
