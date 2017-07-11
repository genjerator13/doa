<?php
namespace Numa\DOAAdminBundle\Lib;
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

/**
 * Description of Curl
 *
 * @author genjerator
 */


class Curl
{

    protected $username;
    protected $password;
    private $baseUrl;
    private $urlSuffix;
    private $process;

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getUrlSuffix()
    {
        return $this->urlSuffix;
    }

    public function getProcess()
    {
        return $this->process;
    }

    public function getFullPath()
    {
        return $this->getBaseUrl() . $this->getUrlSuffix();
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function setUrlSuffix($urlSuffix)
    {
        $this->urlSuffix = $urlSuffix;
    }


    public function init()
    {
        $this->process = curl_init($this->getFullPath());

        if (!empty($this->username) && !empty($this->password)) {
            curl_setopt($this->process, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        }

        curl_setopt($this->process, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->process, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->process, CURLOPT_RETURNTRANSFER, TRUE);
    }

    public function __construct()
    {
        $this->init();
    }

    public function __destruct()
    {
        curl_close($this->process);
    }

    public function call()
    {
        $this->init();

        $return = curl_exec($this->process);

        return $return;
    }

    //put your code here
}
