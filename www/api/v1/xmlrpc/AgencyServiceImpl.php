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
require_once MAX_PATH . '/www/api/v1/common/BaseServiceImpl.php';

// Agency Dll class
require_once MAX_PATH . '/lib/OA/Dll/Agency.php';

/**
 * The AgencyServiceImpl class extends the BaseServiceImpl class to enable
 * you to add, modify, delete and search the agency object.
 *
 */
class AgencyServiceImpl extends BaseServiceImpl
{
    /**
     *
     * @var OA_Dll_Agency $_dllAgency
     */
    var $_dllAgency;

    /**
     *
     * The AgencyServiceImpl method is the constructor for the AgencyServiceImpl class.
     */
    function __construct()
    {
        parent::__construct();
        $this->_dllAgency = new OA_Dll_Agency();
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
            $this->raiseError($this->_dllAgency->getLastError());
            return false;
        }
    }

    /**
     * The addAgency method creates an agency and updates the
     * agency object with the agency ID.
     *
     * @access public
     *
     * @param string $sessionId
     * @param OA_Dll_AgencyInfo &$oAgency <br />
     *          <b>Required properties:</b> agencyName<br />
     *          <b>Optional properties:</b> contactName, emailAddress, username, password, userEmail, language<br />
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
     * The modifyAgency method checks if an agency ID exists and
     * modifies the details for the agency if it exists or returns an error
     * message, as appropriate.
     *
     * @access public
     *
     * @param string $sessionId
     * @param OA_Dll_AgencyInfo &$oAgency <br />
     *          <b>Required properties:</b> agencyId<br />
     *          <b>Optional properties:</b> agencyName, contactName, emailAddress, username, password<br />
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
     * The deleteAgency method checks if an agency exists and deletes
     * the agency or returns an error message, as appropriate.
     *
     * @access public
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
     * The getAgencyDailyStatistics method returns daily statistics for an
     * agency for a specified period.
     *
     * @access public
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
                    $agencyId, $oStartDate, $oEndDate, false, $rsStatisticsData));
        } else {

            return false;
        }
    }

    /**
     * The getAgencyAdvertiserStatistics method returns advertiser statistics
     * for an agency for a specified period.
     *
     * @access public
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
                    $agencyId, $oStartDate, $oEndDate, false, $rsStatisticsData));
        } else {

            return false;
        }
    }

    /**
     * The getAgencyCampaignStatistics method returns campaign statistics for
     * an agency for a specified period.
     *
     * @access public
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
                    $agencyId, $oStartDate, $oEndDate, false, $rsStatisticsData));
        } else {

            return false;
        }
    }

    /**
     * The getAgencyBannerStatistics method returns banner statistics for
     * an agency for a specified period.
     *
     * @access public
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
                    $agencyId, $oStartDate, $oEndDate, false, $rsStatisticsData));
        } else {

            return false;
        }
    }

    /**
     * The getAgencyPublisherStatistics method returns publisher statistics for
     * an agency for a specified period.
     *
     * @access public
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
                    $agencyId, $oStartDate, $oEndDate, false, $rsStatisticsData));
        } else {

            return false;
        }
    }

    /**
     * The getAgencyZoneStatistics method returns zone statistics for
     * an agency for a specified period.
     *
     * @access public
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
                    $agencyId, $oStartDate, $oEndDate, false, $rsStatisticsData));
        } else {

            return false;
        }
    }

    /**
     * The getAgency method returns the agency details for a specified agency.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $agencyId
     * @param OA_Dll_AgencyInfo &$oAgency
     *
     * @return boolean
     */
    function getAgency($sessionId, $agencyId, &$oAgency)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAgency->getAgency($agencyId, $oAgency));
        } else {

            return false;
        }
    }

    /**
     * The getAgencyList method returns a list of agencies.
     *
     * @access public
     *
     * @param string $sessionId
     * @param array &$aAgencyList  Array of OA_Dll_AgencyInfo classes
     *
     * @return boolean
     */
    function getAgencyList($sessionId, &$aAgencyList)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllAgency->getAgencyList($aAgencyList));
        } else {

            return false;
        }
    }
}


?>
