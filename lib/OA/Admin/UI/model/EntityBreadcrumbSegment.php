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
 * A model describing a part of entity breadcrumb shown in header. 
 */
class OA_Admin_UI_Model_EntityBreadcrumbSegment
{
    /**
     * User visible name for entity type. eg. 'Advertiser', 'Website'
     *
     * @var string
     */
    private $entityLabel;
    
    /**
     * Entity name eg. "My advertiser", "My first campaign"
     *
     * @var string
     */
    private $entityName;
    
    /**
     * CSS class indicating entity type icon which will be displayed next to type name.
     *  
     * @var string
     */
    private $cssClass;
    
    /**
     * A url for entity page
     *
     * @var string
     */
    private $url;
    
    
    /**
     * Entity id, meaningful and useful only when segment contains a list
     * of other entities. Used then to select current from the list
     *
     * @var int
     */
    private $entityId;

    
    /**
     * Map of entityId => (entityName, [entityUrl]) entries.
     *
     * @var array
     */    
    private $aEntityMap;


    /**
     * Name that should be used for html name which then will be sent when selection is done.
     * 
     * @var string
     */
    private $htmlName;
    
    
    public function __construct($entityLabel = null, $entityName = null, $cssClass = null, $url = null)
    {
        $this->entityLabel = $entityLabel;
        $this->entityName = $entityName;
        $this->url = $url;
        $this->cssClass = $cssClass;
    }
    
    
    /**
     * @return string
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }
    
    /**
     * @return string
     */
    public function getEntityLabel()
    {
        return $this->entityLabel;
    }
    
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * @param string $cssClass
     */
    public function setCssClass($cssClass)
    {
        $this->cssClass = $cssClass;
    }
    
    /**
     * @param string $entityLabel
     */
    public function setEntityLabel($entityLabel)
    {
        $this->entityLabel = $entityLabel;
    }
    
    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    /**
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }
    
    
    /**
     * @param string $entityName
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
    }

    /**
     * @return int
     */
    public function getEntityId()
    {
        return $this->entityId;
    }
    
    
    /**
     * @return string
     */
    public function getHtmlName()
    {
        return $this->htmlName;
    }
    
    
    /**
     * @param int $entityId
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
    }

    
    /**
     * @param string $htmlName
     */
    public function setHtmlName($htmlName)
    {
        $this->htmlName = $htmlName;
    }
    
	
    /**
     * Returns map of entityId => (entityName, [entityUrl]) entries.
     * @return array
     */
    public function getEntityMap()
    {
        return $this->aEntityMap;
    }
    
    /**
     * @param array $aEntityMap
     */
    public function setEntityMap($aEntityMap)
    {
        if (!empty($aEntityMap)) { 
            uasort($aEntityMap, array($this, "orderEntitiesByNameAsc"));
        }
        $this->aEntityMap = $aEntityMap;
    }
    
    /**
     * Order the drop down selectors by Name asc for easy browsing 
     * when selector has thousands of entries
     * See OX-4877
     */
    protected function orderEntitiesByNameAsc($a, $b) 
    {
	    return strnatcasecmp($a['name'], $b['name']);
    }
}
