<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * A model describing a page header. Allows to specify title, title icon class, 
 * include breadcrumbs if any.
 */
class OA_Admin_UI_Model_PageHeaderModel
{
    /**
     * Page title to be displayed above the content under first level tabs.
     *
     * @var string
     */
    private $title;
    
    /**
     * CSS class indicating icon which will be displayed next to title. If none
     * specified icon will be read from navigation entry. 
     * I none specified no icon is used and page title is aligned with content.
     *
     * @var string
     */
    private $iconClass;
    
    /**
     * Indicates whether page is 
     * - default - icon and class read from nav structure
     * - list - icon is read from nav, title uses last breadcrumb segment eg. 
     *      'Campaigns of Coca Cola', 'Banners in Coca Cola Summer Campaign'
     * - edit - add entity name after page title
     * - new - add parent entity name after title - 'Add new campaign for advertiser Coca Cola' 
     *
     * @var string
     */
    private $pageType;
    
    
    /**
     * You can add entity name which will be displayed after page title. This
     * is most likely used by edit pages and list pages (where entity name 
     * inlcudes accordingly: edited entity name, or entity whose sub items are shown 
     *
     * @var string
     */
    private $entityName;
    
    /**
     * Enter description here...
     *
     * @var array of OA_Admin_UI_Model_EntityBreadcrumbSegment elements
     */
    private $aEntityBreadcrumbs;
    
    
    /**
     * If eg. adding new item, we can add additional info - what is added where.
     * This indicates the "where" type
     *
     * @var string
     */
    private $newTargetTitle;
    
    /**
     * If eg. adding new item, we can add additional info - what is added where.
     * This inicates the "where" name.
     *      
     * @var string
     */
    private $newTargetName;
    
    /**
     * If eg. adding new item, we can add additional info - what is added where.
     * This inicates the link to "where". Eg. Adding campaign to 'Advertiser X'
     * Link will point to 'Advertiser X' edit page
     */
    private $newTargetLink;
    
    /**
     * Indicates whether any of the breadcrumb segments includes entity list.
     *
     * @var boolean
     */
    private $hasEntityList;
    
    /**
     * A header constructor
     *
     */
    public function __construct($title = null, $iconClass = null, $pageType = 'default', $aBreadcrumbs = null)
    {
        $this->title = $title;
        $this->iconClass = $iconClass;
        $this->pageType = $pageType;
        $this->aEntityBreadcrumbs = $aBreadcrumbs;
        $this->hasEntityList == false;
    }
    
    /**
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }
    
    /**
     * @return string
     */
    public function getPageType()
    {
        return $this->pageType;
    }
    
    /**
     * @param string $entityName
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
    }
    
    /**
     * @param string $pageType
     */
    public function setPageType($pageType)
    {
        $this->pageType = $pageType;
    }
    
    
    /**
     * @return string
     */
    public function getIconClass()
    {
        return $this->iconClass;
    }
    
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * @param string $iconClass
     */
    public function setIconClass($iconClass)
    {
        $this->iconClass = $iconClass;
    }
    
    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * @return string
     */
    public function getNewTargetName()
    {
        return $this->newTargetName;
    }
    
    /**
     * @return string
     */
    public function getNewTargetTitle()
    {
        return $this->newTargetTitle;
    }
    
    
    /**
     * @return string
     */
    public function getNewTargetLink()
    {
        return $this->newTargetLink;
    }    
    
    /**
     * @param string $newTargetName
     */
    public function setNewTargetName($newTargetName)
    {
        $this->newTargetName = $newTargetName;
    }
    
    /**
     * @param string $newTargetTitle
     */
    public function setNewTargetTitle($newTargetTitle)
    {
        $this->newTargetTitle = $newTargetTitle;
    }
    
    /**
     * @param string $newTargetLink
     */
    public function setNewTargetLink($newTargetLink)
    {
        $this->newTargetLink = $newTargetLink;
    }    
    
    
    /**
     * Indicates whether model is empty. Model is considered empty if no title is given
     *
     */
    public function isEmpty()
    {
       return empty($this->title);
    }

    /**
     * @return array
     */
    public function getEntityBreadcrumbs()
    {
        return $this->aEntityBreadcrumbs;
    }
    
    /**
     * @param array $aEntityBreadcrumbs
     */
    public function setEntityBreadcrumbs($aEntityBreadcrumbs)
    {
        $this->aEntityBreadcrumbs = $aEntityBreadcrumbs;
    }
    
    
    /**
     * @return boolean
     */
    public function hasEntityList()
    {
        return $this->hasEntityList;
    }
    
    
    /**
     * @param boolean $hasEntityList
     */
    public function setHasEntityList($hasEntityList)
    {
        $this->hasEntityList = $hasEntityList;
    }
        
    
    /**
     * Adds entity breadcrumb segment
     *
     * @param OA_Admin_UI_Model_EntityBreadcrumbSegment $oSegment
     */
    public function addSegment($oSegment)
    {
        $this->aEntityBreadcrumbs[] = $oSegment;
        
        $aEntityMap = $oSegment->getEntityMap();
        if (!empty($aEntityMap)) {
            $this->setHasEntityList(true);
        }
    }
}

?>