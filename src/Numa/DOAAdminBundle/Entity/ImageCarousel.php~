<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Numa\DOADMSBundle\Entity\DealerComponent;
use Numa\DOAModuleBundle\Entity\Component;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ImageCarousel
 */
class ImageCarousel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $src;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $position;

    /**
     * @var int
     */
    private $count;

    /**
     * @var bool
     */
    private $is_public;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;


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
     * Set src
     *
     * @param string $src
     *
     * @return ImageCarousel
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return ImageCarousel
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
     * @param int $position
     *
     * @return ImageCarousel
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set count
     *
     * @param int $count
     *
     * @return ImageCarousel
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set isPublic
     *
     * @param bool $isPublic
     *
     * @return ImageCarousel
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ImageCarousel
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
     * @return ImageCarousel
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
    public function setCreatedAtValue()
    {
        if (!$this->getCreatedAt()) {
            $this->created_at = new \DateTime();
            $this->updated_at = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        if (empty($this->dontupdate)) {

            $this->created_at = new \DateTime();
        }
    }

    /**
     * @var string
     */
    private $url;


    /**
     * Set url
     *
     * @param string $url
     *
     * @return ImageCarousel
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
     * @var bool
     */
    private $active = true;


    /**
     * Set active
     *
     * @param bool $active
     *
     * @return ImageCarousel
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

    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : self::getUploadDir() . '/' . $this->path;
    }

    public function getUploadRootDir($dealer=null,$component=null)
    {
        // the absolute directory path where uploaded
        // documents should be saved
        $folder = __DIR__ . '/../../../../web/' . self::getUploadDir($dealer,$component);
//        if(!file_exists($folder)){
//            mkdir($folder,777,true);
//        }
        return $folder;
    }

    public function getImageSrc()
    {
        return $this->getUploadRootDir() . "/" . $this->getSrc();
    }

    public static function getUploadDir($dealer=null,$component=null)
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        $uploadPath = 'upload/carousel';

        if($dealer instanceof Catalogrecords && !empty($dealer->getId()) &&
            ($component instanceof Component || $component instanceof DealerComponent)){

            if($component instanceof Component){
                $uploadPath = 'upload/dealers/'.$dealer->getId()."/component/".$component->getId();
            }elseif($component instanceof DealerComponent){
                $uploadPath = 'upload/dealers/'.$dealer->getId()."/dcomponent/".$component->getId();
            }
        }
        return $uploadPath;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $uploadDir = $this->getUploadRootDir();
        $uploadSrc = "";
        if($this->getDealer() instanceof Catalogrecords && $this->getComponent() instanceof Component) {
            $uploadDir = $this->getUploadRootDir($this->getDealer(), $this->getComponent());
            $uploadSrc = $this->getDealer()->getId()."/component/".$this->getComponent()->getId()."/";
        }elseif($this->getDealer() instanceof Catalogrecords && $this->getDealerComponent() instanceof DealerComponent){
            $uploadDir = $this->getUploadRootDir($this->getDealer(), $this->getDealerComponent());
            $uploadSrc = $this->getDealer()->getId()."/dcomponent/".$this->getDealerComponent()->getId()."/";
        }
        $this->getFile()->move(
            $uploadDir,
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getFile()->getClientOriginalName();

        $this->src = $uploadSrc.$this->getFile()->getClientOriginalName();
        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * @var int
     */
    private $dealer_id;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Dealer;


    /**
     * Set dealerId
     *
     * @param int $dealerId
     *
     * @return ImageCarousel
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
     * @return ImageCarousel
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
     * @var int
     */
    private $component_id;

    /**
     * @var \Numa\DOAModuleBundle\Entity\Component
     */
    private $Component;


    /**
     * Set componentId
     *
     * @param int $componentId
     *
     * @return ImageCarousel
     */
    public function setComponentId($componentId)
    {
        $this->component_id = $componentId;

        return $this;
    }

    /**
     * Get componentId
     *
     * @return int
     */
    public function getComponentId()
    {
        return $this->component_id;
    }

    /**
     * Set component
     *
     * @param \Numa\DOAModuleBundle\Entity\Component $component
     *
     * @return ImageCarousel
     */
    public function setComponent(\Numa\DOAModuleBundle\Entity\Component $component = null)
    {
        $this->Component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return \Numa\DOAModuleBundle\Entity\Component
     */
    public function getComponent()
    {
        return $this->Component;
    }

    /**
     * @var string
     */
    private $carousel_text;


    /**
     * Set carouselText
     *
     * @param string $carouselText
     *
     * @return ImageCarousel
     */
    public function setCarouselText($carouselText)
    {
        $this->carousel_text = $carouselText;

        return $this;
    }

    /**
     * Get carouselText
     *
     * @return string
     */
    public function getCarouselText()
    {
        return $this->carousel_text;
    }

    /**
     * @var integer
     */
    private $dealer_component_id;

    /**
     * @var \Numa\DOADMSBundle\Entity\DealerComponent
     */
    private $Dealer_component;


    /**
     * Set dealerComponentId
     *
     * @param integer $dealerComponentId
     *
     * @return ImageCarousel
     */
    public function setDealerComponentId($dealerComponentId)
    {
        $this->dealer_component_id = $dealerComponentId;

        return $this;
    }

    /**
     * Get dealerComponentId
     *
     * @return integer
     */
    public function getDealerComponentId()
    {
        return $this->dealer_component_id;
    }

    /**
     * Set dealerComponent
     *
     * @param \Numa\DOADMSBundle\Entity\DealerComponent $dealerComponent
     *
     * @return ImageCarousel
     */
    public function setDealerComponent(\Numa\DOADMSBundle\Entity\DealerComponent $dealerComponent = null)
    {
        $this->Dealer_component = $dealerComponent;

        return $this;
    }

    /**
     * Get dealerComponent
     *
     * @return \Numa\DOADMSBundle\Entity\DealerComponent
     */
    public function getDealerComponent()
    {
        return $this->Dealer_component;
    }

    public function __toString()
    {
        return $this->getImageSrc();
        // TODO: Implement __toString() method.
    }
}
