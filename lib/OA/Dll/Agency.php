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
require_once MAX_PATH . '/lib/OA/Dll/AgencyInfo.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/Agency.php';
require_once MAX_PATH . '/lib/OA/Auth.php';
require_once MAX_PATH . '/lib/RV/Admin/Languages.php';


/**
 * The OA_Dll_Agency class extends the OA_Dll class.
 *
 */

class OA_Dll_Agency extends OA_Dll
{
    public const ALLOWED_STATUSES = [
        OA_ENTITY_STATUS_RUNNING,
        OA_ENTITY_STATUS_PAUSED,
        OA_ENTITY_STATUS_INACTIVE,
    ];

    /**
     * This method sets the AgencyInfo from a data array.
     *
     * @access private
     *
     * @param OA_Dll_AgencyInfo &$oAgency
     * @param array $agencyData
     *
     * @return boolean
     */
    public function _setAgencyDataFromArray(&$oAgency, $agencyData)
    {
        $agencyData['agencyId'] = $agencyData['agencyid'];
        $agencyData['agencyName'] = $agencyData['name'];
        $agencyData['contactName'] = $agencyData['contact'];
        $agencyData['emailAddress'] = $agencyData['email'];
        $agencyData['accountId'] = $agencyData['account_id'];
        $agencyData['status'] = $agencyData['status'];

        // Do not return the password from the Dll.
        unset($agencyData['password']);

        $oAgency->readDataFromArray($agencyData);
        return  true;
    }

    /**
     * This method performs data validation for an agency, for example to check
     * that an email address is an email address. Where necessary, the method connects
     * to the OA_Dal to obtain information for other business validations.
     *
     * @access private
     *
     * @param OA_Dll_AgencyInfo &$oAgency
     *
     * @return boolean  Returns false if fields are not valid and true if valid.
     *
     */
    public function _validate(&$oAgency)
    {
        if (isset($oAgency->agencyId)) {
            // When modifying an agency, check correct field types are used and the agency exists.
            $doAgency = OA_Dal::factoryDO('agency');
            $doAgency->get($oAgency->agencyId);
            $agencyOld = $doAgency->toArray();

            if (!$this->checkStructureRequiredIntegerField($oAgency, 'agencyId') ||
                !$this->checkStructureNotRequiredStringField($oAgency, 'agencyName', 255) ||
                !$this->checkIdExistence('agency', $oAgency->agencyId)) {
                return false;
            }
        } else {
            // When adding an agency, check that the required field 'agencyName' is correct.
            if (!$this->checkStructureRequiredStringField($oAgency, 'agencyName', 255)) {
                return false;
            }
        }

        if ((isset($oAgency->emailAddress) &&
            !$this->checkEmail($oAgency->emailAddress)) ||
            !$this->checkStructureNotRequiredStringField($oAgency, 'emailAddress', 64) ||
            !$this->checkStructureNotRequiredIntegerField($oAgency, 'agencyId') ||
            !$this->checkStructureNotRequiredStringField($oAgency, 'contactName', 255)) {
            return false;
        }

        if ((isset($oAgency->UserEmail) &&
            !$this->checkEmail($oAgency->UserEmail)) ||
            !$this->checkStructureNotRequiredStringField($oAgency, 'userEmail', 64)) {
            return false;
        }

        if (isset($oAgency->username) &&
            !$this->checkStructureRequiredStringField($oAgency, 'password', 64)) {
            return false;
        }

        if (isset($oAgency->language) && !$this->_validateLanguage($oAgency->language)) {
            $this->raiseError('Invalid language');
            return false;
        }

        if (isset($oAgency->status) && !$this->_validateStatus($oAgency->status)) {
            $this->raiseError('Invalid status');
            return false;
        }

        return true;
    }

    public function _validateLanguage($language)
    {
        $aLanguages = RV_Admin_Languages::getAvailableLanguages();

        return isset($aLanguages[$language]);
    }

    public function _validateStatus($status): bool
    {
        return in_array($status, self::ALLOWED_STATUSES, true);
    }

