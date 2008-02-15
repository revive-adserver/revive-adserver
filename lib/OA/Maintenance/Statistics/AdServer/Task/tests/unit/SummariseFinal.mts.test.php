<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/AdServer/mysql.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/AdServer.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/AdServer/Task/SummariseFinal.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class for testing the OA_Maintenance_Statistics_AdServer_Task_SummariseFinal class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Statistics_AdServer_Task_SummariseFinal extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Statistics_AdServer_Task_SummariseFinal()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oSummariseFinal = new OA_Maintenance_Statistics_AdServer_Task_SummariseFinal();
        $this->assertTrue(is_a($oSummariseFinal, 'OA_Maintenance_Statistics_AdServer_Task_SummariseFinal'));
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
        Mock::generate('OA_Dal_Maintenance_Statistics_AdServer_mysql');
        $oDal = new MockOA_Dal_Maintenance_Statistics_AdServer_mysql($this);
        $oDal->expectNever('saveHistory');
        $oDal->expectNever('saveSummary');
        $oServiceLocator->register('OA_Dal_Maintenance_Statistics_AdServer', $oDal);
        // Set the controller class
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_AdServer();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Test
        $oSummariseFinal = new OA_Maintenance_Statistics_AdServer_Task_SummariseFinal();
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
        Mock::generate('OA_Dal_Maintenance_Statistics_AdServer_mysql');
        $oDal = new MockOA_Dal_Maintenance_Statistics_AdServer_mysql($this);
        $oDal->expectOnce('saveHistory', array($oStartDate, $oUpdateIntermediateToDate));
        $oDal->expectNever('saveSummary');
        $oServiceLocator->register('OA_Dal_Maintenance_Statistics_AdServer', $oDal);
        // Set the controller class
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_AdServer();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Test
        $oSummariseFinal = new OA_Maintenance_Statistics_AdServer_Task_SummariseFinal();
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
        Mock::generate('OA_Dal_Maintenance_Statistics_AdServer_mysql');
        $oDal = new MockOA_Dal_Maintenance_Statistics_AdServer_mysql($this);
        $oDal->expectNever('saveHistory');
        $oDal->expectOnce('saveSummary', array($oStartDate, $oUpdateFinalToDate, $aTypes, 'data_intermediate_ad', 'data_summary_ad_hourly'));
        $oServiceLocator->register('OA_Dal_Maintenance_Statistics_AdServer', $oDal);
        // Set the controller class
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_AdServer();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Test
        $oSummariseFinal = new OA_Maintenance_Statistics_AdServer_Task_SummariseFinal();
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
        Mock::generate('OA_Dal_Maintenance_Statistics_AdServer_mysql');
        $oDal = new MockOA_Dal_Maintenance_Statistics_AdServer_mysql($this);
        $oDal->expectOnce('saveHistory', array($oStartDate, $oUpdateIntermediateToDate));
        $oDal->expectOnce('saveSummary', array($oStartDate, $oUpdateFinalToDate, $aTypes, 'data_intermediate_ad', 'data_summary_ad_hourly'));
        $oServiceLocator->register('OA_Dal_Maintenance_Statistics_AdServer', $oDal);
        // Set the controller class
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_AdServer();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Test
        $oSummariseFinal = new OA_Maintenance_Statistics_AdServer_Task_SummariseFinal();
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

?>
