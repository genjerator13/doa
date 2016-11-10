<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserItem
 */
class UserItem
{
    const SAVED_AD = 1;
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $user_id;

    /**
     * @var integer
     */
    private $item_id;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var integer
     */
    private $item_type;

    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var \DateTime
     */
    private $date_updated;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Item
     */
    private $Item;


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
     * Set user_id
     *
     * @param integer $userId
     * @return UserItem
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set item_id
     *
     * @param integer $itemId
     * @return UserItem
     */
    public function setItemId($itemId)
    {
        $this->item_id = $itemId;

        return $this;
    }

    /**
     * Get item_id
     *
     * @return integer
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return UserItem
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set item_type
     *
     * @param integer $itemType
     * @return UserItem
     */
    public function setItemType($itemType)
    {
        $this->item_type = $itemType;

        return $this;
    }

    /**
     * Get item_type
     *
     * @return integer
     */
    public function getItemType()
    {
        return $this->item_type;
    }

    /**
     * Set date_created
     *
     * @param \DateTime $dateCreated
     * @return UserItem
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;

        return $this;
    }

    /**
     * Get date_created
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set date_updated
     *
     * @param \DateTime $dateUpdated
     * @return UserItem
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->date_updated = $dateUpdated;

        return $this;
    }

    /**
     * Get date_updated
     *
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }

    /**
     * Set Item
     *
     * @param \Numa\DOAAdminBundle\Entity\Item $item
     * @return UserItem
     */
    public function setItem(\Numa\DOAAdminBundle\Entity\Item $item = null)
    {
        $this->Item = $item;

        return $this;
    }

    /**
     * Get Item
     *
     * @return \Numa\DOAAdminBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->Item;
    }

    /**
     * @var \Numa\DOAAdminBundle\Entity\User
     */
    private $User;


    /**
     * Set User
     *
     * @param \Numa\DOAAdminBundle\Entity\User $user
     * @return UserItem
     */
    public function setUser(\Numa\DOAAdminBundle\Entity\User $user = null)
    {
        $this->User = $user;

        return $this;
    }

    /**
     * Get User
     *
     * @return \Numa\DOAAdminBundle\Entity\User
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        // Add your code here
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        // Add your code here
    }
}
