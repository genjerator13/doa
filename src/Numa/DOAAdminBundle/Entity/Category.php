<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 */
class Category
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $sid;

    /**
     * @var integer
     */
    private $parent;

    /**
     * @var integer
     */
    private $order;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $input_template;

    /**
     * @var string
     */
    private $search_template;

    /**
     * @var string
     */
    private $search_result_template;

    /**
     * @var string
     */
    private $view_template;

    /**
     * @var string
     */
    private $browsing_settings;

    /**
     * @var string
     */
    private $listing_caption_template_content;

    /**
     * @var \DateTime
     */
    private $last_modified;

    /**
     * @var string
     */
    private $listing_url_seo_data;


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
     * Set sid
     *
     * @param string $sid
     * @return Category
     */
    public function setSid($sid)
    {
        $this->sid = $sid;
    
        return $this;
    }

    /**
     * Get sid
     *
     * @return string 
     */
    public function getSid()
    {
        return $this->sid;
    }

    /**
     * Set parent
     *
     * @param integer $parent
     * @return Category
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return integer 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return Category
     */
    public function setOrder($order)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return integer 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
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
     * Set input_template
     *
     * @param string $inputTemplate
     * @return Category
     */
    public function setInputTemplate($inputTemplate)
    {
        $this->input_template = $inputTemplate;
    
        return $this;
    }

    /**
     * Get input_template
     *
     * @return string 
     */
    public function getInputTemplate()
    {
        return $this->input_template;
    }

    /**
     * Set search_template
     *
     * @param string $searchTemplate
     * @return Category
     */
    public function setSearchTemplate($searchTemplate)
    {
        $this->search_template = $searchTemplate;
    
        return $this;
    }

    /**
     * Get search_template
     *
     * @return string 
     */
    public function getSearchTemplate()
    {
        return $this->search_template;
    }

    /**
     * Set search_result_template
     *
     * @param string $searchResultTemplate
     * @return Category
     */
    public function setSearchResultTemplate($searchResultTemplate)
    {
        $this->search_result_template = $searchResultTemplate;
    
        return $this;
    }

    /**
     * Get search_result_template
     *
     * @return string 
     */
    public function getSearchResultTemplate()
    {
        return $this->search_result_template;
    }

    /**
     * Set view_template
     *
     * @param string $viewTemplate
     * @return Category
     */
    public function setViewTemplate($viewTemplate)
    {
        $this->view_template = $viewTemplate;
    
        return $this;
    }

    /**
     * Get view_template
     *
     * @return string 
     */
    public function getViewTemplate()
    {
        return $this->view_template;
    }

    /**
     * Set browsing_settings
     *
     * @param string $browsingSettings
     * @return Category
     */
    public function setBrowsingSettings($browsingSettings)
    {
        $this->browsing_settings = $browsingSettings;
    
        return $this;
    }

    /**
     * Get browsing_settings
     *
     * @return string 
     */
    public function getBrowsingSettings()
    {
        return $this->browsing_settings;
    }

    /**
     * Set listing_caption_template_content
     *
     * @param string $listingCaptionTemplateContent
     * @return Category
     */
    public function setListingCaptionTemplateContent($listingCaptionTemplateContent)
    {
        $this->listing_caption_template_content = $listingCaptionTemplateContent;
    
        return $this;
    }

    /**
     * Get listing_caption_template_content
     *
     * @return string 
     */
    public function getListingCaptionTemplateContent()
    {
        return $this->listing_caption_template_content;
    }

    /**
     * Set last_modified
     *
     * @param \DateTime $lastModified
     * @return Category
     */
    public function setLastModified($lastModified)
    {
        $this->last_modified = $lastModified;
    
        return $this;
    }

    /**
     * Get last_modified
     *
     * @return \DateTime 
     */
    public function getLastModified()
    {
        return $this->last_modified;
    }

    /**
     * Set listing_url_seo_data
     *
     * @param string $listingUrlSeoData
     * @return Category
     */
    public function setListingUrlSeoData($listingUrlSeoData)
    {
        $this->listing_url_seo_data = $listingUrlSeoData;
    
        return $this;
    }

    /**
     * Get listing_url_seo_data
     *
     * @return string 
     */
    public function getListingUrlSeoData()
    {
        return $this->listing_url_seo_data;
    }
    /**
     * @var integer
     */
    private $categoryorder;


    /**
     * Set categoryorder
     *
     * @param integer $categoryorder
     * @return Category
     */
    public function setCategoryorder($categoryorder)
    {
        $this->categoryorder = $categoryorder;
    
        return $this;
    }

    /**
     * Get categoryorder
     *
     * @return integer 
     */
    public function getCategoryorder()
    {
        return $this->categoryorder;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $CatalogRecords;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->CatalogRecords = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add CatalogRecords
     *
     * @param \Numa\DOAAdminBundle\Entity\Importfeed $catalogRecords
     * @return Category
     */
    public function addCatalogRecord(\Numa\DOAAdminBundle\Entity\Importfeed $catalogRecords)
    {
        $this->CatalogRecords[] = $catalogRecords;
    
        return $this;
    }

    /**
     * Remove CatalogRecords
     *
     * @param \Numa\DOAAdminBundle\Entity\Importfeed $catalogRecords
     */
    public function removeCatalogRecord(\Numa\DOAAdminBundle\Entity\Importfeed $catalogRecords)
    {
        $this->CatalogRecords->removeElement($catalogRecords);
    }

    /**
     * Get CatalogRecords
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCatalogRecords()
    {
        return $this->CatalogRecords;
    }
    
        public function __toString()
    {
        return $this->getName();
    }
}
