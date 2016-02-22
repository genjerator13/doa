<?php

namespace Numa\DOAModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PageAds
 */
class PageAds
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $page_id;

    /**
     * @var integer
     */
    private $ad_id;

    /**
     * @var \Numa\DOAModuleBundle\Entity\Page
     */
    private $Page;

    /**
     * @var \Numa\DOAModuleBundle\Entity\Ad
     */
    private $Ad;


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
     * Set page_id
     *
     * @param integer $pageId
     * @return PageAds
     */
    public function setPageId($pageId)
    {
        $this->page_id = $pageId;

        return $this;
    }

    /**
     * Get page_id
     *
     * @return integer 
     */
    public function getPageId()
    {
        return $this->page_id;
    }

    /**
     * Set ad_id
     *
     * @param integer $adId
     * @return PageAds
     */
    public function setAdId($adId)
    {
        $this->ad_id = $adId;

        return $this;
    }

    /**
     * Get ad_id
     *
     * @return integer 
     */
    public function getAdId()
    {
        return $this->ad_id;
    }

    /**
     * Set Page
     *
     * @param \Numa\DOAModuleBundle\Entity\Page $page
     * @return PageAds
     */
    public function setPage(\Numa\DOAModuleBundle\Entity\Page $page = null)
    {
        $this->Page = $page;

        return $this;
    }

    /**
     * Get Page
     *
     * @return \Numa\DOAModuleBundle\Entity\Page 
     */
    public function getPage()
    {
        return $this->Page;
    }

    /**
     * Set Ad
     *
     * @param \Numa\DOAModuleBundle\Entity\Ad $ad
     * @return PageAds
     */
    public function setAd(\Numa\DOAModuleBundle\Entity\Ad $ad = null)
    {
        $this->Ad = $ad;

        return $this;
    }

    /**
     * Get Ad
     *
     * @return \Numa\DOAModuleBundle\Entity\Ad 
     */
    public function getAd()
    {
        return $this->Ad;
    }
}
