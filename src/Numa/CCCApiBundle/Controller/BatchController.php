<?php

namespace Numa\CCCApiBundle\Controller;

use Proxies\__CG__\Numa\CCCAdminBundle\Entity\Customers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class BatchController extends Controller
{
    public function indexAction()
    {
        return $this->render('NumaCCCApiBundle:Default:index.html.twig');
    }

    public function missingImagesAction($batchid)
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
            $temp=array();
            $temp['missing']=false;
            $temp['waybill']=$probill->getWaybill();
            if($probill->getCustomers() instanceof Customers) {

                $temp['custcode'] = $probill->getCustomers()->getCustcode();
            }
            if(!file_exists($scanImgPath)){
                $temp['missing']=true;
            }
            $missing[]=$temp;
        }


        //dump($missing);die();
        return new JsonResponse($missing);
        //return $this->render('NumaCCCApiBundle:Default:index.html.twig');
    }
}
