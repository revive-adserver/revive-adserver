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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the getAllZonesImpInv() method of the non-DB specific
 * OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Priority_getAllZonesImpInv extends UnitTestCase
{
    var $doZones = null;
    var $doHist  = null;

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getAllZonesImpInv()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _generateTestHistory($idZone, $aDates, $forecast, $actual)
    {
        if (is_null($this->doHist))
        {
            $this->doHist = OA_Dal::factoryDO('data_summary_zone_impression_history');
        }
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->doHist->operation_interval = $conf['maintenance']['operationInterval'];
        $this->doHist->operation_interval_id = OA_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $this->doHist->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $this->doHist->interval_end   = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $this->doHist->zone_id = $idZone;
        $this->doHist->forecast_impressions = $forecast;
        $this->doHist->actual_impressions = $actual;
        $idHist = DataGenerator::generateOne($this->doHist);
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
     * Method to test the getAllZonesImpInv method.
     *
     * Requirements:
     * Test 1: Test with no Date registered in the service locator, ensure false returned.
     * Test 2: Test with a Date registered in the service locator, no data in the database,
     *         and ensure no data is returned.
     * Test 3: Test with data NOT in the current OI, and ensure no data is returned.
     * Test 4: Test with data both in, and not in, the current OI, and ensure the correct
     *         data is returned.
     * Test 5: Repeat Test 4, but with additional zones (that don't have data) in the zones
     *         table.
     */
    function testGetAllZonesImpInv()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        // Test 1
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $result =& $oMaxDalMaintenance->getAllZonesImpInv();
        $this->assertFalse($result);

        // Test 2
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $result =& $oMaxDalMaintenance->getAllZonesImpInv();
        $this->assertEqual(count($result), 0);

        // Test 3
        $oDate =& $oServiceLocator->get('now');
        $oNewDate = new Date();
        $oNewDate->copy($oDate);
        $oNewDate->subtractSeconds(($conf['maintenance']['operationInterval'] * 60) + 1);
        $previousOptIntID = OA_OperationInterval::convertDateToOperationIntervalID($oNewDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate);
        $this->_generateTestHistory(1, $aDates, 42, 0);

        $oNewDate = new Date();
        $oNewDate->copy($aDates['start']);
        $oNewDate->subtractSeconds(1);
        $previousPreviousOpIntID = OA_OperationInterval::convertDateToOperationIntervalID($oNewDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate);
        $this->_generateTestHistory(1, $aDates, 37, 0);

        $result =& $oMaxDalMaintenance->getAllZonesImpInv();
        $this->assertEqual(count($result), 0);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 4
        $oDate =& $oServiceLocator->get('now');
        $currentOpIntID = OA_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->_generateTestHistory(1, $aDates, 42, 0);
        $this->_generateTestHistory(2, $aDates, 1, 2);

        $oNewDate = new Date();
        $oNewDate->copy($oDate);
        $oNewDate->subtractSeconds(($conf['maintenance']['operationInterval'] * 60) + 1);
        $previousOptIntID = OA_OperationInterval::convertDateToOperationIntervalID($oNewDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate);
        $this->_generateTestHistory(1, $aDates, 37, 11);
        $this->_generateTestHistory(2, $aDates, 3, 4);
        $this->_generateTestHistory(3, $aDates, 5, 6);

        $oNewDate = new Date();
        $oNewDate->copy($aDates['start']);
        $oNewDate->subtractSeconds(1);
        $previousPreviousOpIntID = OA_OperationInterval::convertDateToOperationIntervalID($oNewDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate);
        $this->_generateTestHistory(1, $aDates, 10, 9);

        $result =& $oMaxDalMaintenance->getAllZonesImpInv();
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[1]['zone_id'], 1);
        $this->assertEqual($result[1]['forecast_impressions'], 42);
        $this->assertEqual($result[1]['actual_impressions'], 11);
        $this->assertEqual($result[2]['zone_id'], 2);
        $this->assertEqual($result[2]['forecast_impressions'], 1);
        $this->assertEqual($result[2]['actual_impressions'], 4);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 5
        $oDate =& $oServiceLocator->get('now');
        $currentOpIntID = OA_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $oNow = new Date();

        $aZones = $this->_generateTestZones(3);

        $this->_generateTestHistory(1, $aDates, 42, 0);
        $this->_generateTestHistory(2, $aDates, 1, 2);

        $oNewDate = new Date();
        $oNewDate->copy($oDate);
        $oNewDate->subtractSeconds(($conf['maintenance']['operationInterval'] * 60) + 1);
        $previousOptIntID = OA_OperationInterval::convertDateToOperationIntervalID($oNewDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate);
        $this->_generateTestHistory(1, $aDates, 37, 11);
        $this->_generateTestHistory(2, $aDates, 3, 4);
        $this->_generateTestHistory(3, $aDates, 5, 6);

        $oNewDate = new Date();
        $oNewDate->copy($aDates['start']);
        $oNewDate->subtractSeconds(1);
        $previousPreviousOpIntID = OA_OperationInterval::convertDateToOperationIntervalID($oNewDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate);
        $this->_generateTestHistory(1, $aDates, 10, 9);

        $result =& $oMaxDalMaintenance->getAllZonesImpInv();
        $this->assertEqual(count($result), 3);
        $this->assertEqual($result[1]['zone_id'], 1);
        $this->assertEqual($result[1]['forecast_impressions'], 42);
        $this->assertEqual($result[1]['actual_impressions'], 11);
        $this->assertEqual($result[2]['zone_id'], 2);
        $this->assertEqual($result[2]['forecast_impressions'], 1);
        $this->assertEqual($result[2]['actual_impressions'], 4);
        $this->assertEqual($result[3]['zone_id'], 3);
        $this->assertEqual($result[3]['forecast_impressions'], ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS);
        $this->assertEqual($result[3]['actual_impressions'], 0);
        DataGenerator::cleanUp();
    }

}

?>