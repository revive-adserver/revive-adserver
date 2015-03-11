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
require_once LIB_PATH . '/Maintenance/Statistics/Task/ManageConversions.php';

/**
 * A class for testing the OX_Maintenance_Statistics_Task_ManageConversions class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OX_Maintenance_Statistics_Task_ManageConversions extends UnitTestCase
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
        $oManageConversions = new OX_Maintenance_Statistics_Task_ManageConversions();
        $this->assertTrue(is_a($oManageConversions, 'OX_Maintenance_Statistics_Task_ManageConversions'));
    }

    /**
     * A method to test the run() method.
     */
    function testRun()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $aConf['maintenance']['operationInterval'] = 60;

        // Test 1: Test with the bucket data not having been migrated,
        //         and ensure that the DAL calls to de-duplicate and
        //         reject conversions are not made

        // Set the controller class
        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        // Mock the MSE DAL used to de-duplicate conversions,
        // and set the expectations of the calls to the DAL
        Mock::generate('OX_Dal_Maintenance_Statistics');
        $oDal = new MockOX_Dal_Maintenance_Statistics($this);
        $oDal->expectNever('manageConversions');
        $oDal->__construct();
        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);

        // Set the controlling class' status and test
        $oManageConversions = new OX_Maintenance_Statistics_Task_ManageConversions();
        $oManageConversions->oController->updateIntermediate = false;
        $oManageConversions->run();
        $oDal->tally();

        // Test 2: Test with the bucket data having been migrated, and
        //         ensure that the DALL calls to de-duplicate and reject
        //         conversions are made correctly

        // Set the controller class
        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        // Mock the MSE DAL used to de-duplicate conversions,
        // and set the expectations of the calls to the DAL
        Mock::generate('OX_Dal_Maintenance_Statistics');
        $oDal = new MockOX_Dal_Maintenance_Statistics($this);
        $oDate = new Date('2008-09-08 16:59:59');
        $oDate->addSeconds(1);
        $oDal->expectOnce(
            'manageConversions',
            array(
                $oDate,
                new Date('2008-09-08 17:59:59')
            )
        );
        $oDal->__construct();
        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);

        // Set the controlling class' status and test
        $oManageConversions = new OX_Maintenance_Statistics_Task_ManageConversions();
        $oManageConversions->oController->updateIntermediate        = true;
        $oManageConversions->oController->oLastDateIntermediate     = new Date('2008-09-08 16:59:59');
        $oManageConversions->oController->oUpdateIntermediateToDate = new Date('2008-09-08 17:59:59');
        $oManageConversions->run();
        $oDal->tally();

        TestEnv::restoreConfig();
    }

}

?>