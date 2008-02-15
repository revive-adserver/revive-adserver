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
        $oDbh =& new MockOA_DB($this);

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
