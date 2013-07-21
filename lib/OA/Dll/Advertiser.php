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
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */

// Require the following classes:
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Dll/AdvertiserInfo.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/Advertiser.php';


/**
 * The OA_Dll_Advertiser class extends the OA_Dll class.
 *
 */

class OA_Dll_Advertiser extends OA_Dll
{
    /**
     * This method sets AdvertiserInfo from a data array.
     *
     * @access private
     *
     * @param OA_Dll_AdvertiserInfo &$oAdvertiser
     * @param array $advertiserData
     *
     * @return boolean
     */
    function _setAdvertiserDataFromArray(&$oAdvertiser, $advertiserData)
    {
        $advertiserData['advertiserName'] = $advertiserData['clientname'];
        $advertiserData['agencyName']     = $advertiserData['name'];
        $advertiserData['contactName']    = $advertiserData['contact'];
        $advertiserData['emailAddress']   = $advertiserData['email'];
        $advertiserData['agencyId']       = $advertiserData['agencyid'];
        $advertiserData['advertiserId']   = $advertiserData['clientid'];
        $advertiserData['accountId']      = $advertiserData['account_id'];

        $oAdvertiser->readDataFromArray($advertiserData);
        return  true;
    }

    /**
     * This method performs data validation for an advertiser, for example to check
     * that an email address is an email address. Where necessary, the method connects
     * to the OA_Dal to obtain information for other business validations.
     *
     * @access private
     *
     * @param OA_Dll_AdvertiserInfo &$oAdvertiser  Structure with advertiser information.
     *
     * @return boolean  Returns false if fields are not valid and true if valid.
     *
     */
    function _validate(&$oAdvertiser)
    {
        if (isset($oAdvertiser->advertiserId)) {
            // When modifying an advertiser, check correct field types are used and the advertiserID exists.
            if (!$this->checkStructureRequiredIntegerField($oAdvertiser, 'advertiserId')){
                return false;
            }

            $doAdvertiser = OA_Dal::factoryDO('clients');
            $doAdvertiser->get($oAdvertiser->advertiserId);
            $advertiserOld = $doAdvertiser->toArray();
            if (!$this->checkStructureNotRequiredStringField($oAdvertiser, 'advertiserName', 255) ||
                !$this->checkIdExistence('clients', $oAdvertiser->advertiserId)) {
                return false;
            }
        } else {
            // When adding an advertiser, check that the required field 'advertiserName' is correct.
            if (!$this->checkStructureRequiredStringField($oAdvertiser, 'advertiserName', 255)){
                return false;
            }
        }

        if (isset($oAdvertiser->emailAddress) &&
            !$this->checkEmail($oAdvertiser->emailAddress) ||
            !$this->checkStructureNotRequiredIntegerField($oAdvertiser, 'agencyId') ||
            !$this->checkStructureNotRequiredStringField($oAdvertiser, 'contactName', 255) ||
            !$this->checkStructureNotRequiredStringField($oAdvertiser, 'emailAddress', 64)
        ) {
            return false;
        }

        if (isset($oAdvertiser->comments) &&
            !$this->checkStructureNotRequiredStringField($oAdvertiser, 'comments')
        ) {
            return false;
        }
        // Check that an agencyID exists and that the user has permissions.
        if (!$this->checkAgencyPermissions($oAdvertiser->agencyId)) {
            return false;
        }

        return true;
    }

    /**
     * This method performs data validation for statistics methods(advertiserId, date).
     *
     * @access private
     *
     * @param integer  $advertiserId
     * @param date     $oStartDate
     * @param date     $oEndDate
     *
     * @return boolean
     *
     */
    function _validateForStatistics($advertiserId, $oStartDate, $oEndDate)
    {
        if (!$this->checkIdExistence('clients', $advertiserId) ||
            !$this->checkDateOrder($oStartDate, $oEndDate)) {
            return false;
        }

        return true;
    }

