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
 * A class for testing the getZonePastImpressionAverage() method of the
 * non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Priority_getZonePastImpressionAverage extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getZonePastImpressionAverage()
    {
        $this->UnitTestCase();
    }

    /**
     * The method to test the getZonePastImpressionAverage() method.
     */
    function testGetZonePastImpressionAverage()
    {
        $oDal = new OA_Dal_Maintenance_Priority();

        $zoneId = 1;

        // Test with bad input
        $badZoneId = 'foo';
        $result = $oDal->getZonePastImpressionAverage($badZoneId);
        $this->assertNull($result);

        $badZoneId = -1;
        $result = $oDal->getZonePastImpressionAverage($badZoneId);
        $this->assertNull($result);

        // Test with no data in the data_summary_zone_impression_history table
        $result = $oDal->getZonePastImpressionAverage($zoneId);
        $this->assertNull($result);

        // Insert a single past value
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->actual_impressions = 50;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $result = $oDal->getZonePastImpressionAverage($zoneId);
        $this->assertEqual($result, 50);

        // Insert a second past value
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->actual_impressions = 50;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $result = $oDal->getZonePastImpressionAverage($zoneId);
        $this->assertEqual($result, 50);

        // Insert a third past value
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->actual_impressions = 200;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $result = $oDal->getZonePastImpressionAverage($zoneId);
        $this->assertEqual($result, 100);

        // Insert a past value for a different zone
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->zone_id = 2;
        $doData_summary_zone_impression_history->actual_impressions = 200;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $result = $oDal->getZonePastImpressionAverage($zoneId);
        $this->assertEqual($result, 100);

        DataGenerator::cleanUp();
    }
}

?>