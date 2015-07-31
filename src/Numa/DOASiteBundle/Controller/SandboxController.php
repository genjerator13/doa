<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Numa\Util\Util as Util;

class SandboxController extends Controller {

    public function indexAction() {
        $memcache = $this->get('memcached');
        $mymemcached = $this->get('mymemcache');
        $memcache->set("aaa", "sss");
        $memcache->set("aaa", "xxx");
        $memcache->set("aaa", "ccc");
        dump($memcache->get("aaa"));die();
        
    }

}
