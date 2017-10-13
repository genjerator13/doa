<?php

namespace Numa\CCCAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vehtypes
 */
class Vehtypes
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $vehdesc;

    /**
     * @var string
     */
    private $vehclass;

    /**
     * @var float
     */
    private $ctyfsrate;

    /**
     * @var float
     */
    private $hwyfsrate;

    /**
     * @var integer
     */
    private $vehcode;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $probills;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->probills = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set vehdesc
     *
     * @param string $vehdesc
     * @return Vehtypes
     */
    public function setVehdesc($vehdesc)
    {
        $this->vehdesc = $vehdesc;
    
        return $this;
    }

    /**
     * Get vehdesc
     *
     * @return string 
     */
    public function getVehdesc()
    {
        return $this->vehdesc;
    }

    /**
     * Set vehclass
     *
     * @param string $vehclass
     * @return Vehtypes
     */
    public function setVehclass($vehclass)
    {
        $this->vehclass = $vehclass;
    
        return $this;
    }

    /**
     * Get vehclass
     *
     * @return string 
     */
    public function getVehclass()
    {
        return $this->vehclass;
    }

    /**
     * Set ctyfsrate
     *
     * @param float $ctyfsrate
     * @return Vehtypes
     */
    public function setCtyfsrate($ctyfsrate)
    {
        $this->ctyfsrate = $ctyfsrate;
    
        return $this;
    }

    /**
     * Get ctyfsrate
     *
     * @return float 
     */
    public function getCtyfsrate()
    {
        return $this->ctyfsrate;
    }

    /**
     * Set hwyfsrate
     *
     * @param float $hwyfsrate
     * @return Vehtypes
     */
    public function setHwyfsrate($hwyfsrate)
    {
        $this->hwyfsrate = $hwyfsrate;
    
        return $this;
    }

    /**
     * Get hwyfsrate
     *
     * @return float 
     */
    public function getHwyfsrate()
    {
        return $this->hwyfsrate;
    }

    /**
     * Set vehcode
     *
     * @param integer $vehcode
     * @return Vehtypes
     */
    public function setVehcode($vehcode)
    {
        $this->vehcode = $vehcode;
    
        return $this;
    }

    /**
     * Get vehcode
     *
     * @return integer 
     */
    public function getVehcode()
    {
        return $this->vehcode;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Vehtypes
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add probills
     *
     * @param \Numa\CCCAdminBundle\Entity\Probills $probills
     * @return Vehtypes
     */
    public function addProbill(\Numa\CCCAdminBundle\Entity\Probills $probills)
    {
        $this->probills[] = $probills;
    
        return $this;
    }

    /**
     * Remove probills
     *
     * @param \Numa\CCCAdminBundle\Entity\Probills $probills
     */
    public function removeProbill(\Numa\CCCAdminBundle\Entity\Probills $probills)
    {
        $this->probills->removeElement($probills);
    }

    /**
     * Get probills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProbills()
    {
        return $this->probills;
    }
    
    public function set($fieldname, $value) {
        $fieldname = strtolower($fieldname);
        
        $this->$fieldname = $value;


        //check if date
        if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/", $value)) {
            $this->$fieldname = new \DateTime($value);
        }
    }

    public function __toString() {
        return $this->vehdesc;
    }
    /**
     * @var integer
     */
    private $type;


    /**
     * Set type
     *
     * @param integer $type
     * @return Vehtypes
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @var string
     */
    private $short_type;


    /**
     * Set short_type
     *
     * @param string $shortType
     * @return Vehtypes
     */
    public function setShortType($shortType)
    {
        $this->short_type = $shortType;
    
        return $this;
    }

    /**
     * Get short_type
     *
     * @return string 
     */
    public function getShortType()
    {
        return $this->short_type;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $LtDispatch;


    /**
     * Add ltDispatch
     *
     * @param \Numa\CCCAdminBundle\Entity\LtDispatch $ltDispatch
     *
     * @return Vehtypes
     */
    public function addLtDispatch(\Numa\CCCAdminBundle\Entity\LtDispatch $ltDispatch)
    {
        $this->LtDispatch[] = $ltDispatch;

        return $this;
    }

    /**
     * Remove ltDispatch
     *
     * @param \Numa\CCCAdminBundle\Entity\LtDispatch $ltDispatch
     */
    public function removeLtDispatch(\Numa\CCCAdminBundle\Entity\LtDispatch $ltDispatch)
    {
        $this->LtDispatch->removeElement($ltDispatch);
    }

    /**
     * Get ltDispatch
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLtDispatch()
    {
        return $this->LtDispatch;
    }

    /**
     * @var integer
     */
    private $prg;


    /**
     * Set prg
     *
     * @param integer $prg
     *
     * @return Vehtypes
     */
    public function setPrg($prg)
    {
        $this->prg = $prg;

        return $this;
    }

    /**
     * Get prg
     *
     * @return integer
     */
    public function getPrg()
    {
        return $this->prg;
    }
}
