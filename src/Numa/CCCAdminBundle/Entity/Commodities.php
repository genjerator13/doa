<?php

namespace Numa\CCCAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commodities
 */
class Commodities
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $commodity;

    /**
     * @var float
     */
    private $quantity;

    /**
     * @var integer
     */
    private $comcode;


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
     * Set commodity
     *
     * @param string $commodity
     * @return Commodities
     */
    public function setCommodity($commodity)
    {
        $this->commodity = $commodity;

        return $this;
    }

    /**
     * Get commodity
     *
     * @return string 
     */
    public function getCommodity()
    {
        return $this->commodity;
    }

    /**
     * Set quantity
     *
     * @param float $quantity
     * @return Commodities
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return float 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set comcode
     *
     * @param integer $comcode
     * @return Commodities
     */
    public function setComcode($comcode)
    {
        $this->comcode = $comcode;

        return $this;
    }

    /**
     * Get comcode
     *
     * @return integer 
     */
    public function getComcode()
    {
        return $this->comcode;
    }
}
