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
 * A file to description Dll Agency class.
 *
 */

// Require the XMLRPC classes
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Dll/AgencyInfo.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/Agency.php';


/**
 * Agency Dll class
 *
 */

class OA_Dll_Agency extends OA_Dll
{
    /**
     * Method would perform data validation (e.g. email is an email)
     * and where necessary would connect to the DAL to obtain information
     * required to perform other business validations (e.g. username
     * must be unique across all relevant tables).
     *
     * @access private
     *
     * @param OA_Dll_AgencyInfo &$oAgency
     *
     * @return boolean
     *
     */
    function _validate(&$oAgency)
    {
        // Get if isset old username.
        if (isset($oAgency->agencyId)) {
            // Modify Agency
            $doAgency = OA_Dal::factoryDO('agency');
            $doAgency->get($oAgency->agencyId);
            $agencyOld = $doAgency->toArray();

            if (!$this->checkStructureRequiredIntegerField($oAgency, 'agencyId') ||
                !$this->checkStructureNotRequiredStringField($oAgency, 'agencyName', 255) ||
                !$this->checkIdExistence('agency', $oAgency->agencyId)) {
                return false;
            }
        } else {
            // Add Agency
            if (!$this->checkStructureRequiredStringField($oAgency, 'agencyName', 255)) {
                return false;
            }
        }

        if ((isset($oAgency->emailAddress) &&
            !$this->checkEmail($oAgency->emailAddress)) ||
            !$this->checkStructureNotRequiredStringField($oAgency, 'emailAddress', 64) ||
            !$this->checkUniqueUserName($agencyOld['username'], $oAgency->username) ||
            !$this->checkStructureNotRequiredIntegerField($oAgency, 'agencyId') ||
            !$this->checkStructureNotRequiredStringField($oAgency, 'contactName', 255) ||
            !$this->checkStructureNotRequiredStringField($oAgency, 'username', 64) ||
            !$this->checkStructureNotRequiredStringField($oAgency, 'password', 64) ||
            !$this->validateUsernamePassword($oAgency->username, $oAgency->password)) {

            return false;
        }

        return true;
    }

