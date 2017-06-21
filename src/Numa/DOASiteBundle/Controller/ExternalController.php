<?php

namespace Numa\DOASiteBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;


class ExternalController extends Controller
{

    public function fileAction($filename)
    {
        $filename = $filename.".html";
        $path = $this->getParameter('web_path');
        $file = $path."/".$filename;
        if(!file_exists($file)){
            throw $this->createNotFoundException("File not found!");
        }
        //dump($file);die();
        // Generate response
        $response = new Response();

// Set headers
        $response->headers->set('Cache-Control', 'private');
        //$response->headers->set('Content-type', mime_content_type($filename));
        //$response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filename) . '";');
        $response->headers->set('Content-length', filesize($filename));

// Send headers before outputting anything
        $response->sendHeaders();

        $response->setContent(file_get_contents($filename));
    }


}


