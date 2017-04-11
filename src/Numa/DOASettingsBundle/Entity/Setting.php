<?php

namespace Numa\DOASettingsBundle\Entity;

/**
 * Setting
 */
class Setting
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $section;


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
     * Set name
     *
     * @param string $name
     *
     * @return Setting
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
     * Set value
     *
     * @param string $value
     *
     * @return Setting
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
     * Set section
     *
     * @param string $section
     *
     * @return Setting
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return string
     */
    public function getSection()
    {
        return $this->section;
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
     * @return Setting
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
     * @return Setting
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
     * @var string
     */
    private $value2;

    /**
     * @var string
     */
    private $value3;

    /**
     * @var string
     */
    private $value4;


    /**
     * Set value2
     *
     * @param string $value2
     *
     * @return Setting
     */
    public function setValue2($value2)
    {
        $this->value2 = $value2;

        return $this;
    }

    /**
     * Get value2
     *
     * @return string
     */
    public function getValue2()
    {
        return $this->value2;
    }

    /**
     * Set value3
     *
     * @param string $value3
     *
     * @return Setting
     */
    public function setValue3($value3)
    {
        $this->value3 = $value3;

        return $this;
    }

    /**
     * Get value3
     *
     * @return string
     */
    public function getValue3()
    {
        return $this->value3;
    }

    /**
     * Set value4
     *
     * @param string $value4
     *
     * @return Setting
     */
    public function setValue4($value4)
    {
        $this->value4 = $value4;

        return $this;
    }

    /**
     * Get value4
     *
     * @return string
     */
    public function getValue4()
    {
        return $this->value4;
    }
}
