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
 * @package    OpenXDll
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */

// Require the following classes:
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Dll/ZoneInfo.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/Zone.php';

// Legacy Admin_DA
require_once MAX_PATH . '/lib/max/Admin_DA.php';

/**
 * The OA_Dll_Zone class extends the base OA_Dll class.
 *
 */

class OA_Dll_Zone extends OA_Dll
{
    /**
     * This method sets ZoneInfo from a data array.
     *
     * @access private
     *
     * @param OA_Dll_ZoneInfo &$oZone
     * @param array $zoneData
     *
     * @return boolean
     */
    function _setZoneDataFromArray(&$oZone, $zoneData)
    {
        $zoneData['publisherId']    = $zoneData['affiliateid'];
        $zoneData['zoneId']         = $zoneData['zoneid'];
        $zoneData['type']           = $zoneData['delivery'];
        $zoneData['zoneName']       = $zoneData['zonename'];
        $zoneData['sessionCapping'] = $zoneData['session_capping'];
        $zoneData['block']          = $zoneData['block'];

        if (preg_match('/^zone:(\d+)$/D', $zoneData['chain'], $m)) {
            $zoneData['chainedZoneId'] = (int)$m[1];
        }

        $oZone->readDataFromArray($zoneData);
        return  true;
    }

    /**
     * This method validates the zone type.
     * Types: banner=0, interstitial=1, popup=2, text=3, email=4
     *
     * @access private
     *
     * @param string $type
     *
     * @return boolean
     *
     */
    function _validateZoneType($type)
    {

        $arType = array(0, 1, 2, 3, 4);

        if (!isset($type) || in_array($type, $arType)) {
            $this->raiseError("Zone type is wrong!");
            return true;
        } else {
            return false;
        }
    }

    /**
     * This method performs data validation for a zone, for example to check
     * that an email address is an email address. Where necessary, the method connects
     * to the OA_Dal to obtain information for other business validations.
     *
     * @access private
     *
     * @param OA_Dll_ZoneInfo $oZone
     *
     * @return boolean
     *
     */
    function _validate(&$oZone)
    {
        if (!$this->_validateZoneType($oZone->type) ||
            !$this->checkStructureNotRequiredStringField($oZone,  'zoneName', 245) ||
            !$this->checkStructureNotRequiredIntegerField($oZone, 'width') ||
            !$this->checkStructureNotRequiredIntegerField($oZone, 'capping') ||
            !$this->checkStructureNotRequiredIntegerField($oZone, 'sessionCapping') ||
            !$this->checkStructureNotRequiredIntegerField($oZone, 'block') ||
            !$this->checkStructureNotRequiredIntegerField($oZone, 'height') ||
            !$this->checkStructureNotRequiredIntegerField($oZone, 'chainedZoneId') ||
            !$this->checkStructureNotRequiredStringField($oZone,  'comments')
        ) {

            return false;
        }

        if (isset($oZone->zoneId)) {
            // When modifying a zone, check correct field types are used and the zoneID exists.
            if (!$this->checkStructureRequiredIntegerField($oZone, 'zoneId') ||
                !$this->checkStructureNotRequiredIntegerField($oZone, 'publisherId') ||
                !$this->checkIdExistence('zones', $oZone->zoneId)) {
                return false;
            }
        } else {
            // When adding a zone, check that the required field 'publisherId' is correct.
            if (!$this->checkStructureRequiredIntegerField($oZone, 'publisherId')) {
                return false;
            }
        }

        if (isset($oZone->publisherId) &&
            !$this->checkIdExistence('affiliates', $oZone->publisherId)) {
            return false;
        }

        if (isset($oZone->chainedZoneId)) {
            if ($oZone->chainedZoneId == $oZone->zoneId) {
                $this->raiseError('Cannot chain a zone to itself');
                return false;
            }
            if (!$this->checkIdExistence('zones', $oZone->chainedZoneId)) {
                return false;
            }
        }

        return true;
    }

