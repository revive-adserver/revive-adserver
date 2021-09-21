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
 * @package    OpenXDll
 *
 */

// Require the following classes:
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Dll/PublisherInfo.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/Publisher.php';


/**
 * The OA_Dll_Publisher class extends the base OA_Dll class.
 *
 */

class OA_Dll_Publisher extends OA_Dll
{
    /**
     * This method sets PublisherInfo from a data array.
     *
     * @access private
     *
     * @param OA_Dll_PublisherInfo &$oPublisher
     * @param array $publisherData
     *
     * @return boolean
     */
    public function _setPublisherDataFromArray(&$oPublisher, $publisherData)
    {
        $publisherData['publisherName'] = $publisherData['name'];
        $publisherData['contactName'] = $publisherData['contact'];
        $publisherData['emailAddress'] = $publisherData['email'];
        $publisherData['website'] = $publisherData['website'];
        $publisherData['agencyId'] = $publisherData['agencyid'];
        $publisherData['publisherId'] = $publisherData['affiliateid'];
        $publisherData['accountId'] = $publisherData['account_id'];

        $oPublisher->readDataFromArray($publisherData);
        return  true;
    }

    /**
     * This method performs data validation for a publisher, for example to check
     * that an email address is an email address. Where necessary, the method connects
     * to the OA_Dal to obtain information for other business validations.
     *
     * @access private
     *
     * @param OA_Dll_PublisherInfo $oPublisher
     *
     * @return boolean
     *
     */
    public function _validate(&$oPublisher)
    {
        if (isset($oPublisher->publisherId)) {
            // When modifying a publisher, check correct field types are used and the publisherID exists.
            if (!$this->checkStructureRequiredIntegerField($oPublisher, 'publisherId')) {
                return false;
            }

            $doPublisher = OA_Dal::factoryDO('affiliates');
            $doPublisher->get($oPublisher->publisherId);
            $publisherOld = $doPublisher->toArray();
            if (!$this->checkStructureRequiredStringField($oPublisher, 'publisherName', 255) ||
                !$this->checkIdExistence('affiliates', $oPublisher->publisherId)) {
                return false;
            }
        } else {
            // When adding a publisher, check that the required field 'advertiserName' is correct.
            if (!$this->checkStructureRequiredStringField($oPublisher, 'publisherName', 255)) {
                return false;
            }
        }

        if ((isset($oPublisher->emailAddress) &&
            !$this->checkEmail($oPublisher->emailAddress)) ||
            !$this->checkStructureNotRequiredIntegerField($oPublisher, 'agencyId') ||
            !$this->checkStructureNotRequiredStringField($oPublisher, 'contactName', 255) ||
            !$this->checkStructureNotRequiredStringField($oPublisher, 'website', 255) ||
            !$this->checkStructureNotRequiredStringField($oPublisher, 'emailAddress', 64)) {
            return false;
        }

        if (isset($oPublisher->comments) &&
            !$this->checkStructureNotRequiredStringField($oPublisher, 'comments')
        ) {
            return false;
        }

        // Check that an agencyID exists and that the user has permissions.
        if (!$this->checkAgencyPermissions($oPublisher->agencyId)) {
            return false;
        }

        return true;
    }

