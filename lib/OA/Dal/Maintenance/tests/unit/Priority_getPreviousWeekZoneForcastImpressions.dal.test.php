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

/**
 * A class for testing the getPreviousWeekZoneForcastImpressions() method of
 * the non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     James Floyd <james@m3.net>
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OA_Dal_Maintenance_Priority_getPreviousWeekZoneForcastImpressions extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getPreviousWeekZoneForcastImpressions()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the getPreviousWeekZoneForcastImpressions() method.
     *
     * Test 1: Test with bad input, and ensure false is returned.
     * Test 2: Test with no date in the service locator, and ensure that
     *         false is returned.
     * Test 3: Test with no data, and ensure that an array with the default
     *         forecast for each zone is returned.
     * Test 4: Test with data, and ensure that an array with the correct
     *         forecasts is returned.
     */
    function testGetPreviousWeekZoneForcastImpressions()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oDal = new OA_Dal_Maintenance_Priority();

        // Test 1
        $aResult = $oDal->getPreviousWeekZoneForcastImpressions('foo');
        $this->assertFalse($aResult);

        // Test 2
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $aResult = $oDal->getPreviousWeekZoneForcastImpressions(1);
        $this->assertFalse($aResult);

        // Test 3
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $aResult = $oDal->getPreviousWeekZoneForcastImpressions(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), OX_OperationInterval::operationIntervalsPerWeek());
        for ($operationIntervalID = 0; $operationIntervalID < OX_OperationInterval::operationIntervalsPerWeek(); $operationIntervalID++) {
            $this->assertTrue(is_array($aResult[$operationIntervalID]));
            $this->assertEqual(count($aResult[$operationIntervalID]), 3);
            $this->assertEqual($aResult[$operationIntervalID]['zone_id'], 1);
            $this->assertEqual($aResult[$operationIntervalID]['forecast_impressions'], $oDal->getZoneForecastDefaultZoneImpressions());
            $this->assertEqual($aResult[$operationIntervalID]['operation_interval_id'], $operationIntervalID);
        }

        // Test 4

        // Insert forcast for this operation interval
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $firstIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);

        $doHist = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doHist->zone_id = 1;
        $doHist->forecast_impressions = 4000;
        $doHist->operation_interval = $aConf['maintenance']['operationInterval'];
        $doHist->operation_interval_id = $firstIntervalID;
        $doHist->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doHist->interval_end   = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $idHist = DataGenerator::generateOne($doHist);

        // Insert forcast for the previous operation interval
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $secondIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);

        $doHist->zone_id = 1;
        $doHist->forecast_impressions = 5000;
        $doHist->operation_interval = $aConf['maintenance']['operationInterval'];
        $doHist->operation_interval_id = $secondIntervalID;
        $doHist->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doHist->interval_end   = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $idHist = DataGenerator::generateOne($doHist);

        // Insert forcast for the second previous operation interval, but
        // one week ago (so it should not be in the result set)
        $oNewDate = new Date();
        $oNewDate->copy($aDates['start']);
        $oNewDate->subtractSeconds(SECONDS_PER_WEEK);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oNewDate);
        $intervalID = OX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);

        $doHist->zone_id = 1;
        $doHist->forecast_impressions = 1000;
        $doHist->operation_interval = $aConf['maintenance']['operationInterval'];
        $doHist->operation_interval_id = $intervalID;
        $doHist->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doHist->interval_end   = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $idHist = DataGenerator::generateOne($doHist);

        $aResult = $oDal->getPreviousWeekZoneForcastImpressions(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), OX_OperationInterval::operationIntervalsPerWeek());
        for ($operationIntervalID = 0; $operationIntervalID < OX_OperationInterval::operationIntervalsPerWeek(); $operationIntervalID++) {
            $this->assertTrue(is_array($aResult[$operationIntervalID]));
            $this->assertEqual(count($aResult[$operationIntervalID]), 3);
            $this->assertEqual($aResult[$operationIntervalID]['zone_id'], 1);
            if ($operationIntervalID == $firstIntervalID) {
                $this->assertEqual($aResult[$operationIntervalID]['forecast_impressions'], 4000);
            } elseif ($operationIntervalID == $secondIntervalID) {
                $this->assertEqual($aResult[$operationIntervalID]['forecast_impressions'], 5000);
            } else {
                $this->assertEqual($aResult[$operationIntervalID]['forecast_impressions'], 4500); // average between both known forecast
            }
            $this->assertEqual($aResult[$operationIntervalID]['operation_interval_id'], $operationIntervalID);
        }

        DataGenerator::cleanUp();
    }
}

?>