<?php

namespace Numa\CCCAdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * LtdAdditional
 */
class LtdAdditional
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
    private $additional_id;


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
     * @return LtdAdditional
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
     * Set additionalId
     *
     * @param integer $additionalId
     *
     * @return LtdAdditional
     */
    public function setAdditionalId($additionalId)
    {
        $this->additional_id = $additionalId;

        return $this;
    }

    /**
     * Get additionalId
     *
     * @return integer
     */
    public function getAdditionalId()
    {
        return $this->additional_id;
    }
    /**
     * @var \Numa\CCCAdminBundle\Entity\LtDispatch
     */
    private $LtDispatch;

    /**
     * @var \Numa\CCCAdminBundle\Entity\AdditionalReq
     */
    private $AdditionalReq;


    /**
     * Set ltDispatch
     *
     * @param \Numa\CCCAdminBundle\Entity\LtDispatch $ltDispatch
     *
     * @return LtdAdditional
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
     * Set additionalReq
     *
     * @param \Numa\CCCAdminBundle\Entity\AdditionalReq $additionalReq
     *
     * @return LtdAdditional
     */
    public function setAdditionalReq(\Numa\CCCAdminBundle\Entity\AdditionalReq $additionalReq = null)
    {
        $this->AdditionalReq = $additionalReq;

        return $this;
    }

    /**
     * Get additionalReq
     *
     * @return \Numa\CCCAdminBundle\Entity\AdditionalReq
     */
    public function getAdditionalReq()
    {
        return $this->AdditionalReq;
    }
}
