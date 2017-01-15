<?php

namespace Numa\DOADMSBundle\Entity;

/**
 * DealerSetting
 */
class DealerSetting
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $dealer_id;

    /**
     * @var integer
     */
    private $setting_id;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Dealer;

    /**
     * @var \Numa\DOAAdminBundle\Entity\DMSSetting
     */
    private $Setting;


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
     * Set dealerId
     *
     * @param integer $dealerId
     *
     * @return DealerSetting
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
     * Set settingId
     *
     * @param integer $settingId
     *
     * @return DealerSetting
     */
    public function setSettingId($settingId)
    {
        $this->setting_id = $settingId;

        return $this;
    }

    /**
     * Get settingId
     *
     * @return integer
     */
    public function getSettingId()
    {
        return $this->setting_id;
    }

    /**
     * Set dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     *
     * @return DealerSetting
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
     * Set setting
     *
     * @param \Numa\DOAAdminBundle\Entity\DMSSetting $setting
     *
     * @return DealerSetting
     */
    public function setSetting(\Numa\DOADMSBundle\Entity\DMSSetting $setting = null)
    {
        $this->Setting = $setting;

        return $this;
    }

    /**
     * Get setting
     *
     * @return \Numa\DOAAdminBundle\Entity\DMSSetting
     */
    public function getSetting()
    {
        return $this->Setting;
    }
    /**
     * @var \Numa\DOAAdminBundle\Entity\DMSSetting
     */
    private $DMSSetting;


    /**
     * Set dMSSetting
     *
     * @param \Numa\DOAAdminBundle\Entity\DMSSetting $dMSSetting
     *
     * @return DealerSetting
     */
    public function setDMSSetting(\Numa\DOADMSBundle\Entity\DMSSetting $DMSSetting = null)
    {
        $this->DMSSetting = $DMSSetting;
        return $this;
    }

    /**
     * Get dMSSetting
     *
     * @return \Numa\DOAAdminBundle\Entity\DMSSetting
     */
    public function getDMSSetting()
    {
        return $this->DMSSetting;
    }
}
