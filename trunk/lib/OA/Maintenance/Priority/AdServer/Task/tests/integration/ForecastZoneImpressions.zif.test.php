<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/AdServer/Task/LogCompletion.php';

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ForecastZoneImpressions.php';

/**
 * A class for testing the OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test that the Zone Impression Forecasting works as expected from
     * a fresh installation.
     */
    function testRun()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;
        $oServiceLocator =& OA_ServiceLocator::instance();

        ////////////////////////////////////////////////////////////////////////////////
        // Start off with two zones, but no linked banners, and a clean installation  //
        // (i.e. the MSE and MPE have never been run before) and ensure that the      //
        // correct ZIF values are set for zone ID 0 only, for the required operation  //
        // intervals                                                                  //
        ////////////////////////////////////////////////////////////////////////////////

        // Add the initial two zones
        $doZones = OA_Dal::factoryDO('zones');
        $oNow = new Date();
        $doZones->zonename = 'First Zone';
        $doZones->zonetype = 3;
        $doZones->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idZoneFirst = DataGenerator::generateOne($doZones, true);

        $doZones = OA_Dal::factoryDO('zones');
        $oNow = new Date();
        $doZones->zonename = 'Second Zone';
        $doZones->zonetype = 3;
        $doZones->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idZoneSecond = DataGenerator::generateOne($doZones, true);

        // Set the "current" time that the MPE is running at
        $oNowDate = new Date('2007-09-18 14:01:00');
        $oServiceLocator->register('now', $oNowDate);

        // NUMBER 1: Run the ZIF task
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $oTask->run();

        // Inspect the results of the ZIF NUMBER 1 run from the
        // data_summary_zone_impression_history table
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->orderBy('zone_id');
        $doData_summary_zone_impression_history->orderBy('interval_start');
        $doData_summary_zone_impression_history->find();
        $storedForecasts   = $doData_summary_zone_impression_history->getRowCount();
        $expectedForecasts = OA_OperationInterval::operationIntervalsPerWeek() * 1;
        $this->assertEqual($storedForecasts, $expectedForecasts);
        // For the Zone ID 0 zone...
        for ($zoneId = 0; $zoneId < 1; $zoneId++) {
            // Set the start date and start operation interval ID based on the
            // fact that it should have forecast for the week up to the
            // operation interval starting at "2007-09-18 14:00:00" (ID 62),
            // that is, from "2007-09-11 15:00:00" (ID 63).
            $oStartDate = new Date('2007-09-11 15:00:00');
            $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStartDate);
            $operationIntervalId = 63;
            // For each operation interval in the week...
            for ($counter = 0; $counter < OA_OperationInterval::operationIntervalsPerWeek(); $counter ++) {
                // Get the data row from the database
                $doData_summary_zone_impression_history->fetch();
                $aRow = $doData_summary_zone_impression_history->toArray();
                // Compare the data with that which is expected
                $this->assertEqual($aRow['zone_id'], $zoneId);
                $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
                $this->assertEqual($aRow['operation_interval_id'], $operationIntervalId);
                $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                $this->assertEqual($aRow['forecast_impressions'], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS);
                $this->assertEqual($aRow['actual_impressions'], '');
                // Move on to the next operation interval start date and ID
                $aDates = OA_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($aDates['start']);
                $operationIntervalId = OA_OperationInterval::nextOperationIntervalID($operationIntervalId);
            }
        }

        ////////////////////////////////////////////////////////////////////////////////
        // Move on to the next operation interval, but this time link the two zones   //
        // to active banners to ensure that they are considered to be active banners  //
        ////////////////////////////////////////////////////////////////////////////////

        $doBanners = OA_Dal::factoryDO('banners');
        $oNow = new Date();
        $doBanners->status = OA_ENTITY_STATUS_RUNNING;
        $doBanners->acls_updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idBanner = DataGenerator::generateOne($doBanners, true);

        $doAdZone = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZone->ad_id = $idBanner;
        $doAdZone->zone_id = $idZoneFirst;
        $doAdZone->priority = 0;
        $doAdZone->link_type = 1;
        $doAdZone->priority_factor = 1;
        $doAdZone->to_be_delivered = 1;
        $idAdZone = DataGenerator::generateOne($doAdZone);

        $doAdZone = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZone->ad_id = $idBanner;
        $doAdZone->zone_id = $idZoneSecond;
        $doAdZone->priority = 0;
        $doAdZone->link_type = 1;
        $doAdZone->priority_factor = 1;
        $doAdZone->to_be_delivered = 1;
        $idAdZone = DataGenerator::generateOne($doAdZone);

        // Set the "current" time that the MPE is running at
        $oNowDate = new Date('2007-09-18 15:01:00');
        $oServiceLocator->register('now', $oNowDate);

        // NUMBER 2: Run the ZIF task
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $oTask->run();

        // For the Zone ID 0 zone, check that the NUMBER 1 task data is still present
        $this->_inspectNumber1();

        // Inspect the results of the ZIF NUMBER 2 run from the
        // data_summary_zone_impression_history table
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->orderBy('zone_id');
        $doData_summary_zone_impression_history->orderBy('interval_start');
        $doData_summary_zone_impression_history->whereAdd("interval_start >= '2007-09-11 16:00:00'");
        $doData_summary_zone_impression_history->find();
        $storedForecasts   = $doData_summary_zone_impression_history->getRowCount();
        $expectedForecasts = OA_OperationInterval::operationIntervalsPerWeek() * 3;
