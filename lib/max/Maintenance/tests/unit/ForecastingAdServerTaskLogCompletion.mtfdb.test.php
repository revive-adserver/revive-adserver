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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer/Task/LogCompletion.php';
require_once 'Date.php';

/**
 * A class for testing the MAX_Maintenance_Forecasting_AdServer_Task_LogCompletion class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMAX_Maintenance_Forecasting_AdServer_Task_LogCompletion extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMAX_Maintenance_Forecasting_AdServer_Task_LogCompletion()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oLogCompletion = new MAX_Maintenance_Forecasting_AdServer_Task_LogCompletion();
        $this->assertTrue(is_a($oLogCompletion, 'MAX_Maintenance_Forecasting_AdServer_Task_LogCompletion'));
    }

    /**
     * A method to test the run() method.
     */
    function testRun()
    {
        // Reset the testing environment
        TestEnv::restoreEnv();

        $aConf = &$GLOBALS['_MAX']['CONF'];
        $oTables = &OA_DB_Table_Core::singleton();
        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();
        // Create the required table
        $oTables->createTable('data_raw_ad_impression');
        $oTables->createTable('log_maintenance_forecasting');

        $oNow = new Date('2004-06-06 18:10:00');
        $oServiceLocator->register('now', $oNow);
        // Create and register a new MAX_Maintenance_Forecasting_AdServer object
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oServiceLocator->register('Maintenance_Forecasting_Controller', $oMaintenanceForecasting);
        // Create a new MAX_Maintenance_Forecasting_AdServer_Task_LogCompletion object
        $oLogCompletion = new MAX_Maintenance_Forecasting_AdServer_Task_LogCompletion();

        // Set some of the object's variables, and log
        $oLogCompletion->oController->update = true;
        $oLogCompletion->oController->oUpdateToDate = new Date('2004-06-06 17:59:59');
        $oEnd = new Date('2004-06-06 18:12:00');
        $oLogCompletion->run($oEnd);
        // Test
        $query = "
            SELECT
                *
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $aRow = $oDbh->getRow($query);
        $this->assertEqual($aRow['start_run'], '2004-06-06 18:10:00');
        $this->assertEqual($aRow['end_run'], '2004-06-06 18:12:00');
        $this->assertEqual($aRow['duration'], 120);
        $this->assertEqual($aRow['updated_to'], '2004-06-06 17:59:59');

        // Reset the testing environment
        TestEnv::restoreEnv();
    }

}

?>
