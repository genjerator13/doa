<?php

namespace Numa\CCCAdminBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 */
class User implements UserInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var integer
     */
    private $user_group_id;

    /**
     * @var \DateTime
     */
    private $registration_date;

    /**
     * @var string
     */
    private $manyToOne;


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
     * Set status
     *
     * @param boolean $status
     *
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set userGroupId
     *
     * @param integer $userGroupId
     *
     * @return User
     */
    public function setUserGroupId($userGroupId)
    {
        $this->user_group_id = $userGroupId;

        return $this;
    }

    /**
     * Get userGroupId
     *
     * @return integer
     */
    public function getUserGroupId()
    {
        return $this->user_group_id;
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     *
     * @return User
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registration_date = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registration_date;
    }

    /**
     * Set manyToOne
     *
     * @param string $manyToOne
     *
     * @return User
     */
    public function setManyToOne($manyToOne)
    {
        $this->manyToOne = $manyToOne;

        return $this;
    }

    /**
     * Get manyToOne
     *
     * @return string
     */
    public function getManyToOne()
    {
        return $this->manyToOne;
    }
    /**
     * @var \Numa\CCCAdminBundle\Entity\UserGroup
     */
    private $UserGroup;


    /**
     * Set userGroup
     *
     * @param \Numa\CCCAdminBundle\Entity\UserGroup $userGroup
     *
     * @return User
     */
    public function setUserGroup(\Numa\CCCAdminBundle\Entity\UserGroup $userGroup = null)
    {
        $this->UserGroup = $userGroup;

        return $this;
    }

    /**
     * Get userGroup
     *
     * @return \Numa\CCCAdminBundle\Entity\UserGroup
     */
    public function getUserGroup()
    {
        return $this->UserGroup;
    }

    public function getRoles()
    {
        if($this->getUserGroup() instanceof UserGroup && $this->getUserGroup()->getName()=="CSR"){
            return array('ROLE_OCR');
        }
        if($this->getUserGroup() instanceof UserGroup && $this->getUserGroup()->getName()=="ADMIN"){
            return array('ROLE_SUPER_ADMIN');
        }
        return array('ROLE_USER');

    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {

    }

    public function equals(User $user)
    {
        return $user->getUsername() == $this->getUsername();
    }

    public function __toString() {

        return $this->getUsername()."";
    }

    public function getName(){
        return $this->__toString();
    }
    /**
     * @var string
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @var boolean
     */
    private $activate;


    /**
     * Set activate
     *
     * @param boolean $activate
     *
     * @return User
     */
    public function setActivate($activate)
    {
        $this->activate = $activate;

        return $this;
    }

    /**
     * Get activate
     *
     * @return boolean
     */
    public function getActivate()
    {
        return $this->activate;
    }
    public function isDeactivated()
    {
        return !($this->activate===null || $this->activate);
    }
}
