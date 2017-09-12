<?php

namespace Numa\DOADMSBundle\Entity;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserLoaderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * DealerGroup
 */
class DealerGroup   implements UserInterface
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
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var \DateTime
     */
    private $date_updated;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Dealer;


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
     * @return DealerGroup
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
     * Set username
     *
     * @param string $username
     *
     * @return DealerGroup
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
     * @return DealerGroup
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
     * Set email
     *
     * @param string $email
     *
     * @return DealerGroup
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return DealerGroup
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return DealerGroup
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return DealerGroup
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->date_updated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }

    /**
     * Set dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     *
     * @return DealerGroup
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Dealer = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $Dealer
     *
     * @return DealerGroup
     */
    public function addDealer(\Numa\DOAAdminBundle\Entity\Catalogrecords $dealer)
    {
        $this->Dealer[] = $dealer;

        return $this;
    }

    /**
     * Remove dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     */
    public function removeDealer(\Numa\DOAAdminBundle\Entity\Catalogrecords $dealer)
    {
        $this->Dealer->removeElement($dealer);
    }
    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $DealerCreator;


    /**
     * Set dealerCreator
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealerCreator
     *
     * @return DealerGroup
     */
    public function setDealerCreator(\Numa\DOAAdminBundle\Entity\Catalogrecords $dealerCreator = null)
    {
        $this->DealerCreator = $dealerCreator;

        return $this;
    }

    /**
     * Get dealerCreator
     *
     * @return \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    public function getDealerCreator()
    {
        return $this->DealerCreator;
    }

    public function __toString() {
        return $this->getUsername();
    }

    public function getRoles() {
        return array('ROLE_DEALER_PRINCIPAL',"ROLE_DMS_USER","ROLE_BUSINES");
    }

    public function getSalt() {
        return null;
    }

    public function eraseCredentials() {

    }

    public function equals(DealerGroup $user) {
        return $user->getEmail() == $this->getEmail();
    }

    public function __sleep(){
        return array('id', 'username', 'email');
    }

    public function getName(){
        return $this>$this->getUsername();
    }

    public function getLogoUrl(){
        return $this>$this->getUsername();
    }

    public function getLogo(){
        return $this>$this->getUsername();
    }

    public function getUrl(){
        return $this>$this->getUsername();
    }
}
