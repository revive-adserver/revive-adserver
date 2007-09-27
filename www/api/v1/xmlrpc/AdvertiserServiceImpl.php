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
 * A file to description Advertiser Service Implementation class.
 *
 */

// This is the base class for the BaseLogonService
require_once MAX_PATH . '/www/api/v1/common/BaseServiceImpl.php';

// Advertiser Dll class
require_once MAX_PATH . '/lib/OA/Dll/Advertiser.php';

class AdvertiserServiceImpl extends BaseServiceImpl
{
    /**
     *
     * @var OA_Dll_Advertiser $_dllAdvertiser
     */
    var $_dllAdvertiser;

    /**
     *
     * Constructor for AdvertiserServiceImpl.
     */
    function AdvertiserServiceImpl()
    {
        $this->BaseServiceImpl();
        $this->_dllAdvertiser = new OA_Dll_Advertiser();
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
            $this->raiseError($this->_dllAdvertiser->getLastError());
            return false;
        }
    }

    /**
     * Add Advertiser. Call method to modify advertiser.
     *
     * @param string $sessionId
     * @param OA_Dll_AdvertiserInfo &$oAdvertiser
     *
     * @return boolean
     */
    function addAdvertiser($sessionId, &$oAdvertiser)
    {
		if ($this->verifySession($sessionId)) {

		    return $this->_validateResult($this->_dllAdvertiser->modify($oAdvertiser));

		} else {

			return false;
		}

    }
    /**
     * Modify Advertiser. Check and call method to modify advertiser.
     *
     * @param string $sessionId
     * @param OA_Dll_AdvertiserInfo &$oAdvertiser
     *
     * @return boolean
     */
    function modifyAdvertiser($sessionId, &$oAdvertiser)
    {
		if ($this->verifySession($sessionId)) {

            if (isset($oAdvertiser->advertiserId)) {

                return $this->_validateResult($this->_dllAdvertiser->modify($oAdvertiser));

            } else {

                $this->raiseError("Field 'advertiserId' in structure does not exists");
                return false;
            }

		} else {

			return false;
		}

    }

    /**
     * Call method to delete advertiser.
     *
     * @param string $sessionId
     * @param integer $advertiserId
     *
     * @return boolean
     */
    function deleteAdvertiser($sessionId, $advertiserId)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult($this->_dllAdvertiser->delete($advertiserId));

		} else {

			return false;
		}
    }

    /**
     * Call method to generate daily statistics.
     *
     * @param string $sessionId
     * @param integer $advertiserId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getAdvertiserDailyStatistics($sessionId, $advertiserId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAdvertiser->getAdvertiserDailyStatistics(
                    $advertiserId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate campaign statistics.
     *
     * @param string $sessionId
     * @param integer $advertiserId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getAdvertiserCampaignStatistics($sessionId, $advertiserId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAdvertiser->getAdvertiserCampaignStatistics(
                    $advertiserId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate banner statistics.
     *
     * @param string $sessionId
     * @param integer $advertiserId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getAdvertiserBannerStatistics($sessionId, $advertiserId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAdvertiser->getAdvertiserBannerStatistics(
                    $advertiserId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate publisher statistics.
     *
     * @param string $sessionId
     * @param integer $advertiserId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getAdvertiserPublisherStatistics($sessionId, $advertiserId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAdvertiser->getAdvertiserPublisherStatistics(
                    $advertiserId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate zone statistics.
     *
     * @param string $sessionId
     * @param integer $advertiserId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getAdvertiserZoneStatistics($sessionId, $advertiserId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAdvertiser->getAdvertiserZoneStatistics(
                    $advertiserId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to get advertiser by id
     *
     * @param string $sessionId
     * @param integer $advertiserId
     * @param OA_Dll_AdvertiserInfo &$oAdvertiser
     * 
     * @return boolean
     */
    function getAdvertiser($sessionId, $advertiserId, &$oAdvertiser)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAdvertiser->getAdvertiser($advertiserId, $oAdvertiser));
		} else {

			return false;
		}
    }
    
    /**
     * Call method to get advertisers by agency id
     *
     * @param string $sessionId
     * @param integer $agencyId
     * @param array &$aAdvertiserList  Array of OA_Dll_AdvertiserInfo classes
     * 
     * @return boolean
     */
    function getAdvertiserListByAgencyId($sessionId, $agencyId, &$aAdvertiserList)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAdvertiser->getAdvertiserListByAgencyId($agencyId,
                                                    $aAdvertiserList));
		} else {

			return false;
		}
    }

}


?>