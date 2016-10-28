<?php

namespace Numa\DOADMSBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * SupportForm
 */
class SupportForm
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
    private $dms_user_id;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Dealer;

    /**
     * @var \Numa\DOADMSBundle\Entity\DMSUser
     */
    private $DMSUser;


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
     * @return SupportForm
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
     * Set dmsUserId
     *
     * @param integer $dmsUserId
     *
     * @return SupportForm
     */
    public function setDmsUserId($dmsUserId)
    {
        $this->dms_user_id = $dmsUserId;

        return $this;
    }

    /**
     * Get dmsUserId
     *
     * @return integer
     */
    public function getDmsUserId()
    {
        return $this->dms_user_id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return SupportForm
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return SupportForm
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return SupportForm
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
     * Set message
     *
     * @param string $message
     *
     * @return SupportForm
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     *
     * @return SupportForm
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
     * Set dMSUser
     *
     * @param \Numa\DOADMSBundle\Entity\DMSUser $dMSUser
     *
     * @return SupportForm
     */
    public function setDMSUser(\Numa\DOADMSBundle\Entity\DMSUser $dMSUser = null)
    {
        $this->DMSUser = $dMSUser;

        return $this;
    }

    /**
     * Get dMSUser
     *
     * @return \Numa\DOADMSBundle\Entity\DMSUser
     */
    public function getDMSUser()
    {
        return $this->DMSUser;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if (!$this->getCreatedAt()) {
            $this->created_at = new \DateTime();
            $this->updated_at = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        if(empty($this->dontupdate)){

            $this->updated_at = new \DateTime();
        }
    }
    /**
     * @var string
     */
    private $subject;


    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return SupportForm
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
