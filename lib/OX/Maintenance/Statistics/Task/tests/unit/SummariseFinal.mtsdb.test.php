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
require_once LIB_PATH . '/Maintenance/Statistics/Task/SummariseFinal.php';
require_once OX_PATH . '/lib/pear/Date.php';

/**
 * A class for testing the OX_Maintenance_Statistics_Task_SummariseFinal class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OX_Maintenance_Statistics_Task_SummariseFinal extends UnitTestCase
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
        $oSummariseFinal = new OX_Maintenance_Statistics_Task_SummariseFinal();
        $this->assertTrue(is_a($oSummariseFinal, 'OX_Maintenance_Statistics_Task_SummariseFinal'));
    }

    /**
     * A method to test the run() method.
     */
    function testRun()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();

        $aTypes = array(
            'types' => array(
                0 => 'request',
                1 => 'impression',
                2 => 'click'
            ),
            'connections' => array(
                1 => MAX_CONNECTION_AD_IMPRESSION,
                2 => MAX_CONNECTION_AD_CLICK
            )
        );

        // Mock the DAL, and set expectations
        Mock::generate('OX_Dal_Maintenance_Statistics');
        $oDal = new MockOX_Dal_Maintenance_Statistics($this);
        $oDal->expectNever('saveSummary');
        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);
        // Set the controller class
        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Test
        $oSummariseFinal = new OX_Maintenance_Statistics_Task_SummariseFinal();
        $oSummariseFinal->oController->updateIntermediate = false;
        $oSummariseFinal->oController->updateFinal = false;
        $oSummariseFinal->run();
        $oDal->tally();

        // Prepare the dates
        $olastDateIntermediate = new Date('2006-03-09 10:59:59');
        $oStartDate = new Date();
        $oStartDate->copy($olastDateIntermediate);
        $oStartDate->addSeconds(1);
        $oUpdateIntermediateToDate = new Date('2006-03-09 11:59:59');
        // Mock the DAL, and set expectations
        Mock::generate('OX_Dal_Maintenance_Statistics');
        $oDal = new MockOX_Dal_Maintenance_Statistics($this);
        $oDal->expectNever('saveSummary');
        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);
        // Set the controller class
        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Test
        $oSummariseFinal = new OX_Maintenance_Statistics_Task_SummariseFinal();
        $oSummariseFinal->oController->updateIntermediate = true;
        $oSummariseFinal->oController->oLastDateIntermediate = $olastDateIntermediate;
        $oSummariseFinal->oController->oUpdateIntermediateToDate = $oUpdateIntermediateToDate;
        $oSummariseFinal->oController->updateFinal = false;
        $oSummariseFinal->run();
        $oDal->tally();

        // Prepare the dates
        $olastDateFinal= new Date('2006-03-09 10:59:59');
        $oStartDate = new Date();
        $oStartDate->copy($olastDateFinal);
        $oStartDate->addSeconds(1);
        $oUpdateFinalToDate = new Date('2006-03-09 11:59:59');
        // Mock the DAL, and set expectations
        Mock::generate('OX_Dal_Maintenance_Statistics');
        $oDal = new MockOX_Dal_Maintenance_Statistics($this);
        $oDal->expectOnce('saveSummary', array($oStartDate, $oUpdateFinalToDate, $aTypes, 'data_intermediate_ad', 'data_summary_ad_hourly'));
        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);
        // Set the controller class
        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Test
        $oSummariseFinal = new OX_Maintenance_Statistics_Task_SummariseFinal();
        $oSummariseFinal->oController->updateIntermediate = false;
        $oSummariseFinal->oController->updateFinal = true;
        $oSummariseFinal->oController->oLastDateFinal = $olastDateFinal;
        $oSummariseFinal->oController->oUpdateFinalToDate = $oUpdateFinalToDate;
        $oSummariseFinal->run();
        $oDal->tally();

        // Prepare the dates
        $olastDateIntermediate = new Date('2006-03-09 10:59:59');
        $oStartDate = new Date();
        $oStartDate->copy($olastDateIntermediate);
        $oStartDate->addSeconds(1);
        $oUpdateIntermediateToDate = new Date('2006-03-09 11:59:59');
        $olastDateFinal= new Date('2006-03-09 10:59:59');
        $oStartDate = new Date();
        $oStartDate->copy($olastDateFinal);
        $oStartDate->addSeconds(1);
        $oUpdateFinalToDate = new Date('2006-03-09 11:59:59');
        // Mock the DAL, and set expectations
        Mock::generate('OX_Dal_Maintenance_Statistics');
        $oDal = new MockOX_Dal_Maintenance_Statistics($this);
        $oDal->expectOnce('saveSummary', array($oStartDate, $oUpdateFinalToDate, $aTypes, 'data_intermediate_ad', 'data_summary_ad_hourly'));
        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);
        // Set the controller class
        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Test
        $oSummariseFinal = new OX_Maintenance_Statistics_Task_SummariseFinal();
        $oSummariseFinal->oController->updateIntermediate = true;
        $oSummariseFinal->oController->oLastDateIntermediate = $olastDateIntermediate;
        $oSummariseFinal->oController->oUpdateIntermediateToDate = $oUpdateIntermediateToDate;
        $oSummariseFinal->oController->updateFinal = true;
        $oSummariseFinal->oController->oLastDateFinal = $olastDateFinal;
        $oSummariseFinal->oController->oUpdateFinalToDate = $oUpdateFinalToDate;
        $oSummariseFinal->run();
        $oDal->tally();
    }

}
