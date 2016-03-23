<?php

namespace Numa\DOAModuleBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Seo
 */
class Seo
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $keywords;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $url;

    /**
     * @var bool
     */
    private $is_public;

    /**
     * @var bool
     */
    private $active = true;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->active=true;
        $this->autogenerate =true;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Seo
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
     * Set keywords
     *
     * @param string $keywords
     *
     * @return Seo
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Seo
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Seo
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set isPublic
     *
     * @param bool $isPublic
     *
     * @return Seo
     */
    public function setIsPublic($isPublic)
    {
        $this->is_public = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return bool
     */
    public function getIsPublic()
    {
        return $this->is_public;
    }

    /**
     * Set active
     *
     * @param bool $active
     *
     * @return Seo
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Seo
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
     * @return Seo
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
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        if (!$this->getCreatedAt()) {
            $this->created_at = new \DateTime();
            $this->updated_at = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        if(empty($this->dontupdate)){

            $this->updated_at = new \DateTime();
        }
    }
    /**
     * @var bool
     */
    private $autogenerate = true;


    /**
     * Set autogenerate
     *
     * @param bool $autogenerate
     *
     * @return Seo
     */
    public function setAutogenerate($autogenerate)
    {
        $this->autogenerate = $autogenerate;

        return $this;
    }

    /**
     * Get autogenerate
     *
     * @return bool
     */
    public function getAutogenerate()
    {
        return $this->autogenerate;
    }

    public function isEmpty(){
        return empty($this->getTitle() && empty($this->getDescription()));
    }


    /**
     * @var string
     */
    private $table_name;

    /**
     * @var int
     */
    private $table_id;


    /**
     * Set tableName
     *
     * @param string $tableName
     *
     * @return Seo
     */
    public function setTableName($tableName)
    {
        $this->table_name = $tableName;

        return $this;
    }

    /**
     * Get tableName
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->table_name;
    }

    /**
     * Set tableId
     *
     * @param int $tableId
     *
     * @return Seo
     */
    public function setTableId($tableId)
    {
        $this->table_id = $tableId;

        return $this;
    }

    /**
     * Get tableId
     *
     * @return int
     */
    public function getTableId()
    {
        return $this->table_id;
    }
}
