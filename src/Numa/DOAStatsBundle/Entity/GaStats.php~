<?php

namespace Numa\DOAStatsBundle\Entity;

/**
 * GaStats
 */
class GaStats
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $dealer_id;

    /**
     * @var string
     */
    private $count;

    /**
     * @var string
     */
    private $other;

    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Dealer;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dealerId
     *
     * @param integer $dealerId
     *
     * @return GaStats
     */
    public function setDealerId($dealerId)
    {
        $this->dealer_id = $dealerId;

        return $this;
    }

    /**
     * Get dealerId
     *
     * @return integer
     */
    public function getDealerId()
    {
        return $this->dealer_id;
    }

    /**
     * Set count
     *
     * @param string $count
     *
     * @return GaStats
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return string
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set other
     *
     * @param string $other
     *
     * @return GaStats
     */
    public function setOther($other)
    {
        $this->other = $other;

        return $this;
    }

    /**
     * Get other
     *
     * @return string
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return GaStats
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return GaStats
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
     * Set dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     *
     * @return GaStats
     */
    public function setDealer(\Numa\DOAAdminBundle\Entity\Catalogrecords $dealer = null)
    {
        $this->Dealer = $dealer;

        return $this;
    }

    /**
     * Get dealer
     *
     * @return \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    public function getDealer()
    {
        return $this->Dealer;
    }
    /**
     * @var string
     */
    private $sessions;

    /**
     * @var string
     */
    private $bounceRate;

    /**
     * @var string
     */
    private $avgTimeOnPage;

    /**
     * @var string
     */
    private $pageViewsPerSession;

    /**
     * @var string
     */
    private $percentNewVisits;

    /**
     * @var string
     */
    private $pageViews;

    /**
     * @var string
     */
    private $avgPageLoadTime;


    /**
     * Set sessions
     *
     * @param string $sessions
     *
     * @return GaStats
     */
    public function setSessions($sessions)
    {
        $this->sessions = $sessions;

        return $this;
    }

    /**
     * Get sessions
     *
     * @return string
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     * Set bounceRate
     *
     * @param string $bounceRate
     *
     * @return GaStats
     */
    public function setBounceRate($bounceRate)
    {
        $this->bounceRate = $bounceRate;

        return $this;
    }

    /**
     * Get bounceRate
     *
     * @return string
     */
    public function getBounceRate()
    {
        return $this->bounceRate;
    }

    /**
     * Set avgTimeOnPage
     *
     * @param string $avgTimeOnPage
     *
     * @return GaStats
     */
    public function setAvgTimeOnPage($avgTimeOnPage)
    {
        $this->avgTimeOnPage = $avgTimeOnPage;

        return $this;
    }

    /**
     * Get avgTimeOnPage
     *
     * @return string
     */
    public function getAvgTimeOnPage()
    {
        return $this->avgTimeOnPage;
    }

    /**
     * Set pageViewsPerSession
     *
     * @param string $pageViewsPerSession
     *
     * @return GaStats
     */
    public function setPageViewsPerSession($pageViewsPerSession)
    {
        $this->pageViewsPerSession = $pageViewsPerSession;

        return $this;
    }

    /**
     * Get pageViewsPerSession
     *
     * @return string
     */
    public function getPageViewsPerSession()
    {
        return $this->pageViewsPerSession;
    }

    /**
     * Set percentNewVisits
     *
     * @param string $percentNewVisits
     *
     * @return GaStats
     */
    public function setPercentNewVisits($percentNewVisits)
    {
        $this->percentNewVisits = $percentNewVisits;

        return $this;
    }

    /**
     * Get percentNewVisits
     *
     * @return string
     */
    public function getPercentNewVisits()
    {
        return $this->percentNewVisits;
    }

    /**
     * Set pageViews
     *
     * @param string $pageViews
     *
     * @return GaStats
     */
    public function setPageViews($pageViews)
    {
        $this->pageViews = $pageViews;

        return $this;
    }

    /**
     * Get pageViews
     *
     * @return string
     */
    public function getPageViews()
    {
        return $this->pageViews;
    }

    /**
     * Set avgPageLoadTime
     *
     * @param string $avgPageLoadTime
     *
     * @return GaStats
     */
    public function setAvgPageLoadTime($avgPageLoadTime)
    {
        $this->avgPageLoadTime = $avgPageLoadTime;

        return $this;
    }

    /**
     * Get avgPageLoadTime
     *
     * @return string
     */
    public function getAvgPageLoadTime()
    {
        return $this->avgPageLoadTime;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if (!$this->getDateCreated()) {
            $this->date_created = new \DateTime();
        }
    }
}
