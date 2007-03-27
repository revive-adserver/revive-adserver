<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id$
*/

require_once MAX_PATH . '/lib/max/Dal/Entities.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer/Task.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/Channel/Limitations.php';
require_once 'Date.php';

/**
 * A class to perform summarisation of the number of requests, impressions, and/or
 * clicks that would have been valid for the channels in the system.
 *
 * @package    MaxMaintenance
 * @subpackage Forecasting
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */
class MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels extends MAX_Maintenance_Forecasting_AdServer_Task
{

    /**
     * A local variable for storing an instance of the MAX_Dal_Entities class.
     *
     * @var MAX_Dal_Entities
     */
    var $oDalEntities;

    /**
     * A local variable for storing an instance of the OA_Dal_Maintenance_Forecasting class.
     *
     * @var OA_Dal_Maintenance_Forecasting
     */
    var $oDalMaintenanceForecasting;

    /**
     * A local variable for storing an instance of the
     * MAX_Maintenance_Forecasting_Channel_Limitations class.
     *
     * @var MAX_Maintenance_Forecasting_Channel_Limitations
     */
    var $oChannelLimitations;

    /**
     * The constructor method.
     */
    function MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels()
    {
        parent::MAX_Maintenance_Forecasting_AdServer_Task();
        $this->oDalEntities = &$this->_getEntitiesDal();
        $this->oDalMaintenanceForecasting = &$this->_getMaintenanceForecastingDal();
        $this->oChannelLimitations = &$this->_getChannelLimitation();
    }

