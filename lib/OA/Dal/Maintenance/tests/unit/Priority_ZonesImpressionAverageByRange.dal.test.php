<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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

require_once MAX_PATH . '/lib/max/Entity/Ad.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/Entities.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Priority.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once 'DB/QueryTool.php';

// pgsql execution time before refactor: 49.402s
// pgsql execution time after refactor: 22.361s

/**
 * A class for testing the non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 * @author     James Floyd <james@m3.net>
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OA_Dal_Maintenance_Priority_ZonesImpressionAverageByRange extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_ZonesImpressionAverageByRange()
    {
        $this->UnitTestCase();
    }

    /**
     * Test 1 - check values and format of return values
     *
     * @TODO Implement tests to check date range being applied correctly
     */
    function testGetZonesImpressionAverageByRange()
    {
        $oDbh =& OA_DB::singleton();
        // Set up test test data
        $conf = $GLOBALS['_MAX']['CONF'];
        // Write two record for same interval id one week apart
        $doHist = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doHist->operation_interval = 60;
        $doHist->zone_id = 1;

        $doHist->operation_interval_id = 0;
        $doHist->interval_start = '2005-05-02 00:00:00';
        $doHist->interval_end   = '2005-05-02 00:59:59';
        $doHist->forecast_impressions = 200;
        $doHist->actual_impressions = 400;
        $idHist = DataGenerator::generateOne($doHist);

        $doHist->operation_interval_id = 0;
        $doHist->interval_start = '2005-05-09 00:00:00';
        $doHist->interval_end   = '2005-05-09 00:59:59';
        $doHist->forecast_impressions = 100;
        $doHist->actual_impressions = 200;
        $idHist = DataGenerator::generateOne($doHist);

        $doHist->operation_interval_id = 1;
        $doHist->interval_start = '2005-05-02 01:00:00';
        $doHist->interval_end   = '2005-05-02 01:59:59';
        $doHist->forecast_impressions = 200;
        $doHist->actual_impressions = 500;
        $idHist = DataGenerator::generateOne($doHist);

        $doHist->operation_interval_id = 1;
        $doHist->interval_start = '2005-05-09 01:00:00';
        $doHist->interval_end   = '2005-05-09 01:59:59';
        $doHist->forecast_impressions = 100;
        $doHist->actual_impressions = 700;
        $idHist = DataGenerator::generateOne($doHist);

        $oStartDate = new Date('2005-05-16 00:00:00');
        $oEndDate = new Date('2005-05-16 01:59:59');

        // Array of zone ids to resolve
        $aZones = array(1);

        // Number of weeks to get average over
        $weeks = 2;
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();
        $result =& $oMaxDalMaintenance->getZonesImpressionAverageByRange($aZones, $oStartDate, $oEndDate, $weeks);

        $this->assertEqual(count($result), 1);
        $this->assertEqual(count($result[1]), 2);

        $this->assertEqual($result[1][0]['zone_id'], 1);
        $this->assertEqual($result[1][0]['operation_interval_id'], 0);
        $this->assertEqual($result[1][0]['average_impressions'], 300);

        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['operation_interval_id'], 1);
        $this->assertEqual($result[1][1]['average_impressions'], 600);
        DataGenerator::cleanUp();
    }

    /**
     * Test 1 - check values and format of return values
     *
     * @TODO Implement tests to check date range being applied correctly
     */
    function OLD_testGetZonesImpressionAverageByRange()
    {
        $oDbh =& OA_DB::singleton();
        // Set up test test data
        $conf = $GLOBALS['_MAX']['CONF'];
        // Write two record for same interval id one week apart
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].'data_summary_zone_impression_history',true)."
                (
                    data_summary_zone_impression_history_id,
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    zone_id,
                    forecast_impressions,
                    actual_impressions
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            60,
            0,
            '2005-05-02 00:00:00',
            '2005-05-02 00:59:59',
            1,
            200,
            400
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            60,
            0,
            '2005-05-09 00:00:00',
            '2005-05-09 00:59:59',
            1,
            100,
            200
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            60,
            1,
            '2005-05-02 01:00:00',
            '2005-05-02 01:59:59',
            1,
            200,
            500
        );
        $rows = $st->execute($aData);
        $aData = array(
            4,
            60,
            1,
            '2005-05-09 01:00:00',
            '2005-05-09 01:59:59',
            1,
            100,
            700
        );
        $rows = $st->execute($aData);
        // Set up operation interval date range to query
        $oStartDate = new Date('2005-05-16 00:00:00');
        $oEndDate = new Date('2005-05-16 01:59:59');

        // Array of zone ids to resolve
        $aZones = array(1);

        // Number of weeks to get average over
        $weeks = 2;
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();
        $result =& $oMaxDalMaintenance->getZonesImpressionAverageByRange($aZones, $oStartDate, $oEndDate, $weeks);

        $this->assertEqual(count($result), 1);
        $this->assertEqual(count($result[1]), 2);

        $this->assertEqual($result[1][0]['zone_id'], 1);
        $this->assertEqual($result[1][0]['operation_interval_id'], 0);
        $this->assertEqual($result[1][0]['average_impressions'], 300);

        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['operation_interval_id'], 1);
        $this->assertEqual($result[1][1]['average_impressions'], 600);

        TestEnv::restoreEnv('dropTmpTables');
    }
}

?>
