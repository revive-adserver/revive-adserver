<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ForecastZoneImpressions.php';

/**
 * A class for testing the updatePastZoneImpressionForecasts() method of the
 * non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Priority_updatePastZoneImpressionForecasts extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_updatePastZoneImpressionForecasts()
    {
        $this->UnitTestCase();
    }

    /**
     * The method to test the updatePastZoneImpressionForecasts() method.
     */
    function testUpdatePastZoneImpressionForecasts()
    {
        $oDal = new OA_Dal_Maintenance_Priority();

        // Prepare real parameters
        $aForecast = array(
            1 => ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS + 10
        );
        $oDateNow = new Date('2007-09-16 12:00:00');
        $oStartDate = new Date();
        $oStartDate->copy($oDateNow);
        $oStartDate->subtractSeconds(SECONDS_PER_WEEK - OA_OperationInterval::secondsPerOperationInterval());

        // Insert a very old default ZIF value
        $oDate = new Date('2007-01-01 12:00:00');
        $operationIntervalId = OA_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->forecast_impressions = ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS;
        $doData_summary_zone_impression_history->est = 1;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $oldDateRowId = $id;

        // Insert a recent default ZIF value
        $oDate = new Date('2007-09-15 11:00:00');
        $operationIntervalId = OA_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->forecast_impressions = ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS;
        $doData_summary_zone_impression_history->est = 1;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        // Insert another recent default ZIF value
        $oDate = new Date('2007-09-16 09:00:00');
        $operationIntervalId = OA_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->forecast_impressions = ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS;
        $doData_summary_zone_impression_history->est = 1;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        // Insert a recent non-default ZIF value
        $oDate = new Date('2007-09-16 11:00:00');
        $operationIntervalId = OA_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->forecast_impressions = ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS;
        $doData_summary_zone_impression_history->est = 0;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        // Insert a recent default ZIF value for a different zone
        $oDate = new Date('2007-09-16 08:00:00');
        $operationIntervalId = OA_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 2;
        $doData_summary_zone_impression_history->forecast_impressions = ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS;
        $doData_summary_zone_impression_history->est = 1;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        // Test with bad input
        $aBadForecast = 'foo';
        $oDal->updatePastZoneImpressionForecasts($aBadForecast, $oStartDate);
        $this->_testUnchanged();

        $aBadForecast = -1;
        $oDal->updatePastZoneImpressionForecasts($aBadForecast, $oStartDate);
        $this->_testUnchanged();

        $badDate = 'foo';
        $oDal->updatePastZoneImpressionForecasts($aForecast, $badDate);
        $this->_testUnchanged();

        // Test with the date in the future
        $oFutureDate = new Date('2007-10-01 00:00:00');
        $oDal->updatePastZoneImpressionForecasts($aForecast, $oFutureDate);
        $this->_testUnchanged();

        // Test update
        $oDal->updatePastZoneImpressionForecasts($aForecast, $oStartDate);
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->find();
        while ($doData_summary_zone_impression_history->fetch()) {
            $aRow = $doData_summary_zone_impression_history->toArray();
            if ($aRow['data_summary_zone_impression_history_id'] == $oldDateRowId || $aRow['est'] == 0 || $aRow['zone_id'] == 2) {
                $this->assertEqual($aRow['forecast_impressions'], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS);
            } else {
                $this->assertEqual($aRow['forecast_impressions'], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS + 10);
            }
        }

        DataGenerator::cleanUp();
    }

    /**
     * A private method to check that the past ZIF data has not been updated.
     *
     * @access private
     */
    function _testUnchanged()
    {
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->find();
        while ($doData_summary_zone_impression_history->fetch()) {
            $aRow = $doData_summary_zone_impression_history->toArray();
            $this->assertEqual($aRow['forecast_impressions'], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS);
        }
    }
}

?>