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
$Id: TableCoreMySQL.tbl.test.php 6108 2006-11-24 11:34:58Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/DB.php';
require_once MAX_PATH . '/lib/max/Table/Core.php';
require_once 'Date.php';

/**
 * A class for testing the MAX_Table_Core class.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_TestOfMaxTableCore extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function MAX_TestOfMaxTableCore()
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

        // Partially mock the MAX_Table_Core class
        Mock::generatePartial('MAX_Table_Core',
                              'PartialMockMAX_Table_Core',
                              array('_createMaxDb'));
        $oTable = &new PartialMockMAX_Table_Core($this);
        $oTable->setReturnReference('_createMaxDb', $dbh);

        // Test 1
        $first  = &$oTable->singleton('mysql');
        $second = &$oTable->singleton('mysql');
        $this->assertIdentical($first, $second);

        // Ensure the singleton is destroyed
        $first->destroy();
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
        $coreTables = array(
            'acls',
            'acls_channel',
            'ad_category_assoc',
            'ad_zone_assoc',
            'affiliates',
            'affiliates_extra',
            'agency',
            'application_variable',
            'banners',
            'campaigns',
            'campaigns_trackers',
            'category',
            'channel',
            'clients',
            'data_intermediate_ad',
            'data_intermediate_ad_connection',
            'data_intermediate_ad_variable_value',
            'data_summary_ad_hourly',
            'data_summary_ad_zone_assoc',
            'data_summary_zone_impression_history',
            'data_summary_zone_domain_page_daily',
            'data_summary_zone_country_daily',
            'data_summary_zone_source_daily',
            'data_summary_zone_site_keyword_daily',
            'data_summary_zone_domain_page_monthly',
            'data_summary_zone_country_monthly',
            'data_summary_zone_source_monthly',
            'data_summary_zone_site_keyword_monthly',
            'data_summary_zone_domain_page_forecast',
            'data_summary_zone_country_forecast',
            'data_summary_zone_source_forecast',
            'data_summary_zone_site_keyword_forecast',
            'data_summary_channel_daily',
            'images',
            'log_maintenance_forecasting',
            'log_maintenance_priority',
            'log_maintenance_statistics',
            'placement_zone_assoc',
            'plugins_channel_delivery_assoc',
            'plugins_channel_delivery_domains',
            'plugins_channel_delivery_rules',
            'preference',
            'preference_advertiser',
            'preference_publisher',
            'session',
            'targetstats',
            'trackers',
            'tracker_append',
            'userlog',
            'variables',
            'zones'
        );
        $splitTables = array(
            'data_raw_ad_click',
            'data_raw_ad_impression',
            'data_raw_ad_request',
            'data_raw_tracker_click',
            'data_raw_tracker_impression',
            'data_raw_tracker_variable_value'
        );

        // Test 1
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['split'] = false;
        $conf['table']['prefix'] = '';
        $tables = MAX_Table_Core::singleton('mysql');
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDb = &$oServiceLocator->get('MAX_DB');
        foreach ($coreTables as $tbl) {
            $tables->createTable($tbl);
            $tableList = $oMaxDb->getListOf('tables');
            $this->assertEqual($tableList[0], $tbl);
            $tables->dropTable($tbl);
            $query = "SELECT * FROM $tbl";
            PEAR::pushErrorHandling(null);
            $result = $oMaxDb->query($query);
            PEAR::popErrorHandling();
            $this->assertEqual(strtolower(get_class($result)), 'db_error');
        }
        foreach ($splitTables as $tbl) {
            $tables->createTable($tbl);
            $tableList = $oMaxDb->getListOf('tables');
            $this->assertEqual($tableList[0], $tbl);
            $tables->dropTable($tbl);
            $query = "SELECT * FROM $tbl";
            PEAR::pushErrorHandling(null);
            $result = $oMaxDb->query($query);
            PEAR::popErrorHandling();
            $this->assertEqual(strtolower(get_class($result)), 'db_error');
        }
        TestEnv::restoreEnv();

        // Ensure the singleton is destroyed
        $tables->destroy();

        // Test 2
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['split'] = true;
        $conf['table']['prefix'] = '';
        $tables = MAX_Table_Core::singleton('mysql');
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDb = &$oServiceLocator->get('MAX_DB');
        foreach ($coreTables as $tbl) {
            $tables->createTable($tbl);
            $tableList = $oMaxDb->getListOf('tables');
            $this->assertEqual($tableList[0], $tbl);
            $tables->dropTable($tbl);
            $query = "SELECT * FROM $tbl";
            PEAR::pushErrorHandling(null);
            $result = $oMaxDb->query($query);
            PEAR::popErrorHandling();
            $this->assertEqual(strtolower(get_class($result)), 'db_error');
        }
        $oDate = new Date();
        foreach ($splitTables as $tbl) {
            $tables->createTable($tbl, $oDate);
            $tableList = $oMaxDb->getListOf('tables');
            $this->assertEqual($tableList[0], $tbl . '_' . $oDate->format('%Y%m%d'));
            $tables->dropTable($tbl . '_' . $oDate->format('%Y%m%d'));
            $query = "SELECT * FROM $tbl_" . $oDate->format('%Y%m%d');
            PEAR::pushErrorHandling(null);
            $result = $oMaxDb->query($query);
            PEAR::popErrorHandling();
            $this->assertEqual(strtolower(get_class($result)), 'db_error');
        }
        TestEnv::restoreEnv();

        // Ensure the singleton is destroyed
        $tables->destroy();
    }

}

?>
