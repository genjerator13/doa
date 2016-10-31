<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSearch
 */
class UserSearch
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $user_id;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var integer
     */
    private $search_type;

    /**
     * @var string
     */
    private $search_url;

    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var \DateTime
     */
    private $date_updated;

    /**
     * @var \Numa\DOAAdminBundle\Entity\User
     */
    private $User;


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
     * @return UserSearch
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
     * Set active
     *
     * @param boolean $active
     * @return UserSearch
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
     * Set search_type
     *
     * @param integer $searchType
     * @return UserSearch
     */
    public function setSearchType($searchType)
    {
        $this->search_type = $searchType;

        return $this;
    }

    /**
     * Get search_type
     *
     * @return integer
     */
    public function getSearchType()
    {
        return $this->search_type;
    }

    /**
     * Set search_url
     *
     * @param string $searchUrl
     * @return UserSearch
     */
    public function setSearchUrl($searchUrl)
    {
        $this->search_url = $searchUrl;

        return $this;
    }

    /**
     * Get search_url
     *
     * @return string
     */
    public function getSearchUrl()
    {
        return $this->search_url;
    }

    /**
     * Set date_created
     *
     * @param \DateTime $dateCreated
     * @return UserSearch
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
     * @return UserSearch
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
     * Set User
     *
     * @param \Numa\DOAAdminBundle\Entity\User $user
     * @return UserSearch
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

    /**
     * @var string
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     * @return UserSearch
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
}
