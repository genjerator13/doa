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
    /**
     * @var string
     */
    private $value5;

    /**
     * @var string
     */
    private $value6;

    /**
     * @var string
     */
    private $value7;

    /**
     * @var string
     */
    private $value8;

    /**
     * @var string
     */
    private $value9;

    /**
     * @var string
     */
    private $value10;


    /**
     * Set value5
     *
     * @param string $value5
     *
     * @return Setting
     */
    public function setValue5($value5)
    {
        $this->value5 = $value5;

        return $this;
    }

    /**
     * Get value5
     *
     * @return string
     */
    public function getValue5()
    {
        return $this->value5;
    }

    /**
     * Set value6
     *
     * @param string $value6
     *
     * @return Setting
     */
    public function setValue6($value6)
    {
        $this->value6 = $value6;

        return $this;
    }

    /**
     * Get value6
     *
     * @return string
     */
    public function getValue6()
    {
        return $this->value6;
    }

    /**
     * Set value7
     *
     * @param string $value7
     *
     * @return Setting
     */
    public function setValue7($value7)
    {
        $this->value7 = $value7;

        return $this;
    }

    /**
     * Get value7
     *
     * @return string
     */
    public function getValue7()
    {
        return $this->value7;
    }

    /**
     * Set value8
     *
     * @param string $value8
     *
     * @return Setting
     */
    public function setValue8($value8)
    {
        $this->value8 = $value8;

        return $this;
    }

    /**
     * Get value8
     *
     * @return string
     */
    public function getValue8()
    {
        return $this->value8;
    }

    /**
     * Set value9
     *
     * @param string $value9
     *
     * @return Setting
     */
    public function setValue9($value9)
    {
        $this->value9 = $value9;

        return $this;
    }

    /**
     * Get value9
     *
     * @return string
     */
    public function getValue9()
    {
        return $this->value9;
    }

    /**
     * Set value10
     *
     * @param string $value10
     *
     * @return Setting
     */
    public function setValue10($value10)
    {
        $this->value10 = $value10;

        return $this;
    }

    /**
     * Get value10
     *
     * @return string
     */
    public function getValue10()
    {
        return $this->value10;
    }
}
