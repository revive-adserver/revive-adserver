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
$Id: TableStatisticsMySQL.tbl.test.php 4346 2006-03-06 16:43:19Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/DB.php';
require_once MAX_PATH . '/lib/max/Table/Statistics.php';

/**
 * A class for testing the MAX_Table_Statistics class.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_TestOfMaxTableStatistics extends UnitTestCase
{
    
    /**
     * The constructor method.
     */
    function MAX_TestOfMaxTableStatistics()
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
        // Mock the MAX_DB class used in the constructor method
        Mock::generate('MAX_DB');
        $dbh = &new MockMAX_DB($this);
        
        // Partially mock the MAX_Table_Statistics class
        Mock::generatePartial('MAX_Table_Statistics',
                              'PartialMockMAX_Table_Statistics',
                              array('_createMaxDb'));
        $oTable = &new PartialMockMAX_Table_Statistics($this);
        $oTable->setReturnReference('_createMaxDb', $dbh);
        
        // Test 1
        $first  = &$oTable->singleton('mysql');
        $second = &$oTable->singleton('mysql');
        $this->assertIdentical($first, $second);
        
        // Ensure the singleton is destroyed
        $first->destroy();
    }
    
    /**
     * Tests creating/dropping all of the maintenance statistics tables.
     *
     * Requirements:
     * Test 1: Test that all maintenance statistics tables can be created and dropped.
     */
    function testAllMaintenanceStatisticsTables()
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
        $tables = MAX_Table_Statistics::singleton('mysql');
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDb = &$oServiceLocator->get('MAX_DB');
        foreach ($tmpTables as $tbl) {
            $tables->createTable($tbl);
            $query = "SELECT * FROM $tbl";
            $result = $oMaxDb->query($query);
            $this->assertTrue($result);
            $tables->dropTable($tbl);
            $query = "SELECT * FROM $tbl";
            PEAR::pushErrorHandling(null);
            $result = $oMaxDb->query($query);
            PEAR::popErrorHandling();
            $this->assertEqual(strtolower(get_class($result)), 'db_error');
        }
        TestEnv::restoreEnv();
    }
    
}

?>
