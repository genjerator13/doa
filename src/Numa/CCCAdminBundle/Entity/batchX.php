<?php

namespace Numa\CCCAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * batchX
 */
class batchX {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $started;

    /**
     * @var \DateTime
     */
    private $closed;

    /**
     * @var string
     */
    private $dbfile;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $probills;
    private $path;
    private $file;
    private $file_invoice;

    /**
     * Constructor
     */
    public function __construct() {
        $this->probills = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return batchX
     */
    public function setName($name) {
        if(!empty($name)) {
            $this->name = $name;
        }
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set started
     *
     * @param \DateTime $started
     * @return batchX
     */
    public function setStarted($started) {
        if(!empty($started)) {
            $this->started = $started;
        }

        return $this;
    }

    /**
     * Get started
     *
     * @return \DateTime 
     */
    public function getStarted() {
        return $this->started;
    }

    /**
     * Set closed
     *
     * @param \DateTime $closed
     * @return batchX
     */
    public function setClosed($closed) {
        if(!empty($closed)) {
            $this->closed = $closed;
        }
        return $this;
    }

    /**
     * Get closed
     *
     * @return \DateTime 
     */
    public function getClosed() {
        return $this->closed;
    }

    /**
     * Set dbfile
     *
     * @param string $dbfile
     * @return batchX
     */
    public function setDbfile($dbfile) {
        if(!empty($dbfile)) {
            $this->dbfile = $dbfile;
        }
    }

    public function getFile() {
        
        return $this->file;
    }

    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * Get dbfile
     *
     * @return string 
     */
    public function getDbfile() {
        return $this->dbfile;
    }

    /**
     * Add probills
     *
     * @param \Numa\CCCAdminBundle\Entity\Probills $probills
     * @return batchX
     */
    public function addProbill(\Numa\CCCAdminBundle\Entity\Probills $probills) {
        $this->probills[] = $probills;

        return $this;
    }

    /**
     * Remove probills
     *
     * @param \Numa\CCCAdminBundle\Entity\Probills $probills
     */
    public function removeProbill(\Numa\CCCAdminBundle\Entity\Probills $probills) {
        $this->probills->removeElement($probills);
    }

    /**
     * Get probills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProbills() {
        return $this->probills;
    }

    private $temp;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        
        if (null !== $this->getFile()) {

            $this->path = $this->getFile()->guessExtension();
            $this->dbfile = $this->getFile()->getClientOriginalName();
        }
    }
    

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        
        if (null === $this->getFile()) {
            return;
        }
        
        $this->getFile()->move(
                $this->getUploadRootDir(), $this->getFile()->getClientOriginalName()
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove() {
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        if (isset($this->temp)) {
            unlink($this->temp);
        }
    }

    public function getAbsolutePath() {
        return null === $this->path ? null : $this->getUploadRootDir();
    }

    public function getFullImagePath() {
        return null === $this->file ? null : $this->getUploadRootDir() . $this->file;
    }

    public  function getUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return $this->getTmpUploadRootDir() . $this->getId() . "/";
    }

    protected function getTmpUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../web/upload/';
    }

    public function __toString() {
        return $this->getName();
    }

    public function getScansFolder() {
        $dir = "empty";
        
        if ($this->getClosed() instanceof \DateTime) {

            $dir = strtoupper($this->getClosed()->format('Md-y'));
        }
        return $dir;
    }

    /**
     * @var string
     */
    private $newsletter;


    /**
     * Set newsletter
     *
     * @param string $newsletter
     * @return batchX
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;
    
        return $this;
    }

    /**
     * Get newsletter
     *
     * @return string 
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }
    /**
     * @var integer
     */
    private $working_days;


    /**
     * Set workingDays
     *
     * @param integer $workingDays
     *
     * @return batchX
     */
    public function setWorkingDays($workingDays)
    {
        $this->working_days = $workingDays;

        return $this;
    }

    /**
     * Get workingDays
     *
     * @return integer
     */
    public function getWorkingDays()
    {
        return $this->working_days;
    }
}
