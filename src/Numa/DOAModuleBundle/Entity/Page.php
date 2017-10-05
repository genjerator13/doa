<?php

namespace Numa\DOAModuleBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as JMS;
/**
 * Page
 * @JMS\ExclusionPolicy("ALL")
 */
class Page
{
    /**
     * @var string
     * @JMS\Expose
     */
    private $id;

    /**
     * @var string
     * @JMS\Expose
     */
    private $description;

    /**
     * @var string
     * @JMS\Expose
     */
    private $keywords;

    /**
     * @var string
     * @JMS\Expose
     */
    private $title;

    /**
     * @var string
     * @JMS\Expose
     */
    private $url;

    /**
     * @var bool
     * @JMS\Expose
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

            $this->updated_at = new \DateTime();
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

    /**
     * Get Component
     *
     * @return \Doctrine\Common\Collections\Collection
     * @JMS\VirtualProperty
     */
    public function getComponent()
    {
        $components = new ArrayCollection();
        if (!empty($this->getPageComponent()) && !$this->getPageComponent()->isEmpty()) {

            foreach ($this->getPageComponent() as $pc) {
                if ($pc instanceof PageComponent) {
                    $components[] = $pc->getComponent();
                }
            }
        }
        return $components;
    }


    // Important
    public function setComponent($pageComponents)
    {
        foreach ($pageComponents as $pageComponent) {
            $pa = new PageComponent();

            $pa->setPage($this);
            $pa->setComponent($pageComponent);

            $this->addPageComponent($pa);
        }

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

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getUrl();
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $PageComponent;


    /**
     * Add pageComponent
     *
     * @param \Numa\DOAModuleBundle\Entity\PageComponent $pageComponent
     *
     * @return Page
     */
    public function addPageComponent(\Numa\DOAModuleBundle\Entity\PageComponent $pageComponent)
    {
        $this->PageComponent[] = $pageComponent;

        return $this;
    }

    /**
     * Remove pageComponent
     *
     * @param \Numa\DOAModuleBundle\Entity\PageComponent $pageComponent
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePageComponent(\Numa\DOAModuleBundle\Entity\PageComponent $pageComponent)
    {
        return $this->PageComponent->removeElement($pageComponent);
    }

    /**
     * Get pageComponent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageComponent()
    {
        return $this->PageComponent;
    }
    /**
     * @var int
     */
    private $dealer_id;

    /**
     * @JMS\Expose
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Dealer;


    /**
     * Set dealerId
     *
     * @param int $dealerId
     *
     * @return Page
     */
    public function setDealerId($dealerId)
    {
        $this->dealer_id = $dealerId;

        return $this;
    }

    /**
     * Get dealerId
     *
     * @return int
     */
    public function getDealerId()
    {
        return $this->dealer_id;
    }

    /**
     * Set dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     *
     * @return Page
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
     * @var boolean
     * @JMS\Expose
     */
    private $is_manual;


    /**
     * Set isManual
     *
     * @param boolean $isManual

     * @return Page
     */
    public function setIsManual($isManual)
    {
        $this->is_manual = $isManual;

        return $this;
    }

    /**
     * Get isManual
     *
     * @return boolean
     */
    public function getIsManual()
    {
        return $this->is_manual;
    }

    protected $item_id;
    public function setItemId($item_id){
        $this->item_id = $item_id;
    }

    public function getItemId(){
       return $this->item_id;
    }
}
