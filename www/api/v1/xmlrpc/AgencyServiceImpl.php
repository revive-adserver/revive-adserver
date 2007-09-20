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
 * A file to description Agency Service Implementation class.
 *
 */

// Base class BaseLogonService
require_once MAX_PATH . '/www/api/v1/common/BaseServiceImpl.php';

// Agency Dll class
require_once MAX_PATH . '/lib/OA/Dll/Agency.php';

class AgencyServiceImpl extends BaseServiceImpl
{
    /**
     *
     * @var OA_Dll_Agency $_dllAgency
     */
    var $_dllAgency;

    /**
     *
     * Constructor for AgencyServiceImpl.
     */
    function AgencyServiceImpl()
    {
        $this->BaseServiceImpl();
        $this->_dllAgency = new OA_Dll_Agency();
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
            $this->raiseError($this->_dllAgency->getLastError());
            return false;
        }
    }

    /**
     * Add agency. Call method to modify agency.
     *
     * @param string $sessionId
     * @param OA_Dll_AgencyInfo &$oAgency
     *
     * @return boolean
     */
    function addAgency($sessionId, &$oAgency)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult($this->_dllAgency->modify($oAgency));

        } else {

            return false;
		}

    }

    /**
     * Modify agency. Check and call method to modify agency.
     *
     * @param string $sessionId
     * @param OA_DLL_AgencyInfo &$oAgency
     *
     * @return boolean
     */
    function modifyAgency($sessionId, &$oAgency)
    {
        if ($this->verifySession($sessionId)) {

            if (isset($oAgency->agencyId)) {

                return $this->_validateResult($this->_dllAgency->modify($oAgency));

            } else {

                $this->raiseError("Field 'agencyId' in structure does not exists");
                return false;
            }

        } else {

            return false;
		}

    }

    /**
     * Call method to delete agency.
     *
     * @param string $sessionId
     * @param integer $agencyId
     *
     * @return boolean
     */
    function deleteAgency($sessionId, $agencyId)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult($this->_dllAgency->delete($agencyId));

		} else {

			return false;
		}
    }

    /**
     * Call method to generate daily statistics.
     *
     * @param string $sessionId
     * @param integer $agencyId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getAgencyDailyStatistics($sessionId, $agencyId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAgency->getAgencyDailyStatistics(
                    $agencyId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate advertiser statistics.
     *
     * @param string $sessionId
     * @param integer $agencyId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getAgencyAdvertiserStatistics($sessionId, $agencyId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAgency->getAgencyAdvertiserStatistics(
                    $agencyId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate campaign statistics.
     *
     * @param string $sessionId
     * @param integer $agencyId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getAgencyCampaignStatistics($sessionId, $agencyId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAgency->getAgencyCampaignStatistics(
                    $agencyId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate banner statistics.
     *
     * @param string $sessionId
     * @param integer $agencyId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getAgencyBannerStatistics($sessionId, $agencyId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAgency->getAgencyBannerStatistics(
                    $agencyId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate publisher statistics.
     *
     * @param string $sessionId
     * @param integer $agencyId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getAgencyPublisherStatistics($sessionId, $agencyId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAgency->getAgencyPublisherStatistics(
                    $agencyId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate zone statistics.
     *
     * @param string $sessionId
     * @param integer $agencyId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getAgencyZoneStatistics($sessionId, $agencyId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAgency->getAgencyZoneStatistics(
                    $agencyId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }
}


?>