    /**
     * A private method to create/register/return the MAX_Dal_Entities class.
     *
     * @access private
     * @return MAX_Dal_Entities
     */
    function &_getEntitiesDal()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('MAX_Dal_Entities');
        if (!$oDal) {
            $oDal = new MAX_Dal_Entities();
            $oServiceLocator->register('MAX_Dal_Entities', $oDal);
        }
        return $oDal;
    }

    /**
     * A private method to create/register/return the OA_Dal_Maintenance_Forecasting class.
     *
     * @access private
     * @return OA_Dal_Maintenance_Forecasting
     */
    function &_getMaintenanceForecastingDal()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('OA_Dal_Maintenance_Forecasting');
        if (!$oDal) {
            $oDal = new OA_Dal_Maintenance_Forecasting();
            $oServiceLocator->register('OA_Dal_Maintenance_Forecasting', $oDal);
        }
        return $oDal;
    }

    /**
     * A private method to return an instance of the
     * MAX_Maintenance_Forecasting_Channel_Limitations class.
     *
     * @access private
     * @return MAX_Maintenance_Forecasting_Channel_Limitations
     */
    function &_getChannelLimitation()
    {
        return new MAX_Maintenance_Forecasting_Channel_Limitations();
    }

    /**
     * The implementation of the MAX_Core_Task::run() method that performs
     * the task of this class.
     */
    function run()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Is an update required?
        if (!$this->oController->update) {
            return;
        }
        // Prepare the start date
        $oStartDate = new Date();
        $oStartDate->copy($this->oController->oLastUpdateDate);
        $oStartDate->addSeconds(1);
        // Is more than one day to be summarised?
        $oLastUpdateDate = new Date();
        $oLastUpdateDate->copy($this->oController->oLastUpdateDate);
        $oUpdateToDate = new Date();
        $oUpdateToDate->copy($this->oController->oUpdateToDate);
        $oSpan = new Date_Span();
        $oSpan->setFromDateDiff($oLastUpdateDate, $oUpdateToDate);
        if ($oSpan->toSeconds() > SECONDS_PER_DAY) {
            // Iteratively summarise channels for each day
            $oEndDate = new Date();
            $oEndDate->copy($oStartDate);
            $oEndDate->addSeconds(SECONDS_PER_DAY - 1);
            while (!$oEndDate->after($this->oController->oUpdateToDate)) {
                $message = 'Summarising channels for the day ' . $oStartDate->format('%Y-%m-%d %H:%M:%S') .
                           ' to ' . $oEndDate->format('%Y-%m-%d %H:%M:%S');
                MAX::debug($message, PEAR_LOG_DEBUG);
                $this->_summarise($oStartDate, $oEndDate);
                $oStartDate->addSeconds(SECONDS_PER_DAY);
                $oEndDate->addSeconds(SECONDS_PER_DAY);
            }
        } else {
            // Summarise channels for the single day
            $message = 'Summarising channels for the day ' . $oStartDate->format('%Y-%m-%d %H:%M:%S') .
                       ' to ' . $this->oController->oUpdateToDate->format('%Y-%m-%d %H:%M:%S');
            MAX::debug($message, PEAR_LOG_DEBUG);
            $this->_summarise($oStartDate, $this->oController->oUpdateToDate);

        }
    }

    /**
     * A private method to iterate over all the channels owned by the admin user as well
     * as channels owned by all agency users, and connect them with all of the zones that
     * are marked to be channel forecast in publishers owned by either the admin user or
     * all agencies, if it is an admin channel, or owned by the agency, if it is an agency
     * channel....
     *
     * owned those agencies, and then call the
     * MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels::_summarizeRawDataByChannel()
     * method to go on and summarise the impressions for each channel/zone pair.
     *
     * @access private
     * @param Date $oStartDate The start of the day to summarise.
     * @param Date $oEndDate The end of the day to summarise.
     */
    function _summarise($oStartDate, $oEndDate)
    {
        // Get all channels owned by the admin user
        $aAdminChannelIds = $this->oDalEntities->getAllActiveChannelIdsByAgencyId(0);
        if (PEAR::isError($aAdminChannelIds)) {
            $message = '  Error getting admin active channels.';
            MAX::debug($message, PEAR_LOG_ERR);
            return;
        }
        if (empty($aAdminChannelIds)) {
            $aAdminChannelIds = array();
        }
        // Get all publishers owned by the admin user
        $aAdminPublisherIds = $this->oDalEntities->getAllPublisherIdsByAgencyId(0);
        if (PEAR::isError($aAdminPublisherIds)) {
            $message = '  Error getting admin publishers.';
            MAX::debug($message, PEAR_LOG_ERR);
            return;
        }
        if (!empty($aAdminPublisherIds)) {
            // For each publisher owned directly by the admin user...
            foreach ($aAdminPublisherIds as $publisherId) {
                // Get any channels owned by the publisher
                $aPublisherChannelIds = $this->oDalEntities->getAllActiveChannelIdsByAgencyPublisherId(0, $publisherId);
                if (PEAR::isError($aPublisherChannelIds)) {
                    $message = '  Error getting admin/publisher ID ' . $publisherId . ' active channels.';
                    MAX::debug($message, PEAR_LOG_ERR);
                    return;
                }
                // Join the admin and publisher channels
                $aAllChannelIds = $aAdminChannelIds;
                if (!empty($aPublisherChannelIds)) {
                    foreach($aPublisherChannelIds as $channelId) {
                        if (!in_array($channelId, $aAllChannelIds)) {
                            $aAllChannelIds[] = $channelId;
                        }
                    }
                    sort($aAllChannelIds);
                } else if (empty($aAllChannelIds)) {
                    // There are no channels defined for this admin/publisher,
                    // pair, so move carry on with the next publisher
                    continue;
                }
                // Get all the "channel forecast" zones owned by the publisher
                $aPublisherZoneIds = $this->oDalEntities->getAllChannelForecastZonesIdsByPublisherId($publisherId);
                if (PEAR::isError($aPublisherZoneIds)) {
                    $message = '  Error getting publisher ID ' . $publisherId . ' zones set to be forecast.';
                    MAX::debug($message, PEAR_LOG_ERR);
                    return;
                }
                if (is_null($aPublisherZoneIds)) {
                    // Publisher has no zones that need channel summarisation, so
                    // carry on with the next publisher that may have such zones
                    continue;
                }
                // For each channel owned by the admin user or the publisher...
                foreach ($aAllChannelIds as $channelId) {
                    $message = "  Performing channel summarisation for Publisher ID $publisherId, Channel ID $channelId.";
                    MAX::debug($message, PEAR_LOG_DEBUG);
                    // Perform the summarising on this channel, with data
                    // from all associated zones
                    $this->_summariseByChannel($oStartDate, $oEndDate, $channelId, $aPublisherZoneIds);
                }
            }
        }
        // Get all active agencies in the system
        $aAgencyIds = $this->oDalEntities->getAllActiveAgencyIds();
        if (PEAR::isError($aAgencyIds) || is_null($aAgencyIds)) {
            return;
        }
        // For each agency...
        foreach ($aAgencyIds as $agencyId) {
            // Get all channels owned by the agency
            $aAgencyChannelIds = $this->oDalEntities->getAllActiveChannelIdsByAgencyId($agencyId);
            if (PEAR::isError($aAgencyChannelIds)) {
                $message = '  Error getting agency ID ' . $agencyId . ' active channels.';
                MAX::debug($message, PEAR_LOG_ERR);
                return;
            }
            // Join the admin and agency channels
            $aAdminAgencyChannelIds = $aAdminChannelIds;
            if (!empty($aAgencyChannelIds)) {
                foreach($aAgencyChannelIds as $channelId) {
                    if (!in_array($channelId, $aAdminAgencyChannelIds)) {
                        $aAdminAgencyChannelIds[] = $channelId;
                    }
                }
            }
            // Get all publishers owned by the agency
            $aPublisherIds = $this->oDalEntities->getAllPublisherIdsByAgencyId($agencyId);
            if (PEAR::isError($aPublisherIds)) {
                $message = '  Error getting agency ID ' . $agencyId . ' publishers.';
                MAX::debug($message, PEAR_LOG_ERR);
                return;
            }
            if (is_null($aPublisherIds)) {
                // The agency has no publishers, so there will be no zones, so
                // carry on with the next agency that may have publishers
                continue;
            }
            // For each publisher owned by the agency...
            foreach ($aPublisherIds as $publisherId) {
                // Get any channels owned by the publisher
                $aPublisherChannelIds = $this->oDalEntities->getAllActiveChannelIdsByAgencyPublisherId($agencyId, $publisherId);
                if (PEAR::isError($aPublisherChannelIds)) {
                    $message = '  Error getting agency ID ' . $agencyId . '/publisher ID ' . $publisherId . ' active channels.';
                    MAX::debug($message, PEAR_LOG_ERR);
                    return;
                }
                // Join the admin/agency and publisher channels
                $aAllChannelIds = $aAdminAgencyChannelIds;
                if (!empty($aPublisherChannelIds)) {
                    foreach($aPublisherChannelIds as $channelId) {
                        if (!in_array($channelId, $aAllChannelIds)) {
                            $aAllChannelIds[] = $channelId;
                        }
                    }
                    sort($aAllChannelIds);
                } else if (empty($aAdminAgencyChannelIds)) {
                    // There are no channels defined for this admin/agency/publisher
                    // grouping, so move carry on with the next publisher or agency
                    continue;
                }
                // Get all the "channel forecast" zones owned by the publisher
                $aPublisherZoneIds = $this->oDalEntities->getAllChannelForecastZonesIdsByPublisherId($publisherId);
                if (PEAR::isError($aPublisherZoneIds)) {
                    $message = '  Error getting publisher ID ' . $publisherId . ' zones set to be forecast.';
                    MAX::debug($message, PEAR_LOG_ERR);
                    return;
                }
                if (is_null($aPublisherZoneIds)) {
                    // Publisher has no zones that need channel summarisation, so
                    // carry on with the next publisher that may have such zones
                    continue;
                }
                // For each channel owned by the admin user, the agency user or the publisher...
                foreach ($aAllChannelIds as $channelId) {
                    $message = "  Performing channel summarisation for Agency ID $agencyId, Publisher ID $publisherId, Channel ID $channelId.";
                    MAX::debug($message, PEAR_LOG_DEBUG);
                    // Perform the summarising on this channel, with data
                    // from all associated zones
                    $this->_summariseByChannel($oStartDate, $oEndDate, $channelId, $aPublisherZoneIds);
                }
            }
        }
    }

    /**
     * A private method to perform channel forcasting for a given day, given the
     * ID of the channel to summarise for, and an array of associated zones IDs,
     * in which the impressionss that will be used for summarising occurred.
     *
     * @access private
     * @param Date $oStartDate The start of the day to summarise.
     * @param Date $oEndDate The end of the day to summarise.
     * @param integer $channelId The channel ID for which summarising is required.
     * @param array $aZoneIds An array of the zone IDs.
     */
    function _summariseByChannel($oStartDate, $oEndDate, $channelId, $aZoneIds)
    {
        // Prepare the $oChannelLimitations object with the current channel
        $result = $this->oChannelLimitations->buildLimitations($channelId);
        if ($result) {
            // Perform the channel summarising on the basis of SQL limitations
            $aCount = $this->_summariseBySqlLimitations($oStartDate, $oEndDate, $aZoneIds);
            // Store the total number of raw impression counts for the channel
            $this->oDalMaintenanceForecasting->saveChannelSummaryForZones($oStartDate, $channelId, $aCount);
        }
    }

    /**
     * A private method to perform channel forcasting for a given set of
     * zone IDs, using the SQL form of delivery limitation plugins in a
     * prepared MAX_Maintenance_Forecasting_Channel_Limitations class.
     *
     * @access private
     * @param Date $oStartDate The start of the day to summarise.
     * @param Date $oEndDate The end of the day to summarise.
     * @param array $aZoneIds An array of the zone IDs.
     * @return integer The number of raw impression values that matched
     *               the channel's limitations.
     */
    function _summariseBySqlLimitations($oStartDate, $oEndDate, $aZoneIds)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        if ($conf['maintenance']['channelForecasting'] != true) {
            return array();
        }
        $table = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        if ($conf['table']['split']) {
            $table .= '_' . $oStartDate->format('%Y%m%d');
        }
        // Count the number of raw data items that would have happened in the channel
        return $this->oDalMaintenanceForecasting->summariseRecordsInZonesBySqlLimitations(
            $this->oChannelLimitations->aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $table
        );
    }

}

?>
