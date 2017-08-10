<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommandLog
 */
class CommandLog
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $commande;

    /**
     * @var string
     */
    private $category;

    /**
     * @var \DateTime
     */
    private $started_at;

    /**
     * @var \DateTime
     */
    private $ended_at;

    /**
     * @var string
     */
    private $status;


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
     * Set commande
     *
     * @param string $commande
     * @return CommandLog
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return string
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return CommandLog
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set started_at
     *
     * @param \DateTime $startedAt
     * @return CommandLog
     */
    public function setStartedAt($startedAt)
    {
        $this->started_at = $startedAt;

        return $this;
    }

    /**
     * Get started_at
     *
     * @return \DateTime
     */
    public function getStartedAt()
    {
        return $this->started_at;
    }

    /**
     * Set ended_at
     *
     * @param \DateTime $endedAt
     * @return CommandLog
     */
    public function setEndedAt($endedAt)
    {
        $this->ended_at = $endedAt;

        return $this;
    }

    /**
     * Get ended_at
     *
     * @return \DateTime
     */
    public function getEndedAt()
    {
        return $this->ended_at;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return CommandLog
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
     * @ORM\PrePersist
     */
    public function setStartedAtValue()
    {
        if (!$this->getStartedAt()) {
            $this->started_at = new \DateTime();
        }
    }

    /**
     * @var string
     */
    private $full_details;

    /**
     * @var \stdClass
     */
    private $full_details_object;


    /**
     * Set full_details
     *
     * @param string $fullDetails
     * @return CommandLog
     */
    public function setFullDetails($fullDetails)
    {
        $this->full_details = $fullDetails;

        return $this;
    }

    public function appendFullDetails($string)
    {
        $this->setFullDetails($this->getFullDetails() . "\n" . $string);
    }

    /**
     * Get full_details
     *
     * @return string
     */
    public function getFullDetails()
    {
        return $this->full_details;
    }

    /**
     * Set full_details_object
     *
     * @param \stdClass $fullDetailsObject
     * @return CommandLog
     */
    public function setFullDetailsObject($fullDetailsObject)
    {
        $this->full_details_object = $fullDetailsObject;

        return $this;
    }

    /**
     * Get full_details_object
     *
     * @return \stdClass
     */
    public function getFullDetailsObject()
    {
        return $this->full_details_object;
    }

    /**
     * @var string
     */
    private $command;


    /**
     * Set command
     *
     * @param string $command
     * @return CommandLog
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @var integer
     */
    private $count;

    /**
     * @var integer
     */
    private $current;


    /**
     * Set count
     *
     * @param integer $count
     * @return CommandLog
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set current
     *
     * @param integer $current
     * @return CommandLog
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * Get current
     *
     * @return integer
     */
    public function getCurrent()
    {
        return $this->current;
    }

    public function isRunning()
    {
        $running = empty($this->getEndedAt());
        $now = new \DateTime("now");
        $interval = date_diff($this->getStartedAt(), $now);
        $i = intval($interval->format('%i'));

        $isRunning = false;
        if ($running) {
            $isRunning = true;
        }
        if ($i > 10) {
            $isRunning = false;
        }
        return $isRunning;
    }


    /**
     * @var string
     */
    private $entity;

    /**
     * @var string
     */
    private $action;

    /**
     * @var integer
     */
    private $dealer_id;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Catalogrecords
     */
    private $Dealer;


    /**
     * Set entity
     *
     * @param string $entity
     *
     * @return CommandLog
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set action
     *
     * @param string $action
     *
     * @return CommandLog
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set dealerId
     *
     * @param integer $dealerId
     *
     * @return CommandLog
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
     * Set dealer
     *
     * @param \Numa\DOAAdminBundle\Entity\Catalogrecords $dealer
     *
     * @return CommandLog
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
     * @var integer
     */
    private $entity_id;


    /**
     * Set entityId
     *
     * @param integer $entityId
     *
     * @return CommandLog
     */
    public function setEntityId($entityId)
    {
        $this->entity_id = $entityId;

        return $this;
    }

    /**
     * Get entityId
     *
     * @return integer
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }
}
