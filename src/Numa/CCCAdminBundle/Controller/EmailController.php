<?php

namespace Numa\CCCAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\CCCAdminBundle\Entity\Email;
use Numa\CCCAdminBundle\Form\EmailType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Email controller.
 *
 */
class EmailController extends Controller {

    /**
     * Lists all Email entities.
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaCCCAdminBundle:Email')->findAll();
        $adapter = new ArrayAdapter($entities);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(15);
        $page = $request->get('page');
        if (!$page) {
            $page = 1;
        }
        return $this->render('NumaCCCAdminBundle:Email:index.html.twig', array(
                    'entities' => $entities,
                    'pagerfanta' => $pagerfanta,
        ));
    }

    public function generateAction(Request $request, $batch_id,$sending=0) {

        //$command = 'php ' . $this->get('kernel')->getRootDir() . '/console numa:dbutil fetchFeed ' . $id;   
        $msg = '';

        $command = 'php ' . $this->get('kernel')->getRootDir() . '/console numa:CCC:emails generateReports ' . $batch_id." ".$sending;

        $process = new \Symfony\Component\Process\Process($command);

        $process->start();

        //sleep(3);
        $request->getSession()->getFlashBag()->add('success', 'Emails are created for batch# ' . $batch_id);

        return $this->redirectToRoute('email_progress',array('batch_id'=>$batch_id));
    }

    public function sendAction(Request $request, $batch_id){
        //$command = 'php ' . $this->get('kernel')->getRootDir() . '/console numa:dbutil fetchFeed ' . $id;
        $msg = '';

        $command = 'php ' . $this->get('kernel')->getRootDir() . '/console numa:CCC:emails sendAllEmails '.$batch_id;

        $process = new \Symfony\Component\Process\Process($command);

        $process->start();

        //sleep(3);
        $request->getSession()->getFlashBag()->add('success', 'Emails are queued for sending. Sending in progress# ' . $batch_id);

        return $this->redirectToRoute('email_progress',array('batch_id'=>$batch_id));
    }

    public function sendTestAction(Request $request, $batch_id){
        $em = $this->getDoctrine()->getManager();

        $emails = $em->getRepository('NumaCCCAdminBundle:Email')->findBy(array('batch_id'=>$batch_id));

        return $this->render('NumaCCCAdminBundle:Email:viewEmails.html.twig', array(
            'emails' => $emails  ,
            'batchid'=> $batch_id,
        ));
    }

    public function deleteAttAction(Request $request, $email_id,$att_order){
        $em = $this->getDoctrine()->getManager();

        $email = $em->getRepository('NumaCCCAdminBundle:Email')->find($email_id);

        if($email instanceof Email){
            $attachments = $email->getAttachment();
            $att = $attachments;
            $attArray = explode(";",$att);
            $res=array();
            if(!empty($att)) {
                $i=1;
                foreach ($attArray as $attach) {
                    if($i!=$att_order){
                        $res[]=$attach;
                    }
                    $i++;
                }
                $attachment = implode(";",$res);

            }
        }

        $email->setAttachment($attachment);

        $em->flush();
        //return new Response();
        return $this->redirectToRoute("batchx_preview_emails",array("batch_id"=>$email->getBatchId()));
    }

    public function proccessEmailSendingAction(Request $request, $action = "") {
        //$command = 'php ' . $this->get('kernel')->getRootDir() . '/console numa:dbutil fetchFeed ' . $id;   
        $msg = '';
        if ($action == "sendEmailsNoAttachment") {
            $msg = 'only emails with no Attachment';
        } elseif ($action == "sendEmailsWithAttachment") {
            $msg = 'only emails with Attachment';
        } elseif ($action == "sendAllEmails") {
            $msg = 'Send All Emails';
        } else {
            throw $this->createNotFoundException('Unable to find requested action.');
        }
        $command = 'php ' . $this->get('kernel')->getRootDir() . '/console numa:CCC:emails ' . $action;
        //$command = 'php ' . $this->get('kernel')->getRootDir() ."/console numa:CCC:users genjerator13 xxx";
        $process = new \Symfony\Component\Process\Process($command);

        $process->start();

        sleep(3);
        $request->getSession()->getFlashBag()
                ->add('success', 'Emails sending (' . $msg . ") started");
        return $this->redirectToRoute('command_log_home');
    }

    public function progressAction(Request $request,$batch_id) {
        $em = $this->getDoctrine()->getManager();
        

        $generate = $em->getRepository('NumaCCCAdminBundle:CommandLog')->findEmailLog($batch_id,0);
        $email = $em->getRepository('NumaCCCAdminBundle:CommandLog')->findEmailLog($batch_id,1);

        $noattach = $em->getRepository('NumaCCCAdminBundle:CommandLog')->findEmailLog($batch_id,2);
        $attach   = $em->getRepository('NumaCCCAdminBundle:CommandLog')->findEmailLog($batch_id,3);

        if(empty($generate)){
            $generate['total']=0;
            $generate['current']=0;
        }
        if(empty($email)){
            $email['total']=0;
            $email['current']=0;
        }
        if(empty($noattach)){
            $noattach['total']=0;
            $noattach['current']=0;
        }
        if(empty($attach)){
            $attach['total']=0;
            $attach['current']=0;
        }
        
        return $this->render('NumaCCCAdminBundle:Email:progress.html.twig', array(
                    'batch_id' => $batch_id  ,                  
                    'generate' => $generate  ,                  
                    'email' => $email  ,
                    'noattach' => $noattach ,
                    'attach' => $attach                    
        ));
    }
    
    public function progressAjaxAction(Request $request,$batch_id) {
        $em = $this->getDoctrine()->getManager();
        //$entities = $em->getRepository('NumaCCCAdminBundle:CommandLog')->findEmailLog(3,"email",true);
        //$generate = $em->getRepository('NumaCCCAdminBundle:CommandLog')->findEmailLog(3,"email",true);;
        $generate = $em->getRepository('NumaCCCAdminBundle:CommandLog')->findEmailLog($batch_id,0);
        $email = $em->getRepository('NumaCCCAdminBundle:CommandLog')->findEmailLog($batch_id,1);

        $noAttachment = $em->getRepository('NumaCCCAdminBundle:CommandLog')->findEmailLog($batch_id,2);
        $attachment   = $em->getRepository('NumaCCCAdminBundle:CommandLog')->findEmailLog($batch_id,3);

        $res = array();
        
        $res['generate_total'] = $generate['total'];
        $res['generate_current'] = $generate['current'];

        $res['email_total'] = $email['total'];
        $res['email_current'] = $email['current'];

        $res['noatt_total'] = $noAttachment['total'];
        $res['noatt_current'] = $noAttachment['current'];
        $res['withatt_total'] = $attachment['total'];
        $res['withatt_current'] = $attachment['current'];
        $res['generate'] = 0;
        $res['generate'] = $generate['total']>0?($generate['current']/$generate['total'])*100:0;
        $res['email'] = 0;
        $res['email'] = $email['total']>0?($email['current']/$email['total'])*100:0;

        $res['noatt'] = 0;
        $res['noatt'] = $noAttachment['total']>0?($noAttachment['current']/$noAttachment['total'])*100:0;
        $res['withatt'] = $attachment['total']>0?($attachment['current']/$attachment['total'])*100:0;
        //dump($res);
        
        return new \Symfony\Component\HttpFoundation\JsonResponse(array('res' => $res));
    }

}