    /**
     * This method performs data validation for statistics methods(agencyId, date).
     *
     * @access private
     *
     * @param integer  $agencyId
     * @param date     $oStartDate
     * @param date     $oEndDate
     *
     * @return boolean
     *
     */
    public function _validateForStatistics($agencyId, $oStartDate, $oEndDate)
    {
        if (!$this->checkIdExistence('agency', $agencyId) ||
            !$this->checkDateOrder($oStartDate, $oEndDate)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @todo checkStatisticsPermissions($agencyId)?
     */

    /**
     * This method modifies an existing agency. Undefined fields do not change
     * and defined fields with a NULL value also remain unchanged.
     *
     * @access public
     *
     * @param OA_Dll_AgencyInfo &$oAgency <br />
     *          <b>For adding</b><br />
     *          <b>Required properties:</b> agencyName<br />
     *          <b>Optional properties:</b> contactName, emailAddress, username, password<br />
     *
     *          <b>For modify</b><br />
     *          <b>Required properties:</b> agencyId<br />
     *          <b>Optional properties:</b> agencyName, contactName, emailAddress<br />
     *
     * @return boolean  True if the operation was successful
     *
     */
    public function modify(&$oAgency)
    {
        if (!$this->checkPermissions(OA_ACCOUNT_ADMIN)) {
            return false;
        }

        $agencyData = (array) $oAgency;

        // Name
        $agencyData['name'] = $oAgency->agencyName;
        // Default fields
        $agencyData['contact'] = $oAgency->contactName;
        $agencyData['email'] = $oAgency->emailAddress;
        $agencyData['status'] = $oAgency->status ?? OA_ENTITY_STATUS_RUNNING;

        if ($this->_validate($oAgency)) {
            $doAgency = OA_Dal::factoryDO('agency');
            if (!isset($agencyData['agencyId'])) {
                $doAgency->setFrom($agencyData);
                $oAgency->agencyId = $doAgency->insert();

                if ($oAgency->agencyId) {
                    // Set the account ID
                    $doAgency = OA_Dal::staticGetDO('agency', $oAgency->agencyId);
                    $oAgency->accountId = (int)$doAgency->account_id;

                    if (!isset($oAgency->status)) {
                        // Updatre status if it was empty
                        $oAgency->status = (int)$doAgency->status;
                    }
                }

                if (isset($agencyData['username']) || isset($agencyData['userEmail'])) {
                    // Use the authentication plugin to create the user
                    $oPlugin = OA_Auth::staticGetAuthPlugin();
                    $userId = $oPlugin->getMatchingUserId($agencyData['userEmail'], $agencyData['username']);
                    $userId = $oPlugin->saveUser(
                        $userId,
                        $agencyData['username'],
                        $agencyData['password'],
                        $agencyData['contactName'],
                        $agencyData['userEmail'],
                        $agencyData['language'],
                        $oAgency->accountId
                    );
                    if ($userId) {
                        // Link the user and give permission to create new accounts
                        $aAllowedPermissions = [
                            OA_PERM_SUPER_ACCOUNT => 'This string intentionally left blank. WTF?'];
                        $aPermissions = [OA_PERM_SUPER_ACCOUNT];
                        OA_Permission::setAccountAccess($oAgency->accountId, $userId);
                        OA_Permission::storeUserAccountsPermissions(
                            $aPermissions,
                            $oAgency->accountId,
                            $userId,
                            $aAllowedPermissions
                        );
                    }
                }
            } else {
                $doAgency->get($agencyData['agencyId']);
                $doAgency->setFrom($agencyData);
                $doAgency->update();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * This method deletes an existing agency.
     *
     * @access public
     *
     * @param integer $agencyId  The ID of the agency to delete
     *
     * @return boolean  True if the operation was successful
     *
     */
    public function delete($agencyId)
    {
        if (!$this->checkPermissions(OA_ACCOUNT_ADMIN)) {
            return false;
        }

        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->agencyid = $agencyId;
        $result = $doAgency->delete();

        if ($result) {
            return true;
        } else {
            $this->raiseError('Unknown agencyId Error');
            return false;
        }
    }

    /**
     * This method returns AgencyInfo for a specified agency.
     *
     * @access public
     *
     * @param int $agencyId
     * @param OA_Dll_AgencyInfo &$oAgency
     *
     * @return boolean
     */
    public function getAgency($agencyId, &$oAgency)
    {
        if ($this->checkIdExistence('agency', $agencyId)) {
            if (!$this->checkPermissions(null, 'agency', $agencyId)) {
                return false;
            }
            $doAgency = OA_Dal::factoryDO('agency');
            $doAgency->get($agencyId);
            $agencyData = $doAgency->toArray();

            $oAgency = new OA_Dll_AgencyInfo();

            $this->_setAgencyDataFromArray($oAgency, $agencyData);
            return true;
        } else {
            $this->raiseError('Unknown agencyId Error');
            return false;
        }
    }

    /**
     * This method returns a list of agencies.
     *
     * @access public
     *
     * @param array &$aAgencyList
     *
     * @return boolean
     */
    public function getAgencyList(&$aAgencyList)
    {
        if (!$this->checkPermissions(OA_ACCOUNT_ADMIN)) {
            return false;
        }

        $aAgencyList = [];

        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->find();

        while ($doAgency->fetch()) {
            $agencyData = $doAgency->toArray();

            $oAgency = new OA_Dll_AgencyInfo();
            $this->_setAgencyDataFromArray($oAgency, $agencyData);

            $aAgencyList[] = $oAgency;
        }
        return true;
    }

    /**
     * This method returns daily statistics for an agency for a specified period.
     *
     * @access public
     *
     * @param integer $agencyId The ID of the agency to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
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
    public function getAgencyDailyStatistics($agencyId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(
            [OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER],
            'agency',
            $agencyId
        )) {
            return false;
        }

        if ($this->_validateForStatistics($agencyId, $oStartDate, $oEndDate)) {
            $dalAgency = new OA_Dal_Statistics_Agency();
            $rsStatisticsData = $dalAgency->getAgencyDailyStatistics(
                $agencyId,
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
     * This method returns hourly statistics for an agency for a specified period.
     *
     * @access public
     *
     * @param integer $agencyId The ID of the agency to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
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
    public function getAgencyHourlyStatistics($agencyId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(
            [OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER],
            'agency',
            $agencyId
        )) {
            return false;
        }

        if ($this->_validateForStatistics($agencyId, $oStartDate, $oEndDate)) {
            $dalAgency = new OA_Dal_Statistics_Agency();
            $rsStatisticsData = $dalAgency->getAgencyHourlyStatistics(
                $agencyId,
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
     * This method returns advertiser statistics for an agency for a specified period.
     *
     * @access public
     *
     * @param integer $agencyId The ID of the agency to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param array &$rsStatisticsData The data returned by the function
     * <ul>
     *   <li><b>advertiserID integer</b> The ID of the advertiser
     *   <li><b>advertiserName string (255)</b> The name of the advertiser
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     * </ul>
     *
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    public function getAgencyAdvertiserStatistics($agencyId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(
            [OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER],
            'agency',
            $agencyId
        )) {
            return false;
        }

        if ($this->_validateForStatistics($agencyId, $oStartDate, $oEndDate)) {
            $dalAgency = new OA_Dal_Statistics_Agency();
            $rsStatisticsData = $dalAgency->getAgencyAdvertiserStatistics(
                $agencyId,
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
     * This method returns campaign statistics for an agency for a specified period.
     *
     * @access public
     *
     * @param integer $agencyId The ID of the agency to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param array &$rsStatisticsData The data returned by the function
     * <ul>
     *   <li><b>advertiserID integer</b> The ID of the advertiser
     *   <li><b>advertiserName string (255)</b> The name of the advertiser
     *   <li><b>campaignID integer</b> The ID of the campaign
     *   <li><b>campaignName string (255)</b> The name of the campaign
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     * </ul>
     *
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    public function getAgencyCampaignStatistics($agencyId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(
            [OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER],
            'agency',
            $agencyId
        )) {
            return false;
        }

        if ($this->_validateForStatistics($agencyId, $oStartDate, $oEndDate)) {
            $dalAgency = new OA_Dal_Statistics_Agency();
            $rsStatisticsData = $dalAgency->getAgencyCampaignStatistics(
                $agencyId,
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
     * This method returns banner statistics for an agency for a specified period.
     *
     * @access public
     *
     * @param integer $agencyId The ID of the agency to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
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
    public function getAgencyBannerStatistics($agencyId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(
            [OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER],
            'agency',
            $agencyId
        )) {
            return false;
        }

        if ($this->_validateForStatistics($agencyId, $oStartDate, $oEndDate)) {
            $dalAgency = new OA_Dal_Statistics_Agency();
            $rsStatisticsData = $dalAgency->getAgencyBannerStatistics(
                $agencyId,
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
     * This method returns publisher statistics for an agency for a specified period.
     *
     * @access public
     *
     * @param integer $agencyId The ID of the agency to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
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
    public function getAgencyPublisherStatistics($agencyId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(
            [OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER],
            'agency',
            $agencyId
        )) {
            return false;
        }

        if ($this->_validateForStatistics($agencyId, $oStartDate, $oEndDate)) {
            $dalAgency = new OA_Dal_Statistics_Agency();
            $rsStatisticsData = $dalAgency->getAgencypublisherStatistics(
                $agencyId,
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
     * This method returns zone statistics for an agency for a specified period.
     *
     * @access public
     *
     * @param integer $agencyId The ID of the agency to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
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
    public function getAgencyZoneStatistics($agencyId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(
            [OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER],
            'agency',
            $agencyId
        )) {
            return false;
        }

        if ($this->_validateForStatistics($agencyId, $oStartDate, $oEndDate)) {
            $dalAgency = new OA_Dal_Statistics_Agency();
            $rsStatisticsData = $dalAgency->getAgencyZoneStatistics(
                $agencyId,
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
