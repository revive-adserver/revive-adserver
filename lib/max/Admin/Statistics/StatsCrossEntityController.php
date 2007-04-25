<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsByEntityController.php';



/**
 * Controller class for displaying cross-entities type statistics screens
 *
 * Always use the factory method to instantiate fields -- it will create
 * the right subclass for you.
 *
 * @package    Max
 * @subpackage Admin_Statistics
 * @author     Matteo Beccati <matteo@beccati.com>
 *
 * @see StatsControllerFactory
 */
class StatsCrossEntityController extends StatsByEntityController
{
    var $aAnonAdvertisers;
    var $aAnonPlacements;
    
    /**
     * PHP5-style constructor
     */
    function __construct($params)
    {
        // Override links
        $this->entityLinks = array();
        
        parent::__construct($params);
    }
    
    /**
     * PHP4-style constructor
     */
    function StatsCrossEntityController($params)
    {
        $this->__construct($params);
    }
    
    /**
     * Merge aggregate stats with entity properties (name, children, etc)
     *
     * The overridden method also takes care to remove inactive entities
     * and to enforce the anonymous properties when logged in as advertiser
     * or publisher
     *
     * @param array Query parameters
     * @param string Key name
     * @return array Full entity stats with entity data
     */
    function mergeData($aParams, $key)
    {
        $aEntities = parent::mergeData($aParams, $key);
        
        if (phpAds_isUser(phpAds_Client) || phpAds_isUser(phpAds_Affiliate)) {
            if (is_null($this->aAnonAdvertisers)) {
                $this->aAnonAdvertisers = array();
                $this->aAnonPlacements  = array();
                $aPlacements = Admin_DA::fromCache('getPlacements', array('placement_anonymous' => 't'));
                foreach ($aPlacements as $placementId => $placement) {
                    $this->aAnonAdvertisers[$placement['advertiser_id']] = true;
                    $this->aAnonPlacements[$placementId] = true;
                }
            }
        }
        
        foreach (array_keys($aEntities) as $entityId) {
            if (!isset($this->data[$key][$entityId])) {
                unset($aEntities[$entityId]);
            } elseif ($key == 'advertiser_id' && isset($this->aAnonAdvertisers[$entityId])) {
                    $aEntities[$entityId]['hidden'] = true;
            } elseif ($key == 'placement_id' && isset($this->aAnonPlacements[$entityId])) {
                    $aEntities[$entityId]['hidden'] = true;
            } elseif ($key == 'ad_id' && isset($this->aAnonPlacements[$aEntities[$entityId]['placement_id']])) {
                    $aEntities[$entityId]['hidden'] = true;
            } elseif (phpAds_isUser(phpAds_Client)) {
                if (isset($aParams['placement_id'])) {
                    $aEntities[$entityId]['hidden'] = isset($this->aAnonPlacements[$aParams['placement_id']]);
                } else {
                    $aEntities[$entityId]['hidden'] = isset($this->aAnonAdvertisers[phpAds_getUserId()]);
                }
            }
        }
        
        return $aEntities;
    }
    
    /**
     * Fixes link parameters to include cross-entities
     *
     * @param array Entities array
     */
    function fixLinkParams(&$aEntities)
    {
        $linkparams = array();
        $params = $this->removeDuplicateParams('');
        foreach ($params as $k => $v) {
            $linkparams[] = $k.'='.urlencode($v);
        }
        $linkparams = join('&', $linkparams);
    }
    
