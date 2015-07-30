<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Numa\Util\Util as Util;

class SandboxController extends Controller {

    public function indexAction() {
        $memcached = $this->get('memcached');
        $mymemcached = $this->get('mymemcache');
        
        $test = $mymemcached->get("aaa");
        if (!$test) {
            $mymemcached->add("aaa","sss");
            $test = "Aa";
        }
        
        die();
    }

}
