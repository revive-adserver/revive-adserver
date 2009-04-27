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

// This test was written with a ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS value
// of 10 in mind. As a result, this needs to be defined at the start of the
// test to ensure that the current version of the constant, defined in the
// ZIF class, is not used instead
define('ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS', 10);

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the getZoneImpressionForecasts() method of the
 * non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Priority_getZoneImpressionForecasts extends UnitTestCase
{
    var $doZones = null;
    var $doHist = null;

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getZoneImpressionForecasts()
    {
        $this->UnitTestCase();
    }

    /**
     * The method to test the getZoneImpressionForecasts() method.
     *
     * Test 1: Test with no date registered in the OA_ServiceLocator, and ensure that
     *         false is returned.
     * Test 2: Test with a date registered in the OA_ServiceLocator, but no data in
     *         the database, and ensure that an empty array is returned.
     * Test 3: Test with zones in the system, but no forecasts, and ensure that
     *         the default forecast value is returned for all the zones.
     * Test 4: Test with the same zones, but with forecasts > the default forecast
     *         value, and ensure that the correct forecasts are returned for all
     *         the zones.
     * Test 5: Test with the same zones, but with forecasts > and < the default
     *         forecast value, and ensure that the correct forecasts are returned
     *         for all the zones.
     * Test 6: Re-test, but also include a new zone, and older zone forecasts.
     */
    function testGetZoneImpressionForecasts()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oDal = new OA_Dal_Maintenance_Priority();

        // Test 1
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $result = $oDal->getZoneImpressionForecasts();
        $this->assertFalse($result);

        // Test 2
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);

        // Test 3
        $aZoneIds = $this->_generateTestZones(2);
        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[$aZoneIds[0]], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS);
        $this->assertEqual($result[$aZoneIds[1]], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 4
        $aZoneIds = $this->_generateTestZones(2);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->_generateTestHistory($aZoneIds[0], $aDates, 20);
        $this->_generateTestHistory($aZoneIds[1], $aDates, 40);

        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[$aZoneIds[0]], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS + 20);
        $this->assertEqual($result[$aZoneIds[1]], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS + 40);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 5
        $aZoneIds = $this->_generateTestZones(2);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->_generateTestHistory($aZoneIds[0], $aDates, -1);
        $this->_generateTestHistory($aZoneIds[1], $aDates, 40);

        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[$aZoneIds[0]], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS);
        $this->assertEqual($result[$aZoneIds[1]], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS + 40);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 6
        $aZoneIds = $this->_generateTestZones(3);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->_generateTestHistory($aZoneIds[0], $aDates, -1);
        $this->_generateTestHistory($aZoneIds[1], $aDates, 40);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $this->_generateTestHistory($aZoneIds[0], $aDates, 100);
        $this->_generateTestHistory($aZoneIds[1], $aDates, 100);

        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 3);
        $this->assertEqual($result[$aZoneIds[0]], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS);
        $this->assertEqual($result[$aZoneIds[1]], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS + 40);
        $this->assertEqual($result[$aZoneIds[2]], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS);
        DataGenerator::cleanUp();

    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _generateTestZones($numZones)
    {
        $oNow = new Date();
        if (is_null($this->doZones))
        {
            $this->doZones = OA_Dal::factoryDO('zones');
        }
        $doZones->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        return DataGenerator::generate($this->doZones,$numZones);
    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _generateTestHistory($idZone, $aDates, $adjustment)
    {
        if (is_null($this->doHist))
        {
            $this->doHist = OA_Dal::factoryDO('data_summary_zone_impression_history');
        }
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->doHist->operation_interval = $conf['maintenance']['operationInterval'];
        $this->doHist->operation_interval_id = OX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $this->doHist->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $this->doHist->interval_end   = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $this->doHist->zone_id = $idZone;
        $this->doHist->forecast_impressions = ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS + $adjustment;
        $idHist = DataGenerator::generateOne($this->doHist);
    }

}

?>
