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
 * @package    OpenX
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */

// Base class BaseLogonService
require_once MAX_PATH . '/www/api/v2/common/BaseServiceImpl.php';

// Zone Dll class
require_once MAX_PATH . '/lib/OA/Dll/Zone.php';

/**
 * The ZoneServiceImpl class extends the BaseServiceImpl class to enable
 * you to add, modify, delete and search the zone object.
 *
 */
class ZoneServiceImpl extends BaseServiceImpl
{
    /**
     *
     * @var OA_Dll_Zone $_dllZone
     */
    var $_dllZone;

    /**
     *
     * The ZoneServiceImpl method is the constructor for the ZoneServiceImpl class.
     */
    function ZoneServiceImpl()
    {
        $this->BaseServiceImpl();
        $this->_dllZone = new OA_Dll_Zone();
    }

    /**
     * This method checks if an action is valid and either returns a result
     * or an error, as appropriate.
     *
     * @access private
     *
     * @param boolean $result
     *
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
     * The addZone method creates a zone and updates the
     * zone object with the zone ID.
     *
     * @access public
     *
     * @param string $sessionId
     * @param OA_Dll_ZoneInfo &$oZone <br />
     *          <b>Required properties:</b> publisherId<br />
     *          <b>Optional properties:</b> zoneName, type, width, height<br />
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
     * The modifyZone method checks if a zone ID exists and
     * modifies the details for the zone if it exists or returns an error
     * message, as appropriate.
     *
     * @access public
     *
     * @param string $sessionId
     * @param OA_Dll_ZoneInfo &$oZone <br />
     *          <b>Required properties:</b> zoneId<br />
     *          <b>Optional properties:</b> publisherId, zoneName, type, width, height<br />
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
     * The deleteZone method checks if a zone exists and deletes
     * the zone or returns an error message, as appropriate.
     *
     * @access public
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
     * The getZoneDailyStatistics method returns daily statistics for a zone
     * for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $zoneId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param array &$aData  return data
     *
     * @return boolean
     */
    function getZoneDailyStatistics($sessionId, $zoneId, $oStartDate, $oEndDate, $localTZ, &$aData)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllZone->getZoneDailyStatistics(
                    $zoneId, $oStartDate, $oEndDate, $localTZ, $aData));
        } else {

            return false;
        }
    }

    /**
     * The getZoneAdvertiserStatistics method returns advertiser statistics for a
     * zone for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $zoneId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getZoneAdvertiserStatistics($sessionId, $zoneId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllZone->getZoneAdvertiserStatistics(
                    $zoneId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData));
        } else {

            return false;
        }
    }

    /**
     * The getZoneCampaignStatistics method returns campaign statistics for a zone
     * for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $zoneId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getZoneCampaignStatistics($sessionId, $zoneId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllZone->getZoneCampaignStatistics(
                    $zoneId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData));
        } else {

            return false;
        }
    }

    /**
     * The getZoneBannerStatistics method returns banner statistics for a zone
     * for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $zoneId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getZoneBannerStatistics($sessionId, $zoneId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllZone->getZoneBannerStatistics(
                    $zoneId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData));
        } else {

            return false;
        }
    }

    /**
     * The getZone method returns zone details for a specified zone.
     *
     * @access public
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
     * The getZoneListByPublisherId method returns a list of zones for a
     * specified publisher.
     *
     * @access public
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

    function linkBanner($sessionId, $zoneId, $bannerId)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllZone->linkBanner($zoneId, $bannerId));
        } else {
            return false;
        }
    }

    function linkCampaign($sessionId, $zoneId, $campaignId)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllZone->linkCampaign($zoneId, $campaignId));
        } else {
            return false;
        }
    }

    function unlinkBanner($sessionId, $zoneId, $bannerId)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllZone->unlinkBanner($zoneId, $bannerId));
        } else {
            return false;
        }
    }

    function unlinkCampaign($sessionId, $zoneId, $campaignId)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllZone->unlinkCampaign($zoneId, $campaignId));
        } else {
            return false;
        }
    }

    function generateTags($sessionId, $zoneId, $codeType, $aParams, &$generatedTag)
    {
        if ($this->verifySession($sessionId)) {
            $result = $this->_dllZone->generateTags($zoneId, $codeType, $aParams);
            if ($this->_validateResult($result)) {
                $generatedTag = $result;
                return true;
            }
        }

        return false;
    }

}


?>