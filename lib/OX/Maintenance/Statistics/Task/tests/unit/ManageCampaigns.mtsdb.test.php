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

require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once LIB_PATH . '/Dal/Maintenance/Statistics.php';
require_once LIB_PATH . '/Maintenance/Statistics.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/ManageCampaigns.php';

/**
 * A class for testing the OX_Maintenance_Statistics_Task_ManageCampaigns class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OX_Maintenance_Statistics_Task_ManageCampaigns extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OX_Maintenance_Statistics_Task_ManageCampaigns()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oManageCampaigns = new OX_Maintenance_Statistics_Task_ManageCampaigns();
        $this->assertTrue(is_a($oManageCampaigns, 'OX_Maintenance_Statistics_Task_ManageCampaigns'));
    }

    /**
     * A method to test the run() method.
     */
    function testRun()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();

        // Register the current date/time
        $oDateNow = new Date();
        $oServiceLocator->register('now', $oDateNow);
        // Mock the DAL, and set expectations
        Mock::generate('OX_Dal_Maintenance_Statistics');
        $oDal = new MockOX_Dal_Maintenance_Statistics($this);
        $oDal->expectNever('manageCampaigns');
        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);
        // Set the controller class
        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Test
        $oManageCampaigns = new OX_Maintenance_Statistics_Task_ManageCampaigns();
        $oManageCampaigns->oController->updateIntermediate = false;
        $oManageCampaigns->run();
        $oDal->tally();

        // Register the current date/time
        $oDateNow = new Date();
        $oServiceLocator->register('now', $oDateNow);
        // Mock the DAL, and set expectations
        Mock::generate('OX_Dal_Maintenance_Statistics');
        $oDal = new MockOX_Dal_Maintenance_Statistics($this);
        $oDal->expectOnce('manageCampaigns', array($oDateNow));
        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);
        // Set the controller class
        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Test
        $oManageCampaigns = new OX_Maintenance_Statistics_Task_ManageCampaigns();
        $oManageCampaigns->oController->updateIntermediate = true;
        $oManageCampaigns->run();
        $oDal->tally();
    }

}

?>