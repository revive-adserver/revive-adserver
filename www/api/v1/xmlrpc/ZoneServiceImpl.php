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
 * @package    Openads
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 * A file to description Zone Service Implementation class.
 *
 */

// Base class BaseLogonService
require_once MAX_PATH . '/www/api/v1/common/BaseServiceImpl.php';

// Zone Dll class
require_once MAX_PATH . '/lib/OA/Dll/Zone.php';

class ZoneServiceImpl extends BaseServiceImpl
{
    /**
     *
     * @var OA_Dll_Zone $_dllZone
     */
    var $_dllZone;

    /**
     *
     * Constructor for ZoneServiceImpl.
     */
    function ZoneServiceImpl()
    {
        $this->BaseServiceImpl();
        $this->_dllZone = new OA_Dll_Zone();
    }

    /**
     * Validate action, reise error and return result.
     *
     * @access private
     *
     * @param boolean $result
     * @return boolean
     */
    function _validateResult($result)
    {
        if ($result) {
            return true;
        } else {
            $this->raiseError($this->_dllZone->getLastError());
            return false;
        }
    }

    /**
     * Add zone. Call method to modify zone.
     *
     * @param string $sessionId
     * @param OA_Dll_ZoneInfo &$oZone
     *
     * @return boolean
     */
    function addZone($sessionId, &$oZone)
    {
		if ($this->verifySession($sessionId)) {

		    return $this->_validateResult($this->_dllZone->modify($oZone));

		} else {

			return false;
		}

    }

    /**
     * Modify zone. Check and call method to modify zone.
     *
     * @param string $sessionId
     * @param OA_Dll_ZoneInfo &$oZone
     *
     * @return boolean
     */
    function modifyZone($sessionId, &$oZone)
    {
		if ($this->verifySession($sessionId)) {

            if (isset($oZone->zoneId)) {

                return $this->_validateResult($this->_dllZone->modify($oZone));

            } else {

                $this->raiseError("Field 'zoneId' in structure does not exists");
                return false;
            }

		} else {

			return false;
		}

    }

    /**
     * Call method to delete zone.
     *
     * @param string $sessionId
     * @param integer $zoneId
     *
     * @return boolean
     */
    function deleteZone($sessionId, $zoneId)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult($this->_dllZone->delete($zoneId));

		} else {

			return false;
		}
    }

    /**
     * Call method to generate daily statistics.
     *
     * @param string $sessionId
     * @param integer $zoneId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getZoneDailyStatistics($sessionId, $zoneId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllZone->getZoneDailyStatistics(
                    $zoneId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate advertiser statistics.
     *
     * @param string $sessionId
     * @param integer $zoneId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getZoneAdvertiserStatistics($sessionId, $zoneId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllZone->getZoneAdvertiserStatistics(
                    $zoneId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate campaign statistics.
     *
     * @param string $sessionId
     * @param integer $zoneId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getZoneCampaignStatistics($sessionId, $zoneId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllZone->getZoneCampaignStatistics(
                    $zoneId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate banner statistics.
     *
     * @param string $sessionId
     * @param integer $zoneId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getZoneBannerStatistics($sessionId, $zoneId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllZone->getZoneBannerStatistics(
                    $zoneId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to get zone by id
     *
     * @param string $sessionId
     * @param integer $zoneId
     * @param OA_Dll_ZoneInfo &$oZone
     * 
     * @return boolean
     */
    function getZone($sessionId, $zoneId, &$oZone)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllZone->getZone($zoneId, $oZone));
		} else {

			return false;
		}
    }
    
    /**
     * Call method to get zone by publisher id
     *
     * @param string $sessionId
     * @param integer $publisherId
     * @param array &$oZone  Array of OA_Dll_ZoneInfo classes
     * 
     * @return boolean
     */
    function getZoneListByPublisherId($sessionId, $publisherId, &$aZoneList)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllZone->getZoneListByPublisherId($publisherId,
                                                    $aZoneList));
		} else {

			return false;
		}
    }

}


?>