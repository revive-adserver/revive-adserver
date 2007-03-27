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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Dal/Maintenance/Statistics/AdServer/mysql.php';
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/AdServer.php';
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/AdServer/Task/ManagePlacements.php';
require_once 'Date.php';

/**
 * A class for testing the MAX_Maintenance_Statistics_AdServer_Task_ManagePlacements class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMAX_Maintenance_Statistics_AdServer_Task_ManagePlacements extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMAX_Maintenance_Statistics_AdServer_Task_ManagePlacements()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oManagePlacements = new MAX_Maintenance_Statistics_AdServer_Task_ManagePlacements();
        $this->assertTrue(is_a($oManagePlacements, 'MAX_Maintenance_Statistics_AdServer_Task_ManagePlacements'));
    }

    /**
     * A method to test the run() method.
     */
    function testRun()
    {
        $oServiceLocator = &ServiceLocator::instance();

        // Register the current date/time
        $oDateNow = new Date();
        $oServiceLocator->register('now', $oDateNow);
        // Mock the DAL, and set expectations
        Mock::generate('OA_Dal_Maintenance_Statistics_AdServer_mysql');
        $oDal = new MockOA_Dal_Maintenance_Statistics_AdServer_mysql($this);
        $oDal->expectNever('manageCampaigns');
        $oServiceLocator->register('OA_Dal_Maintenance_Statistics_AdServer', $oDal);
        // Set the controller class
        $oMaintenanceStatistics = new MAX_Maintenance_Statistics_AdServer();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Test
        $oManagePlacements = new MAX_Maintenance_Statistics_AdServer_Task_ManagePlacements();
        $oManagePlacements->oController->updateIntermediate = false;
        $oManagePlacements->run();
        $oDal->tally();

        // Register the current date/time
        $oDateNow = new Date();
        $oServiceLocator->register('now', $oDateNow);
        // Mock the DAL, and set expectations
        Mock::generate('OA_Dal_Maintenance_Statistics_AdServer_mysql');
        $oDal = new MockOA_Dal_Maintenance_Statistics_AdServer_mysql($this);
        $oDal->expectOnce('manageCampaigns', array($oDateNow));
        $oServiceLocator->register('OA_Dal_Maintenance_Statistics_AdServer', $oDal);
        // Set the controller class
        $oMaintenanceStatistics = new MAX_Maintenance_Statistics_AdServer();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Test
        $oManagePlacements = new MAX_Maintenance_Statistics_AdServer_Task_ManagePlacements();
        $oManagePlacements->oController->updateIntermediate = true;
        $oManagePlacements->run();
        $oDal->tally();
    }

}

?>
