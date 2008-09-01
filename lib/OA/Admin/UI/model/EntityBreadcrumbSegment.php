<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
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
        $this->aEntityMap = $aEntityMap;
    }
    
}

?>