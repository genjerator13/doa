<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 16.7.17.
 * Time: 08.25
 */
namespace Numa\DOADMSBundle\Util;
use Doctrine\ORM\Mapping as ORM;
trait dateCreatedTrait // implements Logger
{
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if (!$this->getDateCreated()) {
            $this->date_created = new \DateTime();
            $this->date_updated = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        if(empty($this->dontupdate)){

            $this->date_updated = new \DateTime();
        }
    }
}
