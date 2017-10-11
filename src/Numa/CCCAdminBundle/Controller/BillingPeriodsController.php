<?php

namespace Numa\CCCAdminBundle\Controller;

use Numa\CCCAdminBundle\Entity\Customers;
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
use Symfony\Component\HttpFoundation\Response;

/**
 * batchX controller.
 *
 */
class BillingPeriodsController extends Controller {

    /**
     * Lists all batchX entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaCCCAdminBundle:batchX')->findBy(array(),array('id'=>'DESC'),24);

        return $this->render('NumaCCCAdminBundle:BillingPeriods:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    public function missingImagesAction(Request $request, $batchid)
    {
        $em = $this->getDoctrine()->getManager();
        $batch = $em->getRepository("NumaCCCAdminBundle:batchX")->find($batchid);
        $probills = $em->getRepository('NumaCCCAdminBundle:Probills')->findBy(array('batchId'=>$batchid));
        $scanFolder = $batch->getScansFolder();
        $scanPath   = $this->container->getParameter('scans_path');


        $batchPath = $scanPath."/".$scanFolder;
        $missing = array();
        foreach($probills as $probill)
        {

            $scanImgFilename = $probill->getWaybill().".jpg";
            $scanImgPath     = $batchPath."/".$scanImgFilename;
            if(!file_exists($scanImgPath)){
                $missing[$probill->getId()]=$probill;
            }
        }


        return $this->render('NumaCCCAdminBundle:BillingPeriods:missing.html.twig', array(
            'probills' => $probills,
            'missing' => $missing,
            'batchid'=>$batchid,
        ));
    }

    public function zipScansAction(Request $request, $batchid){
        $em = $this->getDoctrine()->getManager();
        $batch = $em->getRepository("NumaCCCAdminBundle:batchX")->find($batchid);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $custcode = $request->query->get('cust');
        if($user instanceof Customers){
            if(!empty($user->getCustcode()))
            {
                $custcode = $user->getCustcode();
            }
        }
        $scanFolder = $batch->getScansFolder();
        $scanPath   = $this->container->getParameter('scans_path');

        $filename   = $custcode."-".$scanFolder.".zip";
        $zipfolderPath = $scanPath."/".$scanFolder;
        $zipPath   = $zipfolderPath."/".$filename;
        $zip = new \ZipArchive();

        if(file_exists($zipPath)){

            //header('Content-Type', 'application/zip');
//            header("Content-Description: File Transfer");
//            header("Content-type: application/octet-stream");
//            header('Content-disposition: attachment; filename="' . $filename . '"');
//            header('Content-Length: ' . filesize($zipPath));
//            return new Response();
            $response = new Response();
            $response->headers->set('Content-Description', 'File Transfer');
            $response->headers->set('Content-type', ' application/octet-stream');
            $response->headers->set('Content-disposition',  'attachment; filename="' . $filename . '"');
            $response->headers->set('Content-Length',  filesize($zipPath));
            $response->send();
        }
        $test = $zip->open($zipPath, \ZipArchive::CREATE);

        if ($test !== TRUE) {
            exit("cannot open <$filename>\n");
        }

//        foreach (new \DirectoryIterator($zipfolderPath) as $fileInfo) {
//            if($fileInfo->isDot()) continue;
//            echo $fileInfo->getFilename() . "<br>\n";
//        }
//        $zip->addFile($invoice, 'PdfInvoice.pdf');

        $probills = $em->getRepository('NumaCCCAdminBundle:Probills')->findBy(array('batchId'=>$batchid,'customers'=>$user));
        foreach($probills as $probill)
        {
            $scanImgFilename = $probill->getWaybill().".jpg";
            $scanImgPath     = $zipfolderPath."/".$scanImgFilename;
            if(file_exists($scanImgPath)){

                $zip->addFile($scanImgPath, $scanImgFilename);
            }
        }
        //$zip->addFile("/var/www/ccc/web/scans/DEC31-15/0456305.jpg","test.jpg");
        $zip->close();
        if(file_exists($zipPath)){
            //header('Content-Type', 'application/zip');
            header("Content-Description: File Transfer");
            header("Content-type: application/octet-stream");
            header('Content-disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($zipPath));
            readfile($zipPath);
            return;
        }
        die();
    }

}
