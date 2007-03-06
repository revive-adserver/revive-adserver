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
require_once MAX_PATH . '/lib/openads/Table/Core.php';
require_once 'Date.php';

/**
 * A class for testing the Openads_Table_Core class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_Openads_Table_Core extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_Openads_Table_Core()
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

        // Partially mock the Openads_Table_Core class, overriding the
        // inherited _getDbConnection() method
        Mock::generatePartial(
            'Openads_Table_Core',
            'PartialMockOpenads_Table_Core',
            array('_getDbConnection')
        );
        $oTable = &new PartialMockOpenads_Table_Core($this);
        $oTable->setReturnReference('_getDbConnection', $oDbh);

        // Test 1
        $oTable1 = &$oTable->singleton();
        $oTable2 = &$oTable->singleton();
        $this->assertIdentical($oTable1, $oTable2);

        // Ensure the singleton is destroyed
        $oTable1->destroy();
    }

    /**
     * Tests creating/dropping all of the core tables.
     *
     * Requirements:
     * Test 1: Test that all core tables can be created and dropped.
     * Test 2: Test that all core tables can be created and dropped, including split tables.
     */
    function testAllCoreTables()
    {
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
        $oTable = Openads_Table_Core::singleton();
        $oTable->createAllTables();
        $aExistingTables = $oDbh->manager->listTables();
        foreach ($conf['table'] as $key => $tableName) {
            if ($key == 'prefix' || $key == 'split' || $key == 'lockfile' || $key == 'type') {
                continue;
            }
            // Test that the tables exists
            $this->assertTrue(in_array($tableName, $aExistingTables));
        }
        TestEnv::restoreEnv();

        // Ensure the singleton is destroyed
        $oTable->destroy();

        // Test 2
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['split'] = true;
        $conf['table']['prefix'] = '';
        $oDbh = &Openads_Dal::singleton();
        $aExistingTables = $oDbh->manager->listTables();
        if (PEAR::isError($aExistingTables)) {
            // Can't talk to database, test fails!
            $this->assertTrue(false);
        }
        $this->assertEqual(count($aExistingTables), 0);
        $oTable = Openads_Table_Core::singleton();
        $oDate = new Date();
        $oTable->createAllTables($oDate);
        $aExistingTables = $oDbh->manager->listTables();
        foreach ($conf['table'] as $key => $tableName) {
            if ($key == 'prefix' || $key == 'split' || $key == 'lockfile' || $key == 'type') {
                continue;
            }
            if ($conf['splitTables'][$tableName]) {
                // That that the split table exists
                $this->assertTrue(in_array($tableName . '_' . $oDate->format('%Y%m%d'), $aExistingTables));
            } else {
                // Test that the normal table exists
                $this->assertTrue(in_array($tableName, $aExistingTables));
            }
        }
        TestEnv::restoreEnv();

        // Ensure the singleton is destroyed
        $oTable->destroy();
    }

}

?>
