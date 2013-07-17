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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/CommonEntity.php';

/**
 * A common class that defines a common "interface" and common methods for
 * classes that display cross-entity delivery statistics.
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Delivery_CommonCrossEntity extends OA_Admin_Statistics_Delivery_CommonEntity
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
    function OA_Admin_Statistics_Delivery_CommonCrossEntity($params)
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
        $aEntitiesData = parent::mergeData($aParams, $key);

        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER) || OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
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

        foreach (array_keys($aEntitiesData) as $entityId) {
            if (!isset($this->data[$key][$entityId])) {
                unset($aEntitiesData[$entityId]);
            } elseif ($key == 'advertiser_id' && isset($this->aAnonAdvertisers[$entityId])) {
                    $aEntitiesData[$entityId]['hidden'] = true;
            } elseif ($key == 'placement_id' && isset($this->aAnonPlacements[$entityId])) {
                    $aEntitiesData[$entityId]['hidden'] = true;
            } elseif ($key == 'ad_id' && isset($this->aAnonPlacements[$aEntitiesData[$entityId]['placement_id']])) {
                    $aEntitiesData[$entityId]['hidden'] = true;
            } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
                if (isset($aParams['placement_id'])) {
                    $aEntitiesData[$entityId]['hidden'] = isset($this->aAnonPlacements[$aParams['placement_id']]);
                } else {
                    $aEntitiesData[$entityId]['hidden'] = isset($this->aAnonAdvertisers[OA_Permission::getEntityId()]);
                }
            }
        }

        return $aEntitiesData;
    }

    /**
     * Fixes link parameters to include cross-entities
     *
     * @param array Entities array
     */
    function fixLinkParams(&$aEntitiesData)
    {
        foreach ($aEntitiesData as $entityId => $aEntity) {
            $linkparams = array();
            $params = $this->_removeDuplicateParams($aEntity['linkparams']);
            foreach ($params as $k => $v) {
                $linkparams[] = $k.'='.urlencode($v);
            }
            if (count($linkparams)) {
                $aEntitiesData[$entityId]['linkparams'] .= '&'.join('&', $linkparams);
            }
        }
    }

    /**
     * Mask entities which have the hidden flag set
     *
     * @param array Entities array
     * @param string Name which should be used for hidden entitiies
     */
    function maskHiddenEntities(&$aEntitiesData, $entityType)
    {
        $this->fixLinkParams($aEntitiesData);

        foreach (array_keys($aEntitiesData) as $entityId) {
            if (isset($aEntitiesData[$entityId]['hidden']) && $aEntitiesData[$entityId]['hidden']) {
                switch ($entityType) {
                    case 'advertiser':
                        $aEntitiesData[$entityId]['name'] = MAX_getAdvertiserName($aEntitiesData[$entityId]['name'], null, true, $aEntitiesData[$entityId]['id']);
                        break;

                    case 'campaign':
                        $tmp = array(
                            'placement_id'  => $aEntitiesData[$entityId]['id'],
                            'name'          => $aEntitiesData[$entityId]['name'],
                            'anonymous'     => true
                        );
                        $aEntitiesData[$entityId]['name'] = MAX_getPlacementName($tmp);
                        break;

                    case 'banner':
                        $aEntitiesData[$entityId]['name'] = MAX_getAdName($aEntitiesData[$entityId]['name'], null, null, true, $aEntitiesData[$entityId]['id']);
                        break;

                    case 'publisher':
                        $aEntitiesData[$entityId]['name'] = MAX_getPublisherName($aEntitiesData[$entityId]['name'], null, true, $aEntitiesData[$entityId]['id']);
                        break;

                    case 'zone':
                        $aEntitiesData[$entityId]['name'] = MAX_getZoneName($aEntitiesData[$entityId]['name'], null, true, $aEntitiesData[$entityId]['id']);
                        break;
                }

                //$aEntitiesData[$entityId]['num_children'] = 0;
                //unset($aEntitiesData[$entityId]['subentities']);
            }
        }

        if ($this->listOrderField == 'name' || $this->listOrderField == 'id') {
            MAX_sortArray(
                $aEntitiesData,
                $this->listOrderField,
                $this->listOrderDirection == 'up'
            );
        }
    }

    function getAdvertisers($aParams, $level, $expand = '')
    {
        $aEntitiesData = parent::getAdvertisers($aParams, $level, $expand);

        $this->maskHiddenEntities($aEntitiesData, 'advertiser');

        return $aEntitiesData;
    }

    function getCampaigns($aParams, $level, $expand = '')
    {
        $aEntitiesData = parent::getCampaigns($aParams, $level, $expand);

        $this->maskHiddenEntities($aEntitiesData, 'campaign');

        return $aEntitiesData;
    }

    function getBanners($aParams, $level, $expand = '')
    {
        $aEntitiesData = parent::getBanners($aParams, $level, $expand);

        $this->maskHiddenEntities($aEntitiesData, 'banner');

        return $aEntitiesData;
    }

    function getPublishers($aParams, $level, $expand = '')
    {
        $aEntitiesData = parent::getPublishers($aParams, $level, $expand);

        $this->maskHiddenEntities($aEntitiesData, 'publisher');
        if (!$level) {
            $this->addDirectSelection($aParams, $aEntitiesData);
        }

        return $aEntitiesData;
    }

    function getZones($aParams, $level, $expand = '')
    {
        $aEntitiesData = parent::getZones($aParams, $level, $expand);

        $this->maskHiddenEntities($aEntitiesData, 'zone');
        if (!$level) {
            $this->addDirectSelection($aParams, $aEntitiesData);
        }

        return $aEntitiesData;
    }

    /**
     * Add direct selection stats to an entity array
     *
     * @param array Query parameters
     * @param array Entities array
     */
    function addDirectSelection($aParams, &$aEntitiesData)
    {
        $aParams['exclude'] = array('ad_id');
        $aParams['zone_id'] = 0;

        // Get plugin aParams
        $pluginParams = array();
        foreach ($this->aPlugins as $oPlugin) {
            $oPlugin->addQueryParams($pluginParams);
        }

        $aDirectSelection = Admin_DA::fromCache('getEntitiesStats', $aParams + $this->aDates);

        // Merge plugin additional data
        foreach ($this->aPlugins as $oPlugin) {
            $oPlugin->mergeData($aDirectSelection, $this->aEmptyRow, 'getEntitiesStats', $aParams + $this->aDates);
        }

        if (count($aDirectSelection)) {
            $zone = current($aDirectSelection) + $this->aEmptyRow;
            $zone['active'] = $this->_hasActiveStats($zone);

            if ($zone['active']) {
                $this->_summarizeStats($zone);

                $zone['name'] = $GLOBALS['strGenerateBannercode'];
                $zone['prefix'] = 'x';
                $zone['id'] = '-';
                $zone['icon'] =  OX::assetPath().'/images/icon-generatecode.gif';
                $zone['htmlclass'] = 'last';

                if ($this->listOrderField != 'name' && $this->listOrderField != 'id') {
                    $aEntitiesData[] = $zone;
                    MAX_sortArray(
                        $aEntitiesData,
                        $this->listOrderField,
                        $this->listOrderDirection == 'up'
                    );
                } elseif ($this->listOrderDirection == 'up') {
                    array_push($aEntitiesData, $zone);
                } else {
                    array_unshift($aEntitiesData, $zone);
                }
            }
        }
    }

}

?>