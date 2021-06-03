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

require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once LIB_PATH . '/Dal/Maintenance/Statistics.php';
require_once LIB_PATH . '/Maintenance/Statistics.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/ManageCampaigns.php';

/**
 * A class for testing the OX_Maintenance_Statistics_Task_ManageCampaigns class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OX_Maintenance_Statistics_Task_ManageCampaigns extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
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
        $oServiceLocator = OA_ServiceLocator::instance();

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