    /**
     * Method would perform data validation for statistics methods(agencyId,
     * date).
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
    function _validateForStatistics($agencyId, $oStartDate, $oEndDate)
    {
        if (!$this->checkIdExistence('agency', $agencyId) ||
            !$this->checkDateOrder($oStartDate, $oEndDate)) {

            return false;
        } else {
            return true;
        }
    }

    /**
     * This method modifies an existing agency. All fields which are
     * undefined (e.g. permissions) are not changed from the state they
     * were before modification. Any fields defined below
     * that are NULL are unchanged.
     * (Add would be triggered by modify where primary ID is null)
     *
     * @access public
     *
     * @param OA_Dll_AgencyInfo &$oAgency
     *
     * @return boolean  True if the operation was successful
     *
     */
    function modify(&$oAgency)
    {
        if (!$this->checkPermissions(phpAds_Admin)) {
            return false;
        }

        $agencyData =  (array) $oAgency;

        // Name
        $agencyData['name']    = $oAgency->agencyName;
        // Default fields
        $agencyData['contact'] = $oAgency->contactName;
        $agencyData['email']   = $oAgency->emailAddress;

        // Password
        if (isset($agencyData['password'])) {
            $agencyData['password'] = md5($oAgency->password);
        }

        if ($this->_validate($oAgency)) {
            $doAgency = OA_Dal::factoryDO('agency');
            if (!isset($agencyData['agencyId'])) {
                $doAgency->setFrom($agencyData);
                $oAgency->agencyId = $doAgency->insert();
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
    function delete($agencyId)
    {
        if (!$this->checkPermissions(phpAds_Admin)) {
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
    * This method returns statistics for a given agency, broken down by day.
    *
    * @access public
    *
    * @param integer $agencyId The ID of the agency to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
    * <ul>
    *   <li><b>day date</b>  The day
    *   <li><b>requests integer</b>  The number of requests for the day
    *   <li><b>impressions integer</b>  The number of impressions for the day
    *   <li><b>clicks integer</b>  The number of clicks for the day
    *   <li><b>revenue decimal</b>  The revenue earned for the day
    * </ul>
    *
    * @return boolean  True if the operation was successful and false on error.
    *
    */
    function getAgencyDailyStatistics($agencyId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency, 'agency',
            $agencyId)) {

            return false;
        }

        if ($this->_validateForStatistics($agencyId, $oStartDate, $oEndDate)) {
            $dalAgency = new OA_Dal_Statistics_Agency;
            $rsStatisticsData = $dalAgency->getAgencyDailyStatistics($agencyId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

    /**
    * This method returns statistics for a given agency, broken down by advertiser.
    *
    * @access public
    *
    * @param integer $agencyId The ID of the agency to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
    * <ul>
    *   <li><b>advertiserID integer</b> The ID of the advertiser
    *   <li><b>advertiserName string (255)</b> The name of the advertiser
    *   <li><b>requests integer</b> The number of requests for the day
    *   <li><b>impressions integer</b> The number of impressions for the day
    *   <li><b>clicks integer</b> The number of clicks for the day
    *   <li><b>revenue decimal</b> The revenue earned for the day
    * </ul>
    *
    * @return boolean  True if the operation was successful and false on error.
    *
    */
    function getAgencyAdvertiserStatistics($agencyId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency, 'agency', $agencyId)) {
            return false;
        }

        if ($this->_validateForStatistics($agencyId, $oStartDate, $oEndDate)) {
            $dalAgency = new OA_Dal_Statistics_Agency;
            $rsStatisticsData = $dalAgency->getAgencyAdvertiserStatistics($agencyId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

    /**
    * This method returns statistics for a given agency, broken down by campaign.
    *
    * @access public
    *
    * @param integer $agencyId The ID of the agency to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
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
    * @return boolean  True if the operation was successful and false on error.
    *
    */
    function getAgencyCampaignStatistics($agencyId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency, 'agency', $agencyId)) {
            return false;
        }

        if ($this->_validateForStatistics($agencyId, $oStartDate, $oEndDate)) {
            $dalAgency = new OA_Dal_Statistics_Agency;
            $rsStatisticsData = $dalAgency->getAgencyCampaignStatistics($agencyId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

    /**
    * This method returns statistics for a given agency, broken down by banner.
    *
    * @access public
    *
    * @param integer $agencyId The ID of the agency to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
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
    * @return boolean  True if the operation was successful and false on error.
    *
    */
    function getAgencyBannerStatistics($agencyId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency, 'agency', $agencyId)) {
            return false;
        }

        if ($this->_validateForStatistics($agencyId, $oStartDate, $oEndDate)) {
            $dalAgency = new OA_Dal_Statistics_Agency;
            $rsStatisticsData = $dalAgency->getAgencyBannerStatistics($agencyId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

    /**
    * This method returns statistics for a given agency, broken down by publisher.
    *
    * @access public
    *
    * @param integer $agencyId The ID of the agency to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
    * <ul>
    *   <li><b>publisherID integer</b> The ID of the publisher
    *   <li><b>publisherName string (255)</b> The name of the publisher
    *   <li><b>requests integer</b> The number of requests for the day
    *   <li><b>impressions integer</b> The number of impressions for the day
    *   <li><b>clicks integer</b> The number of clicks for the day
    *   <li><b>revenue decimal</b> The revenue earned for the day
    * </ul>
    *
    * @return boolean  True if the operation was successful and false on error.
    *
    */
    function getAgencyPublisherStatistics($agencyId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency, 'agency', $agencyId)) {
            return false;
        }

        if ($this->_validateForStatistics($agencyId, $oStartDate, $oEndDate)) {
            $dalAgency = new OA_Dal_Statistics_Agency;
            $rsStatisticsData = $dalAgency->getAgencypublisherStatistics($agencyId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }



    }

    /**
    * This method returns statistics for a given agency, broken down by zone.
    *
    * @access public
    *
    * @param integer $agencyId The ID of the agency to view statistics
    * @param date $oStartDate The date from which to get statistics (inclusive)
    * @param date $oEndDate The date to which to get statistics (inclusive)
    * @param array &$rsStatisticsData Parameter for returned data from function
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
    * @return boolean  True if the operation was successful and false on error.
    *
    */
    function getAgencyZoneStatistics($agencyId, $oStartDate, $oEndDate, &$rsStatisticsData)
    {
        if (!$this->checkPermissions(phpAds_Admin + phpAds_Agency, 'agency', $agencyId)) {
            return false;
        }

        if ($this->_validateForStatistics($agencyId, $oStartDate, $oEndDate)) {
            $dalAgency = new OA_Dal_Statistics_Agency;
            $rsStatisticsData = $dalAgency->getAgencyZoneStatistics($agencyId,
                $oStartDate, $oEndDate);

            return true;
        } else {
            return false;
        }
    }

}

?>
