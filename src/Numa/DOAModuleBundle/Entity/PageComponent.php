<?php

namespace Numa\DOAModuleBundle\Entity;

/**
 * PageComponent
 */
class PageComponent
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $page_id;

    /**
     * @var int
     */
    private $component_id;

    /**
     * @var \Numa\DOAModuleBundle\Entity\Page
     */
    private $Page;

    /**
     * @var \Numa\DOAModuleBundle\Entity\Component
     */
    private $Component;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pageId
     *
     * @param int $pageId
     *
     * @return PageComponent
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
     * Set componentId
     *
     * @param int $componentId
     *
     * @return PageComponent
     */
    public function setComponentId($componentId)
    {
        $this->component_id = $componentId;

        return $this;
    }

    /**
     * Get componentId
     *
     * @return int
     */
    public function getComponentId()
    {
        return $this->component_id;
    }

    /**
     * Set page
     *
     * @param \Numa\DOAModuleBundle\Entity\Page $page
     *
     * @return PageComponent
     */
    public function setPage(\Numa\DOAModuleBundle\Entity\Page $page = null)
    {
        $this->Page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \Numa\DOAModuleBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->Page;
    }

    /**
     * Set component
     *
     * @param \Numa\DOAModuleBundle\Entity\Component $component
     *
     * @return PageComponent
     */
    public function setComponent(\Numa\DOAModuleBundle\Entity\Component $component = null)
    {
        $this->Component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return \Numa\DOAModuleBundle\Entity\Component
     */
    public function getComponent()
    {
        return $this->Component;
    }
}

