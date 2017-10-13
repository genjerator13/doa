<?php

namespace Numa\CCCAdminBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CustomRate
 */
class CustomRate
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
    private $description;

    /**
     * @var string
     */
    private $src;

    private $uploadDir;
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
     * @return CustomRate
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
     * Set description
     *
     * @param string $description
     *
     * @return CustomRate
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
     * Set src
     *
     * @param string $src
     *
     * @return CustomRate
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $CustomRateRate;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->CustomRateRate = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add customRateRate
     *
     * @param \Numa\CCCAdminBundle\Entity\CustomRateRate $customRateRate
     *
     * @return CustomRate
     */
    public function addCustomRateRate(\Numa\CCCAdminBundle\Entity\CustomRateRate $customRateRate)
    {
        $this->CustomRateRate[] = $customRateRate;

        return $this;
    }

    /**
     * Remove customRateRate
     *
     * @param \Numa\CCCAdminBundle\Entity\CustomRateRate $customRateRate
     */
    public function removeCustomRateRate(\Numa\CCCAdminBundle\Entity\CustomRateRate $customRateRate)
    {
        $this->CustomRateRate->removeElement($customRateRate);
    }

    /**
     * Get customRateRate
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomRateRate()
    {
        return $this->CustomRateRate;
    }




    // Important
    public function getRates()
    {
        $rates = new ArrayCollection();
        if (!empty($this->getCustomRateRate()) && !$this->getCustomRateRate()->isEmpty()) {

            foreach ($this->getCustomRateRate() as $r) {
                if ($r instanceof CustomRateRate) {
                    $rates[] = $r->getRates();
                }
            }
        }
        return $rates;
    }


    // Important
    public function setRates($rates)
    {
        foreach ($rates as $rate) {
            $crr = new CustomRateRate();

            $crr->setCustomRate($this);
            $crr->setRates($rate);

            $this->addCustomRateRate($crr);
        }
    }
    private $src_file;

    public function getSrcFile() {
        return $this->src_file;
    }

    public function setSrcFile($src_file)
    {
        $this->src_file = $src_file;
    }

    public function getAbsolutePath()
    {
        return null === $this->src ? null : $this->getUploadRootDir() . '/' . $this->src;
    }

    public function getWebPath()
    {
        //dump($this->rate_pdf);die();

        return null === $this->src ? null : $this->getUploadDir() . '/' . $this->src;
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
        if(empty($this->uploadDir)){
            return 'upload/rate';
        }
        return $this->uploadDir;
    }

    public function setUploadDir($dir){
        $this->uploadDir = $dir;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getSrcFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the
        // target filename to move to
        if(!is_dir($this->getUploadRootDir())){
            mkdir($this->getUploadRootDir(),0777,true);
        }
        $this->getSrcFile()->move(
            $this->getUploadRootDir(), $this->getSrcFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->src = $this->getSrcFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->src_file = null;
    }

    public function writeRates(){
        return implode(", ",$this->getCustomRateValue()->toArray());
    }
    /**
     * @var string
     */
    private $custommade_rate;


    /**
     * Set custommadeRate
     *
     * @param string $custommadeRate
     *
     * @return CustomRate
     */
    public function setCustommadeRate($custommadeRate)
    {
        $this->custommade_rate = $custommadeRate;

        return $this;
    }

    /**
     * Get custommadeRate
     *
     * @return string
     */
    public function getCustommadeRate()
    {
        return $this->custommade_rate;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $CustomRateValue;


    /**
     * Add customRateValue
     *
     * @param \Numa\CCCAdminBundle\Entity\CustomRateValue $customRateValue
     *
     * @return CustomRate
     */
    public function addCustomRateValue(\Numa\CCCAdminBundle\Entity\CustomRateValue $customRateValue)
    {
        $this->CustomRateValue[] = $customRateValue;

        return $this;
    }

    /**
     * Remove customRateValue
     *
     * @param \Numa\CCCAdminBundle\Entity\CustomRateValue $customRateValue
     */
    public function removeCustomRateValue(\Numa\CCCAdminBundle\Entity\CustomRateValue $customRateValue)
    {
        $this->CustomRateValue->removeElement($customRateValue);
    }

    /**
     * Get customRateValue
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomRateValue()
    {
        return $this->CustomRateValue;
    }
}