    /**
     * This method performs data validation for statistics methods(zoneId, date).
     *
     * @access private
     *
     * @param integer  $zoneId
     * @param date     $oStartDate
     * @param date     $oEndDate
     *
     * @return boolean
     *
     */
    function _validateForStatistics($zoneId, $oStartDate, $oEndDate)
    {
        if (!$this->checkIdExistence('zones', $zoneId) ||
            !$this->checkDateOrder($oStartDate, $oEndDate)) {

            return false;
        } else {
            return true;
        }
    }

    /**
     * This function calls a method in the OA_Dll class which checks permissions.
     *
     * @access public
     *
     * @param integer $advertiserId  Zone ID
     *
     * @return boolean  False if access denied and true if allowed.
     */
    function checkStatisticsPermissions($zoneId)
    {
       if (!$this->checkPermissions($this->aAllowTraffickerAndAbovePerm, 'zones', $zoneId))
       {
           return false;
       } else {
           return true;
       }
    }

    /**
     * This method modifies an existing banner. Undefined fields do not change
     * and defined fields with a NULL value also remain unchanged.
     *
     * @access public
     *
     * @param OA_Dll_ZoneInfo &$oZone <br />
     *          <b>For adding</b><br />
     *          <b>Required properties:</b> publisherId<br />
     *          <b>Optional properties:</b> zoneName, type, width, height<br />
     *
     *          <b>For modify</b><br />
     *          <b>Required properties:</b> zoneId<br />
     *          <b>Optional properties:</b> publisherId, zoneName, type, width, height<br />
     *
     * @return success boolean True if the operation was successful
     *
     */
    function modify(&$oZone)
    {
        if (!isset($oZone->zoneId)) {
            // Add
            $oZone->setDefaultForAdd();
            if (!$this->checkPermissions($this->aAllowTraffickerAndAbovePerm,
                'affiliates', $oZone->publisherId, OA_PERM_ZONE_ADD))
            {
                return false;
            }
        } else {
            // Edit
            if (!$this->checkPermissions(
                $this->aAllowTraffickerAndAbovePerm,
                'zones', $oZone->zoneId, OA_PERM_ZONE_EDIT))
            {
                return false;
            }
        }

        if (!empty($oZone->chainedZoneId)) {
            if (!$this->checkPermissions(
                $this->aAllowTraffickerAndAbovePerm,
                'zones', $oZone->chainedZoneId, OA_PERM_ZONE_EDIT))
            {
                return false;
            }
        }

        $zoneData = (array) $oZone;

        // Name
        $zoneData['zonename']       = $oZone->zoneName;
        $zoneData['affiliateid']    = $oZone->publisherId;
        $zoneData['delivery']       = $oZone->type;
        $zoneData['width']          = $oZone->width;
        $zoneData['height']         = $oZone->height;
        $zoneData['capping']        = $oZone->capping > 0 ? $oZone->capping : 0;
        $zoneData['session_capping']= $oZone->sessionCapping > 0 ? $oZone->sessionCapping : 0;
        $zoneData['block']          = $oZone->block > 0 ? $oZone->block : 0;
        $zoneData['chain']          = empty($oZone->chainedZoneId) ? null : 'zone:'.$oZone->chainedZoneId;

        if ($this->_validate($oZone)) {
            $doZone = OA_Dal::factoryDO('zones');
            if (!isset($zoneData['zoneId'])) {
                $doZone->setFrom($zoneData);
                $oZone->zoneId = $doZone->insert();

            } else {
                $doZone->get($zoneData['zoneId']);
                $doZone->setFrom($zoneData);
                $doZone->update();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * This method deletes an existing zone.
     *
     * @access public
     *
     * @param integer $zoneId The ID of the zone to delete
     *
     * @return boolean True if the operation was successful
     *
     */
    function delete($zoneId)
    {
        if (!$this->checkPermissions($this->aAllowTraffickerAndAbovePerm, 'zones', $zoneId)) {
            return false;
        }

        if (!$this->checkIdExistence('zones', $zoneId)) {
            return false;
        } else {
            $doZone = OA_Dal::factoryDO('zones');
            $doZone->zoneid = $zoneId;
            $result = $doZone->delete();
        }

        if ($result) {
            return true;
        } else {
            $this->raiseError('Unknown zoneId Error');
            return false;
        }
    }

    /**
     * This method returns ZoneInfo for a specified zone.
     *
     * @access public
     *
     * @param int $zoneId
     * @param OA_Dll_ZoneInfo &$oZone
     *
     * @return boolean
     */
    function getZone($zoneId, &$oZone)
    {
        if ($this->checkIdExistence('zones', $zoneId)) {
            if (!$this->checkPermissions(null, 'zones', $zoneId)) {
                return false;
            }
            $doZone = OA_Dal::factoryDO('zones');
            $doZone->get($zoneId);
            $zoneData = $doZone->toArray();

            $oZone = new OA_Dll_ZoneInfo();

            $this->_setZoneDataFromArray($oZone, $zoneData);
            return true;

        } else {

            $this->raiseError('Unknown zoneId Error');
            return false;
        }
    }

    /**
     * This method returns a list of zones for a publisher.
     *
     * @access public
     *
     * @param int $publisherId
     * @param array &$aZoneList
     *
     * @return boolean
     */
    function getZoneListByPublisherId($publisherId, &$aZoneList)
    {
        $aZoneList = array();

        if (!$this->checkIdExistence('affiliates', $publisherId)) {
                return false;
        }

        if (!$this->checkPermissions(null, 'affiliates', $publisherId)) {
            return false;
        }

        $doZone = OA_Dal::factoryDO('zones');
        $doZone->affiliateid = $publisherId;
        $doZone->find();

        while ($doZone->fetch()) {
            $zoneData = $doZone->toArray();

            $oZone = new OA_Dll_ZoneInfo();
            $this->_setZoneDataFromArray($oZone, $zoneData);

            $aZoneList[] = $oZone;
        }
        return true;
    }

    /**
     * This method returns daily statistics for a zone for a specified period.
     *
     * @access public
     *
     * @param integer $zoneId The ID of the zone to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array $rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>day date</b> The day
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     *   </ul>
     *
     * @return boolean True if the operation was successful and false if not.
     *
     */
    function getZoneDailyStatistics($zoneId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($zoneId)) {
            return false;
        }

        if ($this->_validateForStatistics($zoneId, $oStartDate, $oEndDate)) {
            $dalZone = new OA_Dal_Statistics_Zone;
            $rsStatisticsData = $dalZone->getZoneDailyStatistics($zoneId,
                $oStartDate, $oEndDate, $localTZ);

            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns daily statistics for a zone for a specified period.
     *
     * @access public
     *
     * @param integer $zoneId The ID of the zone to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array $rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>advertiser ID integer</b> The ID of the advertiser
     *   <li><b>advertiserName string (255)</b> The name of the advertiser
     *   <li><b>requests integer</b> The number of requests for the advertiser
     *   <li><b>impressions integer</b> The number of impressions for the advertiser
     *   <li><b>clicks integer</b> The number of clicks for the advertiser
     *   <li>a<b>revenue decimal</b> The revenue earned for the advertiser
     *   </ul>
     *
     * @return boolean True if the operation was successful and false if not.
     *
     */

    function getZoneAdvertiserStatistics($zoneId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($zoneId)) {
            return false;
        }

        if ($this->_validateForStatistics($zoneId, $oStartDate, $oEndDate)) {
            $dalZone = new OA_Dal_Statistics_Zone;
            $rsStatisticsData = $dalZone->getZoneAdvertiserStatistics($zoneId,
                $oStartDate, $oEndDate, $localTZ);

            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns campaign statistics for a zone for a specified period.
     *
     * @access public
     *
     * @param integer $zoneId The ID of the zone to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array $rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>campaignID integer</b> The ID of the campaign
     *   <li><b>campaignName string</b> The name of the campaign
     *   <li><b>advertiserID integer</b> The ID advertiser
     *   <li><b>advertiserName string</b> The name advertiser
     *   <li><b>requests integer</b> The number of requests for the campaign
     *   <li><b>impressions integer</b> The number of impressions for the campaign
     *   <li><b>clicks integer</b> The number of clicks for the campaign
     *   <li><b>revenue decimal</b> The revenue earned for the campaign
     *   </ul>
     *
     * @return boolean True if the operation was successful and false if not.
     *
     */
    function getZoneCampaignStatistics($zoneId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($zoneId)) {
            return false;
        }

        if ($this->_validateForStatistics($zoneId, $oStartDate, $oEndDate)) {
            $dalZone = new OA_Dal_Statistics_Zone;
            $rsStatisticsData = $dalZone->getZoneCampaignStatistics($zoneId,
                $oStartDate, $oEndDate, $localTZ);

            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns banner statistics for a zone for a specified period.
     *
     * @access public
     *
     * @param integer $zoneId The ID of the zone to view statistics
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array $rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>bannerID integer</b> The ID of the banner
     *   <li><b>bannerName string (255)</b> The name of the banner
     *   <li><b>campaignID integer</b> The ID of the banner
     *   <li><b>campaignName string (255)</b> The name of the banner
     *   <li><b>advertiserID integer</b> The ID of the advertiser
     *   <li><b>advertiserName string</b> The name of the advertiser
     *   <li><b>requests integer</b> The number of requests for the banner
     *   <li><b>impressions integer</b> The number of impressions for the banner
     *   <li><b>clicks integer</b> The number of clicks for the banner
     *   <li><b>revenue decimal</b> The revenue earned for the banner
     *   </ul>
     *
     * @return boolean True if the operation was successful and false if not.
     *
     */
    function getZoneBannerStatistics($zoneId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($zoneId)) {
            return false;
        }

        if ($this->_validateForStatistics($zoneId, $oStartDate, $oEndDate)) {
            $dalZone = new OA_Dal_Statistics_Zone;
            $rsStatisticsData = $dalZone->getZoneBannerStatistics($zoneId,
                $oStartDate, $oEndDate, $localTZ);

            return true;
        } else {
            return false;
        }
    }

    /**
     * A method to link a banner to a zone
     *
     * @param int $zoneId
     * @param int $bannerId
     * @return bool
     */
    function linkBanner($zoneId, $bannerId)
    {
        if ($this->checkIdExistence('zones', $zoneId)) {
            $doZones = OA_Dal::staticGetDO('zones', $zoneId);
            if (!$this->checkPermissions(null, 'affiliates', $doZones->affiliateid, OA_PERM_ZONE_LINK)) {
                return false;
            }

            if ($this->checkIdExistence('banners', $bannerId)) {
                $aLinkedAds = Admin_DA::getAdZones(array('zone_id' => $zoneId), false, 'ad_id');
                if (!isset($aLinkedAds[$bannerId])) {
                    $result = Admin_DA::addAdZone(array('zone_id' => $zoneId, 'ad_id' => $bannerId));

                    if (PEAR::isError($result)) {
                        $this->raiseError($result->getMessage());
                        return false;
                    }

                    return true;
                } else {
                    // Already linked
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * A method to link a campaign to a zone
     *
     * @param int $zoneId
     * @param int $campaignId
     * @return bool
     */
    function linkCampaign($zoneId, $campaignId)
    {
        if ($this->checkIdExistence('zones', $zoneId)) {
            $doZones = OA_Dal::staticGetDO('zones', $zoneId);
            if (!$this->checkPermissions(null, 'affiliates', $doZones->affiliateid, OA_PERM_ZONE_LINK)) {
                return false;
            }

            if ($this->checkIdExistence('campaigns', $campaignId)) {
                $aLinkedPlacements = Admin_DA::getPlacementZones(array('zone_id' => $zoneId), false, 'placement_id');
                if (!isset($aLinkedPlacements[$campaignId])) {
                    $result = Admin_DA::addPlacementZone(array('zone_id' => $zoneId, 'placement_id' => $campaignId));

                    if (PEAR::isError($result)) {
                        $this->raiseError($result->getMessage());
                        return false;
                    }

                    MAX_addLinkedAdsToZone($zoneId, $campaignId);
                    return true;
                } else {
                    // Already linked
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * A method to unlink a banner from a zone
     *
     * @param int $zoneId
     * @param int $bannerId
     * @return bool
     */
    function unlinkBanner($zoneId, $bannerId)
    {
        if ($this->checkIdExistence('zones', $zoneId) &&
            $this->checkIdExistence('banners', $bannerId)) {

            $doZones = OA_Dal::staticGetDO('zones', $zoneId);
            if (!$this->checkPermissions(null, 'affiliates', $doZones->affiliateid, OA_PERM_ZONE_LINK)) {
                return false;
            }

            // $result will be true on success, false on failure and 0 on no rows affected.
            $result = Admin_DA::deleteAdZones(array('zone_id' => $zoneId, 'ad_id' => $bannerId));
            if ($result === 0) {
                $this->raiseError('Unknown link for zoneId and bannerId Error');
                return false;
            } else {
                return $result;
            }
        }
    }

    /**
     * A method to unlink a campaign from a zone
     *
     * @param int $zoneId
     * @param int $campaignId
     * @return bool
     */
    function unlinkCampaign($zoneId, $campaignId)
    {
        if ($this->checkIdExistence('zones', $zoneId) &&
            $this->checkIdExistence('campaigns', $campaignId)) {

            $doZones = OA_Dal::staticGetDO('zones', $zoneId);
            if (!$this->checkPermissions(null, 'affiliates', $doZones->affiliateid, OA_PERM_ZONE_LINK)) {
                return false;
            }

            $result = Admin_DA::deletePlacementZones(array('zone_id' => $zoneId, 'placement_id' => $campaignId));
            if ($result === 0) {
	           $this->raiseError('Unknown link for zoneId and campaignId Error');
               return false;
            } else {
	           return $result;
            }
        }

        return false;
    }

    function generateTags($zoneId, $codeType, $aParams = null)
    {
        // Backwards Compatibity Array for code types
        $aBackwardsCompatibityTypes = array (
            'adframe'         => 'invocationTags:oxInvocationTags:adframe',
            'adjs'            => 'invocationTags:oxInvocationTags:adjs',
            'adlayer'         => 'invocationTags:oxInvocationTags:adlayer',
            'adview'          => 'invocationTags:oxInvocationTags:adview',
            'adviewnocookies' => 'invocationTags:oxInvocationTags:adviewnocookies',
            'local'           => 'invocationTags:oxInvocationTags:local',
            'popup'           => 'invocationTags:oxInvocationTags:popup',
            'xmlrpc'          => 'invocationTags:oxInvocationTags:xmlrpc'
        );
        // Translate old code type to new Component Identifier
        if (array_key_exists($codeType,$aBackwardsCompatibityTypes)) {
            $codeType = $aBackwardsCompatibityTypes[$codeType];
        }
        if ($this->checkIdExistence('zones', $zoneId)) {
            $doZones = OA_Dal::staticGetDO('zones', $zoneId);
            if (!$this->checkPermissions(null, 'affiliates', $doZones->affiliateid, OA_PERM_ZONE_INVOCATION)) {
                return false;
            }
            $aAllowedTags = $this->getAllowedTags();
            if (!in_array($codeType, $aAllowedTags)) {
                $this->raiseError('Field \'codeType\' must be one of the enum: '.join(', ', $aAllowedTags));
                return false;
            }
            if (!empty($codeType)) {
                require_once MAX_PATH . '/lib/max/Admin/Invocation.php';

                $maxInvocation = new MAX_Admin_Invocation();

                // factory plugin for this $codetype
                OA::disableErrorHandling();
                $invocationTag = OX_Component::factoryByComponentIdentifier($codeType);
                OA::enableErrorHandling();
                if($invocationTag === false) {
                    $this->raiseError('Error while factory invocationTag plugin');
                    return false;
                }
                $invocationTag->setInvocation($maxInvocation);

                $aParams['zoneid']   = $zoneId;
                $aParams['codetype'] = $codeType;

                $buffer = $maxInvocation->generateInvocationCode($invocationTag, $aParams);

                return $buffer;
            } else {
                $this->raiseError('Parameter codeType wrong');
            }
        }

        return false;
    }

    /**
     * Returns array of allowed invocation tags
     *
     * @return array of allowed invocation tags (strings)
     */
    function getAllowedTags() {
        $aAllowedTags = array();
        $invocationTags =& OX_Component::getComponents('invocationTags');
        foreach($invocationTags as $pluginKey => $invocationTag) {
            if ($invocationTag->isAllowed(null, null)){
                $aAllowedTags[] = $pluginKey;
            }
        }
        return $aAllowedTags;
    }
}

?>
