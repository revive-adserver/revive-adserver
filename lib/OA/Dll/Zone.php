<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
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
$Id:$
*/

/**
 * @package    OpenadsDll
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 * A file to description Dll Zone class.
 *
 */

// Require the XMLRPC classes
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Dll/ZoneInfo.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/Zone.php';


/**
 * Zone Dll class
 *
 */

class OA_Dll_Zone extends OA_Dll
{
    /**
     * Method would zone type validation.
     * Types: banner=0, interstitial=1, popup=2, text=3, email=4)
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
     * method would perform data validation
     *
     * @param OA_Dll_ZoneInfo $oZone
     *
     * @return boolean
     *
     */
    function _validate(&$oZone)
    {
        if (!$this->_validateZoneType($oZone->type) ||
            !$this->checkStructureNotRequiredStringField($oZone, 'zoneName', 255) ||
            !$this->checkStructureNotRequiredIntegerField($oZone, 'width') ||
            !$this->checkStructureNotRequiredIntegerField($oZone, 'height')) {

            return false;
        }

        if (isset($oZone->zoneId)) {
            // Modify Zone
            if (!$this->checkStructureRequiredIntegerField($oZone, 'zoneId') ||
                !$this->checkStructureNotRequiredIntegerField($oZone, 'publisherId') ||
                !$this->checkIdExistence('zones', $oZone->zoneId)) {
                return false;
            }
        } else {
            // Add Zone
            if (!$this->checkStructureRequiredIntegerField($oZone, 'publisherId')) {
                return false;
            }
        }

        if (isset($oZone->publisherId) &&
            !$this->checkIdExistence('affiliates', $oZone->publisherId)) {
            return false;
        }


        return true;
    }

    /**
     * Method would perform data validation for statistics methods(zoneId,
     *  date).
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
     * Calls method for checking permissions from Dll class.
     *
     * @param integer $advertiserId  Zone ID
     *
     * @return boolean  False in access forbidden and true in other case.
     */
    function checkStatisticsPermissions($zoneId)
    {
       if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency +
            phpAds_Affiliate, 'zones', $zoneId)) {

            return false;
        } else {
            return true;
        }
    }

    /**
     * This method modifies an existing zone. All fields which are
     * undefined (e.g. permissions) are not changed from the state they
     * were before modification. Any fields defined below
     * that are NULL are unchanged.
     *
     * @param OA_Dll_ZoneInfo $oZone
     *
     * @return success boolean True if the operation was successful
     *
     */
    function modify(&$oZone)
    {
        if (!isset($oZone->zoneId)) {
            // Add
            $oZone->setDefaultForAdd();

            if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency +
                 phpAds_Affiliate, 'affiliates', $oZone->publisherId,
                 phpAds_AddZone)) {

                return false;
            }
        } else {
            // Edit
            if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency +
                 phpAds_Affiliate, 'zones', $oZone->zoneId,
                 phpAds_EditZone)) {

                return false;
            }
        }

        $zoneData = (array) $oZone;

        // Name
        $zoneData['zonename']    = $oZone->zoneName;
        $zoneData['affiliateid'] = $oZone->publisherId;
        $zoneData['delivery']    = $oZone->type;
        $zoneData['width']       = $oZone->width;
        $zoneData['heitht']      = $oZone->heitht;

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
     * @param integer $zoneId The ID of the zone to delete
     *
     * @return boolean success - True if the operation was successful
     *
     */
    function delete($zoneId)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency +
             phpAds_Affiliate, 'zones', $zoneId)) {

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
    * This method returns statistics for a given zone, broken down by day.
    *
    * @param integer $zoneId The ID of the zone to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array $rsStatisticsData Parametr for returned data from function
    *   <ul>
    *   <li><b>day date</b> The day
    *   <li><b>requests integer</b> The number of requests for the day
    *   <li><b>impressions integer</b> The number of impressions for the day
    *   <li><b>clicks integer</b> The number of clicks for the day
    *   <li><b>revenue decimal</b> The revenue earned for the day
    *   </ul>
    *
    * @return boolean False if the is error
    *
    */
    function getZoneDailyStatistics($zoneId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($zoneId)) {
            return false;
        }

        if ($this->_validateForStatistics($zoneId, $oStartDate, $oEndDate)) {
            $dalZone = new OA_Dal_Statistics_Zone;
            $rsStatisticsData = $dalZone->getZoneDailyStatistics($zoneId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

    /**
    * This method returns statistics for a given zone, broken
    * down by advertiser.
    *
    * @param integer $zoneId The ID of the zone to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    *
    * @return array
    *   <ul>
    *   <li><b>advertiser ID integer</b> The ID of the advertiser
    *   <li><b>advertiserName string (255)</b> The name of the advertiser
    *   <li><b>requests integer</b> The number of requests for the advertiser
    *   <li><b>impressions integer</b> The number of impressions for the advertiser
    *   <li><b>clicks integer</b> The number of clicks for the advertiser
    *   <li><b>revenue decimal</b> The revenue earned for the advertiser
    *   </ul>
    *
    */

    function getZoneAdvertiserStatistics($zoneId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($zoneId)) {
            return false;
        }

        if ($this->_validateForStatistics($zoneId, $oStartDate, $oEndDate)) {
            $dalZone = new OA_Dal_Statistics_Zone;
            $rsStatisticsData = $dalZone->getZoneAdvertiserStatistics($zoneId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

    /**
    * This method returns statistics for a given zone, broken down by campaign.
    * @errors
    *    Unknown ID Error
    *       If the zoneId is not a defined zone ID.
    *    Date Error
    *        If the start date is after the end date
    *
    * @param integer $zoneId The ID of the zone to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    *
    * @return array
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
    */
    function getZoneCampaignStatistics($zoneId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($zoneId)) {
            return false;
        }

        if ($this->_validateForStatistics($zoneId, $oStartDate, $oEndDate)) {
            $dalZone = new OA_Dal_Statistics_Zone;
            $rsStatisticsData = $dalZone->getZoneCampaignStatistics($zoneId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

    /**
    * This method returns statistics for a given zone, broken down by banner.
    *
    * @param integer $zoneId The ID of the zone to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    *
    * @return array
    *   <ul>
    *   <li><b>bannerID integer</b> The ID of the banner
    *   <li><b>bannerName string (255)</b> The name of the banner
    *   <li><b>campaignID integer</b> The ID of the banner
    *   <li><b>campaignName string (255)</b> The name of the banner
    *   <li><b>advertiserID integer</b> The ID advertiser
    *   <li><b>advertiserName string</b> The name advertiser
    *   <li><b>requests integer</b> The number of requests for the banner
    *   <li><b>impressions integer</b> The number of impressions for the banner
    *   <li><b>clicks integer</b> The number of clicks for the banner
    *   <li><b>revenue decimal</b> The revenue earned for the banner
    *   </ul>
    *
    */
    function getZoneBannerStatistics($zoneId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($zoneId)) {
            return false;
        }

        if ($this->_validateForStatistics($zoneId, $oStartDate, $oEndDate)) {
            $dalZone = new OA_Dal_Statistics_Zone;
            $rsStatisticsData = $dalZone->getZoneBannerStatistics($zoneId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

}

?>
