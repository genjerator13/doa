<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

class HelpController extends Controller
{
    public function UserPermissionViewAction()
    {

        $download_path = $this->container->getParameter('upload_dealer');
        $filename = "UserGroupPermissions.xlsx";

        $inputFileType = \PHPExcel_IOFactory::identify($download_path.$filename);
        $readerObject = \PHPExcel_IOFactory::createReader($inputFileType);
        $phpExcelObject = $readerObject->load($download_path.$filename);

        $objWriter = \PHPExcel_IOFactory::createWriter($phpExcelObject, $inputFileType);
        $objWriter->save($download_path.$filename);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
        exit;
    }

}
