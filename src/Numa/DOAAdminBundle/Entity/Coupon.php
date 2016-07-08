<?php

namespace Numa\DOAAdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Coupon
 */
class Coupon
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

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
    private $description;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;


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
     * Set name
     *
     * @param string $name
     *
     * @return Coupon
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
     * Set photo
     *
     * @param string $photo
     *
     * @return Coupon
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
     *
     * @return Coupon
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
     * Set description
     *
     * @param string $description
     *
     * @return Coupon
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Coupon
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
     *
     * @return Coupon
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
//    public function setCreatedAtValue()
//    {
//        // Add your code here
//    }
//
//    /**
//     * @ORM\PreUpdate
//     */
//    public function setUpdatedAtValue()
//    {
//        // Add your code here
//    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        if (!$this->getUpdatedAt()) {
            $this->setCreatedAt(new \DateTime());
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->date_updated = new \DateTime();
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
     * @return Coupon
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
     * @return Coupon
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

    public function getUploadRootDir()
    {
        // absolute path to your directory where images must be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        return 'upload/coupons';
    }

    public function getAbsolutePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir().'/'.$this->image;
    }

    public function getWebPath()
    {
        return null === $this->image ? null : '/'.$this->getUploadDir().'/'.$this->image;
    }

    /**
     * @var string
     */
    private $originalImage;


    /**
     * Set originalImage
     *
     * @param string $originalImage
     *
     * @return Coupon
     */
    public function setOriginalImage($originalImage)
    {
        $this->originalImage = $originalImage;

        return $this;
    }

    /**
     * Get originalImage
     *
     * @return string
     */
    public function getOriginalImage()
    {
        return $this->originalImage;
    }
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFileImportSource()
    {
        return $this->originalImage;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required

        if (null === $this->getOriginalImage()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the
        // target filename to move to
        dump($this->getUploadRootDir());
        if(!file_exists($this->getUploadDir() . "/" . $this->getCatalogrecords()->getId())){

            mkdir($this->getUploadDir() . "/" . $this->getCatalogrecords()->getId(),0775,true);
        }

        $this->getOriginalImage()->move(
            $this->getUploadDir() . "/" . $this->getCatalogrecords()->getId(), "coupon".$this->getId().".".$this->getOriginalImage()->getClientOriginalExtension()
        );

        // set the path property to the filename where you've saved the file

        $this->photo = $this->getUploadDir() . "/" . $this->getCatalogrecords()->getId()."/coupon".$this->getId().".".$this->getOriginalImage()->getClientOriginalExtension();

        // clean up the file property as you won't need it anymore
        $this->originalImage = null;
    }
    public function isEmpty(){
//        if (empty($this->getPhoto()) && empty($this->getDescription()) && empty($this->$discount)){
//            return false;
//        }
//        else{
//            return true;
//        }
        return empty($this->getPhoto()) && empty($this->getDescription()) && empty($this->getDiscount());
    }
}
