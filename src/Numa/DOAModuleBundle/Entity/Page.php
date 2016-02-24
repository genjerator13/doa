<?php

namespace Numa\DOAModuleBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Page
 */
class Page
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $keywords;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $url;

    /**
     * @var bool
     */
    private $is_public;

    /**
     * @var bool
     */
    private $autogenerate = true;

    /**
     * @var bool
     */
    private $active = true;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;


    /**
     * Set id
     *
     * @param string $id
     *
     * @return Page
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Page
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     *
     * @return Page
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Page
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set isPublic
     *
     * @param bool $isPublic
     *
     * @return Page
     */
    public function setIsPublic($isPublic)
    {
        $this->is_public = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return bool
     */
    public function getIsPublic()
    {
        return $this->is_public;
    }

    /**
     * Set autogenerate
     *
     * @param bool $autogenerate
     *
     * @return Page
     */
    public function setAutogenerate($autogenerate)
    {
        $this->autogenerate = $autogenerate;

        return $this;
    }

    /**
     * Get autogenerate
     *
     * @return bool
     */
    public function getAutogenerate()
    {
        return $this->autogenerate;
    }

    /**
     * Set active
     *
     * @param bool $active
     *
     * @return Page
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Page
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Page
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        if (!$this->getCreatedAt()) {
            $this->created_at = new \DateTime();
            $this->updated_at = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        if(empty($this->dontupdate)){

            $this->created_at = new \DateTime();
        }
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $PageAds;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->PageAds = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add PageAds
     *
     * @param \Numa\DOAModuleBundle\Entity\PageAds $pageAds
     * @return Page
     */
    public function addPageAd(\Numa\DOAModuleBundle\Entity\PageAds $pageAds)
    {
        $this->PageAds[] = $pageAds;

        return $this;
    }

    /**
     * Remove PageAds
     *
     * @param \Numa\DOAModuleBundle\Entity\PageAds $pageAds
     */
    public function removePageAd(\Numa\DOAModuleBundle\Entity\PageAds $pageAds)
    {
        $this->PageAds->removeElement($pageAds);
    }

    /**
     * Get PageAds
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPageAds()
    {
        return $this->PageAds;
    }

    // Important
    public function getAds()
    {
        $ads = new ArrayCollection();
        if (!empty($this->getPageAds()) && !$this->getPageAds()->isEmpty()) {

            foreach ($this->getPageAds() as $pa) {
                if ($pa instanceof PageAds) {
                    $ads[] = $pa->getAd();

                }
            }
        }
        return $ads;
    }

    public function getActiveAds()
    {
        $currentDate = new \DateTime();

        $criteria = new \Doctrine\Common\Collections\Criteria();

        $criteria->andWhere($criteria->expr()->eq('status', 'enabled'));
        $criteria->andWhere($criteria->expr()->gte('endDate', $currentDate));
        $criteria->andWhere($criteria->expr()->lte('startDate', $currentDate));

        return $this->getAds()->matching($criteria);

        //return $ads;
    }

    // Important
    public function setAds($pageAds)
    {
        foreach ($pageAds as $pageAd) {
            $pa = new PageAds();

            $pa->setPage($this);
            $pa->setAd($pageAd);

            $this->addPageAd($pa);
        }

    }
}
