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
//dump($memcache->getAllKeys());
dump($memcache->get('0d171f6b05f0a877c193c76b55ef3fc7:command:progress:81'));
$i=1;
foreach($memcache->getAllKeys() as $key){
  if($i>4){
     die();  
  }
  $i++;
  dump($key);
  dump($memcache->get($key));
}
        $keys = $memcache->getVersion();

        die();
    }

}


