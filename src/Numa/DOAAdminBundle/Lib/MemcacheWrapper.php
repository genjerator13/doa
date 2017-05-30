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
    const dealerPrefix = "dealer_";
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
        $this->memcached->add($this->makeKey($key), $value);
    }

    public function get($key)
    {

        return $this->memcached->get($this->makeKey($key));
    }

    public function makeKey($key)
    {
        return md5($this->kernel->getRootDir()) . ":" . $key;
    }

    public function deleteDealerCache(Catalogrecords $dealer){
        $dealerHost = str_replace("www.", "", $dealer->getSiteUrl());
        $key = $this::dealerPrefix.$dealerHost;

        return $this->delete($key);
    }

}
