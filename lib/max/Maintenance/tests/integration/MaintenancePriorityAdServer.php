<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
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
$Id$
*/

require_once MAX_PATH . '/variables.php';
require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer.php';
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/AdServer.php';
require_once 'Date.php';
require_once 'Date/Span.php';

/**
 * A parent class for Maintenance Priority AdServer integration tests, containing
 * common testing methods.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Maintenance_TestOfMaintenancePriorityAdServer extends UnitTestCase
{

    /**
     * A local instance of the database handler object.
     *
     * @var MDB2_Driver_Common
     */
    var $oDbh;

    /**
     * A local instance of the service locator.
     *
     * @var ServiceLocator
     */
    var $oServiceLocator;

    /**
     * The number of operation intervals per week.
     *
     * @var integer
     */
    var $intervalsPerWeek;

    /**
     * A method to be run before all tests.
     */
    function setUp()
    {
        // Set up the configuration array to have an operation interval
        // of 60 minutes, and set the timezone to GMT
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['timezone']['location'] = 'GMT';
        setTimeZoneLocation($aConf['timezone']['location']);

        // Set up the database handler object
        $this->oDbh = &OA_DB::singleton();

        // Set up the service locator object
        $this->oServiceLocator = &ServiceLocator::instance();

        // Discover the number of operation intervals per week
        $this->intervalsPerWeek = OA_OperationInterval::operationIntervalsPerWeek();
    }

    /**
     * A method to be run after all tests.
     */
    function tearDown()
    {
        // Clean up the testing environment
        TestEnv::restoreEnv();
    }

    /**
     * A private method to get the number of rows currently in the
     * ad_zone_assoc table.
     *
     * @access private
     * @param boolean $limit Limit the rows counted to those where
     *                       the priority value is > 0? Default is false.
     * @return integer The number of rows in the table.
     */
    function _azaRows($limit = false)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $tableName = $aConf['table']['prefix'] . 'ad_zone_assoc';
        return $this->_getRows($tableName, $limit);
    }

    /**
     * A private method to get the number of rows currently in the
     * data_summary_ad_zone_assoc table.
     *
     * @access private
     * @param boolean $limit Limit the rows counted to those where
     *                       the priority value is > 0? Default is false.
     * @return integer The number of rows in the table.
     */
    function _dsazaRows($limit = false)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $tableName = $aConf['table']['prefix'] . 'data_summary_ad_zone_assoc';
        return $this->_getRows($tableName, $limit);
    }

    /**
     * A private method to get the number of rows currently in the
     * data_summary_zone_impression_history table.
     *
     * @access private
     * @param boolean $limit Limit the rows counted to those where
     *                       the priority value is > 0? Default is false.
     * @return integer The number of rows in the table.
     */
    function _dszihRows($limit = false)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $tableName = $aConf['table']['prefix'] . 'data_summary_zone_impression_history';
        return $this->_getRows($tableName, $limit);
    }

    /**
     * A private function to get the number of rows from a
     * specified table.
     *
     * @access private
     * @param string $tableName The name of the table to get the
     *                          number of rows of, including the table
     *                          prefix, if required.
     * @param boolean $limit Limit the rows counted to those where
     *                       the priority value is > 0?
     * @return integer The number of rows in the table.
     */
    function _getRows($tableName, $limit)
    {
        $table = $this->oDbh->quoteIdentifier($tableName, true);
        $query = "
            SELECT
                count(*) AS number
            FROM
                $table";
        if ($limit) {
            $query .= "
            WHERE
                priority > 0";
        }
        $rc = $this->oDbh->query($query);
        $aRow = $rc->fetchRow();
        return $aRow['number'];
    }

    /**
     * A private method to validate one specific operation interval's
     * values in the data_summary_zone_impression_history table.
     *
     * @access private
     * @param PEAR::Date $oDate The operation interval start date for the
     *                          operation interval to test.
     */
    function _validateDszihRowsSpecific($oDate)
    {
        $oStartDate = new Date();
        $oStartDate->copy($oDate);
        $oEndDate = new Date();
        $oEndDate->copy($oDate);
        $this->_validateDszihRowsRange($oStartDate, $oEndDate);
    }

    /**
     * A private method to validate a range of values in the
     * data_summary_zone_impression_history table. Requires that
     * the range exist within a single week!
     *
     * @access private
     * @param PEAR::Date $oStartDate The start date of the operation interval to begin
     *                               testing with.
     * @param PEAR::Date $oEndDate The start date of the operation interval to end
     *                             testing with.
     */
    function _validateDszihRowsRange($oStartDate, $oEndDate)
    {
        $startOperationIntervalID = OA_OperationInterval::convertDateToOperationIntervalID($oStartDate);
        $endOperationIntervalID = OA_OperationInterval::convertDateToOperationIntervalID($oEndDate);
        $aConf = $GLOBALS['_MAX']['CONF'];
        $tableName = $aConf['table']['prefix'] . 'data_summary_zone_impression_history';
        $table = $this->oDbh->quoteIdentifier($tableName, true);
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
                $table
            WHERE
                interval_start >= '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "'
                AND interval_start <= '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'
            ORDER BY
                interval_start, zone_id";
        $rc = $this->oDbh->query($query);
        $oTestStartDate = new Date();
        $oTestStartDate->copy($oStartDate);
        $oTestEndDate = new Date();
        $oTestEndDate->copy($oStartDate);
        $oTestEndDate->addSeconds(($aConf['maintenance']['operationInterval'] * 60) - 1);
        for ($counter = $startOperationIntervalID; $counter <= $endOperationIntervalID; $counter++) {
            for ($zoneID = 0; $zoneID <= 4; $zoneID++) {
                if ($zoneID == 2) {
                    continue;
                }
                $aRow = $rc->fetchRow();
                $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
                $this->assertEqual($aRow['operation_interval_id'], OA_OperationInterval::convertDateToOperationIntervalID($oTestStartDate));
                $this->assertEqual($aRow['interval_start'], $oTestStartDate->format('%Y-%m-%d %H:%M:%S'));
                $this->assertEqual($aRow['interval_end'], $oTestEndDate->format('%Y-%m-%d %H:%M:%S'));
                $this->assertEqual($aRow['zone_id'], $zoneID);
                $this->assertEqual($aRow['forecast_impressions'], $aConf['priority']['defaultZoneForecastImpressions']);
                $this->assertNull($aRow['actual_impressions']);
            }
            $oTestStartDate->addSeconds(OA_OperationInterval::secondsPerOperationInterval());
            $oTestEndDate->addSeconds(OA_OperationInterval::secondsPerOperationInterval());
        }
    }

    /**
     * A private method for performing assertions on priority values
     * that should be set in the ad_zone_assoc and
     * data_summary_ad_zone_assoc tables.
     *
     * @access private
     * @param array $aParams An array of values to test, specifically:
     *
     * array(
     *     'ad_id'           => The ad ID to test.
     *     'zone_id'         => The zone ID to test.
     *     'priority'        => The ad/zone priority that should be set.
     *     'priority_factor' => The ad/zone priority factor that should be set.
     *     'history'         => An array of arrays of values to assert in the
     *                          data_summary_ad_zone_assoc table.
     * )
     *
     * The "history" arrays should be of in the following format:
     *
     * array(
     *     'operation_interval'         => The operation interval to test.
     *     'operation_interval_id'      => The operation interval ID to test.
     *     'interval_start'             => The operation interval start to test.
     *     'interval_end'               => The operation interval end to test.
     *     'required_impressions'       => The ad/zone required impressions that should be set.
     *     'requested_impressions'      => The ad/zone requested impressions that should be set.
     *     'priority'                   => The ad/zone priority that should be set.
     *     'priority_factor'            => The ad/zone priority factor that should be set.
     *     'past_zone_traffic_fraction' => The ad/zone past zone traffic fraction that should be set.
     * )
     */
    function _assertPriority($aParams)
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();

        $tableAza   = $oDbh->quoteIdentifier($aConf['table']['prefix'].'ad_zone_assoc', true);
        $tableDsaza = $oDbh->quoteIdentifier($aConf['table']['prefix'].'data_summary_ad_zone_assoc', true);

        // Assert the values in the ad_zone_assoc table are correct
        $query = "
            SELECT
                priority,
                priority_factor
            FROM
                {$tableAza}
            WHERE
                ad_id = {$aParams['ad_id']}
                AND zone_id = {$aParams['zone_id']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual((string) $aRow['priority'], (string) $aParams['priority']);
        $this->assertEqual($aRow['priority_factor'], $aParams['priority_factor']);
        // Assert the values in the data_summary_ad_zone_assoc table are correct
        if (is_array($aParams['history']) && !empty($aParams['history'])) {
            foreach ($aParams['history'] as $aTestData) {
                $query = "
                    SELECT
                        required_impressions,
                        requested_impressions,
                        priority,
                        priority_factor,
                        past_zone_traffic_fraction
                    FROM
                        {$tableDsaza}
                    WHERE
                        operation_interval = {$aTestData['operation_interval']}
                        AND operation_interval_id = {$aTestData['operation_interval_id']}
                        AND interval_start = '{$aTestData['interval_start']}'
                        AND interval_end = '{$aTestData['interval_end']}'
                        AND ad_id = {$aParams['ad_id']}
                        AND zone_id = {$aParams['zone_id']}";
                $rc = $oDbh->query($query);
                $aRow = $rc->fetchRow();
                $this->assertEqual($aRow['required_impressions'], $aTestData['required_impressions']);
                $this->assertEqual($aRow['requested_impressions'], $aTestData['requested_impressions']);
                $this->assertEqual((string) $aRow['priority'], (string) $aTestData['priority']);
                $this->assertEqual($aRow['priority_factor'], $aTestData['priority_factor']);
                $this->assertEqual($aRow['past_zone_traffic_fraction'], $aTestData['past_zone_traffic_fraction']);
            }
        }
    }

    /**
     * A private method to perform assertions on the contents of the
     * log_maintenance_priority table.
     *
     * @access private
     * @param integer    $id Optional row ID to test on, if not set, tests
     *                       that table is empty.
     * @param PEAR::Date $oBeforeUpdateDate The before date to test the row with.
     * @param PEAR::Date $oAfterUpdateDate The after date to test the row with.
     * @param integer    $oi The operation interval to test the row with.
     * @param integer    $runType The run type value to test the row with.
     * @param string     $updatedTo The updated to date to test the row with, if any.
     */
    function _assertLogMaintenance($id = null, $oBeforeUpdateDate = null, $oAfterUpdateDate = null, $oi = null, $runType = null, $updatedTo = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $tableName = $aConf['table']['prefix'] . 'log_maintenance_priority';
        $table = $this->oDbh->quoteIdentifier($tableName, true);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                $table";
        if (!is_null($id)) {
            $query .= "
            WHERE
                log_maintenance_priority_id = $id";
        }
        $rc = $this->oDbh->query($query);
        $aRow = $rc->fetchRow();
        if (is_null($id)) {
            // Check there are no rows returned
            $this->assertNull($aRow);
        } else {
            // Check the returned row's values
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
            $this->assertEqual($aRow['operation_interval'], $oi);
            $this->assertEqual($aRow['run_type'], $runType);
            if (!is_null($updatedTo)) {
                $this->assertEqual($aRow['updated_to'], $updatedTo);
            } else {
                $this->assertNull($aRow['updated_to']);
            }
        }
    }


}

?>