    /**
     * This function calls a method in the OA_Dll class to check permissions.
     *
     * @access public
     *
     * @param integer $advertiserId  The ID of the advertiser
     *
     * @return boolean  False if access is denied and true if allowed.
     */
    function checkStatisticsPermissions($advertiserId)
    {
       if (!$this->checkPermissions($this->aAllowAdvertiserAndAbovePerm,
            'clients', $advertiserId)) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * This method modifies an existing advertiser. Undefined fields do not change
     * and defined fields with a NULL value also remain unchanged.
     *
     * @access public
     *
     * @param OA_Dll_AdvertiserInfo &$oAdvertiser <br />
     *          <b>For adding</b><br />
     *          <b>Required properties:</b> advertiserName<br />
     *          <b>Optional properties:</b> agencyId, contactName, emailAddress<br />
     *
     *          <b>For modify</b><br />
     *          <b>Required properties:</b> advertiserId<br />
     *          <b>Optional properties:</b> agencyId, advertiserName, contactName, emailAddress<br />
     *
     * @return boolean  True if the operation was successful.
     *
     */
    function modify(&$oAdvertiser)
    {
        if (!$this->checkPermissions($this->aAllowAdvertiserAndAbovePerm, 'clients',
            $oAdvertiser->advertiserId))
        {
            return false;
        }

        if (empty($oAdvertiser->advertiserId)) {
            unset($oAdvertiser->advertiserId);
            $oAdvertiser->setDefaultForAdd();
        } else {
            $oAdvertiser->advertiserId = (int) $oAdvertiser->advertiserId;
        }

        $advertiserData = (array) $oAdvertiser;

        // Name
        $advertiserData['clientname']     = $oAdvertiser->advertiserName;
        // Default fields
        $advertiserData['contact']        = $oAdvertiser->contactName;
        $advertiserData['email']          = $oAdvertiser->emailAddress;

        if ($this->_validate($oAdvertiser)) {
            $doAdvertiser = OA_Dal::factoryDO('clients');
            if (!isset($advertiserData['advertiserId'])) {
                // Only set agency ID for insert
                $advertiserData['agencyid'] = $oAdvertiser->agencyId;
                $doAdvertiser->setFrom($advertiserData);
                $oAdvertiser->advertiserId = $doAdvertiser->insert();
                if ($oAdvertiser->advertiserId) {
                    // Set the account ID
                    $doAdvertiser = OA_Dal::staticGetDO('clients', $oAdvertiser->advertiserId);
                    $oAdvertiser->accountId = (int)$doAdvertiser->account_id;
                }
            } else {
                $doAdvertiser->get($advertiserData['advertiserId']);
                $doAdvertiser->setFrom($advertiserData);
                $doAdvertiser->update();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * This method deletes an existing advertiser.
     *
     * @access public
     *
     * @param integer $advertiserId  The ID of the advertiser to delete.
     *
     * @return boolean  True if the operation was successful.
     *
     */
    function delete($advertiserId)
    {
       if (!$this->checkPermissions(array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER),
            'clients', $advertiserId)) {
            return false;
        }

       if (isset($advertiserId)) {
            $doAdvertiser = OA_Dal::factoryDO('clients');
            $doAdvertiser->clientid = $advertiserId;
            $result = $doAdvertiser->delete();
        } else {
            $result = false;
        }

        if ($result) {
            return true;
        } else {
            $this->raiseError('Unknown advertiserId Error');
            return false;
        }
    }

    /**
     * This method returns AdvertiserInfo for a specified advertiser.
     *
     * @access public
     *
     * @param int $advertiserId
     * @param OA_Dll_AdvertiserInfo &$oAdvertiser
     *
     * @return boolean
     */
    function getAdvertiser($advertiserId, &$oAdvertiser)
    {
        if ($this->checkIdExistence('clients', $advertiserId)) {
            if (!$this->checkPermissions(null, 'clients', $advertiserId, null, OA_Permission::OPERATION_VIEW)) {
                return false;
            }
            $doAdvertiser = OA_Dal::factoryDO('clients');
            $doAdvertiser->get($advertiserId);
            $advertiserData = $doAdvertiser->toArray();

            $oAdvertiser = new OA_Dll_AdvertiserInfo();

            $this->_setAdvertiserDataFromArray($oAdvertiser, $advertiserData);
            return true;

        } else {

            $this->raiseError('Unknown advertiserId Error');
            return false;
        }
    }

    /**
     * This method returns a list of advertisers for a specified agency.
     *
     * @access public
     *
     * @param int $agencyId
     * @param array &$aAdvertiserList
     *
     * @return boolean
     */
    function getAdvertiserListByAgencyId($agencyId, &$aAdvertiserList)
    {
        $aAdvertiserList = array();

        if (!$this->checkIdExistence('agency', $agencyId)) {
                return false;
        }

        if (!$this->checkPermissions(null, 'agency', $agencyId)) {
            return false;
        }

        $doAdvertiser = OA_Dal::factoryDO('clients');
        $doAdvertiser->agencyid = $agencyId;
        $doAdvertiser->find();

        while ($doAdvertiser->fetch()) {
            $advertiserData = $doAdvertiser->toArray();

            $oAdvertiser = new OA_Dll_AdvertiserInfo();
            $this->_setAdvertiserDataFromArray($oAdvertiser, $advertiserData);

            $aAdvertiserList[] = $oAdvertiser;
        }
        return true;
    }

    /**
     * This method returns daily statistics for an advertiser for a specified period.
     *
     * @access public
     *
     * @param integer $advertiserId The ID of the advertiser to view the statistics for.
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
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    function getAdvertiserDailyStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($advertiserId)) {
            return false;
        }

        if ($this->_validateForStatistics($advertiserId, $oStartDate, $oEndDate)) {
            $dalAdvertiser = new OA_Dal_Statistics_Advertiser();
            $rsStatisticsData = $dalAdvertiser->getAdvertiserDailyStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ);

            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns campaign statistics for an advertiser for a specified period.
     *
     * @access public
     *
     * @param integer $advertiserId The ID of the advertiser to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>campaignID integer</b> The ID of the campaign
     *   <li><b>campaignName string (255)</b> The name of the campaign
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     *   </ul>
     *
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    function getAdvertiserCampaignStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($advertiserId)) {
            return false;
        }

        if ($this->_validateForStatistics($advertiserId, $oStartDate, $oEndDate)) {
            $dalAdvertiser = new OA_Dal_Statistics_Advertiser();
            $rsStatisticsData = $dalAdvertiser->getAdvertiserCampaignStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ);

            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns banner statistics for an advertiser for a specified period.
     *
     * @access public
     *
     * @param integer $advertiserId The ID of the advertiser to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>campaignID integer</b> The ID of the campaign
     *   <li><b>campaignName string (255)</b> The name of the campaign
     *   <li><b>bannerID integer</b> The ID of the banner
     *   <li><b>bannerName string (255)</b> The name of the banner
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     *   </ul>
     *
     * @return boolean  True if the operation was successful and false otherwise.
     *
     */
    function getAdvertiserBannerStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($advertiserId)) {
            return false;
        }

        if ($this->_validateForStatistics($advertiserId, $oStartDate, $oEndDate)) {
            $dalAdvertiser = new OA_Dal_Statistics_Advertiser();
            $rsStatisticsData = $dalAdvertiser->getAdvertiserBannerStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ);

            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns publisher statistics for an advertiser for a specified period.
     *
     * @access public
     *
     * @param integer $advertiserId The ID of the advertiser to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>publisherID integer</b> The ID of the publisher
     *   <li><b>publisherName string (255)</b> The name of the publisher
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     *   </ul>
     *
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    function getAdvertiserPublisherStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($advertiserId)) {
            return false;
        }

        if ($this->_validateForStatistics($advertiserId, $oStartDate, $oEndDate)) {
            $dalAdvertiser = new OA_Dal_Statistics_Advertiser();
            $rsStatisticsData = $dalAdvertiser->getAdvertiserPublisherStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ);

            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns zone statistics for an advertiser for a specified period.
     *
     * @access public
     *
     * @param integer $advertiserId The ID of the advertiser to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>publisherID integer</b> The ID of the publisher
     *   <li><b>publisherName string (255)</b> The name of the publisher
     *   <li><b>zoneID integer</b> The ID of the zone
     *   <li><b>zoneName string (255)</b> The name of the zone
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     *   </ul>
     *
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    function getAdvertiserZoneStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($advertiserId)) {
            return false;
        }

        if ($this->_validateForStatistics($advertiserId, $oStartDate, $oEndDate)) {
            $dalAdvertiser = new OA_Dal_Statistics_Advertiser();
            $rsStatisticsData = $dalAdvertiser->getAdvertiserZoneStatistics($advertiserId, $oStartDate, $oEndDate, $localTZ);

            return true;
        } else {
            return false;
        }
    }

}

?>
