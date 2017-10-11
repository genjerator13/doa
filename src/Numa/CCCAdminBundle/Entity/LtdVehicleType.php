<?php

namespace Numa\CCCAdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * LtdVehicleType
 */
class LtdVehicleType
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $ltd_id;

    /**
     * @var integer
     */
    private $vehtype_id;


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
     * Set ltdId
     *
     * @param integer $ltdId
     *
     * @return LtdVehicleType
     */
    public function setLtdId($ltdId)
    {
        $this->ltd_id = $ltdId;

        return $this;
    }

    /**
     * Get ltdId
     *
     * @return integer
     */
    public function getLtdId()
    {
        return $this->ltd_id;
    }

    /**
     * Set vehtypeId
     *
     * @param integer $vehtypeId
     *
     * @return LtdVehicleType
     */
    public function setVehtypeId($vehtypeId)
    {
        $this->vehtype_id = $vehtypeId;

        return $this;
    }

    /**
     * Get vehtypeId
     *
     * @return integer
     */
    public function getVehtypeId()
    {
        return $this->vehtype_id;
    }
    /**
     * @var \Numa\CCCAdminBundle\Entity\LtDispatch
     */
    private $LtDispatch;

    /**
     * @var \Numa\CCCAdminBundle\Entity\Vehtypes
     */
    private $Vehtypes;


    /**
     * Set ltDispatch
     *
     * @param \Numa\CCCAdminBundle\Entity\LtDispatch $ltDispatch
     *
     * @return LtdVehicleType
     */
    public function setLtDispatch(\Numa\CCCAdminBundle\Entity\LtDispatch $ltDispatch = null)
    {
        $this->LtDispatch = $ltDispatch;

        return $this;
    }

    /**
     * Get ltDispatch
     *
     * @return \Numa\CCCAdminBundle\Entity\LtDispatch
     */
    public function getLtDispatch()
    {
        return $this->LtDispatch;
    }

    /**
     * Set vehtypes
     *
     * @param \Numa\CCCAdminBundle\Entity\Vehtypes $vehtypes
     *
     * @return LtdVehicleType
     */
    public function setVehtypes(\Numa\CCCAdminBundle\Entity\Vehtypes $vehtypes = null)
    {
        $this->Vehtypes = $vehtypes;

        return $this;
    }

    /**
     * Get vehtypes
     *
     * @return \Numa\CCCAdminBundle\Entity\Vehtypes
     */
    public function getVehtypes()
    {
        return $this->Vehtypes;
    }
}