    /**
     * Mask entities which have the hidden flag set
     *
     * @param array Entities array
     * @param string Name which should be used for hidden entitiies
     */
    function maskHiddenEntities(&$aEntities, $entityType)
    {
        $this->fixLinkParams($aEntities);
        
        foreach (array_keys($aEntities) as $entityId) {
            if (isset($aEntities[$entityId]['hidden']) && $aEntities[$entityId]['hidden']) {
                switch ($entityType) {
                    case 'advertiser':
                        $aEntities[$entityId]['name'] = MAX_getAdvertiserName($aEntities[$entityId]['name'], null, true, $aEntities[$entityId]['id']);
                        break;
                    
                    case 'campaign':
                        $tmp = array(
                            'placement_id'  => $aEntities[$entityId]['id'],
                            'name'          => $aEntities[$entityId]['name'],
                            'anonymous'     => true
                        );
                        $aEntities[$entityId]['name'] = MAX_getPlacementName($tmp);
                        break;
                    
                    case 'banner':
                        $aEntities[$entityId]['name'] = MAX_getAdName($aEntities[$entityId]['name'], null, null, true, $aEntities[$entityId]['id']);
                        break;
                    
                    case 'publisher':
                        $aEntities[$entityId]['name'] = MAX_getPublisherName($aEntities[$entityId]['name'], null, true, $aEntities[$entityId]['id']);
                        break;
                    
                    case 'zone':
                        $aEntities[$entityId]['name'] = MAX_getZoneName($aEntities[$entityId]['name'], null, true, $aEntities[$entityId]['id']);
                        break;
                }

                //$aEntities[$entityId]['num_children'] = 0;
                //unset($aEntities[$entityId]['subentities']);
            }
        }
        
        if ($this->listOrderField == 'name' || $this->listOrderField == 'id') {
            MAX_sortArray(
                $aEntities,
                $this->listOrderField,
                $this->listOrderDirection == 'up'
            );
        }
    }
    
    function getAdvertisers($aParams, $level, $expand = '')
    {
        $aEntities = parent::getAdvertisers($aParams, $level, $expand);
        
        $this->maskHiddenEntities($aEntities, 'advertiser');
        
        return $aEntities;
    }
    
    function getCampaigns($aParams, $level, $expand = '')
    {
        $aEntities = parent::getCampaigns($aParams, $level, $expand);
        
        $this->maskHiddenEntities($aEntities, 'campaign');
        
        return $aEntities;
    }
    
    function getBanners($aParams, $level, $expand = '')
    {
        $aEntities = parent::getBanners($aParams, $level, $expand);
        
        $this->maskHiddenEntities($aEntities, 'banner');
        
        return $aEntities;
    }
    
    function getPublishers($aParams, $level, $expand = '')
    {
        $aEntities = parent::getPublishers($aParams, $level, $expand);
        
        $this->maskHiddenEntities($aEntities, 'publisher');
        if (!$level) {
            $this->addDirectSelection($aParams, $aEntities);
        }
        
        return $aEntities;
    }
    
    function getZones($aParams, $level, $expand = '')
    {
        $aEntities = parent::getZones($aParams, $level, $expand);
        
        $this->maskHiddenEntities($aEntities, 'zone');
        if (!$level) {
            $this->addDirectSelection($aParams, $aEntities);
        }
        
        return $aEntities;
    }
    
    /**
     * Add direct selection stats to an entity array
     *
     * @param array Query parameters
     * @param array Entities array
     */
    function addDirectSelection($aParams, &$aEntities)
    {
        $aParams['exclude'] = array('ad_id');
        $aParams['zone_id'] = 0;
        
        // Get plugin aParams
        $pluginParams = array();
        foreach ($this->plugins as $plugin) {
            $plugin->addQueryParams($pluginParams);
        }
        
        $aDirectSelection = Admin_DA::fromCache('getEntitiesStats', $aParams + $this->aDates);
        
        // Merge plugin additional data
        foreach ($this->plugins as $plugin) {
            $plugin->mergeData($aDirectSelection, $this->emptyRow, 'getEntitiesStats', $aParams + $this->aDates);
        }
        
        if (count($aDirectSelection)) {
            $zone = current($aDirectSelection) + $this->emptyRow;
            $zone['active'] = $this->hasActiveStats($zone);
            
            if ($zone['active']) {
                $this->summarizeStats($zone);
                                
                $zone['name'] = $GLOBALS['strGenerateBannercode'];
                $zone['prefix'] = 'x';
                $zone['id'] = '-';
                $zone['icon'] = 'images/icon-generatecode.gif';
                $zone['htmlclass'] = 'last';
                
                if ($this->listOrderField != 'name' && $this->listOrderField != 'id') {
                    $aEntities[] = $zone;
                    MAX_sortArray(
                        $aEntities,
                        $this->listOrderField,
                        $this->listOrderDirection == 'up'
                    );
                } elseif ($this->listOrderDirection == 'up') {
                    array_push($aEntities, $zone);
                } else {
                    array_unshift($aEntities, $zone);
                }
            }
        }
    }
}

?>