    /**
     * This method performs data validation for statistics methods(publisherId, date).
     *
     * @access private
     *
     * @param integer  $publisherId
     * @param date     $oStartDate
     * @param date     $oEndDate
     *
     * @return boolean
     *
     */
    public function _validateForStatistics($publisherId, $oStartDate, $oEndDate)
    {
        if (!$this->checkIdExistence('affiliates', $publisherId) ||
            !$this->checkDateOrder($oStartDate, $oEndDate)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * This method modifies an existing publisher. Undefined fields do not change
     * and defined fields with a NULL value also remain unchanged.
     *
     * @access public
     *
     * @param OA_Dll_PublisherInfo &$oPublisher <br />
     *          <b>For adding</b><br />
     *          <b>Optional properties:</b> agencyId, publisherName, contactName, emailAddress, Website<br />
     *
     *          <b>For modify</b><br />
     *          <b>Required properties:</b> publisherId<br />
     *          <b>Optional properties:</b> agencyId, publisherName, contactName, emailAddress, Website<br />
     *
     * @return success boolean True if the operation was successful
     *
     */
    public function modify(&$oPublisher)
    {
        if (!$this->checkPermissions(
            $this->aAllowTraffickerAndAbovePerm,
            'affiliates',
            $oPublisher->publisherId
        )) {
            return false;
        }

        if (empty($oPublisher->publisherId)) {
            unset($oPublisher->publisherId);
            $oPublisher->setDefaultForAdd();
        } else {
            $oPublisher->publisherId = (int) $oPublisher->publisherId;

            // Capture the existing data
            /**
             * @todo This needs to be updated to use the getPublisher method, however right now
             *       I need access to properties not referenced by the DLL
             */
            $doPrevPublisher = OA_Dal::factoryDO('affiliates');
            $doPrevPublisher->get($oPublisher->publisherId);
            $publisherPrevData = $doPrevPublisher->toArray();
        }

        $publisherData = (array) $oPublisher;

        // Trim input variables
        foreach ($publisherData as $key => $value) {
            $publisherData[$key] = trim($publisherData[$key]);
        }

        // Clear the website if only the pre-filled "http://" is passed
        if (isset($publisherData['website']) && $publisherData['website'] == 'http://') {
            $publisherData['website'] = '';
        }

        // Remap fields where the PublisherInfo object does not map directly to the DataObject.
        $publisherData['name'] = $oPublisher->publisherName;
        $publisherData['contact'] = $oPublisher->contactName;
        $publisherData['email'] = $oPublisher->emailAddress;

        if ($this->_validate($oPublisher)) {
            $doPublisher = OA_Dal::factoryDO('affiliates');
            if (!isset($publisherData['publisherId'])) {
                // Only set agency ID for insert
                $publisherData['agencyid'] = $oPublisher->agencyId;
                $doPublisher->setFrom($publisherData);
                $oPublisher->publisherId = $doPublisher->insert();
                if ($oPublisher->publisherId) {
                    // Set the account ID
                    $doPublisher = OA_Dal::staticGetDO('affiliates', $oPublisher->publisherId);
                    $oPublisher->accountId = (int)$doPublisher->account_id;
                }
            } else {
                $doPublisher->get($publisherData['publisherId']);
                $doPublisher->setFrom($publisherData);
                $doPublisher->update();
            }
            return true;
        }
        return false;
    }

    /**
     * This method deletes an existing publisher.
     *
     * @access public
     *
     * @param integer $publisherId The ID of the publisher to delete
     *
     * @return boolean success - True if the operation was successful
     *
     */
    public function delete($publisherId)
    {
        if (!$this->checkPermissions(
            [OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER],
            'affiliates',
            $publisherId
        )) {
            return false;
        }

        $doPublisher = OA_Dal::factoryDO('affiliates');
        $doPublisher->affiliateid = $publisherId;
        $result = $doPublisher->delete();

        if ($result) {
            return true;
        } else {
            $this->raiseError('Unknown publisherId Error');
            return false;
        }
    }

    /**
     * This method returns PublisherInfo for a specified publisher.
     *
     * @access public
     *
     * @param int $publisherId
     * @param OA_Dll_PublisherInfo &$oPublisher
     *
     * @return boolean
     */
    public function getPublisher($publisherId, &$oPublisher)
    {
        if ($this->checkIdExistence('affiliates', $publisherId)) {
            if (!$this->checkPermissions(null, 'affiliates', $publisherId)) {
                return false;
            }
            $doPublisher = OA_Dal::factoryDO('affiliates');
            $doPublisher->get($publisherId);
            $publisherData = $doPublisher->toArray();

            $oPublisher = new OA_Dll_PublisherInfo();

            $this->_setPublisherDataFromArray($oPublisher, $publisherData);

            return true;
        } else {
            $this->raiseError('Unknown publisherId Error');
            return false;
        }
    }

    /**
     * This method returns a list of publishers for an agency.
     *
     * @access public
     *
     * @param int $agencyId
     * @param array &$aPublisherList
     *
     * @return boolean
     */
    public function getPublisherListByAgencyId($agencyId, &$aPublisherList)
    {
        $aPublisherList = [];

        if (!$this->checkIdExistence('agency', $agencyId)) {
            return false;
        }

        if (!$this->checkPermissions(null, 'agency', $agencyId)) {
            return false;
        }

        $doPublisher = OA_Dal::factoryDO('affiliates');
        $doPublisher->agencyid = $agencyId;
        $doPublisher->find();

        while ($doPublisher->fetch()) {
            $publisherData = $doPublisher->toArray();

            $oPublisher = new OA_Dll_PublisherInfo();
            $this->_setPublisherDataFromArray($oPublisher, $publisherData);

            $aPublisherList[] = $oPublisher;
        }
        return true;
    }

    /**
     * This method returns daily statistics for a publisher for a specified period.
     *
     * @access public
     *
     * @param integer $publisherId The ID of the publisher to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>day date</b> The day
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     *   </ul>
     *
     * @return boolean True if the operation was successful and false if not.
     *
     */
    public function getPublisherDailyStatistics($publisherId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkPermissions($this->aAllowTraffickerAndAbovePerm, 'affiliates', $publisherId)) {
            return false;
        }

        if ($this->_validateForStatistics($publisherId, $oStartDate, $oEndDate)) {
            $publisherDal = new OA_Dal_Statistics_Publisher();
            $rsStatisticsData = $publisherDal->getPublisherDailyStatistics(
                $publisherId,
                $oStartDate,
                $oEndDate,
                $localTZ
            );

            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns hourly statistics for a publisher for a specified period.
     *
     * @access public
     *
     * @param integer $publisherId The ID of the publisher to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>day date</b> The day
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     *   </ul>
     *
     * @return boolean True if the operation was successful and false if not.
     *
     */
    public function getPublisherHourlyStatistics($publisherId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkPermissions($this->aAllowTraffickerAndAbovePerm, 'affiliates', $publisherId)) {
            return false;
        }

        if ($this->_validateForStatistics($publisherId, $oStartDate, $oEndDate)) {
            $publisherDal = new OA_Dal_Statistics_Publisher();
            $rsStatisticsData = $publisherDal->getPublisherHourlyStatistics(
                $publisherId,
                $oStartDate,
                $oEndDate,
                $localTZ
            );

            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns zone statistics for a publisher for a specified period.
     *
     * @access public
     *
     * @param integer $publisherId The ID of the publisher to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>zoneID integer</b> The ID of the zone
     *   <li><b>zoneName string (255)</b> The name of the zone
     *   <li><b>requests integer</b> The number of requests for the zone
     *   <li><b>impressions integer</b> The number of impressions for the zone
     *   <li><b>clicks integer</b> The number of clicks for the zone
     *   <li><b>revenue decimal</b> The revenue earned for the zone
     *   </ul>
     *
     * @return boolean True if the operation was successful and false if not.
     *
     */
    public function getPublisherZoneStatistics($publisherId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkPermissions($this->aAllowTraffickerAndAbovePerm, 'affiliates', $publisherId)) {
            return false;
        }

        if ($this->_validateForStatistics($publisherId, $oStartDate, $oEndDate)) {
            $publisherDal = new OA_Dal_Statistics_Publisher();
            $rsStatisticsData = $publisherDal->getPublisherZoneStatistics(
                $publisherId,
                $oStartDate,
                $oEndDate,
                $localTZ
            );

            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns advertiser statistics for a publisher for a specified period.
     *
     * @access public
     *
     * @param integer $publisherId The ID of the publisher to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>advertiser ID integer</b> The ID of the advertiser
     *   <li><b>advertiserName string (255)</b> The name of the advertiser
     *   <li><b>requests integer</b> The number of requests for the advertiser
     *   <li><b>impressions integer</b> The number of impressions for the advertiser
     *   <li><b>clicks integer</b> The number of clicks for the advertiser
     *   <li><b>revenue decimal</b> The revenue earned for the advertiser
     *   </ul>
     *
     * @return boolean True if the operation was successful and false if not.
     *
     */

    public function getPublisherAdvertiserStatistics($publisherId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkPermissions($this->aAllowTraffickerAndAbovePerm, 'affiliates', $publisherId)) {
            return false;
        }

        if ($this->_validateForStatistics($publisherId, $oStartDate, $oEndDate)) {
            $publisherDal = new OA_Dal_Statistics_Publisher();
            $rsStatisticsData = $publisherDal->getPublisherAdvertiserStatistics(
                $publisherId,
                $oStartDate,
                $oEndDate,
                $localTZ
            );

            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns campaign statistics for a publisher for a specified period.
     *
     * @access public
     *
     * @param integer $publisherId The ID of the publisher to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>campaignID integer</b> The ID of the campaign
     *   <li><b>campaignName string (255)</b> The name of the campaign
     *   <li><b>advertiserID integer</b> The ID of the advertiser
     *   <li><b>advertiserName string</b> The name of the advertiser
     *   <li><b>requests integer</b> The number of requests for the campaign
     *   <li><b>impressions integer</b> The number of impressions for the campaign
     *   <li><b>clicks integer</b> The number of clicks for the campaign
     *   <li><b>revenue decimal</b> The revenue earned for the campaign
     *   </ul>
     *
     * @return boolean True if the operation was successful and false if not.
     *
     */
    public function getPublisherCampaignStatistics($publisherId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkPermissions($this->aAllowTraffickerAndAbovePerm, 'affiliates', $publisherId)) {
            return false;
        }

        if ($this->_validateForStatistics($publisherId, $oStartDate, $oEndDate)) {
            $publisherDal = new OA_Dal_Statistics_Publisher();
            $rsStatisticsData = $publisherDal->getPublisherCampaignStatistics(
                $publisherId,
                $oStartDate,
                $oEndDate,
                $localTZ
            );

            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns banner statistics for a publisher for a specified period.
     *
     * @access public
     *
     * @param integer $publisherId The ID of the publisher to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>bannerID integer</b> The ID of the banner
     *   <li><b>bannerName string (255)</b> The name of the banner
     *   <li><b>campaignID integer</b> The ID of the banner
     *   <li><b>campaignName string (255)</b> The name of the banner
     *   <li><b>advertiserID integer</b> The ID of the advertiser
     *   <li><b>advertiserName string</b> The name of the advertiser
     *   <li><b>requests integer</b> The number of requests for the banner
     *   <li><b>impressions integer</b> The number of impressions for the banner
     *   <li><b>clicks integer</b> The number of clicks for the banner
     *   <li><b>revenue decimal</b> The revenue earned for the banner
     *   </ul>
     *
     * @return boolean True if the operation was successful and false if not.
     *
     */
    public function getPublisherBannerStatistics($publisherId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkPermissions($this->aAllowTraffickerAndAbovePerm, 'affiliates', $publisherId)) {
            return false;
        }

        if ($this->_validateForStatistics($publisherId, $oStartDate, $oEndDate)) {
            $publisherDal = new OA_Dal_Statistics_Publisher();
            $rsStatisticsData = $publisherDal->getPublisherBannerStatistics(
                $publisherId,
                $oStartDate,
                $oEndDate,
                $localTZ
            );

            return true;
        } else {
            return false;
        }
    }
}
