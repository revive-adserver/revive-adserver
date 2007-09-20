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
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 * A file to description Campaign Service Implementation class.
 *
 */

// Base class BaseLogonService
require_once MAX_PATH . '/www/api/v1/common/BaseServiceImpl.php';

// Campaign Dll class
require_once MAX_PATH . '/lib/OA/Dll/Campaign.php';

class CampaignServiceImpl extends BaseServiceImpl
{
    /**
     *
     * @var OA_Dll_Campaign $_dllCampaign
     */
    var $_dllCampaign;

    /**
     *
     * Constructor for CampignServiceImpl.
     */
    function CampaignServiceImpl()
    {
        $this->BaseServiceImpl();
        $this->_dllCampaign = new OA_Dll_Campaign();
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
            $this->raiseError($this->_dllCampaign->getLastError());
            return false;
        }
    }

    /**
     * Add campaign. Call method to modify campaign.
     *
     * @param string $sessionId
     * @param OA_Dll_CampaignInfo &$oCampaign
     *
     * @return boolean
     */
    function addCampaign($sessionId, &$oCampaign)
    {
		if ($this->verifySession($sessionId)) {

		    return $this->_validateResult($this->_dllCampaign->modify($oCampaign));

		} else {

			return false;
		}

    }

    /**
     * Modify campaign. Call method to modify campaign.
     *
     * @param string $sessionId
     * @param OA_DLL_CampaignInfo &$oCampaign
     *
     * @return boolean
     */
    function modifyCampaign($sessionId, &$oCampaign)
    {
		if ($this->verifySession($sessionId)) {

            if (isset($oCampaign->campaignId)) {

                return $this->_validateResult($this->_dllCampaign->modify($oCampaign));

            } else {

                $this->raiseError("Field 'campaignId' in structure does not exists");
                return false;
		    }

		} else {

			return false;
		}

    }

    /**
     * Call method to delete campaign.
     *
     * @param string $sessionId
     * @param integer $campaignId
     *
     * @return boolean
     */
    function deleteCampaign($sessionId, $campaignId)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult($this->_dllCampaign->delete($campaignId));

		} else {

			return false;
		}
    }

    /**
     * Call method to generate daily statistics.
     *
     * @param string $sessionId
     * @param integer $campaignId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getCampaignDailyStatistics($sessionId, $campaignId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllCampaign->getCampaignDailyStatistics(
                    $campaignId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate banner statistics.
     *
     * @param string $sessionId
     * @param integer $campaignId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getCampaignBannerStatistics($sessionId, $campaignId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllCampaign->getCampaignBannerStatistics(
                    $campaignId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate publisher statistics.
     *
     * @param string $sessionId
     * @param integer $campaignId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getCampaignPublisherStatistics($sessionId, $campaignId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllCampaign->getCampaignPublisherStatistics(
                    $campaignId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate zone statistics.
     *
     * @param string $sessionId
     * @param integer $campaignId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getCampaignZoneStatistics($sessionId, $campaignId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllCampaign->getCampaignZoneStatistics(
                    $campaignId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }
}


?>