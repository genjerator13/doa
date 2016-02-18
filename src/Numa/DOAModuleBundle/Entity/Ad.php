<?php

namespace Numa\DOAModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ad
 */
class Ad
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
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $position;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $photo;

    /**
     * @var float
     */
    private $discount;

    /**
     * @var string
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
        //$this->pa = new \Doctrine\Common\Collections\ArrayCollection();
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
}
