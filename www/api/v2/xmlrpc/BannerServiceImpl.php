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
 */

// Base class BaseLogonService
require_once MAX_PATH . '/www/api/v2/common/BaseServiceImpl.php';

// Banner Dll class
require_once MAX_PATH . '/lib/OA/Dll/Banner.php';

/**
 * The BannerServiceImpl class extends the BaseServiceImpl class to enable
 * you to add, modify, delete and search the banner object.
 *
 */
class BannerServiceImpl extends BaseServiceImpl
{
    /**
     *
     * @var OA_Dll_Banner $_dllBanner
     */
    public $_dllBanner;

    /**
     *
     * The BannerServiceImpl method is the constructor for the BannerServiceImpl class.
     */
    public function __construct()
    {
        parent::__construct();
        $this->_dllBanner = new OA_Dll_Banner();
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
    public function _validateResult($result)
    {
        if ($result) {
            return true;
        } else {
            $this->raiseError($this->_dllBanner->getLastError());
            return false;
        }
    }

    /**
     * The addBanner method creates a banner and updates the
     * banner object with the banner ID.
     *
     * @access public
     *
     * @param string $sessionId
     * @param OA_Dll_BannerInfo &$oBanner <br />
     *          <b>Required properties:</b> campaignId<br />
     *          <b>Optional properties:</b> bannerName, storageType, fileName, imageURL, htmlTemplate, width, height, weight, url<br />
     *
     * @return boolean
     */
    public function addBanner($sessionId, &$oBanner)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllBanner->modify($oBanner));
        } else {
            return false;
        }
    }

    /**
     * The modifyBanner method checks if a banner ID exists and
     * modifies the details for the banner if it exists or returns an error
     * message, as appropriate.
     *
     * @access public
     *
     * @param string $sessionId
     * @param OA_Dll_BannerInfo &$oBanner <br />
     *          <b>Required properties:</b> bannerId<br />
     *          <b>Optional properties:</b> campaignId, bannerName, storageType, fileName, imageURL, htmlTemplate, width, height, weight, url<br />
     *
     * @return boolean
     */
    public function modifyBanner($sessionId, &$oBanner)
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
     * The deleteBanner method checks if a banner exists and deletes
     * the banner or returns an error message, as appropriate.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $bannerId
     *
     * @return boolean
     */
    public function deleteBanner($sessionId, $bannerId)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllBanner->delete($bannerId));
        } else {
            return false;
        }
    }

    /**
     * This method return targeting limitations for banner
     * or returns an error message,.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $bannerId
     * @param array &$aTargeting
     *
     * @return boolean
     */
    public function getBannerTargeting($sessionId, $bannerId, &$aTargeting)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllBanner->getBannerTargeting(
                $bannerId,
                $aTargeting,
            ));
        } else {
            return false;
        }
    }


    /**
     * This method set targeting limitations for banner
     * or returns an error message.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $bannerId
     * @param array &$aTargeting
     *
     * @return boolean
     */
    public function setBannerTargeting($sessionId, $bannerId, &$aTargeting)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllBanner->setBannerTargeting(
                $bannerId,
                $aTargeting,
            ));
        } else {
            return false;
        }
    }

    /**
     * The getBannerDailyStatistics method returns daily statistics for a
     * banner for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $bannerId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param array &$aData  return data
     *
     * @return boolean
     */
    public function getBannerDailyStatistics($sessionId, $bannerId, $oStartDate, $oEndDate, $localTZ, &$aData)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllBanner->getBannerDailyStatistics(
                    $bannerId,
                    $oStartDate,
                    $oEndDate,
                    $localTZ,
                    $aData,
                ),
            );
        } else {
            return false;
        }
    }

    /**
     * The getBannerHourlyStatistics method returns hourly statistics for a
     * banner for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $bannerId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param array &$aData  return data
     *
     * @return boolean
     */
    public function getBannerHourlyStatistics($sessionId, $bannerId, $oStartDate, $oEndDate, $localTZ, &$aData)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllBanner->getBannerHourlyStatistics(
                    $bannerId,
                    $oStartDate,
                    $oEndDate,
                    $localTZ,
                    $aData,
                ),
            );
        } else {
            return false;
        }
    }

    /**
     * The getBannerPublisherStatistics method returns publisher statistics for
     * a banner for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $bannerId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    public function getBannerPublisherStatistics($sessionId, $bannerId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllBanner->getBannerPublisherStatistics(
                    $bannerId,
                    $oStartDate,
                    $oEndDate,
                    $localTZ,
                    $rsStatisticsData,
                ),
            );
        } else {
            return false;
        }
    }

    /**
     * The getBannerZoneStatistics method returns zone statistics for a zone for
     * a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $bannerId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    public function getBannerZoneStatistics($sessionId, $bannerId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllBanner->getBannerZoneStatistics(
                    $bannerId,
                    $oStartDate,
                    $oEndDate,
                    $localTZ,
                    $rsStatisticsData,
                ),
            );
        } else {
            return false;
        }
    }

    /**
     * The getBanner method returns the banner details for a specified banner.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $bannerId
     * @param OA_Dll_BannerInfo &$oBanner
     *
     * @return boolean
     */
    public function getBanner($sessionId, $bannerId, &$oBanner)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllBanner->getBanner($bannerId, $oBanner),
            );
        } else {
            return false;
        }
    }

    /**
     * The getBannerListByCampaignId method returns a list of banners for a campaign.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $campaignId
     * @param array &$aBannerList  Array of OA_Dll_BannerInfo classes
     *
     * @return boolean
     */
    public function getBannerListByCampaignId($sessionId, $campaignId, &$aBannerList)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllBanner->getBannerListByCampaignId(
                    $campaignId,
                    $aBannerList,
                ),
            );
        } else {
            return false;
        }
    }
}
