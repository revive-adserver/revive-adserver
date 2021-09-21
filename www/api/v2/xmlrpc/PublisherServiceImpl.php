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

// Publisher Dll class
require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';

/**
 * The PublisherServiceImpl class extends the BaseServiceImpl class to enable
 * you to add, modify, delete and search the publisher object.
 *
 */
class PublisherServiceImpl extends BaseServiceImpl
{
    /**
     *
     * @var OA_Dll_Publisher $_dllPublisher
     */
    public $_dllPublisher;

    /**
     *
     * The PublisherServiceImpl method is the constructor for the PublisherServiceImpl class.
     */
    public function __construct()
    {
        parent::__construct();
        $this->_dllPublisher = new OA_Dll_Publisher();
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
            $this->raiseError($this->_dllPublisher->getLastError());
            return false;
        }
    }

    /**
     * The addPublisher method creates a publisher and updates the
     * publisher object with the publisher ID.
     *
     * @access public
     *
     * @param string $sessionId
     * @param OA_Dll_PublisherInfo &$oPublisher <br />
     *          <b>Optional properties:</b> agencyId, publisherName, contactName, emailAddress, username, password<br />
     *
     * @return boolean
     */
    public function addPublisher($sessionId, &$oPublisher)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllPublisher->modify($oPublisher));
        } else {
            return false;
        }
    }

    /**
     * The modifyPublisher method checks if a publisher ID exists and
     * modifies the details for the publisher if it exists or returns an error
     * message, as appropriate.
     *
     * @access public
     *
     * @param string $sessionId
     * @param OA_Dll_PublisherInfo &$oPublisher <br />
     *          <b>Required properties:</b> publisherId<br />
     *          <b>Optional properties:</b> agencyId, publisherName, contactName, emailAddress, username, password<br />
     *
     * @return boolean
     */
    public function modifyPublisher($sessionId, &$oPublisher)
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
     * The deletePublisher method checks if a publisher exists and deletes
     * the publisher or returns an error message, as appropriate.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $publisherId
     *
     * @return boolean
     */
    public function deletePublisher($sessionId, $publisherId)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllPublisher->delete($publisherId));
        } else {
            return false;
        }
    }

    /**
     * The getPublisherDailyStatistics method returns daily statistics for a
     * publisher for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $publisherId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param array &$aData  return data
     *
     * @return boolean
     */
    public function getPublisherDailyStatistics($sessionId, $publisherId, $oStartDate, $oEndDate, $localTZ, &$aData)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllPublisher->getPublisherDailyStatistics(
                    $publisherId,
                    $oStartDate,
                    $oEndDate,
                    $localTZ,
                    $aData
                )
            );
        } else {
            return false;
        }
    }

    /**
     * The getPublisherHourlyStatistics method returns hourly statistics for a
     * publisher for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $publisherId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param array &$aData  return data
     *
     * @return boolean
     */
    public function getPublisherHourlyStatistics($sessionId, $publisherId, $oStartDate, $oEndDate, $localTZ, &$aData)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllPublisher->getPublisherHourlyStatistics(
                    $publisherId,
                    $oStartDate,
                    $oEndDate,
                    $localTZ,
                    $aData
                )
            );
        } else {
            return false;
        }
    }

    /**
     * The getPublisherZoneStatistics method returns zone statistics for a
     * publisher for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $publisherId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    public function getPublisherZoneStatistics($sessionId, $publisherId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllPublisher->getPublisherZoneStatistics(
                    $publisherId,
                    $oStartDate,
                    $oEndDate,
                    $localTZ,
                    $rsStatisticsData
                )
            );
        } else {
            return false;
        }
    }

    /**
     * The getPublisherAdvertiserStatistics method returns advertiser statistics
     * for a publisher for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $publisherId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    public function getPublisherAdvertiserStatistics($sessionId, $publisherId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllPublisher->getPublisherAdvertiserStatistics(
                    $publisherId,
                    $oStartDate,
                    $oEndDate,
                    $localTZ,
                    $rsStatisticsData
                )
            );
        } else {
            return false;
        }
    }

    /**
     * The getPublisherCampaignStatistics method returns campaign statistics for
     * a publisher for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $publisherId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    public function getPublisherCampaignStatistics($sessionId, $publisherId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllPublisher->getPublisherCampaignStatistics(
                    $publisherId,
                    $oStartDate,
                    $oEndDate,
                    $localTZ,
                    $rsStatisticsData
                )
            );
        } else {
            return false;
        }
    }

    /**
     * The getPublisherBannerStatistics method returns banner statistics for a
     * publisher for a specified period.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $publisherId
     * @param date $oStartDate
     * @param date $oEndDate
     * @param bool $localTZ
     * @param recordSet &$rsStatisticsData  return data
     *
     * @return boolean
     */
    public function getPublisherBannerStatistics($sessionId, $publisherId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllPublisher->getPublisherBannerStatistics(
                    $publisherId,
                    $oStartDate,
                    $oEndDate,
                    $localTZ,
                    $rsStatisticsData
                )
            );
        } else {
            return false;
        }
    }

    /**
     * The getPublisher method returns the details of a specified publisher.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $publisherId
     * @param OA_Dll_PublisherInfo &$oPublisher
     *
     * @return boolean
     */
    public function getPublisher($sessionId, $publisherId, &$oPublisher)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllPublisher->getPublisher($publisherId, $oPublisher)
            );
        } else {
            return false;
        }
    }

    /**
     * The getPublisherListByAgencyId method returns a list of publishers for
     * a specified agency.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $agencyId
     * @param array &$aPublisherList  Array of OA_Dll_PublisherInfo classes
     *
     * @return boolean
     */
    public function getPublisherListByAgencyId($sessionId, $agencyId, &$aPublisherList)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllPublisher->getPublisherListByAgencyId(
                    $agencyId,
                    $aPublisherList
                )
            );
        } else {
            return false;
        }
    }
}
