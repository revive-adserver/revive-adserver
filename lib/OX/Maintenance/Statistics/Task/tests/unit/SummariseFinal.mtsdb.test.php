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
require_once LIB_PATH . '/Maintenance/Statistics/Task/SummariseFinal.php';
require_once OX_PATH . '/lib/pear/Date.php';

/**
 * A class for testing the OX_Maintenance_Statistics_Task_SummariseFinal class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OX_Maintenance_Statistics_Task_SummariseFinal extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OX_Maintenance_Statistics_Task_SummariseFinal()
    {
        $this->UnitTestCase();
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
