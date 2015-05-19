<?php

namespace Numa\DOAAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\Importfeed;
use Numa\DOAAdminBundle\Form\ImportfeedType;
use Symfony\Component\Process\Process;

/**
 * Importfeed controller.
 *
 */
class CommandLogController extends Controller {

    /**
     * Lists all Importfeed entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('NumaDOAAdminBundle:CommandLog')->findLastCommandLog(100);
        //$inProgress = $this->get('memcache.default')->get('progresses');
        $progresses = array();
        //$temp = $this->get('memcache.default')->get('progresses');
        //if(!empty($temp)){
            
           // $progresses = $temp;
        ///}
        //$pending = $em->getRepository('NumaDOAAdminBundle:CommandLog')->getPendingCommands();

        return $this->render('NumaDOAAdminBundle:CommandLog:index.html.twig', array(
                    'entities' => $entities,
                    'progresses' => $progresses
        //            'inprogress' => $inProgress,
        ));
    }

    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('NumaDOAAdminBundle:CommandLog')->find($id);
        return $this->render('NumaDOAAdminBundle:CommandLog:details.html.twig', array(
                    'entity' => $entity,
        ));
    }

    public function startAction(Request $request) {
        $force = $request->query->get('force');
        $inProgress = $this->get('memcache.default')->get('command_in_progress');
        if (empty($inProgress) || !empty($force)) {
            $this->get('memcache.default')->set('command_in_progress', 1);
            
            $command = 'php ' . $this->get('kernel')->getRootDir() . '/console numa:dbutil startCommand';
            $process = new \Symfony\Component\Process\Process($command);
            $process->start();
            
//            $process->wait(function ($type, $buffer) {
//                if (Process::ERR === $type) {
//                    echo 'ERR > ' . $buffer;
//                } else {
//                    echo 'OUT > ' . $buffer;
//                }
//            });
//            die();
        }
        return $this->redirectToRoute('command_log_home');
    }

}
