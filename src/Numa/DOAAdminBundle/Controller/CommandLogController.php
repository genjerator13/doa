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
        $em = $this->getDoctrine()->getManager();
        //$inProgress = $em->getRepository('NumaDOAAdminBundle:CommandLog')->isInProgress();

        //if ((!empty($inProgress[0]) && $inProgress[0] instanceof \Numa\DOAAdminBundle\Entity\CommandLog) || !empty($force)) {
            $command = 'php ' . $this->get('kernel')->getRootDir() . '/console numa:dbutil startCommand';
            $process = new \Symfony\Component\Process\Process($command);
            $process->start();
//            
//            $process->wait(function ($type, $buffer) {
//                if (Process::ERR === $type) {
//                    echo 'ERR > ' . $buffer;
//                } else {
//                    echo 'OUT > ' . $buffer;
//                }
//            });
//            die();
        //}
        sleep(2);
        return $this->redirectToRoute('command_log_home');
    }

}
