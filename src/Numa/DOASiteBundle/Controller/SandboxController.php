<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Numa\Util\Util as Util;

class SandboxController extends Controller {

    public function indexAction() {
        // create curl resource
        $ch = curl_init();

        // set url
        //curl_setopt($ch, CURLOPT_URL, "http://www.machinefinder.com");
        curl_setopt($ch, CURLOPT_URL, "http://www.machinefinder.com/dealer_families/6926/machine_feed.xml");
        curl_setopt($ch, CURLOPT_POST, 1);
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);
        dump($output);die();

        // close curl resource to free up system resources
        curl_close($ch);      
    }

}
