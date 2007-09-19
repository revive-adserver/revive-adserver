<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
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


// pgsql execution time before refactor: 55.804s
// pgsql execution time after refactor: 23.435s

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
class Test_OA_Dal_Maintenance_Priority_AllZonesWithAllocInv extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_AllZonesWithAllocInv()
    {
        $this->UnitTestCase();
    }


    /**
     * Method to test the getAllZonesWithAllocInv method.
     *
     * Requirements:
     * Test 1: Test with no data, and ensure no data returned.
     * Test 2: Test with sample data, and ensure the correct data is returned.
     */
    function testGetAllZonesWithAllocInv()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        // Create the required temporary table for the tests
        $oTable =& OA_DB_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_zone_impression');

        $tableTmp = $oDbh->quoteIdentifier('tmp_ad_zone_impression',true);

        // Test 1
        $result =& $oMaxDalMaintenance->getAllZonesWithAllocInv();
        $this->assertEqual(count($result), 0);

        // Test 2
        $query = "
            INSERT INTO
                {$tableTmp}
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    1,
                    1,
                    2,
                    3
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$tableTmp}
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    1,
                    2,
                    4,
                    5
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$tableTmp}
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    2,
                    2,
                    6,
                    7
                )";
        $rows = $oDbh->exec($query);
        $result =& $oMaxDalMaintenance->getAllZonesWithAllocInv();
        $this->assertEqual(count($result), 3);
        $this->assertEqual($result[0]['zone_id'], 1);
        $this->assertEqual($result[0]['ad_id'], 1);
        $this->assertEqual($result[0]['required_impressions'], 2);
        $this->assertEqual($result[0]['requested_impressions'], 3);
        $this->assertEqual($result[1]['zone_id'], 2);
        $this->assertEqual($result[1]['ad_id'], 1);
        $this->assertEqual($result[1]['required_impressions'], 4);
        $this->assertEqual($result[1]['requested_impressions'], 5);
        $this->assertEqual($result[2]['zone_id'], 2);
        $this->assertEqual($result[2]['ad_id'], 2);
        $this->assertEqual($result[2]['required_impressions'], 6);
        $this->assertEqual($result[2]['requested_impressions'], 7);
        TestEnv::dropTempTables();
    }

    /**
     * Method to test the getAllZonesWithAllocInv method.
     *
     * Requirements:
     * Test 1: Test with no data, and ensure no data returned.
     * Test 2: Test with sample data, and ensure the correct data is returned.
     */
    function OLD_testGetAllZonesWithAllocInv()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        // Create the required temporary table for the tests
        $oTable =& OA_DB_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_zone_impression');

        $tableTmp = $oDbh->quoteIdentifier('tmp_ad_zone_impression',true);

        // Test 1
        $result =& $oMaxDalMaintenance->getAllZonesWithAllocInv();
        $this->assertEqual(count($result), 0);

        // Test 2
        $query = "
            INSERT INTO
                {$tableTmp}
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    1,
                    1,
                    2,
                    3
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$tableTmp}
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    1,
                    2,
                    4,
                    5
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$tableTmp}
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    2,
                    2,
                    6,
                    7
                )";
        $rows = $oDbh->exec($query);
        $result =& $oMaxDalMaintenance->getAllZonesWithAllocInv();
        $this->assertEqual(count($result), 3);
        $this->assertEqual($result[0]['zone_id'], 1);
        $this->assertEqual($result[0]['ad_id'], 1);
        $this->assertEqual($result[0]['required_impressions'], 2);
        $this->assertEqual($result[0]['requested_impressions'], 3);
        $this->assertEqual($result[1]['zone_id'], 2);
        $this->assertEqual($result[1]['ad_id'], 1);
        $this->assertEqual($result[1]['required_impressions'], 4);
        $this->assertEqual($result[1]['requested_impressions'], 5);
        $this->assertEqual($result[2]['zone_id'], 2);
        $this->assertEqual($result[2]['ad_id'], 2);
        $this->assertEqual($result[2]['required_impressions'], 6);
        $this->assertEqual($result[2]['requested_impressions'], 7);
        TestEnv::restoreEnv('dropTmpTables');
    }
}

?>
