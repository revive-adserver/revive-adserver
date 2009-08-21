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

class Test_OA_Dal_Maintenance_Priority_getLatestAvailableActualImpressionsForZone extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getLatestAvailableActualImpressionsForZone()
    {
        $this->UnitTestCase();
    }

    /**
     * The method to test the getLatestAvailableActualImpressionsForZone() method.
     */
    function test_getLatestAvailableActualImpressionsForZone()
    {
        $oDal = new OA_Dal_Maintenance_Priority();

        $zoneId = 1;
        $weeks = 2;

        // Test with bad input
        $badZoneId = 'foo';
        $impressions = $oDal->getLatestAvailableActualImpressionsForZone($badZoneId);
        $this->assertEqual($impressions, false);

        $badZoneId = -1;
        $impressions = $oDal->getLatestAvailableActualImpressionsForZone($badZoneId);
        $this->assertEqual($impressions, false);

        // Test with no data in the data_summary_zone_impression_history table
        $aResult = $oDal->getLatestAvailableActualImpressionsForZone($zoneId);
        $this->assertEqual($aResult, false);

        // Test with one row
        $oDate = new Date('2007-09-16 11:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->forecast_impressions = 50;
        $doData_summary_zone_impression_history->actual_impressions = 60;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $impressions = $oDal->getLatestAvailableActualImpressionsForZone($zoneId);
        $this->assertEqual($impressions, 60);

        // Test with two rows
        $oDate = new Date('2007-09-16 12:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->forecast_impressions = 70;
        $doData_summary_zone_impression_history->actual_impressions = 80;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $impressions = $oDal->getLatestAvailableActualImpressionsForZone($zoneId);
        $this->assertEqual($impressions, 80);
        
        // Generate a row for another zone_id and test that is still returning the impressions for the right zone
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 33;
        $doData_summary_zone_impression_history->forecast_impressions = 700;
        $doData_summary_zone_impression_history->actual_impressions = 800;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);
        
        $impressions = $oDal->getLatestAvailableActualImpressionsForZone($zoneId);
        $this->assertEqual($impressions, 80);

        DataGenerator::cleanUp();
    }

}

