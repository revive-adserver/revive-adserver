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

// Campaign Dll class
require_once MAX_PATH . '/lib/OA/Dll/Campaign.php';

/**
 * The CampaignServiceImpl class extends the BaseServiceImpl class to enable
 * you to add, modify, delete and search the campaign object.
 *
 */
class CampaignServiceImpl extends BaseServiceImpl
{
    /**
     *
     * @var OA_Dll_Campaign $_dllCampaign
     */
    var $_dllCampaign;

    /**
     *
     * The CampaignServiceImpl method is the constructor for the CampignServiceImpl class.
     */
    function __construct()
    {
        parent::__construct();
        $this->_dllCampaign = new OA_Dll_Campaign();
    }

    /**
     * This method checks if an action is valid and either returns a result
     * or an error, as appropriate.
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
     * The addCampaign method creates a campaign and updates the
     * campaign object with the campaign ID.
     *
     * @access public
     *
     * @param string $sessionId
     * @param OA_Dll_CampaignInfo &$oCampaign <br />
     *          <b>Required properties:</b> advertiserId<br />
     *          <b>Optional properties:</b> campaignName, startDate, endDate, impressions, clicks, priority, weight, viewWindow, clickWindow<br />
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
     * The modifyCampaign method checks if a campaign ID exists and
     * modifies the details for the campaign if it exists or returns an error
     * message, as appropriate.
     *
     * @access public
     *
     * @param string $sessionId
     * @param OA_Dll_CampaignInfo &$oCampaign <br />
     *          <b>Required properties:</b> campaignId<br />
     *          <b>Optional properties:</b> advertiserId, campaignName, startDate, endDate, impressions, clicks, priority, weight, viewWindow, clickWindow<br />
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
     * The deleteCampaign method checks if a campaign ID exists and
     * modifies the details for the campaign if it exists or returns an error
     * message, as appropriate.
     *
     * @access public
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
     * The getCampaignDailyStatistics method returns daily statistics for a
     * campaign for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $campaignId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getCampaignDailyStatistics($sessionId, $campaignId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllCampaign->getCampaignDailyStatistics(
                    $campaignId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData));
        } else {

            return false;
        }
    }

    /**
     * The getCampaignBannerStatistics method returns banner statistics for a
     * campaign for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $campaignId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getCampaignBannerStatistics($sessionId, $campaignId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllCampaign->getCampaignBannerStatistics(
                    $campaignId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData));
        } else {

            return false;
        }
    }

    /**
     * The getCampaignPublisherStatistics method returns publisher statistics
     * for a campaign for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $campaignId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getCampaignPublisherStatistics($sessionId, $campaignId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllCampaign->getCampaignPublisherStatistics(
                    $campaignId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData));
        } else {

            return false;
        }
    }

    /**
     * The getCampaignZoneStatistics method returns zone statistics for a campaign
     * for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $campaignId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    function getCampaignZoneStatistics($sessionId, $campaignId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllCampaign->getCampaignZoneStatistics(
                    $campaignId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData));
        } else {

            return false;
        }
    }

    /**
     * The getCampaign method returns the campaign details for a specified campaign.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $campaignId
     * @param OA_Dll_CampaignInfo &$oCampaign
     *
     * @return boolean
     */
    function getCampaign($sessionId, $campaignId, &$oCampaign)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllCampaign->getCampaign($campaignId, $oCampaign));
        } else {

            return false;
        }
    }

    /**
     * The getCampaignListByAdvertiserId method returns a list of campaigns for
     * a specified advertiser.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $advertiserId
     * @param array &$aCampaignList  Array of OA_Dll_CampaignInfo classes
     *
     * @return boolean
     */
    function getCampaignListByAdvertiserId($sessionId, $advertiserId, &$aCampaignList)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllCampaign->getCampaignListByAdvertiserId($advertiserId,
                                                    $aCampaignList));
        } else {

            return false;
        }
    }

    /**
     * Gets conversion statistics for a campaign for a specified period.
     *
     * @param string $sessionId
     * @param integer $campaignId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    public function getCampaignConversionStatistics(
        $sessionId, $campaignId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllCampaign->getCampaignConversionStatistics(
                    $campaignId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData));
        } else {

            return false;
        }
    }

}


?>