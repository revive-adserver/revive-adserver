<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once LIB_PATH . '/Maintenance.php';
require_once OX_PATH . '/lib/pear/Date.php';

/**
 * A class for testing the OX_Maintenance class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 */
class Test_OA_Maintenance extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * A method to test the _runGeneralPruning() method.
     */
    function test_runGeneralPruning()
    {
        $oNowDate = new Date('2007-09-28 12:00:01');
        $oServiceLocator = OA_ServiceLocator::instance();
        $oServiceLocator->register('now', $oNowDate);

        $oMaintenance = new OX_Maintenance();

        // Test 1: Assert no data present at start of tests
        $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
        $doLog_maintenance_statistics->find();
        $rows = $doLog_maintenance_statistics->getRowCount();
        $this->assertEqual($rows, 0);

        $doLog_maintenance_priority = OA_Dal::factoryDO('log_maintenance_priority');
        $doLog_maintenance_priority->find();
        $rows = $doLog_maintenance_priority->getRowCount();
        $this->assertEqual($rows, 0);

        $doUserlog = OA_Dal::factoryDO('userlog');
        $doUserlog->find();
        $rows = $doUserlog->getRowCount();
        $this->assertEqual($rows, 0);

        // Test 2: Assert still no data after running
        $oMaintenance->_runGeneralPruning();

        $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
        $doLog_maintenance_statistics->find();
        $rows = $doLog_maintenance_statistics->getRowCount();
        $this->assertEqual($rows, 0);

        $doLog_maintenance_priority = OA_Dal::factoryDO('log_maintenance_priority');
        $doLog_maintenance_priority->find();
        $rows = $doLog_maintenance_priority->getRowCount();
        $this->assertEqual($rows, 0);

        $doUserlog = OA_Dal::factoryDO('userlog');
        $doUserlog->find();
        $rows = $doUserlog->getRowCount();
        $this->assertEqual($rows, 0);

        // Test 3: Insert test data, and assert its presence
        $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
        $doLog_maintenance_statistics->start_run  = '2007-09-28 11:00:01';
        $idStatsOne = DataGenerator::generateOne($doLog_maintenance_statistics);

        $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
        $doLog_maintenance_statistics->start_run  = '2007-09-28 10:00:01';
        $idStatsTwo = DataGenerator::generateOne($doLog_maintenance_statistics);

        $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
        $doLog_maintenance_statistics->start_run  = '2007-08-28 11:00:01';
        $idStatsThree = DataGenerator::generateOne($doLog_maintenance_statistics);

        $doLog_maintenance_priority = OA_Dal::factoryDO('log_maintenance_priority');
        $doLog_maintenance_priority->start_run  = '2007-09-28 11:00:01';
        $idPriorityOne = DataGenerator::generateOne($doLog_maintenance_priority);

        $doLog_maintenance_priority = OA_Dal::factoryDO('log_maintenance_priority');
        $doLog_maintenance_priority->start_run  = '2007-09-28 10:00:01';
        $idPriorityTwo = DataGenerator::generateOne($doLog_maintenance_priority);

        $doLog_maintenance_priority = OA_Dal::factoryDO('log_maintenance_priority');
        $doLog_maintenance_priority->start_run  = '2007-08-28 11:00:01';
        $idPriorityThree = DataGenerator::generateOne($doLog_maintenance_priority);

        $oDate = new Date('2007-09-28 11:01:01');
        $doUserlog = OA_Dal::factoryDO('userlog');
        $doUserlog->timestamp  = $oDate->getTime();
        $idUserlogOne = DataGenerator::generateOne($doUserlog);

        $oDate = new Date('2007-09-28 10:01:01');
        $doUserlog = OA_Dal::factoryDO('userlog');
        $doUserlog->timestamp  = $oDate->getTime();
        $idUserlogTwo = DataGenerator::generateOne($doUserlog);

        $oDate = new Date('2007-08-28 11:01:01');
        $doUserlog = OA_Dal::factoryDO('userlog');
        $doUserlog->timestamp  = $oDate->getTime();
        $idUserlogThree = DataGenerator::generateOne($doUserlog);

        $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
        $doLog_maintenance_statistics->find();
        $rows = $doLog_maintenance_statistics->getRowCount();
        $this->assertEqual($rows, 3);

        $doLog_maintenance_priority = OA_Dal::factoryDO('log_maintenance_priority');
        $doLog_maintenance_priority->find();
        $rows = $doLog_maintenance_priority->getRowCount();
        $this->assertEqual($rows, 3);

        $doUserlog = OA_Dal::factoryDO('userlog');
        $doUserlog->find();
        $rows = $doUserlog->getRowCount();
        $this->assertEqual($rows, 3);

        // Test 4: Ensure the correct old data has been pruned after running
        $oMaintenance->_runGeneralPruning();

        $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
        $doLog_maintenance_statistics->find();
        $rows = $doLog_maintenance_statistics->getRowCount();
        $this->assertEqual($rows, 2);
        while ($doLog_maintenance_statistics->fetch()) {
            $this->assertNotEqual($doLog_maintenance_statistics->log_maintenance_statistics_id, $idStatsThree);
        }

        $doLog_maintenance_priority = OA_Dal::factoryDO('log_maintenance_priority');
        $doLog_maintenance_priority->find();
        $rows = $doLog_maintenance_priority->getRowCount();
        $this->assertEqual($rows, 2);
        while ($doLog_maintenance_priority->fetch()) {
            $this->assertNotEqual($doLog_maintenance_priority->log_maintenance_priority_id, $idPriorityThree);
        }

        $doUserlog = OA_Dal::factoryDO('userlog');
        $doUserlog->find();
        $rows = $doUserlog->getRowCount();
        $this->assertEqual($rows, 2);
        while ($doUserlog->fetch()) {
            $this->assertNotEqual($doUserlog->userlogid, $idUserlogThree);
        }

        DataGenerator::cleanUp();
    }

    function testGetLastRun()
    {
        $oMaintenance = new OX_Maintenance();

        $this->assertNull($oMaintenance->getLastRun());

        $iLastRun = strtotime('2002-01-01');
        OA_Dal_ApplicationVariables::set('maintenance_timestamp', $iLastRun);

        $oDate = new Date((int)$iLastRun);
        $this->assertTrue($oDate->equals($oMaintenance->getLastRun()));

        OA_Dal_ApplicationVariables::delete('maintenance_timestamp');
    }

    function testIsMidnightMaintenance()
    {
        unset($GLOBALS['serverTimezone']);

        $oNowDate = new Date('2008-01-28 00:00:10');
        $oServiceLocator = OA_ServiceLocator::instance();
        $oServiceLocator->register('now', $oNowDate);

        $oMaintenance = new OX_Maintenance();

        // No previous run
        $oLastRun = null;
        $this->assertTrue($oMaintenance->isMidnightMaintenance($oLastRun));

        // Last run was 6 seconds ago, midnight did already pass
        $oLastRun = new Date('2008-01-28 00:00:04');
        $this->assertFalse($oMaintenance->isMidnightMaintenance($oLastRun));

        // Last run was one hour ago, midnight has passed
        $oLastRun = new Date('2008-01-27 23:00:04');
        $this->assertTrue($oMaintenance->isMidnightMaintenance($oLastRun));

        // Midnight did already pass in CET
        $GLOBALS['serverTimezone'] = 'CET';
        $this->assertFalse($oMaintenance->isMidnightMaintenance($oLastRun));

        // Not midnight yet in New York, last run was at 17PM local time
        $GLOBALS['serverTimezone'] = 'EST';
        $oLastRun = new Date('2008-01-27 12:00:04');
        $this->assertFalse($oMaintenance->isMidnightMaintenance($oLastRun));
    }

}

?>