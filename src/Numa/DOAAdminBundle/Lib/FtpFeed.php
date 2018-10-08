<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 8.10.18.
 * Time: 18.56
 */

namespace Numa\DOAAdminBundle\Lib;


use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class FtpFeed
{
    use ContainerAwareTrait;
    private $username;
    private $password;
    private $host;
    private $ftpConnection;

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getFtpConnection()
    {
        return $this->ftpConnection;
    }

    /**
     * @param mixed $ftpConnection
     */
    public function setFtpConnection($ftpConnection)
    {
        $this->ftpConnection = $ftpConnection;
    }

    public function connectToFtp(){
        $this->setFtpConnection(ftp_connect($this->getHost()));
        ftp_login($this->getFtpConnection(), $this->getUsername(), $this->getPassword());
        ftp_pasv($this->getFtpConnection(), true);
    }

    public function uploadFile($filename, $localfile){
        $uploaded = ftp_put($this->getFtpConnection(), $filename, $localfile, FTP_ASCII));
        return $uploaded;
    }


}