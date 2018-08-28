<?php

namespace Numa\DOADMSBundle\Entity;

/**
 * Media
 */
class Media
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
    private $content;

    /**
     * @var string
     */
    private $mimetype;

    /**
     * @var string
     */
    private $origin;

    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var \Numa\DOADMSBundle\Entity\Mediathek
     */
    private $mediathek;


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
     *
     * @return Media
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
     * Set content
     *
     * @param string $content
     *
     * @return Media
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set mimetype
     *
     * @param string $mimetype
     *
     * @return Media
     */
    public function setMimetype($mimetype)
    {
        $this->mimetype = $mimetype;

        return $this;
    }

    /**
     * Get mimetype
     *
     * @return string
     */
    public function getMimetype()
    {
        return $this->mimetype;
    }

    /**
     * Set origin
     *
     * @param string $origin
     *
     * @return Media
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Media
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
     * Set mediathek
     *
     * @param \Numa\DOADMSBundle\Entity\Mediathek $mediathek
     *
     * @return Media
     */
    public function setMediathek(\Numa\DOADMSBundle\Entity\Mediathek $mediathek = null)
    {
        $this->mediathek = $mediathek;

        return $this;
    }

    /**
     * Get mediathek
     *
     * @return \Numa\DOADMSBundle\Entity\Mediathek
     */
    public function getMediathek()
    {
        return $this->mediathek;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        // Add your code here
    }
}
