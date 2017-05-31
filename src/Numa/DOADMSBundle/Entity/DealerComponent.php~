<?php

namespace Numa\DOADMSBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Numa\Util\Component\ComponentEntityInterface;

/**
 * DealerComponent
 */
class DealerComponent  implements ComponentEntityInterface
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
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $settings;

    /**
     * @var \DateTime
     */
    private $date_updated;

    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Dealer;


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
     * @return DealerComponent
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
     * Set name
     *
     * @param string $name
     *
     * @return DealerComponent
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
     * Set type
     *
     * @param string $type
     *
     * @return DealerComponent
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return DealerComponent
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set settings
     *
     * @param string $settings
     *
     * @return DealerComponent
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Get settings
     *
     * @return string
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return DealerComponent
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->date_updated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return DealerComponent
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return DealerComponent
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
     * Set dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     *
     * @return DealerComponent
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
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        if (!$this->getDateCreated()) {
            $this->date_created = new \DateTime();
            $this->date_updated = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
            $this->date_updated = new \DateTime();

    }
    
    /**
     * @var string
     */
    private $helpdesc;


    /**
     * Set helpdesc
     *
     * @param string $helpdesc
     *
     * @return DealerComponent
     */
    public function setHelpdesc($helpdesc)
    {
        $this->helpdesc = $helpdesc;

        return $this;
    }

    /**
     * Get helpdesc
     *
     * @return string
     */
    public function getHelpdesc()
    {
        if(empty($this->helpdesc)){
            return "";
        }
        return $this->helpdesc;
    }

    /**
     * @var string
     */
    private $help;


    /**
     * Set help
     *
     * @param string $help
     *
     * @return Component
     */
    public function setHelp($help)
    {
        $this->help = $help;

        return $this;
    }

    /**
     * Get helpdesc
     *
     * @return string
     */
    public function getHelp()
    {
        return $this->help;
    }
    /**
     * @var string
     */
    private $theme;


    /**
     * Set theme
     *
     * @param string $theme
     *
     * @return DealerComponent
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }
}
