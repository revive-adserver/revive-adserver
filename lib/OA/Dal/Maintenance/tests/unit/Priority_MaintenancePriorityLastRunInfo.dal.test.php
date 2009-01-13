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

// pgsql execution time before refactor: 103.68s
// pgsql execution time after refactor: 55.232s

/**
 * A class for testing the non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     James Floyd <james@m3.net>
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OA_Dal_Maintenance_Priority_SetMaintenancePriorityLastRunInfo extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_SetMaintenancePriorityLastRunInfo()
    {
        $this->UnitTestCase();
    }

    /**
     * Method to test the setMaintenancePriorityLastRunInfo method.
     *
     * Requirements:
     * Test 1: Test with no data in the database, ensure data is correctly stored.
     * Test 2: Test with previous test data in the database, ensure data is correctly stored.
     */
    function testSetMaintenancePriorityLastRunInfo()
    {
        // Test relies on transaction numbers, so ensure fresh database used
        TestEnv::restoreEnv('dropTmpTables');

        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        // Test 1
        $oStartDate = new Date('2005-06-21 15:00:01');
        $oEndDate   = new Date('2005-06-21 15:01:01');
        $oUpdatedTo = new Date('2005-06-21 15:59:59');
        $result = $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo, DAL_PRIORITY_UPDATE_ZIF);
        $this->assertEqual($result, 1);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                duration,
                run_type,
                updated_to
            FROM
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['log_maintenance_priority'],true)."
            WHERE
                log_maintenance_priority_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['start_run'], '2005-06-21 15:00:01');
        $this->assertEqual($aRow['end_run'], '2005-06-21 15:01:01');
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['duration'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_ZIF);
        $this->assertEqual($aRow['updated_to'], '2005-06-21 15:59:59');

        // Test 2
        $oStartDate = new Date('2005-06-21 16:00:01');
        $oEndDate   = new Date('2005-06-21 16:01:06');
        $oUpdatedTo = new Date('2005-06-21 16:59:59');
        $result = $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo, DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION);
        $this->assertEqual($result, 1);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                duration,
                run_type,
                updated_to
            FROM
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['log_maintenance_priority'],true)."
            WHERE
                log_maintenance_priority_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['start_run'], '2005-06-21 15:00:01');
        $this->assertEqual($aRow['end_run'], '2005-06-21 15:01:01');
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['duration'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_ZIF);
        $this->assertEqual($aRow['updated_to'], '2005-06-21 15:59:59');
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                duration,
                run_type,
                updated_to
            FROM
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['log_maintenance_priority'],true)."
            WHERE
                log_maintenance_priority_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['start_run'], '2005-06-21 16:00:01');
        $this->assertEqual($aRow['end_run'], '2005-06-21 16:01:06');
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['duration'], 65);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION);
        $this->assertEqual($aRow['updated_to'], '2005-06-21 16:59:59');

        DataGenerator::cleanUp(array('log_maintenance_priority'));
    }

    /**
     * Method to test the getMaintenancePriorityLastRunInfo method.
     *
     * Requirements:
     * Test 1: Test correct results are returned with no data.
     * Test 2: Test correct results are returned with single data entry.
     * Test 3: Test correct results are returned with multiple data entries.
     * Test 4: Test correct results are returned with multiple run types.
     */
    function testGetMaintenancePriorityLastRunInfo()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        // Test 1
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->assertFalse($result);

        // Test 2
        $oStartDate = new Date('2005-06-21 15:00:01');
        $oEndDate   = new Date('2005-06-21 15:01:01');
        $oUpdatedTo = new Date('2005-06-21 15:59:59');
        $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo, DAL_PRIORITY_UPDATE_ZIF);
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 15:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);

        // Test 3
        $oStartDate = new Date('2005-06-21 14:00:01');
        $oEndDate   = new Date('2005-06-21 14:01:01');
        $oUpdatedTo = new Date('2005-06-21 14:59:59');
        $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo, DAL_PRIORITY_UPDATE_ZIF);
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 15:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);
        $oStartDate = new Date('2005-06-21 16:00:01');
        $oEndDate   = new Date('2005-06-21 16:01:01');
        $oUpdatedTo = new Date('2005-06-21 16:59:59');
        $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo, DAL_PRIORITY_UPDATE_ZIF);
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 16:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);

        // Test 4
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION);
        $this->assertFalse($result);
        DataGenerator::cleanUp(array('log_maintenance_priority'));
    }

}

?>