//        echo "<pre>";
//        var_dump($storedForecasts);
//        var_dump($expectedForecasts);
        $this->assertEqual($storedForecasts, $expectedForecasts);
        // For the Zone ID 0 zone and the two "real" zones...
        for ($zoneId = 0; $zoneId < 3; $zoneId++) {
            // Set the start date and start operation interval ID based on the
            // fact that it should have forecast for the week up to the
            // operation interval starting at "2007-09-18 15:00:00" (ID 63),
            // that is, from "2007-09-11 16:00:00" (ID 64).
            $oStartDate = new Date('2007-09-11 16:00:00');
            $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStartDate);
            $operationIntervalId = 64;
            // For each operation interval in the week...
            for ($counter = 0; $counter < OA_OperationInterval::operationIntervalsPerWeek(); $counter ++) {
                // Get the data row from the database
                $doData_summary_zone_impression_history->fetch();
                $aRow = $doData_summary_zone_impression_history->toArray();
                // Compare the data with that which is expected
                $this->assertEqual($aRow['zone_id'], $zoneId);
                $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
                $this->assertEqual($aRow['operation_interval_id'], $operationIntervalId);
                $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                $this->assertEqual($aRow['forecast_impressions'], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS);
                $this->assertEqual($aRow['actual_impressions'], '');
                // Move on to the next operation interval start date and ID
                $aDates = OA_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($aDates['start']);
                $operationIntervalId = OA_OperationInterval::nextOperationIntervalID($operationIntervalId);
            }
        }

        ////////////////////////////////////////////////////////////////////////////////
        // Move on to the next operation interval, but this time set the MSE to have  //
        // run, and for the First Zone to have delivered impressions in the previous  //
        // operation interval                                                         //
        ////////////////////////////////////////////////////////////////////////////////

        // Get the operation interval ID and start/end dates from the "previous"
        // operation interval where the statistics is to be placed
        $operationInterval = OA_OperationInterval::convertDateToOperationIntervalID($oNowDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNowDate);

        // Insert the impressions actually delivered for the First Zone
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->zone_id = $idZoneFirst;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->find();
        $doData_summary_zone_impression_history->fetch();
        $doData_summary_zone_impression_history->actual_impressions = 2000;
        $doData_summary_zone_impression_history->update();

        // Set the "current" time that the MPE is running at
        $oNowDate = new Date('2007-09-18 16:01:00');
        $oServiceLocator->register('now', $oNowDate);

        // Insert the fact that the MSE has run "now" (but before the MPE)
        $oLogCompletion = new OA_Maintenance_Statistics_AdServer_Task_LogCompletion();
        $oLogCompletion->oController->updateIntermediate = true;
        $oLogCompletion->oController->updateFinal        = true;
        $oLogCompletion->oController->oUpdateIntermediateToDate = $aDates['end'];
        $oLogCompletion->oController->oUpdateFinalToDate        = $aDates['end'];
        $oLogCompletion->run($oNowDate);

        // NUMBER 3: Run the ZIF task
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $oTask->run();

        // For the Zone ID 0 zone, check that the NUMBER 1 task data is still present
        $this->_inspectNumber1();

        // For the Zone ID 0 zone and the two "real" zones, check that the NUMBER 2 task data is still present
        $this->_inspectNumber2();

        // Inspect the results of the ZIF NUMBER 3 run from the
        // data_summary_zone_impression_history table
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->orderBy('zone_id');
        $doData_summary_zone_impression_history->orderBy('interval_start');
        $doData_summary_zone_impression_history->whereAdd("interval_start >= '2007-09-11 17:00:00'");
        $doData_summary_zone_impression_history->find();
        $storedForecasts   = $doData_summary_zone_impression_history->getRowCount();
        $expectedForecasts = OA_OperationInterval::operationIntervalsPerWeek() * 3;
        $this->assertEqual($storedForecasts, $expectedForecasts);
        // For the Zone ID 0 zone and the two "real" zones...
        for ($zoneId = 0; $zoneId < 3; $zoneId++) {
            // Set the start date and start operation interval ID based on the
            // fact that it should have forecast for the week up to the
            // operation interval starting at "2007-09-18 16:00:00" (ID 63),
            // that is, from "2007-09-11 17:00:00" (ID 65).
            $oStartDate = new Date('2007-09-11 17:00:00');
            $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStartDate);
            $operationIntervalId = 65;
            // For each operation interval in the week...
            for ($counter = 0; $counter < OA_OperationInterval::operationIntervalsPerWeek(); $counter ++) {
                // Get the data row from the database
                $doData_summary_zone_impression_history->fetch();
                $aRow = $doData_summary_zone_impression_history->toArray();
                // Compare the data with that which is expected
                $this->assertEqual($aRow['zone_id'], $zoneId);
                $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
                $this->assertEqual($aRow['operation_interval_id'], $operationIntervalId);
                $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
                $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
                if ($aRow['zone_id'] == $idZoneFirst) {
                    $this->assertEqual($aRow['forecast_impressions'], 2000);
                } else {
                    $this->assertEqual($aRow['forecast_impressions'], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS);
                }
                if (($aRow['zone_id'] == $idZoneFirst) && ($aRow['operation_interval_id'] == 63)) {
                    $this->assertEqual($aRow['actual_impressions'], 2000);
                } else {
                    $this->assertEqual($aRow['actual_impressions'], '');
                }
                // Move on to the next operation interval start date and ID
                $aDates = OA_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($aDates['start']);
                $operationIntervalId = OA_OperationInterval::nextOperationIntervalID($operationIntervalId);
            }
        }

        DataGenerator::cleanUp();
    }

    /**
     * A private method to inspect just the ZIF data generated
     * in the NUMBER 1 run of the test.
     *
     * @access private
     */
    function _inspectNumber1()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->orderBy('zone_id');
        $doData_summary_zone_impression_history->orderBy('interval_start');
        $doData_summary_zone_impression_history->whereAdd("interval_start = '2007-09-11 15:00:00'");
        $doData_summary_zone_impression_history->find();
        $storedForecasts   = $doData_summary_zone_impression_history->getRowCount();
        $expectedForecasts = 1;
        $this->assertEqual($storedForecasts, $expectedForecasts);
        // For the Zone ID 0 zone...
        for ($zoneId = 0; $zoneId < 1; $zoneId++) {
            // Use the same date and ID values as for the NUMBER 1 test above
            $oStartDate = new Date('2007-09-11 15:00:00');
            $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStartDate);
            $operationIntervalId = 63;
            // Get the data row from the database
            $doData_summary_zone_impression_history->fetch();
            $aRow = $doData_summary_zone_impression_history->toArray();
            // Compare the data with that which is expected
            $this->assertEqual($aRow['zone_id'], $zoneId);
            $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
            $this->assertEqual($aRow['operation_interval_id'], $operationIntervalId);
            $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
            $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
            $this->assertEqual($aRow['forecast_impressions'], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS);
            $this->assertEqual($aRow['actual_impressions'], '');
        }
    }

    /**
     * A private method to inspect just the ZIF data generated
     * in the NUMBER 2 run of the test.
     *
     * @access private
     */
    function _inspectNumber2()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->orderBy('zone_id');
        $doData_summary_zone_impression_history->orderBy('interval_start');
        $doData_summary_zone_impression_history->whereAdd("interval_start = '2007-09-11 16:00:00'");
        $doData_summary_zone_impression_history->find();
        $storedForecasts   = $doData_summary_zone_impression_history->getRowCount();
        $expectedForecasts = 3;
        $this->assertEqual($storedForecasts, $expectedForecasts);
        // For the Zone ID 0 zone and the two "real" zones...
        for ($zoneId = 0; $zoneId < 3; $zoneId++) {
            // Use the same date and ID values as for the NUMBER 2 test above
            $oStartDate = new Date('2007-09-11 16:00:00');
            $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStartDate);
            $operationIntervalId = 64;
            // Get the data row from the database
            $doData_summary_zone_impression_history->fetch();
            $aRow = $doData_summary_zone_impression_history->toArray();
            // Compare the data with that which is expected
            $this->assertEqual($aRow['zone_id'], $zoneId);
            $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
            $this->assertEqual($aRow['operation_interval_id'], $operationIntervalId);
            $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
            $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
            $this->assertEqual($aRow['forecast_impressions'], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS);
            $this->assertEqual($aRow['actual_impressions'], '');
        }
    }

}

?>