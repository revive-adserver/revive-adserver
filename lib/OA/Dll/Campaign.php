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
require_once MAX_PATH . '/lib/OA/Dll/CampaignInfo.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/Campaign.php';


/**
 * The OA_Dll_Campaign class extends the base OA_Dll class.
 *
 */

class OA_Dll_Campaign extends OA_Dll
{
    /**
     * This method sets the CampaignInfo from a data array.
     *
     * @access private
     *
     * @param OA_Dll_CampaignInfo &$oCampaign
     * @param array $campaignData
     *
     * @return boolean
     */
    public function _setCampaignDataFromArray(&$oCampaign, $campaignData)
    {
        $campaignData['campaignId'] = $campaignData['campaignid'];
        $campaignData['campaignName'] = $campaignData['campaignname'];
        $campaignData['advertiserId'] = $campaignData['clientid'];
        $campaignData['startDate'] = $campaignData['activate_time'];
        $campaignData['endDate'] = $campaignData['expire_time'];
        $campaignData['impressions'] = $campaignData['views'];
        $campaignData['targetImpressions'] = $campaignData['target_impression'];
        $campaignData['targetClicks'] = $campaignData['target_click'];
        $campaignData['targetConversions'] = $campaignData['target_conversion'];
        $campaignData['capping'] = $campaignData['capping'];
        $campaignData['sessionCapping'] = $campaignData['session_capping'];
        $campaignData['block'] = $campaignData['block'];
        $campaignData['viewWindow'] = $campaignData['viewwindow'];
        $campaignData['clickWindow'] = $campaignData['clickwindow'];

        // Don't send revenue & revenueType if the are null values in DB
        if (!is_numeric($campaignData['revenue'])) {
            unset($campaignData['revenue']);
            unset($oCampaign->revenue);
            unset($oCampaign->revenueType);
        } else {
            $campaignData['revenueType'] = $campaignData['revenue_type'];
        }

        $oCampaign->readDataFromArray($campaignData);

        // Convert UTC timestamps to dates
        if (!empty($oCampaign->startDate)) {
            $oTz = $oCampaign->startDate->tz;
            $oCampaign->startDate->setTZByID('UTC');
            $oCampaign->startDate->convertTZ($oTz);
        }
        if (!empty($oCampaign->endDate)) {
            $oTz = $oCampaign->endDate->tz;
            $oCampaign->endDate->setTZByID('UTC');
            $oCampaign->endDate->convertTZ($oTz);
        }

        return  true;
    }

