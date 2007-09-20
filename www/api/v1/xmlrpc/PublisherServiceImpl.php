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
 * A file to description Publisher Service Implementation class.
 *
 */

// Base class BaseLogonService
require_once MAX_PATH . '/www/api/v1/common/BaseServiceImpl.php';

// Publisher Dll class
require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';

class PublisherServiceImpl extends BaseServiceImpl
{
    /**
     *
     * @var OA_Dll_Publisher $_dllPublisher
     */
    var $_dllPublisher;

    /**
     *
     * Constructor for PublisherServiceImpl.
     */
    function PublisherServiceImpl()
    {
        $this->BaseServiceImpl();
        $this->_dllPublisher = new OA_Dll_Publisher();
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
            $this->raiseError($this->_dllPublisher->getLastError());
            return false;
        }
    }

    /**
     * Add publisher. Call method to modify publisher.
     *
     * @param string $sessionId
     * @param OA_Dll_PublisherInfo &$oPublisher
     *
     * @return boolean
     */
    function addPublisher($sessionId, &$oPublisher)
    {
		if ($this->verifySession($sessionId)) {

		    return $this->_validateResult($this->_dllPublisher->modify($oPublisher));

		} else {

			return false;
		}

    }

    /**
     * Modify publisher. Check and call method to modify publisher.
     *
     * @param string $sessionId
     * @param OA_Dll_PublisherInfo &$oPublisher
     *
     * @return boolean
     */
    function modifyPublisher($sessionId, &$oPublisher)
    {
		if ($this->verifySession($sessionId)) {

            if (isset($oPublisher->publisherId)) {

                return $this->_validateResult($this->_dllPublisher->modify($oPublisher));
            } else {

                $this->raiseError("Field 'publisherId' in structure does not exists");
                return false;
            }

		} else {

			return false;
		}

    }

    /**
     * Call method to delete publisher.
     *
     * @param string $sessionId
     * @param integer $publisherId
     *
     * @return boolean
     */
    function deletePublisher($sessionId, $publisherId)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult($this->_dllPublisher->delete($publisherId));

		} else {

			return false;
		}
    }

    /**
     * Call method to generate daily statistics.
     *
     * @param string $sessionId
     * @param integer $publisherId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getPublisherDailyStatistics($sessionId, $publisherId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllPublisher->getPublisherDailyStatistics(
                    $publisherId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate zone statistics.
     *
     * @param string $sessionId
     * @param integer $publisherId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getPublisherZoneStatistics($sessionId, $publisherId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllPublisher->getPublisherZoneStatistics(
                    $publisherId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate advertiser statistics.
     *
     * @param string $sessionId
     * @param integer $publisherId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getPublisherAdvertiserStatistics($sessionId, $publisherId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllPublisher->getPublisherAdvertiserStatistics(
                    $publisherId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate campaign statistics.
     *
     * @param string $sessionId
     * @param integer $publisherId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getPublisherCampaignStatistics($sessionId, $publisherId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllPublisher->getPublisherCampaignStatistics(
                    $publisherId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate banner statistics.
     *
     * @param string $sessionId
     * @param integer $publisherId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getPublisherBannerStatistics($sessionId, $publisherId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllPublisher->getPublisherBannerStatistics(
                    $publisherId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

}


?>