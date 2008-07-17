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
 * A class for testing the getRecentZones() method of the non-DB specific
 * OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Priority_getRecentZones extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getRecentZones()
    {
        $this->UnitTestCase();
    }

    /**
     * The method to test the getRecentZones() method.
     */
    function testGetRecentZones()
    {
        $oDal = new OA_Dal_Maintenance_Priority();

        // Test with bad input
        $aZoneIds = 'foo';
        $oNowDate = new Date('2007-09-19 12:00:00');
        $aResult = $oDal->getRecentZones($aZoneIds, $oNowDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aZoneIds = array();
        $aResult = $oDal->getRecentZones($aZoneIds, $oNowDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aZoneIds = array();
        $aZoneIds[] = 'foo';
        $aResult = $oDal->getRecentZones($aZoneIds, $oNowDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Set a valid zone ID array
        $aZoneIds = array();
        $aZoneIds[] = 1;
        $aZoneIds[] = 2;
        $aZoneIds[] = 3;

        $oNowDate = 'foo';
        $aResult = $oDal->getRecentZones($aZoneIds, $oNowDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Re-set the valid "now" date
        $oNowDate = new Date('2007-09-19 12:00:00');

        // Test with no zones in the system, no set zone
        // IDs should be returned as being recent (they
        // are new zones, not recent zones!)
        $aResult = $oDal->getRecentZones($aZoneIds, $oNowDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Add zone information that is NOT based on the
        // default ZIF value, and re-test, expecting the
        // same result as above
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = 0;
        $doData_summary_zone_impression_history->interval_start = '2007-09-23 00:00:00';
        $doData_summary_zone_impression_history->interval_end = '2007-09-23 00:59:59';
        $doData_summary_zone_impression_history->zone_id = 2;
        $doData_summary_zone_impression_history->forecast_impressions = 37;
        $doData_summary_zone_impression_history->est = 0;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getRecentZones($aZoneIds, $oNowDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Add zone information that IS based on the default
        // ZIF value, but is much older than one week from the
        // current date, and re-test, expecting the same result
        // as above
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = 0;
        $doData_summary_zone_impression_history->interval_start = '2007-09-12 12:00:00';
        $doData_summary_zone_impression_history->interval_end = '2007-09-12 12:59:59';
        $doData_summary_zone_impression_history->zone_id = 2;
        $doData_summary_zone_impression_history->forecast_impressions = ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS;
        $doData_summary_zone_impression_history->est = 1;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getRecentZones($aZoneIds, $oNowDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Add zone information that IS based on the default
        // ZIF value, and is within the past week, and re-test,
        // expecting the zone to now be included in the results
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = 0;
        $doData_summary_zone_impression_history->interval_start = '2007-09-12 13:00:00';
        $doData_summary_zone_impression_history->interval_end = '2007-09-12 13:59:59';
        $doData_summary_zone_impression_history->zone_id = 2;
        $doData_summary_zone_impression_history->forecast_impressions = ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS;
        $doData_summary_zone_impression_history->est = 1;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getRecentZones($aZoneIds, $oNowDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(in_array(2, $aResult));

        // Test the same thing again, but with a more recent value
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = 0;
        $doData_summary_zone_impression_history->interval_start = '2007-09-19 00:00:00';
        $doData_summary_zone_impression_history->interval_end = '2007-09-19 00:59:59';
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->forecast_impressions = ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS;
        $doData_summary_zone_impression_history->est = 1;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getRecentZones($aZoneIds, $oNowDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertTrue(in_array(1, $aResult));
        $this->assertTrue(in_array(2, $aResult));

        // Finally, test with dodgy future data
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = 0;
        $doData_summary_zone_impression_history->interval_start = '2007-09-20 00:00:00';
        $doData_summary_zone_impression_history->interval_end = '2007-09-20 00:59:59';
        $doData_summary_zone_impression_history->zone_id = 3;
        $doData_summary_zone_impression_history->forecast_impressions = ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS;
        $doData_summary_zone_impression_history->est = 1;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getRecentZones($aZoneIds, $oNowDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertTrue(in_array(1, $aResult));
        $this->assertTrue(in_array(2, $aResult));

        DataGenerator::cleanUp();
    }

}

?>