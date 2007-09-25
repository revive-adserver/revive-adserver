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
 * @package    OpenadsDll
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 * A file to description Dll Publisher class.
 *
 */

// Require the XMLRPC classes
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Dll/PublisherInfo.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/Publisher.php';


/**
 * Publisher Dll class
 *
 */

class OA_Dll_Publisher extends OA_Dll
{
    /**
     * Init publisher info from data array
     *
     * @access private
     *
     * @param OA_Dll_PublisherInfo &$oPublisher
     * @param array $publisherData
     *
     * @return boolean
     */
    function _setPublisherDataFromArray(&$oPublisher, $publisherData)
    {
        $publisherData['publisherName']  = $publisherData['name'];
        $publisherData['contactName']    = $publisherData['contact'];
        $publisherData['emailAddress']   = $publisherData['email'];
        $publisherData['username']       = $publisherData['username'];
        $publisherData['password']       = $publisherData['password'];
        $publisherData['agencyId']       = $publisherData['agencyid'];
        $publisherData['publisherId']    = $publisherData['affiliateid'];

        // Do not return password from Dll
        unset($publisherData['password']);

        $oPublisher->readDataFromArray($publisherData);
        return  true;
    }

    /**
     * method would perform data validation (e.g. email is an email)
     * and where necessary would connect to the DAL to obtain information
     * required to perform other business validations (e.g.
     *      username must be unique across all relevant tables)
     *
     * @param OA_Dll_PublisherInfo $oPublisher
     *
     * @return boolean
     *
     */
    function _validate(&$oPublisher)
    {
        // Get if isset old username.
        if (isset($oPublisher->publisherId)) {
            // Modify Publisher
            if (!$this->checkStructureRequiredIntegerField($oPublisher, 'publisherId')) {
                return false;
            }

            $doPublisher = OA_Dal::factoryDO('affiliates');
            $doPublisher->get($oPublisher->publisherId);
            $publisherOld = $doPublisher->toArray();

            if (!$this->checkIdExistence('affiliates', $oPublisher->publisherId)) {
                return false;
            }
        } else {
            // Add Publisher
            if (!$this->checkStructureNotRequiredIntegerField($oPublisher, 'publisherId')) {
                return false;
            }
        }

        if ((isset($oPublisher->emailAddress) &&
            !$this->checkEmail($oPublisher->emailAddress)) ||
            !$this->checkUniqueUserName($publisherOld['username'], $oPublisher->username) ||
            !$this->checkStructureNotRequiredIntegerField($oPublisher, 'agencyId') ||
            !$this->checkStructureNotRequiredStringField($oPublisher, 'publisherName', 255) ||
            !$this->checkStructureNotRequiredStringField($oPublisher, 'contactName',255) ||
            !$this->checkStructureNotRequiredStringField($oPublisher, 'username',64) ||
            !$this->checkStructureNotRequiredStringField($oPublisher, 'password',64) ||
            !$this->validateUsernamePassword($oPublisher->username, $oPublisher->password)) {

            return false;
        }

        if (isset($oPublisher->agencyId) && $oPublisher->agencyId != 0) {
            if (!$this->checkIdExistence('agency', $oPublisher->agencyId)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Method would perform data validation for statistics
     * methods(publisherId, date).
     *
     * @param integer  $publisherId
     * @param date     $oStartDate
     * @param date     $oEndDate
     *
     * @return boolean
     *
     */
    function _validateForStatistics($publisherId, $oStartDate, $oEndDate)
    {
        if (!$this->checkIdExistence('affiliates', $publisherId) ||
            !$this->checkDateOrder($oStartDate, $oEndDate)) {

            return false;
        } else {
            return true;
        }
    }

    /**
     * This method modifies an existing publisher. All fields which are
     * undefined (e.g. permissions) are not changed from the state they
     * were before modification. Any fields defined below
     * that are NULL are unchanged.
     * (Add would be triggered by modify where primary ID is null)
     *
     * @param OA_Dll_PublisherInfo $oPublisher
     *
     * @return success boolean True if the operation was successful
     *
     */
    function modify(&$oPublisher)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency +
             phpAds_Affiliate, 'affiliates', $oPublisher->publisherId,
             phpAds_ModifyInfo)) {

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

        $publisherData =  (array) $oPublisher;

        // Trim input variables
        foreach ($publisherData as $key => $value) {
            $publisherData[$key] = trim($publisherData[$key]);
        }

        // Clear the website if only the pre-filled "http://" is passed
        if (isset($publisherData['website']) && $publisherData['website'] == 'http://') {
            $publisherData['website'] = '';
        }

        // Sum the permissions values into a bitwise value
        if (isset($oPublisher->permissions) && is_array($oPublisher->permissions)) {
            $permissions = 0;
            for ($i=0;$i<sizeof($oPublisher->permissions);$i++) {
                $permissions += $oPublisher->permissions[$i];
            }
            $publisherData['permissions'] = $permissions;
        }

        // Remap fields where the PublisherInfo Object do not map directly to the DataObject
        $publisherData['name']      = $oPublisher->publisherName;
        $publisherData['contact']   = $oPublisher->contactName;
        $publisherData['email'] 	= $oPublisher->emailAddress;
        $publisherData['agencyid']  = $oPublisher->agencyId;
        $publisherData['oac_category_id'] = $oPublisher->oacCategoryId;
        $publisherData['oac_language_id'] = $oPublisher->oacLanguageId;
        $publisherData['oac_country_code'] = $oPublisher->oacCountryCode;

        if (isset($publisherData['password']) && ($publisherData['password'] != '********')) {
            $publisherData['password'] = md5($oPublisher->password);
        } else {
            // Starred password passed in, leave as-is
            unset($publisherData['password']);
        }
        if (empty($publisherData['username'])) {
            $publisherData['username'] = $oPublisher->username = null;
            $publisherData['password'] = $oPublisher->password = null;
        }

        if ($this->_validate($oPublisher)) {
            $doPublisher = OA_Dal::factoryDO('affiliates');
            if (!isset($publisherData['publisherId'])) {
                $doPublisher->setFrom($publisherData);
                $oPublisher->publisherId = $doPublisher->insert();
            } else {
                $doPublisher->get($publisherData['publisherId']);
                $doPublisher->setFrom($publisherData);
                $doPublisher->update();
            }
            // Trigger OAC call if adnetworks was enabled or OAC values were changed
            if ($oPublisher->adNetworks) {
                // Initialise Ad  Networks
                $oAdNetworks = new OA_Central_AdNetworks();

                $aRpcPublisher = array(
                array(
                        'id'       => $oPublisher->publisherId,
                        'url'      => $oPublisher->website,
                        'country'  => $oPublisher->oacCountryCode,
                        'language' => $oPublisher->oacLanguageId,
                        'category' => $oPublisher->oacCategoryId,
                    )
                );

                $result = $oAdNetworks->subscribeWebsites($aRpcPublisher);

                if (PEAR::isError($result)) {
                    $aError = array(
                       'id' => isset($pubid) ? $pubid : 0,
                       'message' => $result->getMessage()
                    );
                    if ($result->getCode() == 802) {
                        $captchaErrorFormId = $formId;
                        $aError['message'] = '';
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * This method deletes an existing publisher.
     *
     * @param integer $publisherId The ID of the publisher to delete
     *
     * @return boolean success - True if the operation was successful
     *
     */
    function delete($publisherId)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency,
             'affiliates', $publisherId)) {

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
     * Returns publisher information by id
     *
     * @access public
     *
     * @param int $publisherId
     * @param OA_Dll_PublisherInfo &$oPublisher
     *
     * @return boolean
     */
    function getPublisher($publisherId, &$oPublisher)
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
     * Returns list of publisher by agency id
     *
     * @access public
     *
     * @param int $agencyId
     * @param array &$aPublisherList
     *
     * @return boolean
     */
    function getPublisherListByAgencyId($agencyId, &$aPublisherList)
    {
        $aPublisherList = array();

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
    * This method returns statistics for a given publisher, broken down by day.
    *
    * @param integer $publisherId The ID of the publisher to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
    *   <ul>
    *   <li><b>day date</b> The day
    *   <li><b>requests integer</b> The number of requests for the day
    *   <li><b>impressions integer</b> The number of impressions for the day
    *   <li><b>clicks integer</b> The number of clicks for the day
    *   <li><b>revenue decimal</b> The revenue earned for the day
    *   </ul>
    *
    * @return boolean False if the is error
    *
    */
    function getPublisherDailyStatistics($publisherId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency +
            phpAds_Affiliate, 'affiliates', $publisherId)) {

            return false;
        }

        if ($this->_validateForStatistics($publisherId, $oStartDate, $oEndDate)) {
            $publisherDal = new OA_Dal_Statistics_Publisher;
            $rsStatisticsData = $publisherDal->getPublisherDailyStatistics($publisherId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

    /**
    * This method returns statistics for a given publisher, broken down by zone.
    *
    * @param integer $publisherId The ID of the publisher to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
    *   <ul>
    *   <li><b>zoneID integer</b> The ID of the zone
    *   <li><b>zoneName string (255)</b> The name of the zone
    *   <li><b>requests integer</b> The number of requests for the zone
    *   <li><b>impressions integer</b> The number of impressions for the zone
    *   <li><b>clicks integer</b> The number of clicks for the zone
    *   <li><b>revenue decimal</b> The revenue earned for the zone
    *   </ul>
    *
    * @return boolean False if the is error
    *
    */
    function getPublisherZoneStatistics($publisherId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency +
            phpAds_Affiliate, 'affiliates', $publisherId)) {

            return false;
        }

        if ($this->_validateForStatistics($publisherId, $oStartDate, $oEndDate)) {
            $publisherDal = new OA_Dal_Statistics_Publisher;
            $rsStatisticsData = $publisherDal->getPublisherZoneStatistics($publisherId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

    /**
    * This method returns statistics for a given publisher,
    * broken down by advertiser.
    *
    * @param integer $publisherId The ID of the publisher to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
    *   <ul>
    *   <li><b>advertiser ID integer</b> The ID of the advertiser
    *   <li><b>advertiserName string (255)</b> The name of the advertiser
    *   <li><b>requests integer</b> The number of requests for the advertiser
    *   <li><b>impressions integer</b> The number of impressions for the advertiser
    *   <li><b>clicks integer</b> The number of clicks for the advertiser
    *   <li><b>revenue decimal</b> The revenue earned for the advertiser
    *   </ul>
    *
    * @return boolean False if the is error
    *
    */

    function getPublisherAdvertiserStatistics($publisherId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency +
            phpAds_Affiliate, 'affiliates', $publisherId)) {

            return false;
        }

        if ($this->_validateForStatistics($publisherId, $oStartDate, $oEndDate)) {
            $publisherDal = new OA_Dal_Statistics_Publisher;
            $rsStatisticsData = $publisherDal->getPublisherAdvertiserStatistics($publisherId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

    /**
    * This method returns statistics for a given publisher, broken down by campaign.
    *
    * @param integer $publisherId The ID of the publisher to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
    *   <ul>
    *   <li><b>campaignID integer</b> The ID of the campaign
    *   <li><b>campaignName string (255)</b> The name of the campaign
    *   <li><b>advertiserID integer</b> The ID advertiser
    *   <li><b>advertiserName string</b> The name advertiser
    *   <li><b>requests integer</b> The number of requests for the campaign
    *   <li><b>impressions integer</b> The number of impressions for the campaign
    *   <li><b>clicks integer</b> The number of clicks for the campaign
    *   <li><b>revenue decimal</b> The revenue earned for the campaign
    *   </ul>
    *
    * @return boolean False if the is error
    *
    */
    function getPublisherCampaignStatistics($publisherId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency +
            phpAds_Affiliate, 'affiliates', $publisherId)) {

            return false;
        }

        if ($this->_validateForStatistics($publisherId, $oStartDate, $oEndDate)) {
            $publisherDal = new OA_Dal_Statistics_Publisher;
            $rsStatisticsData = $publisherDal->getPublisherCampaignStatistics($publisherId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

    /**
    * This method returns statistics for a given publisher, broken down by banner.
    *
    * @param integer $publisherId The ID of the publisher to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
    *   <ul>
    *   <li><b>bannerID integer</b> The ID of the banner
    *   <li><b>bannerName string (255)</b> The name of the banner
    *   <li><b>campaignID integer</b> The ID of the banner
    *   <li><b>campaignName string (255)</b> The name of the banner
    *   <li><b>advertiserID integer</b> The ID advertiser
    *   <li><b>advertiserName string</b> The name advertiser
    *   <li><b>requests integer</b> The number of requests for the banner
    *   <li><b>impressions integer</b> The number of impressions for the banner
    *   <li><b>clicks integer</b> The number of clicks for the banner
    *   <li><b>revenue decimal</b> The revenue earned for the banner
    *   </ul>
    *
    * @return boolean False if the is error
    *
    */
    function getPublisherBannerStatistics($publisherId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency +
            phpAds_Affiliate, 'affiliates', $publisherId)) {

            return false;
        }

        if ($this->_validateForStatistics($publisherId, $oStartDate, $oEndDate)) {
            $publisherDal = new OA_Dal_Statistics_Publisher;
            $rsStatisticsData = $publisherDal->getPublisherBannerStatistics($publisherId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

}

?>
