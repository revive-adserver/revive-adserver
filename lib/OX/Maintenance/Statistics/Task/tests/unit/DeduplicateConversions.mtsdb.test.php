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

require_once LIB_PATH . '/Dal/Maintenance/Statistics/Mysql.php';
require_once LIB_PATH . '/Dal/Maintenance/Statistics/Pgsql.php';
require_once LIB_PATH . '/Maintenance/Statistics.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/DeduplicateConversions.php';

/**
 * A class for testing the OX_Maintenance_Statistics_Task_DeduplicateConversions class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OX_Maintenance_Statistics_Task_DeduplicateConversions extends UnitTestCase
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
        $oDeDuplicateConversions = new OX_Maintenance_Statistics_Task_DeduplicateConversions();
        $this->assertTrue(is_a($oDeDuplicateConversions, 'OX_Maintenance_Statistics_Task_DeduplicateConversions'));
    }

    /**
     * A method to test the run() method.
     */
    function testRun()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $aConf           =& $GLOBALS['_MAX']['CONF'];
        $className       = 'OX_Dal_Maintenance_Statistics_' . ucfirst(strtolower($aConf['database']['type']));
        $mockClassName   = 'MockOX_Dal_Maintenance_Statistics_' . ucfirst(strtolower($aConf['database']['type']));

        $aConf['maintenance']['operationInterval'] = 60;

        // Test 1: Test with the bucket data not having been migrated,
        //         and ensure that the DAL calls to de-duplicate and
        //         reject conversions are not made

        // Set the controller class
        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        // Mock the MSE DAL used to de-duplicate conversions,
        // and set the expectations of the calls to the DAL
        Mock::generate($className);
        $oDal = new $mockClassName($this);
        $oDal->expectNever('deduplicateConversions');
        $oDal->expectNever('rejectEmptyVarConversions');
        $oDal->__construct();
        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);

        // Set the controlling class' status and test
        $oDeDuplicateConversions = new OX_Maintenance_Statistics_Task_DeDuplicateConversions();
        $oDeDuplicateConversions->oController->updateIntermediate = false;
        $oDeDuplicateConversions->run();
        $oDal->tally();

        // Test 2: Test with the bucket data having been migrated, and
        //         ensure that the DALL calls to de-duplicate and reject
        //         conversions are made correctly

        // Set the controller class
        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        // Mock the MSE DAL used to de-duplicate conversions,
        // and set the expectations of the calls to the DAL
        Mock::generate($className);
        $oDal = new $mockClassName($this);
        $oDate = new Date('2008-09-08 16:59:59');
        $oDate->addSeconds(1);
        $oDal->expectOnce(
            'deduplicateConversions',
            array(
                $oDate,
                new Date('2008-09-08 17:59:59')
            )
        );
        $oDal->expectOnce(
            'rejectEmptyVarConversions',
            array(
                $oDate,
                new Date('2008-09-08 17:59:59')
            )
        );
        $oDal->__construct();
        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);

        // Set the controlling class' status and test
        $oDeDuplicateConversions = new OX_Maintenance_Statistics_Task_DeDuplicateConversions();
        $oDeDuplicateConversions->oController->updateIntermediate        = true;
        $oDeDuplicateConversions->oController->oLastDateIntermediate     = new Date('2008-09-08 16:59:59');
        $oDeDuplicateConversions->oController->oUpdateIntermediateToDate = new Date('2008-09-08 17:59:59');
        $oDeDuplicateConversions->run();
        $oDal->tally();

        TestEnv::restoreConfig();
    }

}

?>