<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Numa\Util\Util as Util;

class SandboxController extends Controller {

    public function indexAction() {
        $data = array('key' => '16ab1a10-2daf-0130-dd76-005056be005f', 'password' => 'arkansas22');
        $url = "http://www.machinefinder.com/dealer_families/6926/machine_feed.xml";
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_exec($handle);
    }

}


