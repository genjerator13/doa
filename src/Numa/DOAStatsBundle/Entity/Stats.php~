<?php

namespace Numa\DOAStatsBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;

/**
 * Stats
 * @JMS\ExclusionPolicy("ALL")
 */
class Stats
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $table_name;

    /**
     * @var int
     */
    private $table_id;

    /**
     * @var \DateTime
     * @JMS\Expose
     */
    private $date_visited;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $http_user_agent;

    /**
     * @var string
     */
    private $http_accept;

    /**
     * @var string
     */
    private $http_accept_language;

    /**
     * @var string
     */
    private $http_accept_encoding;

    /**
     * @var string
     */
    private $http_referer;

    /**
     * @var string
     */
    private $http_cookie;

    /**
     * @var string
     */
    private $http_conection;

    /**
     * @var string
     */
    private $remote_address;

    /**
     * @var string
     */
    private $remote_port;

    /**
     * @var string
     */
    private $request_url;

    /**
     * @var \DateTime
     */
    private $request_time;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tableName
     *
     * @param string $tableName
     *
     * @return Stats
     */
    public function setTableName($tableName)
    {
        $this->table_name = $tableName;

        return $this;
    }

    /**
     * Get tableName
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->table_name;
    }

    /**
     * Set tableId
     *
     * @param int $tableId
     *
     * @return Stats
     */
    public function setTableId($tableId)
    {
        $this->table_id = $tableId;

        return $this;
    }

    /**
     * Get tableId
     *
     * @return int
     */
    public function getTableId()
    {
        return $this->table_id;
    }

    /**
     * Set dateVisited
     *
     * @param \DateTime $dateVisited
     *
     * @return Stats
     */
    public function setDateVisited($dateVisited)
    {
        $this->date_visited = $dateVisited;

        return $this;
    }

    /**
     * Get dateVisited
     *
     * @return \DateTime
     */
    public function getDateVisited()
    {
        return $this->date_visited;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Stats
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set httpUserAgent
     *
     * @param string $httpUserAgent
     *
     * @return Stats
     */
    public function setHttpUserAgent($httpUserAgent)
    {
        $this->http_user_agent = $httpUserAgent;

        return $this;
    }

    /**
     * Get httpUserAgent
     *
     * @return string
     */
    public function getHttpUserAgent()
    {
        return $this->http_user_agent;
    }

    /**
     * Set httpAccept
     *
     * @param string $httpAccept
     *
     * @return Stats
     */
    public function setHttpAccept($httpAccept)
    {
        $this->http_accept = $httpAccept;

        return $this;
    }

    /**
     * Get httpAccept
     *
     * @return string
     */
    public function getHttpAccept()
    {
        return $this->http_accept;
    }

    /**
     * Set httpAcceptLanguage
     *
     * @param string $httpAcceptLanguage
     *
     * @return Stats
     */
    public function setHttpAcceptLanguage($httpAcceptLanguage)
    {
        $this->http_accept_language = $httpAcceptLanguage;

        return $this;
    }

    /**
     * Get httpAcceptLanguage
     *
     * @return string
     */
    public function getHttpAcceptLanguage()
    {
        return $this->http_accept_language;
    }

    /**
     * Set httpAcceptEncoding
     *
     * @param string $httpAcceptEncoding
     *
     * @return Stats
     */
    public function setHttpAcceptEncoding($httpAcceptEncoding)
    {
        $this->http_accept_encoding = $httpAcceptEncoding;

        return $this;
    }

    /**
     * Get httpAcceptEncoding
     *
     * @return string
     */
    public function getHttpAcceptEncoding()
    {
        return $this->http_accept_encoding;
    }

    /**
     * Set httpReferer
     *
     * @param string $httpReferer
     *
     * @return Stats
     */
    public function setHttpReferer($httpReferer)
    {
        $this->http_referer = $httpReferer;

        return $this;
    }

    /**
     * Get httpReferer
     *
     * @return string
     */
    public function getHttpReferer()
    {
        return $this->http_referer;
    }

    /**
     * Set httpCookie
     *
     * @param string $httpCookie
     *
     * @return Stats
     */
    public function setHttpCookie($httpCookie)
    {
        $this->http_cookie = $httpCookie;

        return $this;
    }

    /**
     * Get httpCookie
     *
     * @return string
     */
    public function getHttpCookie()
    {
        return $this->http_cookie;
    }

    /**
     * Set httpConection
     *
     * @param string $httpConection
     *
     * @return Stats
     */
    public function setHttpConection($httpConection)
    {
        $this->http_conection = $httpConection;

        return $this;
    }

    /**
     * Get httpConection
     *
     * @return string
     */
    public function getHttpConection()
    {
        return $this->http_conection;
    }

    /**
     * Set remoteAddress
     *
     * @param string $remoteAddress
     *
     * @return Stats
     */
    public function setRemoteAddress($remoteAddress)
    {
        $this->remote_address = $remoteAddress;

        return $this;
    }

    /**
     * Get remoteAddress
     *
     * @return string
     */
    public function getRemoteAddress()
    {
        return $this->remote_address;
    }

    /**
     * Set remotePort
     *
     * @param string $remotePort
     *
     * @return Stats
     */
    public function setRemotePort($remotePort)
    {
        $this->remote_port = $remotePort;

        return $this;
    }

    /**
     * Get remotePort
     *
     * @return string
     */
    public function getRemotePort()
    {
        return $this->remote_port;
    }

    /**
     * Set requestUrl
     *
     * @param string $requestUrl
     *
     * @return Stats
     */
    public function setRequestUrl($requestUrl)
    {
        $this->request_url = $requestUrl;

        return $this;
    }

    /**
     * Get requestUrl
     *
     * @return string
     */
    public function getRequestUrl()
    {
        return $this->request_url;
    }

    /**
     * Set requestTime
     *
     * @param \DateTime $requestTime
     *
     * @return Stats
     */
    public function setRequestTime($requestTime)
    {
        $this->request_time = $requestTime;

        return $this;
    }

    /**
     * Get requestTime
     *
     * @return \DateTime
     */
    public function getRequestTime()
    {
        return $this->request_time;
    }
}
