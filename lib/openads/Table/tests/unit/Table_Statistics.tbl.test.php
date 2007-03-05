<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/openads/Dal.php';
require_once MAX_PATH . '/lib/openads/Table/Priority.php';

/**
 * A class for testing the Openads_Table_Priority class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_Openads_Table_Priority extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_Openads_Table_Priority()
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
        // Mock the Openads_Dal class used in the constructor method
        Mock::generate('Openads_Dal');
        $oDbh = &new MockOpenads_Dal($this);

        // Partially mock the Openads_Table_Priority class, overriding the
        // inherited _getDbConnection() method
        Mock::generatePartial(
            'Openads_Table_Priority',
            'PartialMockOpenads_Table_Priority',
            array('_getDbConnection')
        );
        $oTable = &new PartialMockOpenads_Table_Priority($this);
        $oTable->setReturnReference('_getDbConnection', $oDbh);

        // Test 1
        $oTable1 = &$oTable->singleton();
        $oTable2 = &$oTable->singleton();
        $this->assertIdentical($oTable1, $oTable2);

        // Ensure the singleton is destroyed
        $oTable1->destroy();
    }

    /**
     * Tests creating/dropping all of the MPE temporary tables.
     *
     * Requirements:
     * Test 1: Test that all MPE temporary tables can be created and dropped.
     */
    function testAllMaintenancePriorityTables()
    {
        $tmpTables = array(
            'tmp_ad_impression',
            'tmp_ad_click',
            'tmp_tracker_impression_ad_impression_connection',
            'tmp_tracker_impression_ad_click_connection',
            'tmp_ad_connection'
        );

        // Test 1
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['split'] = false;
        $conf['table']['prefix'] = '';
        $oDbh = &Openads_Dal::singleton();
        $aExistingTables = $oDbh->manager->listTables();
        if (PEAR::isError($aExistingTables)) {
            // Can't talk to database, test fails!
            $this->assertTrue(false);
        }
        $this->assertEqual(count($aExistingTables), 0);
        $oTable = Openads_Table_Priority::singleton();
        foreach ($tmpTables as $tableName) {
            $oTable->createTable($tableName);
        }
        $aExistingTables = $oDbh->manager->listTables();
        foreach ($tmpTables as $tableName) {
            // Test that the table has been created
            $this->assertTrue(in_array($tableName, $aExistingTables));
            // Test that the table can be dropped
            $oTable->dropTempTable($tableName);
            $aNewExistingTables = $oDbh->manager->listTables();
            $this->assertFalse(in_array($tableName, $aExistingTables));
        }

        // Restore the testing environment
        TestEnv::restoreEnv();
    }

}

?>
