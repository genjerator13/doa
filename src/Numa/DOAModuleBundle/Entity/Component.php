<?php

namespace Numa\DOAModuleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation as JMS;
use Numa\Util\Component\ComponentEntityInterface;

/**
 * Component
 * @JMS\ExclusionPolicy("ALL")
 */
class Component implements ComponentEntityInterface
{
    /**
     * @var int
     * @JMS\Expose
     * @Groups({"site"})
     */
    private $id;

    /**
     * @var int
     * @JMS\Expose
     * @Groups({"site"})
     */
    private $page_id;

    /**
     * @var string
     * @JMS\Expose
     * @Groups({"site"})
     */
    private $name;

    /**
     * @var string
     * @JMS\Expose
     * @Groups({"site"})
     */
    private $type;

    /**
     * @var string
     * @JMS\Expose
     * @Groups({"site"})
     */
    private $value;

    /**
     * @var string
     * @JMS\Expose
     * @Groups({"site"})
     */
    private $settings;

    /**
     * @var \DateTime
     * @Groups({"site"})
     */
    private $date_updated;

    /**
     * @var \DateTime
     * @Groups({"site"})
     */
    private $date_created;

    /**
     * @var string
     * @Groups({"site"})
     */
    private $status;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $PageComponent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->PageComponent = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set pageId
     *
     * @param int $pageId
     *
     * @return Component
     */
    public function setPageId($pageId)
    {
        $this->page_id = $pageId;

        return $this;
    }

    /**
     * Get pageId
     *
     * @return int
     */
    public function getPageId()
    {
        return $this->page_id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Component
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
     * Set type
     *
     * @param string $type
     *
     * @return Component
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Component
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set settings
     *
     * @param string $settings
     *
     * @return Component
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Get settings
     *
     * @return string
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return Component
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Component
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
     * Set status
     *
     * @param string $status
     *
     * @return Component
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
     * Add pageComponent
     *
     * @param \Numa\DOAModuleBundle\Entity\PageComponent $pageComponent
     *
     * @return Component
     */
    public function addPageComponent(\Numa\DOAModuleBundle\Entity\PageComponent $pageComponent)
    {
        $this->PageComponent[] = $pageComponent;

        return $this;
    }

    /**
     * Remove pageComponent
     *
     * @param \Numa\DOAModuleBundle\Entity\PageComponent $pageComponent
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePageComponent(\Numa\DOAModuleBundle\Entity\PageComponent $pageComponent)
    {
        return $this->PageComponent->removeElement($pageComponent);
    }

    /**
     * Get pageComponent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageComponent()
    {
        return $this->PageComponent;
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
        $this->date_updated = new \DateTime();
    }

    // Important manytomany
    public function getPages()
    {
        $pages = new ArrayCollection();
        if (!empty($this->getPageComponent())) {
            foreach ($this->getPageComponent() as $pa) {
                if ($pa instanceof PageComponent) {
                    $pages[] = $pa->getPage();
                }
            }
        }
        return $pages;
    }

    /**
     * Get Note
     *
     * @return \Doctrine\Common\Collections\Collection
     * @JMS\VirtualProperty
     */
    public function getPagesNames(){
        $pages=array();
        if (!empty($this->getPageComponent())) {
            foreach ($this->getPageComponent() as $pa) {
                if ($pa instanceof PageComponent) {
                    $pages[] = $pa->getPage()->getUrl();

                }
            }
        }

        $names = implode(",",$pages);
        return $names;
    }


    // Important
    public function setPages($pageAds)
    {
        foreach ($pageAds as $pageAd) {
            $pa = new PageComponent();
            $pa->setPage($pageAd);
            $pa->setComponent($this);
            $this->addPageComponent($pa);
        }

    }

    public static function getUploadDir($dealer_id, $component_id)
    {
        $uploadDir = "upload/dealers";
        return $uploadDir;
    }
    /**
     * @var string
     * @JMS\Expose
     * @Groups({"site"})
     */
    private $helpdesc;


    /**
     * Set helpdesc
     *
     * @param string $helpdesc
     *
     * @return Component
     */
    public function setHelpdesc($helpdesc)
    {

        $this->helpdesc = $helpdesc;

        return $this;
    }

    /**
     * Get helpdesc
     *
     * @return string
     */
    public function getHelpdesc()
    {
        if(empty($this->helpdesc)){
            return "";
        }
        return $this->helpdesc;
    }

    /**
     * @var string
     */
    private $help;


    /**
     * Set help
     *
     * @param string $help
     *
     * @return Component
     */
    public function setHelp($help)
    {
        $this->help = $help;

        return $this;
    }

    /**
     * Get help
     *
     * @return string
     */
    public function getHelp()
    {
        return $this->help;
    }
    /**
     * @var string
     */
    private $theme;


    /**
     * Set theme
     *
     * @param string $theme
     *
     * @return Component
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }
}
