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
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 * A file to description Dll Advertiser class.
 *
 */

// Required classes
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Dll/AdvertiserInfo.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/Advertiser.php';


/**
 * Advertiser Dll class
 *
 */

class OA_Dll_Advertiser extends OA_Dll
{
    /**
     * Method would perform data validation (e.g. email is an email)
     * and where necessary would connect to the DAL to obtain information
     * required to perform other business validations (e.g. username must be
     * unique across all relevant tables).
     *
     * @access private
     *
     * @param OA_Dll_AdvertiserInfo &$oAdvertiser  Structure with Advertiser information.
     *
     * @return boolean  Returns false if fields is not valid and true in other case.
     *
     */
    function _validate(&$oAdvertiser)
    {
        if (isset($oAdvertiser->advertiserId)) {
            // Modify Advertiser
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
            // For add we need to check required field 'advertiserName'
            if (!$this->checkStructureRequiredStringField($oAdvertiser, 'advertiserName', 255)){
                return false;
            }
        }


        if (isset($oAdvertiser->emailAddress) &&
            !$this->checkEmail($oAdvertiser->emailAddress) ||
            !$this->checkUniqueUserName($advertiserOld['clientusername'], $oAdvertiser->username) ||
            !$this->checkStructureNotRequiredIntegerField($oAdvertiser, 'agencyId') ||
            !$this->checkStructureNotRequiredStringField($oAdvertiser, 'contactName', 255) ||
            !$this->checkStructureNotRequiredStringField($oAdvertiser, 'emailAddress', 64) ||
            !$this->checkStructureNotRequiredStringField($oAdvertiser, 'username', 64) ||
            !$this->checkStructureNotRequiredStringField($oAdvertiser, 'password', 64) ||
            !$this->validateUsernamePassword($oAdvertiser->username, $oAdvertiser->password)) {
            return false;
        }

        // Check Agency ID existance
        if (isset($oAdvertiser->agencyId) && $oAdvertiser->agencyId != 0) {
            if (!$this->checkIdExistence('agency', $oAdvertiser->agencyId)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Method would perform data validation for statistics methods(advertiserId, date).
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
     * Calls method for checking permissions from Dll class.
     *
     * @param integer $advertiserId  Advertiser ID
     *
     * @return boolean  False in access forbidden and true in other case.
     */
    function checkStatisticsPermissions($advertiserId)
    {
       if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency +
            phpAds_Client, 'clients', $advertiserId)) {

            return false;
        } else {
            return true;
        }
    }


    /**
     * This method modifies an existing advertiser.
     * All fields which are undefined (e.g. permissions) are not changed
     * from the state they were before modification.
     * Any fields defined below that are NULL are unchanged.
     *
     * @access public
     *
     * @param OA_Dll_AdvertiserInfo &$oAdvertiser
     *
     * @return boolean  True if the operation was successful
     *
     */
    function modify(&$oAdvertiser)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency +
             phpAds_Client, 'clients', $oAdvertiser->advertiserId,
             phpAds_ModifyInfo)) {

            return false;
        }
        
        if (!isset($oAdvertiser->advertiserId)) {
            $oAdvertiser->setDefaultForAdd();
        }

        $advertiserData = (array) $oAdvertiser;

        // Name
        $advertiserData['clientname']     = $oAdvertiser->advertiserName;
        // Default fields
        $advertiserData['contact']        = $oAdvertiser->contactName;
        $advertiserData['email']          = $oAdvertiser->emailAddress;
        $advertiserData['clientusername'] = $oAdvertiser->username;
        $advertiserData['clientpassword'] = $oAdvertiser->password;
        $advertiserData['agencyid'] 	  = $oAdvertiser->agencyId;

        // Password
        if (isset($advertiserData['clientpassword'])) {
            $advertiserData['clientpassword'] = md5($oAdvertiser->password);
        }

        if ($this->_validate($oAdvertiser)) {
            $doAdvertiser = OA_Dal::factoryDO('clients');
            if (!isset($advertiserData['advertiserId'])) {
                $doAdvertiser->setFrom($advertiserData);
                $oAdvertiser->advertiserId = $doAdvertiser->insert();
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
     * @return boolean  True if the operation was successful
     *
     */
    function delete($advertiserId)
    {
       if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency,
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
    * This method returns statistics for a given advertiser, broken down by day.
    *
    * @access public
    *
    * @param integer $advertiserId The ID of the advertiser to view statistics
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
    * @return boolean  True if the operation was successful and false on error.
    *
    */
    function getAdvertiserDailyStatistics($advertiserId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($advertiserId)) {
            return false;
        }

        if ($this->_validateForStatistics($advertiserId, $oStartDate, $oEndDate)) {
            $dalAdvertiser = new OA_Dal_Statistics_Advertiser();
            $rsStatisticsData = $dalAdvertiser->getAdvertiserDailyStatistics($advertiserId, $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

   /**
    * This method returns statistics for a given advertiser, broken down by campaign.
    *
    * @access public
    *
    * @param integer $advertiserId The ID of the advertiser to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
    *   <ul>
    *   <li><b>campaignID integer</b> The ID of the campaign
    *   <li><b>campaignName string (255)</b> The name of the campaign
    *   <li><b>requests integer</b> The number of requests for the day
    *   <li><b>impressions integer</b> The number of impressions for the day
    *   <li><b>clicks integer</b> The number of clicks for the day
    *   <li><b>revenue decimal</b> The revenue earned for the day
    *   </ul>
    *
    * @return boolean  True if the operation was successful and false on error.
    *
    */
    function getAdvertiserCampaignStatistics($advertiserId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($advertiserId)) {
            return false;
        }

        if ($this->_validateForStatistics($advertiserId, $oStartDate, $oEndDate)) {
            $dalAdvertiser = new OA_Dal_Statistics_Advertiser();
            $rsStatisticsData = $dalAdvertiser->getAdvertiserCampaignStatistics($advertiserId, $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

   /**
    * This method returns statistics for a given advertiser, broken down by banner.
    *
    * @access public
    *
    * @param integer $advertiserId The ID of the advertiser to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
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
    * @return boolean  True if the operation was successful and false on error.
    *
    */
    function getAdvertiserBannerStatistics($advertiserId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($advertiserId)) {
            return false;
        }

        if ($this->_validateForStatistics($advertiserId, $oStartDate, $oEndDate)) {
            $dalAdvertiser = new OA_Dal_Statistics_Advertiser();
            $rsStatisticsData = $dalAdvertiser->getAdvertiserBannerStatistics($advertiserId, $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

   /**
    * This method returns statistics for a given advertiser, broken down by publisher.
    *
    * @access public
    *
    * @param integer $advertiserId The ID of the advertiser to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
    *   <ul>
    *   <li><b>publisherID integer</b> The ID of the publisher
    *   <li><b>publisherName string (255)</b> The name of the publisher
    *   <li><b>requests integer</b> The number of requests for the day
    *   <li><b>impressions integer</b> The number of impressions for the day
    *   <li><b>clicks integer</b> The number of clicks for the day
    *   <li><b>revenue decimal</b> The revenue earned for the day
    *   </ul>
    *
    * @return boolean  True if the operation was successful and false on error.
    *
    */
    function getAdvertiserPublisherStatistics($advertiserId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($advertiserId)) {
            return false;
        }

        if ($this->_validateForStatistics($advertiserId, $oStartDate, $oEndDate)) {
            $dalAdvertiser = new OA_Dal_Statistics_Advertiser();
            $rsStatisticsData = $dalAdvertiser->getAdvertiserPublisherStatistics($advertiserId, $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

   /**
    * This method returns statistics for a given advertiser, broken down by zone.
    *
    * @access public
    *
    * @param integer $advertiserId The ID of the advertiser to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
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
    * @return boolean  True if the operation was successful and false on error.
    *
    */
    function getAdvertiserZoneStatistics($advertiserId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($advertiserId)) {
            return false;
        }

        if ($this->_validateForStatistics($advertiserId, $oStartDate, $oEndDate)) {
            $dalAdvertiser = new OA_Dal_Statistics_Advertiser();
            $rsStatisticsData = $dalAdvertiser->getAdvertiserZoneStatistics($advertiserId, $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

}

?>
