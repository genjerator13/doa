<?php

namespace Numa\DOAModuleBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;


/**
 * @ExclusionPolicy("all")
 */
class Ad
{
    /**
     * @var integer
     * @Expose
     */
    private $id;

    /**
     * @var integer
     * @Expose
     */
    private $page_id;

    /**
     * @var string
     * @Expose
     */
    private $name;

    /**
     * @var string
     * @Expose
     */
    private $title;

    /**
     * @var string
     * @Expose
     */
    private $position;

    /**
     * @var string
     * @Expose
     */
    private $status;

    /**
     * @var string
     * @Expose
     */
    private $photo;

    /**
     * @var float
     */
    private $discount;

    /**
     * @var string
     * @Expose
     */
    private $body;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->PageAds = new \Doctrine\Common\Collections\ArrayCollection();
        $this->start_date = new \DateTime();
        $this->end_date = new \DateTime();
    }

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
     * @return Ad
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
     * Set name
     *
     * @param string $name
     * @return Ad
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Ad
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
     * Set position
     *
     * @param string $position
     * @return Ad
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Ad
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
     * Set photo
     *
     * @param string $photo
     * @return Ad
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set discount
     *
     * @param float $discount
     * @return Ad
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return float 
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Ad
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Ad
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Ad
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        if (!$this->getCreatedAt()) {
            $this->createdAt = new \DateTime();
            $this->updatedAt = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
            $this->updatedAt = new \DateTime();
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $PageAds;


    /**
     * Add PageAds
     *
     * @param \Numa\DOAModuleBundle\Entity\PageAds $pageAds
     * @return Ad
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

    /**
     * Get PageAds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function removePageAds()
    {
        $this->PageAds = array();
    }


    //UPLOAD

    public function getAbsolutePath()
    {
        return null === $this->photo ? null : $this->getUploadRootDir() . '/' . $this->photo;
    }

    public function getLogoImage()
    {
        return null === $this->photo ? null : '/' . $this->getUploadDir() . '/' . $this->photo;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'upload/ads/' . $this->getId();
    }

    public $file_import_source;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFileImportSource(\Symfony\Component\HttpFoundation\File\UploadedFile $file_import_source = null)
    {
        $this->file_import_source = $file_import_source;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFileImportSource()
    {
        return $this->file_import_source;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required

        if (null === $this->getFileImportSource()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the
        // target filename to move to
        $this->getFileImportSource()->move(
            $this->getUploadRootDir(), $this->getFileImportSource()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->photo = $this->getUploadDir() . "/" . $this->getFileImportSource()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file_import_source = null;
    }
    /**
     * @var string
     */
    private $size;


    /**
     * Set size
     *
     * @param string $size
     * @return Ad
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string 
     */
    public function getSize()
    {
        return $this->size;
    }
    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $order;

    /**
     * @var \DateTime
     */
    private $start_date;

    /**
     * @var \DateTime
     */
    private $end_date;


    /**
     * Set url
     *
     * @param string $url
     * @return Ad
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
     * Set order
     *
     * @param integer $order
     * @return Ad
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set start_date
     *
     * @param \DateTime $startDate
     * @return Ad
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;

        return $this;
    }

    /**
     * Get start_date
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set end_date
     *
     * @param \DateTime $endDate
     * @return Ad
     */
    public function setEndDate($endDate)
    {
        $this->end_date = $endDate;

        return $this;
    }

    /**
     * Get end_date
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->end_date;
    }
    /**
     * @var integer
     */
    private $adorder;


    /**
     * Set adorder
     *
     * @param integer $adorder
     * @return Ad
     */
    public function setAdorder($adorder)
    {
        $this->adorder = $adorder;

        return $this;
    }

    /**
     * Get adorder
     *
     * @return integer 
     */
    public function getAdorder()
    {
        return $this->adorder;
    }

    // Important manytomany
    public function getPages()
    {
        $pages = new ArrayCollection();
        if (!empty($this->getPageAds()) ) {
            foreach ($this->getPageAds() as $pa) {
                if ($pa instanceof PageAds) {
                    $pages[] = $pa->getPage();
                }
            }
        }
        return $pages;
    }


    // Important manytomany
    public function setPages($pageAds)
    {
        foreach ($pageAds as $pageAd) {
            $pa = new PageAds();

            $pa->setPage($pageAd);
            $pa->setAd($this);

            $this->addPageAd($pa);
        }

    }


    /**
     * @var integer
     */
    private $clicks;

    /**
     * @var integer
     */
    private $views;


    /**
     * Set clicks
     *
     * @param integer $clicks
     * @return Ad
     */
    public function setClicks($clicks)
    {
        $this->clicks = $clicks;

        return $this;
    }

    /**
     * Get clicks
     *
     * @return integer 
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * Set views
     *
     * @param integer $views
     * @return Ad
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer 
     */
    public function getViews()
    {
        return $this->views;
    }
    public function getRatio()
    {
        $ratio = 0;
        if (!$this->clicks == 0 && !$this->views == 0)
        $ratio = $this->views / $this->clicks;
        return number_format((float)$ratio, 2, '.', '');
    }
    /**
     * @var integer
     */
    private $dealer_id;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Catalogrecords;


    /**
     * Set dealerId
     *
     * @param integer $dealerId
     *
     * @return Ad
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
     * Set catalogrecords
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $catalogrecords
     *
     * @return Ad
     */
    public function setCatalogrecords(\Numa\DOAAdminBundle\Entity\Catalogrecords $catalogrecords = null)
    {
        $this->Catalogrecords = $catalogrecords;

        return $this;
    }

    /**
     * Get catalogrecords
     *
     * @return \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    public function getCatalogrecords()
    {
        return $this->Catalogrecords;
    }
}
