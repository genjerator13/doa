<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserGroup
 */
class UserGroup
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $reg_form_template;

    /**
     * @var string
     */
    private $description;

    /**
     * @var boolean
     */
    private $immediate_activation;

    /**
     * @var string
     */
    private $user_menu_template;

    /**
     * @var integer
     */
    private $initial_balance;

    /**
     * @var boolean
     */
    private $make_user_trusted;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $User;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->User = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set name
     *
     * @param string $name
     * @return UserGroup
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
     * Set reg_form_template
     *
     * @param string $regFormTemplate
     * @return UserGroup
     */
    public function setRegFormTemplate($regFormTemplate)
    {
        $this->reg_form_template = $regFormTemplate;
    
        return $this;
    }

    /**
     * Get reg_form_template
     *
     * @return string 
     */
    public function getRegFormTemplate()
    {
        return $this->reg_form_template;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return UserGroup
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set immediate_activation
     *
     * @param boolean $immediateActivation
     * @return UserGroup
     */
    public function setImmediateActivation($immediateActivation)
    {
        $this->immediate_activation = $immediateActivation;
    
        return $this;
    }

    /**
     * Get immediate_activation
     *
     * @return boolean 
     */
    public function getImmediateActivation()
    {
        return $this->immediate_activation;
    }

    /**
     * Set user_menu_template
     *
     * @param string $userMenuTemplate
     * @return UserGroup
     */
    public function setUserMenuTemplate($userMenuTemplate)
    {
        $this->user_menu_template = $userMenuTemplate;
    
        return $this;
    }

    /**
     * Get user_menu_template
     *
     * @return string 
     */
    public function getUserMenuTemplate()
    {
        return $this->user_menu_template;
    }

    /**
     * Set initial_balance
     *
     * @param integer $initialBalance
     * @return UserGroup
     */
    public function setInitialBalance($initialBalance)
    {
        $this->initial_balance = $initialBalance;
    
        return $this;
    }

    /**
     * Get initial_balance
     *
     * @return integer 
     */
    public function getInitialBalance()
    {
        return $this->initial_balance;
    }

    /**
     * Set make_user_trusted
     *
     * @param boolean $makeUserTrusted
     * @return UserGroup
     */
    public function setMakeUserTrusted($makeUserTrusted)
    {
        $this->make_user_trusted = $makeUserTrusted;
    
        return $this;
    }

    /**
     * Get make_user_trusted
     *
     * @return boolean 
     */
    public function getMakeUserTrusted()
    {
        return $this->make_user_trusted;
    }

    /**
     * Add User
     *
     * @param \Numa\DOAAdminBundle\Entity\User $user
     * @return UserGroup
     */
    public function addUser(\Numa\DOAAdminBundle\Entity\User $user)
    {
        $this->User[] = $user;
    
        return $this;
    }

    /**
     * Remove User
     *
     * @param \Numa\DOAAdminBundle\Entity\User $user
     */
    public function removeUser(\Numa\DOAAdminBundle\Entity\User $user)
    {
        $this->User->removeElement($user);
    }

    /**
     * Get User
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUser()
    {
        return $this->User;
    }
    /**
     * Get User
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function __toString()
    {
        return $this->getName();
    }
}
