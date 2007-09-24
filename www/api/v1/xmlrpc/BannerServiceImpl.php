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
 * A file to description Banner Service Implementation class.
 *
 */

// Base class BaseLogonService
require_once MAX_PATH . '/www/api/v1/common/BaseServiceImpl.php';

// Banner Dll class
require_once MAX_PATH . '/lib/OA/Dll/Banner.php';

class BannerServiceImpl extends BaseServiceImpl
{
    /**
     *
     * @var OA_Dll_Banner $_dllBanner
     */
    var $_dllBanner;

    /**
     *
     * Constructor for BannerServiceImpl.
     */
    function BannerServiceImpl()
    {
        $this->BaseServiceImpl();
        $this->_dllBanner = new OA_Dll_Banner();
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
            $this->raiseError($this->_dllBanner->getLastError());
            return false;
        }
    }

    /**
     * Add Banner. Call method to modify Banner.
     *
     * @param string $sessionId
     * @param OA_Dll_BannerInfo &$oBanner
     *
     * @return boolean
     */
    function addBanner($sessionId, &$oBanner)
    {
		if ($this->verifySession($sessionId)) {

		    return $this->_validateResult($this->_dllBanner->modify($oBanner));

		} else {

			return false;
		}

    }

    /**
     * Modify Banner. Check and call method to modify Banner.
     *
     * @param string $sessionId
     * @param OA_DLL_BannerInfo &$oBanner
     *
     * @return boolean
     */
    function modifyBanner($sessionId, &$oBanner)
    {
		if ($this->verifySession($sessionId)) {


            if (isset($oBanner->bannerId)) {

    		    return $this->_validateResult($this->_dllBanner->modify($oBanner));

            } else {

                $this->raiseError("Field 'bannerId' in structure does not exists");
                return false;

            }

		} else {

			return false;
		}

    }

    /**
     * Call method to delete banner.
     *
     * @param string $sessionId
     * @param integer $bannerId
     *
     * @return boolean
     */
    function deleteBanner($sessionId, $bannerId)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult($this->_dllBanner->delete($bannerId));

		} else {

			return false;
		}
    }

    /**
     * Call method to generate daily statistics.
     *
     * @param string $sessionId
     * @param integer $bannerId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getBannerDailyStatistics($sessionId, $bannerId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllBanner->getBannerDailyStatistics(
                    $bannerId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate publisher statistics.
     *
     * @param string $sessionId
     * @param integer $bannerId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getBannerPublisherStatistics($sessionId, $bannerId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllBanner->getBannerPublisherStatistics(
                    $bannerId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }

    /**
     * Call method to generate zone statistics.
     *
     * @param string $sessionId
     * @param integer $bannerId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getBannerZoneStatistics($sessionId, $bannerId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllBanner->getBannerZoneStatistics(
                    $bannerId, $oStartDate, $oEndDate, $rsStatisticsData));
		} else {

			return false;
		}
    }
    
    /**
     * Call method to get banner by id
     *
     * @param string $sessionId
     * @param integer $bannerId
     * @param OA_Dll_BannerInfo &$oBanner
     * 
     * @return boolean
     */
    function getBanner($sessionId, $bannerId, &$oBanner)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllBanner->getBanner($bannerId, $oBanner));
		} else {

			return false;
		}
    }
    
    /**
     * Call method to get banners by campaign id
     *
     * @param string $sessionId
     * @param integer $campaignId
     * @param array &$aBannerList  Array of OA_Dll_BannerInfo classes
     * 
     * @return boolean
     */
    function getBannerListByCampaignId($sessionId, $campaignId, &$aBannerList)
    {
		if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllBanner->getBannerListByCampaignId($campaignId,
                                                    $aBannerList));
		} else {

			return false;
		}
    }
}


?>