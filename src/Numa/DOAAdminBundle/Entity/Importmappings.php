<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class Importmappings
{

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $ImportmappingRow;

    protected $feed_sid;

    public function __construct()
    {
        $this->ImportmappingRow = new ArrayCollection();
    }


    /**
     * Add CatalogRecords
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $catalogRecords
     * @return Catalogcategory
     */
    public function addImportmappingRow(\Numa\DOAAdminBundle\Entity\Importmapping $if)
    {
        $this->ImportmappingRow->add($if);

        return $this;
    }

    /**
     * Remove CatalogRecords
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $catalogRecords
     */
    public function removeImportmappingRow(\Numa\DOAAdminBundle\Entity\Importmapping $if)
    {
        $this->ImportmappingRow->removeElement($if);
    }

    /**
     * Get CatalogRecords
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImportmappingRow()
    {
        return $this->ImportmappingRow;
    }

    public function getFeedSid()
    {
        return $this->feed_sid;
    }

    public function setFeedSid($test)
    {
        $this->feed_sid = $test;
    }

    public function __toString()
    {
        return $this->getSid();
    }
}