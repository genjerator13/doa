<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MemcacheWrapper
 *
 * @author genjerator
 */

namespace Numa\DOAAdminBundle\Lib;

use Numa\DOAAdminBundle\Entity\Catalogrecords;

class MemcacheWrapper
{

    public $memcached;
    private $container;
    private $kernel;

    public function __construct($memcached, $container, $kernel)
    {
        $this->memcached = $memcached;
        $this->container = $container;
        $this->kernel = $kernel;
    }

    public function set($key, $value, $time = 0)
    {
        $this->memcached->set($this->makeKey($key), $value, $time);
    }

    public function delete($key)
    {
        $this->memcached->delete($this->makeKey($key));
    }

    public function add($key, $value)
    {
        $this->memcached->add($this->makeKey($key), base64_encode(serialize($value)));
    }

    public function get($key)
    {

        return unserialize(base64_decode($this->memcached->get($this->makeKey($key))));
    }

    public function makeKey($key)
    {
        $key = str_replace("/","_",$key);
        return md5($this->kernel->getRootDir()) . ":" . $key;
    }

    public function deleteDealerCache(Catalogrecords $dealer){
        $dealerHost = str_replace("www.", "", $dealer->getSiteUrl());
        $key = $this::dealerPrefix.$dealerHost;

        return $this->delete($key);
    }

}
