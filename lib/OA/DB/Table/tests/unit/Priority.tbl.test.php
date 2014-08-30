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

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Priority.php';

/**
 * A class for testing the OA_DB_Table_Priority class.
 *
 * @package    OpenXDB
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_DB_Table_Priority extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_DB_Table_Priority()
    {
        $this->UnitTestCase();
    }

    /**
     * Method to test the singleton method.
     *
     * Requirements:
     * Test 1: Test that only one instance of the class is created.
     */
    function testSingleton()
    {
        // Mock the OA_DB class used in the constructor method
        Mock::generate('OA_DB');
        $oDbh = new MockOA_DB($this);

        // Partially mock the OA_DB_Table_Priority class, overriding the
        // inherited _getDbConnection() method
        Mock::generatePartial(
            'OA_DB_Table_Priority',
            'PartialMockOA_DB_Table_Priority',
            array('_getDbConnection')
        );
        $oTable = new PartialMockOA_DB_Table_Priority($this);
        $oTable->setReturnReference('_getDbConnection', $oDbh);

        // Test 1
        $oTable1 =& $oTable->singleton();
        $oTable2 =& $oTable->singleton();
        $this->assertIdentical($oTable1, $oTable2);

        // Ensure the singleton is destroyed
        $oTable1->destroy();
    }

    /**
     * Tests creating/dropping all of the MPE temporary tables.
     *
     * Note that testing for the existence of temporary tables is done via
     * SELECT statements, as some databases (e.g. MySQL) do not allow
     * temporary tables to be seen via any administrative commands.
     *
     * Requirements:
     * Test 1: Test that all MPE temporary tables can be created and dropped.
     */
    function testAllMaintenancePriorityTables()
    {
        $tmpTables = array(
            'tmp_ad_required_impression',
            'tmp_ad_zone_impression'
        );

        // Test 1
        $conf =& $GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = '';
        $oDbh =& OA_DB::singleton();
        foreach ($tmpTables as $tableName) {
            $query = "SELECT * FROM $tableName";
            OA::disableErrorHandling();
            $result = $oDbh->query($query);
            OA::enableErrorHandling();
            $this->assertEqual(strtolower(get_class($result)), 'mdb2_error');
        }
        $oTable =& OA_DB_Table_Priority::singleton();
        foreach ($tmpTables as $tableName) {
            $oTable->createTable($tableName);
        }
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        foreach ($tmpTables as $tableName) {
            // Test that the table has been created
            $query = "SELECT * FROM $tableName";
            $result = $oDbh->query($query);
            $this->assertTrue($result);
            // Test that the table can be dropped
            // Use a different query to overcome MDB2 query buffering
            $query = "SELECT foo FROM $tableName";
            OA::disableErrorHandling();
            $result = $oDbh->query($query);
            OA::enableErrorHandling();
            $this->assertEqual(strtolower(get_class($result)), 'mdb2_error');
        }

        // Restore the testing environment
        TestEnv::restoreEnv();
    }

}

?>