    /**
     * This method performs data validation for a campaign, for example to check
     * that an email address is an email address. Where necessary, the method connects
     * to the OA_Dal to obtain information for other business validations.
     *
     * @access private
     *
     * @param OA_Dll_CampaignInfo $oCampaign
     *
     * @return boolean
     *
     */
    public function _validate(&$oCampaign)
    {
        if (isset($oCampaign->campaignId)) {
            // When modifying a campaign, check correct field types are used and the campaignID exists.
            if (!$this->checkStructureRequiredIntegerField($oCampaign, 'campaignId') ||
                !$this->checkIdExistence('campaigns', $oCampaign->campaignId)) {
                return false;
            }

            if (!$this->checkStructureNotRequiredIntegerField($oCampaign, 'advertiserId')) {
                return false;
            }

            if (isset($oCampaign->advertiserId) &&
                !$this->checkIdExistence('clients', $oCampaign->advertiserId)) {
                return false;
            }
        } else {
            // When adding a campaign, check that the required field 'advertiserId' is correct.
            if (!$this->checkStructureRequiredIntegerField($oCampaign, 'advertiserId') ||
                !$this->checkIdExistence('clients', $oCampaign->advertiserId)) {
                return false;
            }
        }

        // If the campaign has a start date and end date, check the date order is correct.
        if (is_object($oCampaign->startDate) && is_object($oCampaign->endDate)) {
            if (!$this->checkDateOrder($oCampaign->startDate, $oCampaign->endDate)) {
                return false;
            }
        }

        // Check that the campaign priority and weight are consistent.
        if ($this->_isHighPriority($oCampaign) && $this->_hasWeight($oCampaign)) {
            $this->raiseError('High or medium priority campaigns cannot have a weight' .
                              ' that is greater than zero.');
            return false;
        } elseif (!$this->_isHighPriority($oCampaign) && $this->_hasTargets($oCampaign)) {
            $this->raiseError('Low or override priority campaigns cannot have targets.');
            return false;
        }

        if (!$this->checkStructureNotRequiredStringField($oCampaign, 'campaignName', 255) ||
            !$this->checkStructureNotRequiredIntegerField($oCampaign, 'impressions') ||
            !$this->checkStructureNotRequiredIntegerField($oCampaign, 'clicks') ||
            !$this->checkStructureNotRequiredIntegerField($oCampaign, 'priority') ||
            !$this->checkStructureNotRequiredIntegerField($oCampaign, 'weight') ||
            !$this->checkStructureNotRequiredIntegerField($oCampaign, 'targetImpressions') ||
            !$this->checkStructureNotRequiredIntegerField($oCampaign, 'targetClicks') ||
            !$this->checkStructureNotRequiredIntegerField($oCampaign, 'targetConversions') ||
            !$this->checkStructureNotRequiredDoubleField($oCampaign, 'revenue') ||
            !$this->checkStructureNotRequiredIntegerField($oCampaign, 'revenueType') ||
            !$this->checkStructureNotRequiredIntegerField($oCampaign, 'capping') ||
            !$this->checkStructureNotRequiredIntegerField($oCampaign, 'sessionCapping') ||
            !$this->checkStructureNotRequiredIntegerField($oCampaign, 'block') ||
            !$this->checkStructureNotRequiredStringField($oCampaign, 'comments') ||
            !$this->checkStructureNotRequiredIntegerField($oCampaign, 'viewWindow') ||
            !$this->checkStructureNotRequiredIntegerField($oCampaign, 'clickWindow')
            ) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * This method performs data validation for statistics methods (campaignId, date).
     *
     * @access private
     *
     * @param integer  $campaignId
     * @param date     $oStartDate
     * @param date     $oEndDate
     *
     * @return boolean
     *
     */
    public function _validateForStatistics($campaignId, $oStartDate, $oEndDate)
    {
        if (!$this->checkIdExistence('campaigns', $campaignId) ||
            !$this->checkDateOrder($oStartDate, $oEndDate)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * This function calls a method in the OA_Dll class which checks permissions.
     *
     * @access public
     *
     * @param integer $campaignId  Campaign ID
     *
     * @return boolean  False if access is denied and true if allowed.
     */
    public function checkStatisticsPermissions($campaignId)
    {
        if (!$this->checkPermissions(
            $this->aAllowAdvertiserAndAbovePerm,
            'campaigns',
            $campaignId
        )) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * This method modifies an existing campaign. Undefined fields do not change
     * and defined fields with a NULL value also remain unchanged.
     *
     * @access public
     *
     * @param OA_Dll_CampaignInfo &$oCampaign <br />
     *          <b>For adding</b><br />
     *          <b>Required properties:</b> advertiserId<br />
     *          <b>Optional properties:</b> campaignName, startDate, endDate, impressions, clicks, priority, weight<br />
     *
     *          <b>For modify</b><br />
     *          <b>Required properties:</b> campaignId<br />
     *          <b>Optional properties:</b> advertiserId, campaignName, startDate, endDate, impressions, clicks, priority, weight, viewWindow, clickWindow<br />
     *
     * @return boolean  True if the operation was successful
     *
     */
    public function modify(&$oCampaign)
    {
        if (!isset($oCampaign->campaignId)) {
            // Add
            $oCampaign->setDefaultForAdd();
            if (!$this->checkPermissions(
                [OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER],
                'clients',
                $oCampaign->advertiserId
            )) {
                return false;
            }
        } else {
            // Edit
            if (!$this->checkPermissions(
                [OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER],
                'campaigns',
                $oCampaign->campaignId
            )) {
                return false;
            }
        }

        $oStartDate = $oCampaign->startDate;
        $oEndDate = $oCampaign->endDate;
        $campaignData = (array) $oCampaign;

        $campaignData['campaignid'] = $oCampaign->campaignId;
        $campaignData['campaignname'] = $oCampaign->campaignName;
        $campaignData['clientid'] = $oCampaign->advertiserId;
        $oNow = new Date();
        if (is_object($oStartDate)) {
            $oDate = new Date($oStartDate);
            $oDate->setTZ($oNow->tz);
            $oDate->setHour(0);
            $oDate->setMinute(0);
            $oDate->setSecond(0);
            $oDate->toUTC();
            $campaignData['activate_time'] = $oDate->getDate(DATE_FORMAT_ISO);
        }
        if (is_object($oEndDate)) {
            $oDate = new Date($oEndDate);
            $oDate->setTZ($oNow->tz);
            $oDate->setHour(23);
            $oDate->setMinute(59);
            $oDate->setSecond(59);
            $oDate->toUTC();
            $campaignData['expire_time'] = $oDate->getDate(DATE_FORMAT_ISO);
        }

        $campaignData['views'] = $oCampaign->impressions;

        $campaignData['target_impression'] = $oCampaign->targetImpressions;
        $campaignData['target_click'] = $oCampaign->targetClicks;
        $campaignData['target_conversion'] = $oCampaign->targetConversions;

        $campaignData['revenue_type'] = $oCampaign->revenueType;

        $campaignData['capping'] = $oCampaign->capping > 0
                                            ? $oCampaign->capping
                                            : 0;
        $campaignData['session_capping'] = $oCampaign->sessionCapping > 0
                                            ? $oCampaign->sessionCapping
                                            : 0;
        $campaignData['block'] = $oCampaign->block > 0
                                            ? $oCampaign->block
                                            : 0;

        $campaignData['viewwindow'] = $oCampaign->viewWindow;
        $campaignData['clickwindow'] = $oCampaign->clickWindow;

        if ($this->_validate($oCampaign)) {
            $doCampaign = OA_Dal::factoryDO('campaigns');
            if (!isset($oCampaign->campaignId)) {
                $doCampaign->setFrom($campaignData);
                $oCampaign->campaignId = $doCampaign->insert();
            } else {
                $doCampaign->get($campaignData['campaignid']);
                $doCampaign->setFrom($campaignData);
                $doCampaign->update();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * This method deletes an existing campaign.
     *
     * @access public
     *
     * @param integer $campaignId  The ID of the campaign to delete
     *
     * @return boolean  True if the operation was successful
     *
     */
    public function delete($campaignId)
    {
        if (!$this->checkPermissions(
            [OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER],
            'campaigns',
            $campaignId
        )) {
            return false;
        }

        if (!$this->checkIdExistence('campaigns', $campaignId)) {
            return false;
        }

        $doCampaign = OA_Dal::factoryDO('campaigns');
        $doCampaign->campaignid = $campaignId;
        $result = $doCampaign->delete();

        if ($result) {
            return true;
        } else {
            $this->raiseError('Unknown campaignId Error');
            return false;
        }
    }

    /**
     * This method returns CampaignInfo for a specified campaign.
     *
     * @access public
     *
     * @param int $campaignId
     * @param OA_Dll_CampaignInfo &$oCampaign
     *
     * @return boolean
     */
    public function getCampaign($campaignId, &$oCampaign)
    {
        if ($this->checkIdExistence('campaigns', $campaignId)) {
            if (!$this->checkPermissions(null, 'campaigns', $campaignId)) {
                return false;
            }
            $doCampaign = OA_Dal::factoryDO('campaigns');
            $doCampaign->get($campaignId);
            $campaignData = $doCampaign->toArray();

            $oCampaign = new OA_Dll_CampaignInfo();

            $this->_setCampaignDataFromArray($oCampaign, $campaignData);
            return true;
        } else {
            $this->raiseError('Unknown campaignId Error');
            return false;
        }
    }

    /**
     * This method returns a list of campaigns for a specified advertiser.
     *
     * @access public
     *
     * @param int $advertiserId
     * @param array &$aCampaignList
     *
     * @return boolean
     */
    public function getCampaignListByAdvertiserId($advertiserId, &$aCampaignList)
    {
        $aCampaignList = [];

        if (!$this->checkIdExistence('clients', $advertiserId)) {
            return false;
        }

        if (!$this->checkPermissions(null, 'clients', $advertiserId, null, $operationAccessType = OA_Permission::OPERATION_VIEW)) {
            return false;
        }

        $doCampaign = OA_Dal::factoryDO('campaigns');
        $doCampaign->clientid = $advertiserId;
        $doCampaign->find();

        while ($doCampaign->fetch()) {
            $campaignData = $doCampaign->toArray();

            $oCampaign = new OA_Dll_CampaignInfo();
            $this->_setCampaignDataFromArray($oCampaign, $campaignData);

            $aCampaignList[] = $oCampaign;
        }
        return true;
    }

    /**
     * This method returns daily statistics for a campaign for a specified period.
     *
     * @access public
     *
     * @param integer $campaignId The ID of the campaign to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     * <ul>
     *   <li><b>day date</b>  The day
     *   <li><b>requests integer</b>  The number of requests for the day
     *   <li><b>impressions integer</b>  The number of impressions for the day
     *   <li><b>clicks integer</b>  The number of clicks for the day
     *   <li><b>revenue decimal</b>  The revenue earned for the day
     * </ul>
     *
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    public function getCampaignDailyStatistics($campaignId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($campaignId)) {
            return false;
        }

        if ($this->_validateForStatistics($campaignId, $oStartDate, $oEndDate)) {
            $dalCampaign = new OA_Dal_Statistics_Campaign();
            $rsStatisticsData = $dalCampaign->getCampaignDailyStatistics(
                $campaignId,
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
     * This method returns hourly statistics for a campaign for a specified period.
     *
     * @access public
     *
     * @param integer $campaignId The ID of the campaign to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     * <ul>
     *   <li><b>day date</b>  The day
     *   <li><b>requests integer</b>  The number of requests for the day
     *   <li><b>impressions integer</b>  The number of impressions for the day
     *   <li><b>clicks integer</b>  The number of clicks for the day
     *   <li><b>revenue decimal</b>  The revenue earned for the day
     * </ul>
     *
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    public function getCampaignHourlyStatistics($campaignId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($campaignId)) {
            return false;
        }

        if ($this->_validateForStatistics($campaignId, $oStartDate, $oEndDate)) {
            $dalCampaign = new OA_Dal_Statistics_Campaign();
            $rsStatisticsData = $dalCampaign->getCampaignHourlyStatistics(
                $campaignId,
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
     * This method returns banner statistics for a campaign for a specified period.
     *
     * @access public
     *
     * @param integer $campaignId The ID of the campaign to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     * <ul>
     *   <li><b>advertiserID integer</b> The ID of the advertiser
     *   <li><b>advertiserName string (255)</b> The name of the advertiser
     *   <li><b>campaignID integer</b> The ID of the campaign
     *   <li><b>campaignName string (255)</b> The name of the campaign
     *   <li><b>bannerID integer</b> The ID of the banner
     *   <li><b>bannerName string (255)</b> The name of the banner
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     * </ul>
     *
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    public function getCampaignBannerStatistics($campaignId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($campaignId)) {
            return false;
        }

        if ($this->_validateForStatistics($campaignId, $oStartDate, $oEndDate)) {
            $dalCampaign = new OA_Dal_Statistics_Campaign();
            $rsStatisticsData = $dalCampaign->getCampaignBannerStatistics(
                $campaignId,
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
     * This method returns publisher statistics for a campaign for a specified period.
     *
     * @access public
     *
     * @param integer $campaignId The ID of the campaign to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     * <ul>
     *   <li><b>publisherID integer</b> The ID of the publisher
     *   <li><b>publisherName string (255)</b> The name of the publisher
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     * </ul>
     *
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    public function getCampaignPublisherStatistics($campaignId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($campaignId)) {
            return false;
        }

        if ($this->_validateForStatistics($campaignId, $oStartDate, $oEndDate)) {
            $dalCampaign = new OA_Dal_Statistics_Campaign();
            $rsStatisticsData = $dalCampaign->getCampaignpublisherStatistics(
                $campaignId,
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
     * This method returns zone statistics for a campaign for a specified period.
     *
     * @access public
     *
     * @param integer $campaignId The ID of the campaign to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     * <ul>
     *   <li><b>publisherID integer</b> The ID of the publisher
     *   <li><b>publisherName string (255)</b> The name of the publisher
     *   <li><b>zoneID integer</b> The ID of the zone
     *   <li><b>zoneName string (255)</b> The name of the zone
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     * </ul>
     *
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    public function getCampaignZoneStatistics($campaignId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($campaignId)) {
            return false;
        }

        if ($this->_validateForStatistics($campaignId, $oStartDate, $oEndDate)) {
            $dalCampaign = new OA_Dal_Statistics_Campaign();
            $rsStatisticsData = $dalCampaign->getCampaignZoneStatistics(
                $campaignId,
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
     * Gets conversion statistics for a campaign for a specified period.
     *
     * @param integer $campaignId The ID of the campaign to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function each row containing
     * <ul>
     *  <li><b>campaignID integer</b> The ID of the campaign</li>
     *  <li><b>trackerID integer</b> The ID of the tracker</li>
     *  <li><b>bannerID integer</b> The ID of the banner</li>
     *  <li><b>conversionTime date</b> The time of the conversion</li>
     *  <li><b>conversionStatus integer</b> The conversion status</li>
     *  <li><b>userIp string</b> The IP address of the conversion</li>
     *  <li><b>action integer</b> The conversion event type</li>
     *  <li><b>window integer</b> The conversion window</li>
     *  <li><b>variables array</b> array of variable values, indexed by variable name</li>
      *</ul>
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    public function getCampaignConversionStatistics(
        $campaignId,
        $oStartDate,
        $oEndDate,
        $localTZ,
        &$rsStatisticsData
    ) {
        if (!$this->checkStatisticsPermissions($campaignId)) {
            return false;
        }

        if ($this->_validateForStatistics($campaignId, $oStartDate, $oEndDate)) {
            $dalCampaign = new OA_Dal_Statistics_Campaign();
            $rsStatisticsData = $dalCampaign->getCampaignConversionStatistics(
                $campaignId,
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
     * Checks if a campaign is high priority.
     * High priority is between 1 and 10.
     *
     * @param OA_Dll_CampaignInfo $oCampaign
     * @return boolean true if campaign is a high priority campaign, false otherwise.
     */
    public function _isHighPriority(&$oCampaign)
    {
        return isset($oCampaign->priority) &&
            ((1 <= $oCampaign->priority) && ($oCampaign->priority <= 10));
    }

    public function _hasWeight(&$oCampaign)
    {
        return isset($oCampaign->weight) && ($oCampaign->weight > 0);
    }

    public function _hasTargets(&$oCampaign)
    {
        return ((isset($oCampaign->targetImpressions) && $oCampaign->targetImpressions > 0) ||
            (isset($oCampaign->targetClicks) && $oCampaign->targetClicks > 0) ||
            (isset($oCampaign->targetConversions) && $oCampaign->targetConversions > 0));
    }
}
