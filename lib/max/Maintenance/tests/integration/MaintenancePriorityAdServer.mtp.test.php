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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer.php';
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/AdServer.php';
require_once 'Date.php';
require_once 'Date/Span.php';

/**
 * A class for performing an integration test of the Prioritisation Engine
 * via a test of the AdServer class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMaintenancePriorityAdServer extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMaintenancePriorityAdServer()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to perform basic end-to-end integration testing of the Maintenance
     * Priority Engine classes for the Ad Server.
     *
     * Test 0: Test that no zone forecast or priority data exists to begin with.
     * Test 1: Run the MPE without any stats, and without the stats engine ever
     *         having been run before. Test that zone forecasts are updated
     *         with the appropriate values, and that the correct priorities are
     *         generated.
     * Test 2: Run the MPE without any stats, but with the stats engine having
     *         reported that it has run. Test that zone forecasts are updated
     *         with the appropriate values, and that the correct priorities are
     *         generated.
     * Test 3: Run the MPE again, as for Test 2, but with a later date used as
     *         for when the stats engine reported having run.
     */
    function testAdServerBasic()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['priority']['useZonePatterning'] = false;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        // Test 0
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_priority']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertNull($aRow);

        // Test 1
        $oDate = new Date('2005-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenancePriority = new MAX_Maintenance_Priority_AdServer();
        $oBeforeUpdateDate = new Date();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oMaintenancePriority->updatePriorities();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();
        $intervalsPerWeek = MAX_OperationInterval::operationIntervalsPerWeek();
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], $intervalsPerWeek * 3);
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                forecast_impressions AS forecast_impressions,
                actual_impressions AS actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            ORDER BY
                operation_interval_id, zone_id";
        $rc = $oDbh->query($query);
        for ($counter = 0; $counter < $intervalsPerWeek; $counter++) {
            for ($zoneID = 1; $zoneID <= 4; $zoneID++) {
                if ($zoneID == 2) {
                    continue;
                }
                $aRow = $rc->fetchRow();
                $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
                $this->assertEqual($aRow['operation_interval_id'], $counter);
                if ($counter <= $currentOperationIntervalID) {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
                    // Go back the required number of operation intervals
                    $retreat = $currentOperationIntervalID - $counter;
                    $aDates['start'] = new Date();
                    $aDates['start']->copy($aCurrentOIDates['start']);
                    $aDates['end'] = new Date();
                    $aDates['end']->copy($aCurrentOIDates['end']);
                    for ($i = 0; $i < $retreat; $i++) {
                        $aDates['start']->subtractSeconds(1);
                        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aDates['start']);
                    }
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                } else {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
                    // Go back the required number of operation intervals
                    $advance = $counter - $currentOperationIntervalID;
                    $aDates['start'] = new Date();
                    $aDates['start']->copy($aCurrentOIDates['start']);
                    $aDates['end'] = new Date();
                    $aDates['end']->copy($aCurrentOIDates['end']);
                    for ($i = 0; $i < $advance; $i++) {
                        $aDates['end']->addSeconds(1);
                        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aDates['end']);
                    }
                    $aDates['start']->subtractSeconds(60 * 60 * 24 * 7);
                    $aDates['end']->subtractSeconds(60 * 60 * 24 * 7);
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                }
                $this->assertEqual($aRow['zone_id'], $zoneID);
                $this->assertEqual($aRow['forecast_impressions'], 10);
                $this->assertNull($aRow['actual_impressions']);
            }
        }
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['priority'], 0.9);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['priority'], 0.7);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['priority'], 0.2);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['priority'], 0.3);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 11);
        $this->assertEqual($aRow['requested_impressions'], 9);
        $this->assertEqual($aRow['priority'], 0.9);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 7);
        $this->assertEqual($aRow['priority'], 0.7);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 2);
        $this->assertEqual($aRow['priority'], 0.2);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 3);
        $this->assertEqual($aRow['priority'], 0.3);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oStartRunDate = new Date($aRow['start_run']);
        $oEndRunDate = new Date($aRow['end_run']);
        $result = $oBeforeUpdateDate->before($oStartRunDate);
        $this->assertTrue($result);
        $result = $oBeforeUpdateDate->before($oEndRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oStartRunDate->after($oEndRunDate);
        $this->assertFalse($result);
        $this->assertEqual($aRow['operation_interval'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_ZIF);
        $this->assertEqual($aRow['updated_to'], '2005-06-15 13:59:59');
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oStartRunDate = new Date($aRow['start_run']);
        $oEndRunDate = new Date($aRow['end_run']);
        $result = $oBeforeUpdateDate->before($oStartRunDate);
        $this->assertTrue($result);
        $result = $oBeforeUpdateDate->before($oEndRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oStartRunDate->after($oEndRunDate);
        $this->assertFalse($result);
        $this->assertEqual($aRow['operation_interval'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION);
        $this->assertNull($aRow['updated_to']);

        // Insert data that indicates that the Maintenance Statistics Engine
        // has recently updated the available stats, but don't insert any
        // stats into the tables
        $oServiceLocator = &ServiceLocator::instance();
        $startDate = new Date('2005-06-15 14:00:01');
        $oServiceLocator->register('now', $startDate);
        $oMaintenanceStatistics = new MAX_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->updateFinal = true;
        $aOiDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($startDate);
        $oMaintenanceStatistics->updateIntermediateToDate = $aOiDates['end'];
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        $oLogCompletion = new MAX_Maintenance_Statistics_AdServer_Task_LogCompletion();
        $oLogCompletion->run();

        // Test 2
        $oPreviousDate = new Date('2005-06-15 13:01:01');
        $previousOperationIntervalID = $currentOperationIntervalID;
        $oDate = new Date('2005-06-15 14:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenancePriority = new MAX_Maintenance_Priority_AdServer();
        $oBeforeUpdateDate = new Date();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oMaintenancePriority->updatePriorities();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $oLastUpdatedTo = new Date('2005-06-15 14:00:00');
        $oNowUpdatedTo  = new Date('2005-06-15 15:00:00');
        $oSpan = new Date_Span();
        $oLastUpdatedToCopy = new Date();
        $oLastUpdatedToCopy->copy($oLastUpdatedTo);
        $oNowUpdatedToCopy = new Date();
        $oNowUpdatedToCopy->copy($oNowUpdatedTo);
        $oSpan->setFromDateDiff($oLastUpdatedToCopy, $oNowUpdatedToCopy);
        $hours = $oSpan->toHours();
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], ($intervalsPerWeek + $hours) * 3);
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                forecast_impressions AS forecast_impressions,
                actual_impressions AS actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                interval_start < '" . $oPreviousDate->format('%Y-%m-%d %H:%M:%S') . "'
            ORDER BY
                operation_interval_id, zone_id";
        $rc = $oDbh->query($query);
        for ($counter = 0; $counter < $intervalsPerWeek; $counter++) {
            for ($zoneID = 1; $zoneID <= 4; $zoneID++) {
                if ($zoneID == 2) {
                    continue;
                }
                $aRow = $rc->fetchRow();
                $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
                $this->assertEqual($aRow['operation_interval_id'], $counter);
                if ($counter <= $previousOperationIntervalID) {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oPreviousDate);
                    // Go back the required number of operation intervals
                    $retreat = $previousOperationIntervalID - $counter;
                    $aDates['start'] = $aCurrentOIDates['start'];
                    $aDates['end'] = $aCurrentOIDates['end'];
                    for ($i = 0; $i < $retreat; $i++) {
                        $aDates['start']->subtractSeconds(1);
                        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aDates['start']);
                    }
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                } else {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oPreviousDate);
                    // Go back the required number of operation intervals
                    $advance = $counter - $previousOperationIntervalID;
                    $aDates['start'] = $aCurrentOIDates['start'];
                    $aDates['end'] = $aCurrentOIDates['end'];
                    for ($i = 0; $i < $advance; $i++) {
                        $aDates['end']->addSeconds(1);
                        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aDates['end']);
                    }
                    $aDates['start']->subtractSeconds(60 * 60 * 24 * 7);
                    $aDates['end']->subtractSeconds(60 * 60 * 24 * 7);
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                }
                $this->assertEqual($aRow['zone_id'], $zoneID);
                $this->assertEqual($aRow['forecast_impressions'], 10);
                $this->assertNull($aRow['actual_impressions']);
            }
        }
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                forecast_impressions AS forecast_impressions,
                actual_impressions AS actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                interval_start >= '" . $oPreviousDate->format('%Y-%m-%d %H:%M:%S') . "'
            ORDER BY
                operation_interval_id, zone_id";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 86);
        $this->assertEqual($aRow['interval_start'], '2005-06-15 14:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-15 14:59:59');
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 86);
        $this->assertEqual($aRow['interval_start'], '2005-06-15 14:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-15 14:59:59');
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 86);
        $this->assertEqual($aRow['interval_start'], '2005-06-15 14:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-15 14:59:59');
        $this->assertEqual($aRow['zone_id'], 4);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 9 / 9.1, 40), 0);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 7 / 9.1, 40), 0);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 2 / 9.1, 40), 0);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 3 / 3.7, 40), 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 8);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 11);
        $this->assertEqual($aRow['requested_impressions'], 9);
        $this->assertEqual($aRow['priority'], 0.9);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 7);
        $this->assertEqual($aRow['priority'], 0.7);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 2);
        $this->assertEqual($aRow['priority'], 0.2);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 3);
        $this->assertEqual($aRow['priority'], 0.3);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 9);
        $this->assertEqual(strncmp($aRow['priority'], 9 / 9.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 7);
        $this->assertEqual(strncmp($aRow['priority'], 7 / 9.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 2);
        $this->assertEqual(strncmp($aRow['priority'], 2 / 9.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 3);
        $this->assertEqual(strncmp($aRow['priority'], 3 / 3.7, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oStartRunDate = new Date($aRow['start_run']);
        $oEndRunDate = new Date($aRow['end_run']);
        $result = $oBeforeUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oBeforeUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oStartRunDate->after($oEndRunDate);
        $this->assertFalse($result);
        $this->assertEqual($aRow['operation_interval'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_ZIF);
        $this->assertEqual($aRow['updated_to'], '2005-06-15 13:59:59');
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oStartRunDate = new Date($aRow['start_run']);
        $oEndRunDate = new Date($aRow['end_run']);
        $result = $oBeforeUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oBeforeUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oStartRunDate->after($oEndRunDate);
        $this->assertFalse($result);
        $this->assertEqual($aRow['operation_interval'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION);
        $this->assertNull($aRow['updated_to']);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oStartRunDate = new Date($aRow['start_run']);
        $oEndRunDate = new Date($aRow['end_run']);
        $result = $oBeforeUpdateDate->before($oStartRunDate);
        $this->assertTrue($result);
        $result = $oBeforeUpdateDate->before($oEndRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oStartRunDate->after($oEndRunDate);
        $this->assertFalse($result);
        $this->assertEqual($aRow['operation_interval'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_ZIF);
        $this->assertEqual($aRow['updated_to'], '2005-06-15 14:59:59');
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oStartRunDate = new Date($aRow['start_run']);
        $oEndRunDate = new Date($aRow['end_run']);
        $result = $oBeforeUpdateDate->before($oStartRunDate);
        $this->assertTrue($result);
        $result = $oBeforeUpdateDate->before($oEndRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oStartRunDate->after($oEndRunDate);
        $this->assertFalse($result);
        $this->assertEqual($aRow['operation_interval'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION);
        $this->assertNull($aRow['updated_to']);

        // Insert data that indicates that the Maintenance Statistics Engine
        // has recently updated the available stats, but don't insert any
        // stats into the tables
        $oServiceLocator = &ServiceLocator::instance();
        $startDate = new Date('2005-06-19 00:00:01');
        $oServiceLocator->register('now', $startDate);
        $oMaintenanceStatistics = new MAX_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->updateFinal = true;
        $aOiDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($startDate);
        $oMaintenanceStatistics->updateIntermediateToDate = $aOiDates['end'];
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        $oLogCompletion = new MAX_Maintenance_Statistics_AdServer_Task_LogCompletion();
        $oLogCompletion->run();

        // Test 3
        $oDate = new Date('2005-06-19 00:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenancePriority = new MAX_Maintenance_Priority_AdServer();
        $oBeforeUpdateDate = new Date();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oMaintenancePriority->updatePriorities();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();
        $oLastUpdatedTo1 = new Date('2005-06-15 14:00:00');
        $oNowUpdatedTo1  = new Date('2005-06-15 15:00:00');
        $oSpan = new Date_Span();
        $oLastUpdatedTo1Copy = new Date();
        $oLastUpdatedTo1Copy->copy($oLastUpdatedTo1);
        $oNowUpdatedTo1Copy = new Date();
        $oNowUpdatedTo1Copy->copy($oNowUpdatedTo1);
        $oSpan->setFromDateDiff($oLastUpdatedTo1Copy, $oNowUpdatedTo1Copy);
        $hours1 = $oSpan->toHours();
        $oLastUpdatedTo2 = new Date('2005-06-15 15:00:00');
        $oNowUpdatedTo2  = new Date('2005-06-19 01:00:00');
        $oSpan = new Date_Span();
        $oLastUpdatedTo2Copy = new Date();
        $oLastUpdatedTo2Copy->copy($oLastUpdatedTo2);
        $oNowUpdatedTo2Copy = new Date();
        $oNowUpdatedTo2Copy->copy($oNowUpdatedTo2);
        $oSpan->setFromDateDiff($oLastUpdatedTo2Copy, $oNowUpdatedTo2Copy);
        $hours2 = $oSpan->toHours();
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], ($intervalsPerWeek + $hours1 + $hours2) * 3);
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                forecast_impressions AS forecast_impressions,
                actual_impressions AS actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                interval_start < '" . $oPreviousDate->format('%Y-%m-%d %H:%M:%S') . "'
            ORDER BY
                operation_interval_id, zone_id";
        $rc = $oDbh->query($query);
        for ($counter = 0; $counter < $intervalsPerWeek; $counter++) {
            for ($zoneID = 1; $zoneID <= 4; $zoneID++) {
                if ($zoneID == 2) {
                    continue;
                }
                $aRow = $rc->fetchRow();
                $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
                $this->assertEqual($aRow['operation_interval_id'], $counter);
                if ($counter <= $previousOperationIntervalID) {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oPreviousDate);
                    // Go back the required number of operation intervals
                    $retreat = $previousOperationIntervalID - $counter;
                    $aDates['start'] = $aCurrentOIDates['start'];
                    $aDates['end'] = $aCurrentOIDates['end'];
                    for ($i = 0; $i < $retreat; $i++) {
                        $aDates['start']->subtractSeconds(1);
                        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aDates['start']);
                    }
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                } else {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oPreviousDate);
                    // Go back the required number of operation intervals
                    $advance = $counter - $previousOperationIntervalID;
                    $aDates['start'] = $aCurrentOIDates['start'];
                    $aDates['end'] = $aCurrentOIDates['end'];
                    for ($i = 0; $i < $advance; $i++) {
                        $aDates['end']->addSeconds(1);
                        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aDates['end']);
                    }
                    $aDates['start']->subtractSeconds(60 * 60 * 24 * 7);
                    $aDates['end']->subtractSeconds(60 * 60 * 24 * 7);
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                }
                $this->assertEqual($aRow['zone_id'], $zoneID);
                $this->assertEqual($aRow['forecast_impressions'], 10);
                $this->assertNull($aRow['actual_impressions']);
            }
        }
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                forecast_impressions AS forecast_impressions,
                actual_impressions AS actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                interval_start = '2005-06-15 14:00:00'
            ORDER BY
                operation_interval_id, zone_id";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 86);
        $this->assertEqual($aRow['interval_start'], '2005-06-15 14:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-15 14:59:59');
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 86);
        $this->assertEqual($aRow['interval_start'], '2005-06-15 14:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-15 14:59:59');
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 86);
        $this->assertEqual($aRow['interval_start'], '2005-06-15 14:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-15 14:59:59');
        $this->assertEqual($aRow['zone_id'], 4);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $oDate = new Date('2005-06-15 15:00:00');
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                forecast_impressions AS forecast_impressions,
                actual_impressions AS actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                interval_start >= '2005-06-15 15:00:00'
                AND interval_start < '2005-06-19 00:00:00'
            ORDER BY
                operation_interval_id, zone_id";
        $rc = $oDbh->query($query);
        for ($counter = ($intervalsPerWeek - $hours) + 1; $counter < $intervalsPerWeek; $counter++) {
            for ($zoneID = 1; $zoneID <= 3; $zoneID++) {
                if ($zoneID == 2) {
                    continue;
                }
                $aRow = $rc->fetchRow();
                $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
                $this->assertEqual($aRow['operation_interval_id'], $counter);
                if ($counter == 0) {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
                    // Go forward to the next operation interval
                    $aDates['start'] = $aCurrentOIDates['start'];
                    $aDates['end'] = $aCurrentOIDates['end'];
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                } else {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
                    $aDates['end'] = $aCurrentOIDates['end'];
                    // Go back the required number of operation intervals
                    for ($i = 0; $i < $counter; $i++) {
                        $aDates['end']->addSeconds(1);
                        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aDates['end']);
                    }
                    $aDates['start']->subtractSeconds(60 * 60 * 24 * 7);
                    $aDates['end']->subtractSeconds(60 * 60 * 24 * 7);
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                }
                $this->assertEqual($aRow['zone_id'], $zoneID);
                $this->assertEqual($aRow['forecast_impressions'], 10);
                $this->assertNull($aRow['actual_impressions']);
            }
        }
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                forecast_impressions AS forecast_impressions,
                actual_impressions AS actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                interval_start = '2005-06-19 00:00:00'
            ORDER BY
                operation_interval_id, zone_id";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 0);
        $this->assertEqual($aRow['interval_start'], '2005-06-19 00:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-19 00:59:59');
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 0);
        $this->assertEqual($aRow['interval_start'], '2005-06-19 00:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-19 00:59:59');
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 0);
        $this->assertEqual($aRow['interval_start'], '2005-06-19 00:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-19 00:59:59');
        $this->assertEqual($aRow['zone_id'], 4);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 50 / 50.5, 40), 0);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 70 / 90.1, 40), 0);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 20 / 90.1, 40), 0);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 30 / 30.7, 40), 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 12);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 11);
        $this->assertEqual($aRow['requested_impressions'], 9);
        $this->assertEqual($aRow['priority'], 0.9);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 7);
        $this->assertEqual($aRow['priority'], 0.7);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 2);
        $this->assertEqual($aRow['priority'], 0.2);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 3);
        $this->assertEqual($aRow['priority'], 0.3);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 9);
        $this->assertEqual(strncmp($aRow['priority'], 9 / 9.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 7);
        $this->assertEqual(strncmp($aRow['priority'], 7 / 9.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 2);
        $this->assertEqual(strncmp($aRow['priority'], 2 / 9.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 3);
        $this->assertEqual(strncmp($aRow['priority'], 3 / 3.7, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 0
                AND interval_start = '2005-06-19 00:00:00'
                AND interval_end = '2005-06-19 00:59:59'
                AND ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 5);
        $this->assertEqual($aRow['requested_impressions'], 5);
        $this->assertEqual(strncmp($aRow['priority'], 50 / 50.5, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 100); // Increased from 10 to 100, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 0
                AND interval_start = '2005-06-19 00:00:00'
                AND interval_end = '2005-06-19 00:59:59'
                AND ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 7);
        $this->assertEqual(strncmp($aRow['priority'], 70 / 90.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 100); // Increased from 10 to 100, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 0
                AND interval_start = '2005-06-19 00:00:00'
                AND interval_end = '2005-06-19 00:59:59'
                AND ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 2);
        $this->assertEqual(strncmp($aRow['priority'], 20 / 90.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 100); // Increased from 10 to 100, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 0
                AND interval_start = '2005-06-19 00:00:00'
                AND interval_end = '2005-06-19 00:59:59'
                AND ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 3);
        $this->assertEqual(strncmp($aRow['priority'], 30 / 30.7, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 100); // Increased from 10 to 100, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oStartRunDate = new Date($aRow['start_run']);
        $oEndRunDate = new Date($aRow['end_run']);
        $result = $oBeforeUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oBeforeUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oStartRunDate->after($oEndRunDate);
        $this->assertFalse($result);
        $this->assertEqual($aRow['operation_interval'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_ZIF);
        $this->assertEqual($aRow['updated_to'], '2005-06-15 13:59:59');
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oStartRunDate = new Date($aRow['start_run']);
        $oEndRunDate = new Date($aRow['end_run']);
        $result = $oBeforeUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oBeforeUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oStartRunDate->after($oEndRunDate);
        $this->assertFalse($result);
        $this->assertEqual($aRow['operation_interval'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION);
        $this->assertNull($aRow['updated_to']);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oStartRunDate = new Date($aRow['start_run']);
        $oEndRunDate = new Date($aRow['end_run']);
        $result = $oBeforeUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oBeforeUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oStartRunDate->after($oEndRunDate);
        $this->assertFalse($result);
        $this->assertEqual($aRow['operation_interval'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_ZIF);
        $this->assertEqual($aRow['updated_to'], '2005-06-15 14:59:59');
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oStartRunDate = new Date($aRow['start_run']);
        $oEndRunDate = new Date($aRow['end_run']);
        $result = $oBeforeUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oBeforeUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oStartRunDate->after($oEndRunDate);
        $this->assertFalse($result);
        $this->assertEqual($aRow['operation_interval'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION);
        $this->assertNull($aRow['updated_to']);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 5";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oStartRunDate = new Date($aRow['start_run']);
        $oEndRunDate = new Date($aRow['end_run']);
        $result = $oBeforeUpdateDate->before($oStartRunDate);
        $this->assertTrue($result);
        $result = $oBeforeUpdateDate->before($oEndRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oStartRunDate->after($oEndRunDate);
        $this->assertFalse($result);
        $this->assertEqual($aRow['operation_interval'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_ZIF);
        $this->assertEqual($aRow['updated_to'], '2005-06-19 00:59:59');
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 6";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oStartRunDate = new Date($aRow['start_run']);
        $oEndRunDate = new Date($aRow['end_run']);
        $result = $oBeforeUpdateDate->before($oStartRunDate);
        $this->assertTrue($result);
        $result = $oBeforeUpdateDate->before($oEndRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oStartRunDate);
        $this->assertTrue($result);
        $result = $oAfterUpdateDate->after($oEndRunDate);
        $this->assertTrue($result);
        $result = $oStartRunDate->after($oEndRunDate);
        $this->assertFalse($result);
        $this->assertEqual($aRow['operation_interval'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION);
        $this->assertNull($aRow['updated_to']);

        // Hack! The TestEnv class doesn't always drop temp tables for some
        // reason, so drop them "by hand", just in case.
        $dbType = strtolower($aConf['database']['type']);
        $oTable = &OA_DB_Table_Priority::singleton();
        $oTable->dropTable("tmp_ad_required_impression");
        $oTable->dropTable("tmp_ad_zone_impression");

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the Maintenance
     * Priority Engine classes for the Ad Server, when using Zone Patterning.
     *
     * Test 0: Test that no zone forecast or priority data exists to begin with.
     * Test 1: Run the MPE without any stats, and without the stats engine ever
     *         having been run before. Test that zone forecasts are updated
     *         with the appropriate values, and that the correct priorities are
     *         generated.
     * Test 2: Run the MPE without any stats, but with the stats engine having
     *         reported that it has run. Test that zone forecasts are updated
     *         with the appropriate values, and that the correct priorities are
     *         generated.
     * Test 3: Run the MPE again, as for Test 2, but with a later date used as
     *         for when the stats engine reported having run.
     */
    function testAdServerBasicZonePatterning()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['priority']['useZonePatterning'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        // Test 0
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Test 1
        $oDate = new Date('2005-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenancePriority = new MAX_Maintenance_Priority_AdServer();
        $oMaintenancePriority->updatePriorities();
        $intervalsPerWeek = MAX_OperationInterval::operationIntervalsPerWeek();
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], $intervalsPerWeek * 3);
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                forecast_impressions AS forecast_impressions,
                actual_impressions AS actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            ORDER BY
                operation_interval_id, zone_id";
        $rc = $oDbh->query($query);
        for ($counter = 0; $counter < $intervalsPerWeek; $counter++) {
            for ($zoneID = 1; $zoneID <= 4; $zoneID++) {
                if ($zoneID == 2) {
                    continue;
                }
                $aRow = $rc->fetchRow();
                $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
                $this->assertEqual($aRow['operation_interval_id'], $counter);
                if ($counter <= $currentOperationIntervalID) {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
                    // Go back the required number of operation intervals
                    $retreat = $currentOperationIntervalID - $counter;
                    $aDates['start'] = new Date();
                    $aDates['start']->copy($aCurrentOIDates['start']);
                    $aDates['end'] = new Date();
                    $aDates['end']->copy($aCurrentOIDates['end']);
                    for ($i = 0; $i < $retreat; $i++) {
                        $aDates['start']->subtractSeconds(1);
                        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aDates['start']);
                    }
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                } else {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
                    // Go back the required number of operation intervals
                    $advance = $counter - $currentOperationIntervalID;
                    $aDates['start'] = new Date();
                    $aDates['start']->copy($aCurrentOIDates['start']);
                    $aDates['end'] = new Date();
                    $aDates['end']->copy($aCurrentOIDates['end']);
                    for ($i = 0; $i < $advance; $i++) {
                        $aDates['end']->addSeconds(1);
                        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aDates['end']);
                    }
                    $aDates['start']->subtractSeconds(60 * 60 * 24 * 7);
                    $aDates['end']->subtractSeconds(60 * 60 * 24 * 7);
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                }
                $this->assertEqual($aRow['zone_id'], $zoneID);
                $this->assertEqual($aRow['forecast_impressions'], 10);
                $this->assertNull($aRow['actual_impressions']);
            }
        }
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['priority'], 0.9);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['priority'], 0.7);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['priority'], 0.2);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['priority'], 0.3);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 11);
        $this->assertEqual($aRow['requested_impressions'], 9);
        $this->assertEqual($aRow['priority'], 0.9);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 7);
        $this->assertEqual($aRow['priority'], 0.7);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 2);
        $this->assertEqual($aRow['priority'], 0.2);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 3);
        $this->assertEqual($aRow['priority'], 0.3);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);

        // Insert data that indicates that the Maintenance Statistics Engine
        // has recently updated the available stats, but don't insert any
        // stats into the tables
        $oServiceLocator = &ServiceLocator::instance();
        $startDate = new Date('2005-06-15 14:00:01');
        $oServiceLocator->register('now', $startDate);
        $oMaintenanceStatistics = new MAX_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->updateFinal = true;
        $aOiDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($startDate);
        $oMaintenanceStatistics->updateIntermediateToDate = $aOiDates['end'];
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        $oLogCompletion = new MAX_Maintenance_Statistics_AdServer_Task_LogCompletion();
        $oLogCompletion->run();

        // Test 2
        $oPreviousDate = new Date('2005-06-15 13:01:01');
        $previousOperationIntervalID = $currentOperationIntervalID;
        $oDate = new Date('2005-06-15 14:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenancePriority = new MAX_Maintenance_Priority_AdServer();
        $oMaintenancePriority->updatePriorities();
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $oLastUpdatedTo = new Date('2005-06-15 14:00:00');
        $oNowUpdatedTo  = new Date('2005-06-15 15:00:00');
        $oSpan = new Date_Span();
        $oLastUpdatedToCopy = new Date();
        $oLastUpdatedToCopy->copy($oLastUpdatedTo);
        $oNowUpdatedToCopy = new Date();
        $oNowUpdatedToCopy->copy($oNowUpdatedTo);
        $oSpan->setFromDateDiff($oLastUpdatedToCopy, $oNowUpdatedToCopy);
        $hours = $oSpan->toHours();
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], ($intervalsPerWeek + $hours) * 3);
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                forecast_impressions AS forecast_impressions,
                actual_impressions AS actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                interval_start < '" . $oPreviousDate->format('%Y-%m-%d %H:%M:%S') . "'
            ORDER BY
                operation_interval_id, zone_id";
        $rc = $oDbh->query($query);
        for ($counter = 0; $counter < $intervalsPerWeek; $counter++) {
            for ($zoneID = 1; $zoneID <= 4; $zoneID++) {
                if ($zoneID == 2) {
                    continue;
                }
                $aRow = $rc->fetchRow();
                $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
                $this->assertEqual($aRow['operation_interval_id'], $counter);
                if ($counter <= $previousOperationIntervalID) {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oPreviousDate);
                    // Go back the required number of operation intervals
                    $retreat = $previousOperationIntervalID - $counter;
                    $aDates['start'] = $aCurrentOIDates['start'];
                    $aDates['end'] = $aCurrentOIDates['end'];
                    for ($i = 0; $i < $retreat; $i++) {
                        $aDates['start']->subtractSeconds(1);
                        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aDates['start']);
                    }
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                } else {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oPreviousDate);
                    // Go back the required number of operation intervals
                    $advance = $counter - $previousOperationIntervalID;
                    $aDates['start'] = $aCurrentOIDates['start'];
                    $aDates['end'] = $aCurrentOIDates['end'];
                    for ($i = 0; $i < $advance; $i++) {
                        $aDates['end']->addSeconds(1);
                        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aDates['end']);
                    }
                    $aDates['start']->subtractSeconds(60 * 60 * 24 * 7);
                    $aDates['end']->subtractSeconds(60 * 60 * 24 * 7);
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                }
                $this->assertEqual($aRow['zone_id'], $zoneID);
                $this->assertEqual($aRow['forecast_impressions'], 10);
                $this->assertNull($aRow['actual_impressions']);
            }
        }
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                forecast_impressions AS forecast_impressions,
                actual_impressions AS actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                interval_start >= '" . $oPreviousDate->format('%Y-%m-%d %H:%M:%S') . "'
            ORDER BY
                operation_interval_id, zone_id";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 86);
        $this->assertEqual($aRow['interval_start'], '2005-06-15 14:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-15 14:59:59');
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 86);
        $this->assertEqual($aRow['interval_start'], '2005-06-15 14:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-15 14:59:59');
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 86);
        $this->assertEqual($aRow['interval_start'], '2005-06-15 14:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-15 14:59:59');
        $this->assertEqual($aRow['zone_id'], 4);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 9 / 9.1, 40), 0);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 7 / 9.1, 40), 0);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 2 / 9.1, 40), 0);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 3 / 3.7, 40), 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 8);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 11);
        $this->assertEqual($aRow['requested_impressions'], 9);
        $this->assertEqual($aRow['priority'], 0.9);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 7);
        $this->assertEqual($aRow['priority'], 0.7);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 2);
        $this->assertEqual($aRow['priority'], 0.2);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 3);
        $this->assertEqual($aRow['priority'], 0.3);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 9);
        $this->assertEqual(strncmp($aRow['priority'], 9 / 9.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 7);
        $this->assertEqual(strncmp($aRow['priority'], 7 / 9.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 2);
        $this->assertEqual(strncmp($aRow['priority'], 2 / 9.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 3);
        $this->assertEqual(strncmp($aRow['priority'], 3 / 3.7, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);

        // Insert data that indicates that the Maintenance Statistics Engine
        // has recently updated the available stats, but don't insert any
        // stats into the tables
        $oServiceLocator = &ServiceLocator::instance();
        $startDate = new Date('2005-06-19 00:00:01');
        $oServiceLocator->register('now', $startDate);
        $oMaintenanceStatistics = new MAX_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->updateFinal = true;
        $aOiDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($startDate);
        $oMaintenanceStatistics->updateIntermediateToDate = $aOiDates['end'];
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        $oLogCompletion = new MAX_Maintenance_Statistics_AdServer_Task_LogCompletion();
        $oLogCompletion->run();

        // Test 3
        $oDate = new Date('2005-06-19 00:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenancePriority = new MAX_Maintenance_Priority_AdServer();
        $oMaintenancePriority->updatePriorities();
        $oLastUpdatedTo1 = new Date('2005-06-15 14:00:00');
        $oNowUpdatedTo1  = new Date('2005-06-15 15:00:00');
        $oSpan = new Date_Span();
        $oLastUpdatedTo1Copy = new Date();
        $oLastUpdatedTo1Copy->copy($oLastUpdatedTo1);
        $oNowUpdatedTo1Copy = new Date();
        $oNowUpdatedTo1Copy->copy($oNowUpdatedTo1);
        $oSpan->setFromDateDiff($oLastUpdatedTo1Copy, $oNowUpdatedTo1Copy);
        $hours1 = $oSpan->toHours();
        $oLastUpdatedTo2 = new Date('2005-06-15 15:00:00');
        $oNowUpdatedTo2  = new Date('2005-06-19 01:00:00');
        $oSpan = new Date_Span();
        $oLastUpdatedTo2Copy = new Date();
        $oLastUpdatedTo2Copy->copy($oLastUpdatedTo2);
        $oNowUpdatedTo2Copy = new Date();
        $oNowUpdatedTo2Copy->copy($oNowUpdatedTo2);
        $oSpan->setFromDateDiff($oLastUpdatedTo2Copy, $oNowUpdatedTo2Copy);
        $hours2 = $oSpan->toHours();
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], ($intervalsPerWeek + $hours1 + $hours2) * 3);
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                forecast_impressions AS forecast_impressions,
                actual_impressions AS actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                interval_start < '" . $oPreviousDate->format('%Y-%m-%d %H:%M:%S') . "'
            ORDER BY
                operation_interval_id, zone_id";
        $rc = $oDbh->query($query);
        for ($counter = 0; $counter < $intervalsPerWeek; $counter++) {
            for ($zoneID = 1; $zoneID <= 4; $zoneID++) {
                if ($zoneID == 2) {
                    continue;
                }
                $aRow = $rc->fetchRow();
                $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
                $this->assertEqual($aRow['operation_interval_id'], $counter);
                if ($counter <= $previousOperationIntervalID) {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oPreviousDate);
                    // Go back the required number of operation intervals
                    $retreat = $previousOperationIntervalID - $counter;
                    $aDates['start'] = $aCurrentOIDates['start'];
                    $aDates['end'] = $aCurrentOIDates['end'];
                    for ($i = 0; $i < $retreat; $i++) {
                        $aDates['start']->subtractSeconds(1);
                        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aDates['start']);
                    }
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                } else {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oPreviousDate);
                    // Go back the required number of operation intervals
                    $advance = $counter - $previousOperationIntervalID;
                    $aDates['start'] = $aCurrentOIDates['start'];
                    $aDates['end'] = $aCurrentOIDates['end'];
                    for ($i = 0; $i < $advance; $i++) {
                        $aDates['end']->addSeconds(1);
                        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aDates['end']);
                    }
                    $aDates['start']->subtractSeconds(60 * 60 * 24 * 7);
                    $aDates['end']->subtractSeconds(60 * 60 * 24 * 7);
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                }
                $this->assertEqual($aRow['zone_id'], $zoneID);
                $this->assertEqual($aRow['forecast_impressions'], 10);
                $this->assertNull($aRow['actual_impressions']);
            }
        }
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                forecast_impressions AS forecast_impressions,
                actual_impressions AS actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                interval_start = '2005-06-15 14:00:00'
            ORDER BY
                operation_interval_id, zone_id";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 86);
        $this->assertEqual($aRow['interval_start'], '2005-06-15 14:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-15 14:59:59');
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 86);
        $this->assertEqual($aRow['interval_start'], '2005-06-15 14:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-15 14:59:59');
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 86);
        $this->assertEqual($aRow['interval_start'], '2005-06-15 14:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-15 14:59:59');
        $this->assertEqual($aRow['zone_id'], 4);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $oDate = new Date('2005-06-15 15:00:00');
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                forecast_impressions AS forecast_impressions,
                actual_impressions AS actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                interval_start >= '2005-06-15 15:00:00'
                AND interval_start < '2005-06-19 00:00:00'
            ORDER BY
                operation_interval_id, zone_id";
        $rc = $oDbh->query($query);
        for ($counter = ($intervalsPerWeek - $hours) + 1; $counter < $intervalsPerWeek; $counter++) {
            for ($zoneID = 1; $zoneID <= 3; $zoneID++) {
                if ($zoneID == 2) {
                    continue;
                }
                $aRow = $rc->fetchRow();
                $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
                $this->assertEqual($aRow['operation_interval_id'], $counter);
                if ($counter == 0) {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
                    // Go forward to the next operation interval
                    $aDates['start'] = $aCurrentOIDates['start'];
                    $aDates['end'] = $aCurrentOIDates['end'];
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                } else {
                    $aCurrentOIDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
                    $aDates['end'] = $aCurrentOIDates['end'];
                    // Go back the required number of operation intervals
                    for ($i = 0; $i < $counter; $i++) {
                        $aDates['end']->addSeconds(1);
                        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aDates['end']);
                    }
                    $aDates['start']->subtractSeconds(60 * 60 * 24 * 7);
                    $aDates['end']->subtractSeconds(60 * 60 * 24 * 7);
                    $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                    $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                }
                $this->assertEqual($aRow['zone_id'], $zoneID);
                $this->assertEqual($aRow['forecast_impressions'], 10);
                $this->assertNull($aRow['actual_impressions']);
            }
        }
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                forecast_impressions AS forecast_impressions,
                actual_impressions AS actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                interval_start = '2005-06-19 00:00:00'
            ORDER BY
                operation_interval_id, zone_id";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 0);
        $this->assertEqual($aRow['interval_start'], '2005-06-19 00:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-19 00:59:59');
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 0);
        $this->assertEqual($aRow['interval_start'], '2005-06-19 00:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-19 00:59:59');
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], 0);
        $this->assertEqual($aRow['interval_start'], '2005-06-19 00:00:00');
        $this->assertEqual($aRow['interval_end'], '2005-06-19 00:59:59');
        $this->assertEqual($aRow['zone_id'], 4);
        $this->assertEqual($aRow['forecast_impressions'], 10);
        $this->assertNull($aRow['actual_impressions']);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 50 / 50.5, 40), 0);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 70 / 90.1, 40), 0);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 20 / 90.1, 40), 0);
        $query = "
            SELECT
                priority
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual(strncmp($aRow['priority'], 30 / 30.7, 40), 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 12);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 11);
        $this->assertEqual($aRow['requested_impressions'], 9);
        $this->assertEqual($aRow['priority'], 0.9);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 7);
        $this->assertEqual($aRow['priority'], 0.7);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 2);
        $this->assertEqual($aRow['priority'], 0.2);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 85
                AND interval_start = '2005-06-15 13:00:00'
                AND interval_end = '2005-06-15 13:59:59'
                AND ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 3);
        $this->assertEqual($aRow['priority'], 0.3);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 9);
        $this->assertEqual(strncmp($aRow['priority'], 9 / 9.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 7);
        $this->assertEqual(strncmp($aRow['priority'], 7 / 9.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 2);
        $this->assertEqual(strncmp($aRow['priority'], 2 / 9.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 86
                AND interval_start = '2005-06-15 14:00:00'
                AND interval_end = '2005-06-15 14:59:59'
                AND ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 3);
        $this->assertEqual(strncmp($aRow['priority'], 3 / 3.7, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 10); // Increased from 1 to 10, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 0
                AND interval_start = '2005-06-19 00:00:00'
                AND interval_end = '2005-06-19 00:59:59'
                AND ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 5);
        $this->assertEqual($aRow['requested_impressions'], 5);
        $this->assertEqual(strncmp($aRow['priority'], 50 / 50.5, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 100); // Increased from 10 to 100, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 0
                AND interval_start = '2005-06-19 00:00:00'
                AND interval_end = '2005-06-19 00:59:59'
                AND ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 12);
        $this->assertEqual($aRow['requested_impressions'], 7);
        $this->assertEqual(strncmp($aRow['priority'], 70 / 90.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 100); // Increased from 10 to 100, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 0
                AND interval_start = '2005-06-19 00:00:00'
                AND interval_end = '2005-06-19 00:59:59'
                AND ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 2);
        $this->assertEqual(strncmp($aRow['priority'], 20 / 90.1, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 100); // Increased from 10 to 100, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = 0
                AND interval_start = '2005-06-19 00:00:00'
                AND interval_end = '2005-06-19 00:59:59'
                AND ad_id = 3
                AND zone_id = 4";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['required_impressions'], 3);
        $this->assertEqual($aRow['requested_impressions'], 3);
        $this->assertEqual(strncmp($aRow['priority'], 30 / 30.7, 40), 0);
        $this->assertEqual($aRow['priority_factor'], 100); // Increased from 10 to 100, as no impressions
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0);

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform more complex end-to-end integration testing of the AdServer class.
     *
     * Requirements:
     * Simulate running the maintenance engine for the first time, and then insert some
     * statistics as if real delivery has occured, and then the maintenance statistics
     * engine has summarised the statistics. Then, re-run the prioritisation engine,
     * and ensure the final priority values are correct. Finally, insert new statistics
     * and re-run the prioritisation again.
     *
     * @TODO This test has been disabled, as *all* zones now have Priority Compensation
     *       performed, so the values in this test need to be updated.
     */
    function xtestAdServerComplex()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        // Insert data to indicate the initial maintenance statistics engine has run without data
        $startDate = new Date('2005-07-01 12:00:01');
        $oMS = new Maintenance_Statistics();
        $oMSC = &$oMS->instance('AdServer');
        $aOiDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($startDate);
        $report = null;
        $endDate = new Date('2005-07-01 12:01:00');
        $oMSC->logCompletion($startDate, $endDate, OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH,
                             $aOiDates['end'], $report);

        // Run the prioritisation engine for the initial run
        $oDate = new Date('2005-07-01 12:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenancePriority = new MAX_Maintenance_Priority_AdServer();
        $oMaintenancePriority->updatePriorities();

        // Perform basic checking of the initial priorities (as above, so not as involved)
        $intervalsPerWeek = MAX_OperationInterval::operationIntervalsPerWeek();
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], $intervalsPerWeek * 2);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 2);

        // Insert the simulated statistics representing the delivery for these priority values
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad']}
                (
                    day,
                    hour,
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    creative_id,
                    zone_id,
                    requests,
                    impressions,
                    clicks,
                    conversions,
                    total_basket_value
                )
            VALUES
                (
                    '2005-07-01',
                    12,
                    60,
                    $currentOperationIntervalID,
                    '2005-07-01 12:00:00',
                    '2005-07-01 12:59:59',
                    1,
                    0,
                    1,
                    NULL,
                    100,
                    NULL,
                    NULL,
                    NULL
                ),
                (
                    '2005-07-01',
                    12,
                    60,
                    $currentOperationIntervalID,
                    '2005-07-01 12:00:00',
                    '2005-07-01 12:59:59',
                    2,
                    0,
                    3,
                    NULL,
                    100,
                    NULL,
                    NULL,
                    NULL
                )";
        $rc = $oDbh->query($query);
        $query = "
            UPDATE
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            SET
                actual_impressions = 100
            WHERE
                operation_interval = 60
                AND operation_interval_id = $currentOperationIntervalID
                AND interval_start = '2005-07-01 12:00:00'
                AND interval_end = '2005-07-01 12:59:59'
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $query = "
            UPDATE
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            SET
                actual_impressions = 100
            WHERE
                operation_interval = 60
                AND operation_interval_id = $currentOperationIntervalID
                AND interval_start = '2005-07-01 12:00:00'
                AND interval_end = '2005-07-01 12:59:59'
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_hourly']}
                (
                    day,
                    hour,
                    ad_id,
                    creative_id,
                    zone_id,
                    requests,
                    impressions,
                    clicks,
                    conversions,
                    total_basket_value
                )
            VALUES
                (
                    '2005-07-01',
                    12,
                    1,
                    0,
                    1,
                    NULL,
                    100,
                    NULL,
                    NULL,
                    NULL
                ),
                (
                    '2005-07-01',
                    12,
                    2,
                    0,
                    3,
                    NULL,
                    100,
                    NULL,
                    NULL,
                    NULL
                )";
        $rc = $oDbh->query($query);

        // Insert the end of statistics run for the above data
        $startDate = new Date('2005-07-01 13:00:01');
        $oMS = new Maintenance_Statistics();
        $oMSC = &$oMS->instance('AdServer');
        $aOiDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($startDate);
        $report = null;
        $endDate = new Date('2005-07-01 13:01:00');
        $oMSC->logCompletion($startDate, $endDate, OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH,
                             $aOiDates['end'], $report);

        // Re-run the prioritisation engine with the statistics present
        $oDate = new Date('2005-07-01 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenancePriority = new MAX_Maintenance_Priority_AdServer();
        $oMaintenancePriority->updatePriorities();

        // Check the new priority values
        $intervalsPerWeek = MAX_OperationInterval::operationIntervalsPerWeek();
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], ($intervalsPerWeek * 2) + 2);
        $query = "
            SELECT
                forecast_impressions AS forecast_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = $currentOperationIntervalID
                AND interval_start = '2005-07-01 13:00:00'
                AND interval_end = '2005-07-01 13:59:59'
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['forecast_impressions'], 100);
        $query = "
            SELECT
                forecast_impressions AS forecast_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = $currentOperationIntervalID
                AND interval_start = '2005-07-01 13:00:00'
                AND interval_end = '2005-07-01 13:59:59'
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['forecast_impressions'], 100);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = $currentOperationIntervalID
                AND interval_start = '2005-07-01 13:00:00'
                AND interval_end = '2005-07-01 13:59:59'
                AND ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        // 120 Daily target - 100 already, 11 OIs left
        $this->assertEqual($aRow['required_impressions'], round((120 - 100) / 11));
        // Above priority from 100 impressions available
        $this->assertEqual($aRow['priority'], round((120 - 100) / 11) / 100);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = $currentOperationIntervalID
                AND interval_start = '2005-07-01 13:00:00'
                AND interval_end = '2005-07-01 13:59:59'
                AND ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        // 87,600 Total target - 100 already, IOs remaining:
        // - 11 to end of day                           =   11
        // - 30 * 24 to end of July                     =  720
        // - 3 * 31 * 24 for August, October, December  = 2232
        // - 2 * 30 * 24 for September, November        = 1440
        // Total:                                       = 4403
        // Weight is 2 of 3
        $this->assertEqual($aRow['required_impressions'], round((87600 - 100) / 4403 * 2 / 3));
        // Above priority from 100 impressions available
        $this->assertEqual($aRow['priority'], round((87600 - 100) / 4403 * 2 / 3) / 100);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = $currentOperationIntervalID
                AND interval_start = '2005-07-01 13:00:00'
                AND interval_end = '2005-07-01 13:59:59'
                AND ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        // 87,600 Total target - 100 already, IOs remaining:
        // - 11 to end of day                           =   11
        // - 30 * 24 to end of July                     =  720
        // - 3 * 31 * 24 for August, October, December  = 2232
        // - 2 * 30 * 24 for September, November        = 1440
        // Total:                                       = 4403
        // Weight is 1 of 3
        $this->assertEqual($aRow['required_impressions'], round((87600 - 100) / 4403 * 1 / 3));
        // Above priority from 100 impressions available
        $this->assertEqual($aRow['priority'], round((87600 - 100) / 4403 * 1 / 3) / 100);
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 5);

        // Insert the simulated statistics representing the delivery for these priority values
        $adOneImpressions   = round(round((120 - 100) / 11) / 100 * 120);
        $adTwoImpressions   = round(round((87600 - 100) / 4403 * 2 / 3) / 100 * 120);
        $adThreeImpressions = round(round((87600 - 100) / 4403 * 1 / 3) / 100 * 120);
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad']}
                (
                    day,
                    hour,
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    creative_id,
                    zone_id,
                    requests,
                    impressions,
                    clicks,
                    conversions,
                    total_basket_value
                )
            VALUES
                (
                    '2005-07-01',
                    13,
                    60,
                    $currentOperationIntervalID,
                    '2005-07-01 13:00:00',
                    '2005-07-01 13:59:59',
                    1,
                    0,
                    1,
                    NULL,
                    $adOneImpressions,
                    NULL,
                    NULL,
                    NULL
                ),
                (
                    '2005-07-01',
                    13,
                    60,
                    $currentOperationIntervalID,
                    '2005-07-01 13:00:00',
                    '2005-07-01 13:59:59',
                    2,
                    0,
                    3,
                    NULL,
                    $adTwoImpressions,
                    NULL,
                    NULL,
                    NULL
                ),
                (
                    '2005-07-01',
                    13,
                    60,
                    $currentOperationIntervalID,
                    '2005-07-01 13:00:00',
                    '2005-07-01 13:59:59',
                    3,
                    0,
                    3,
                    NULL,
                    $adThreeImpressions,
                    NULL,
                    NULL,
                    NULL
                )";
        $rc = $oDbh->query($query);
        $query = "
            UPDATE
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            SET
                actual_impressions = 120
            WHERE
                operation_interval = 60
                AND operation_interval_id = $currentOperationIntervalID
                AND interval_start = '2005-07-01 13:00:00'
                AND interval_end = '2005-07-01 13:59:59'
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $query = "
            UPDATE
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            SET
                actual_impressions = 120
            WHERE
                operation_interval = 60
                AND operation_interval_id = $currentOperationIntervalID
                AND interval_start = '2005-07-01 13:00:00'
                AND interval_end = '2005-07-01 13:59:59'
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_hourly']}
                (
                    day,
                    hour,
                    ad_id,
                    creative_id,
                    zone_id,
                    requests,
                    impressions,
                    clicks,
                    conversions,
                    total_basket_value
                )
            VALUES
                (
                    '2005-07-01',
                    13,
                    1,
                    0,
                    1,
                    NULL,
                    $adOneImpressions,
                    NULL,
                    NULL,
                    NULL
                ),
                (
                    '2005-07-01',
                    12,
                    2,
                    0,
                    3,
                    NULL,
                    $adTwoImpressions,
                    NULL,
                    NULL,
                    NULL
                ),
                (
                    '2005-07-01',
                    12,
                    3,
                    0,
                    3,
                    NULL,
                    $adThreeImpressions,
                    NULL,
                    NULL,
                    NULL
                )";
        $rc = $oDbh->query($query);

        // Insert the end of statistics run for the above data
        $startDate = new Date('2005-07-01 14:00:01');
        $oMS = new Maintenance_Statistics();
        $oMSC = &$oMS->instance('AdServer');
        $aOiDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($startDate);
        $report = null;
        $endDate = new Date('2005-07-01 14:01:00');
        $oMSC->logCompletion($startDate, $endDate, OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH,
                             $aOiDates['end'], $report);

        // Re-run the prioritisation engine with the statistics present
        $oDate = new Date('2005-07-01 14:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenancePriority = new MAX_Maintenance_Priority_AdServer();
        $oMaintenancePriority->updatePriorities();

        // Check the new priority values
        $intervalsPerWeek = MAX_OperationInterval::operationIntervalsPerWeek();
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], ($intervalsPerWeek * 2) + 4);
        $query = "
            SELECT
                forecast_impressions AS forecast_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = $currentOperationIntervalID
                AND interval_start = '2005-07-01 14:00:00'
                AND interval_end = '2005-07-01 14:59:59'
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['forecast_impressions'], 120);
        $query = "
            SELECT
                forecast_impressions AS forecast_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = $currentOperationIntervalID
                AND interval_start = '2005-07-01 14:00:00'
                AND interval_end = '2005-07-01 14:59:59'
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['forecast_impressions'], 120);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = $currentOperationIntervalID
                AND interval_start = '2005-07-01 14:00:00'
                AND interval_end = '2005-07-01 14:59:59'
                AND ad_id = 1
                AND zone_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        // 120 Daily target - 100 + $adOneImpressions already, 10 OIs left
        $this->assertEqual($aRow['required_impressions'], round((120 - 100 - $adOneImpressions) / 10));
        // Above priority from 120 impressions available
        $this->assertEqual(round($aRow['priority'], 10), round(round((120 - 100 - $adOneImpressions) / 10) / 120, 10));
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = $currentOperationIntervalID
                AND interval_start = '2005-07-01 14:00:00'
                AND interval_end = '2005-07-01 14:59:59'
                AND ad_id = 2
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        // 87,600 Total target - 100 + $adTwoImpressions already, IOs remaining:
        // - 10 to end of day                           =   10
        // - 30 * 24 to end of July                     =  720
        // - 3 * 31 * 24 for August, October, December  = 2232
        // - 2 * 30 * 24 for September, November        = 1440
        // Total:                                       = 4402
        // Weight is 2 of 3
        $this->assertEqual($aRow['required_impressions'], round((87600 - 100 - $adTwoImpressions) / 4402 * 2 / 3));
        // Above priority from 120 impressions available
        $this->assertEqual(round($aRow['priority'], 10), round(round((87600 - 100 - $adTwoImpressions) / 4402 * 2 / 3) / 120, 10));
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                past_zone_traffic_fraction
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                operation_interval = 60
                AND operation_interval_id = $currentOperationIntervalID
                AND interval_start = '2005-07-01 14:00:00'
                AND interval_end = '2005-07-01 14:59:59'
                AND ad_id = 3
                AND zone_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        // 87,600 Total target - 100 + $adThreeImpressions already, IOs remaining:
        // - 10 to end of day                           =   10
        // - 30 * 24 to end of July                     =  720
        // - 3 * 31 * 24 for August, October, December  = 2232
        // - 2 * 30 * 24 for September, November        = 1440
        // Total:                                       = 4402
        // Weight is 1 of 3
        $this->assertEqual($aRow['required_impressions'], round((87600 - 100 - $adThreeImpressions) / 4402 * 1 / 3));
        // Above priority from 120 impressions available
        $this->assertEqual(round($aRow['priority'], 10), round(round((87600 - 100 - $adThreeImpressions) / 4402 * 1 / 3) / 120, 10));
        $this->assertEqual($aRow['priority_factor'], 1);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                priority > 0";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 8);

        TestEnv::restoreEnv();
    }

}

?>
