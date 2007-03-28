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
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/AdServer.php';
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/AdServer/Task/SummariseIntermediate.php';

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/AdServer/mysql.php';
require_once 'Date.php';

/**
 * A class for testing the MAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oSummariseIntermediate = new MAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate();
        $this->assertTrue(is_a($oSummariseIntermediate, 'MAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate'));
    }

    /**
     * A method to test the run() method.
     *
     * Tests WITHOUT the Tracker module
     * Test 1:  Test where not updating either intermediate or final tables.
     * Test 2:  Test where updating intermediate tables on a single hour.
     * Test 3:  Test where updating final tables on a single hour.
     * Test 4:  Test where updating intermediate tables on multiple hours.
     * Test 5:  Test where updating final tables on multiple hours.
     *
     * Tests WITH the Tracker module
     * Test 6:  Test where not updating either intermediate or final tables.
     * Test 7:  Test where updating intermediate tables on a single hour.
     * Test 8:  Test where updating final tables on a single hour.
     * Test 9:  Test where updating intermediate tables on multiple hours.
     * Test 10: Test where updating final tables on multiple hours.
     */
    function testRun()
    {
        $oServiceLocator = &ServiceLocator::instance();

        // Create a reference to the config, so that config options can be
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Mock the DAL
        Mock::generate('OA_Dal_Maintenance_Statistics_AdServer_mysql');
        $oDal = new MockOA_Dal_Maintenance_Statistics_AdServer_mysql($this);
        $oServiceLocator->register('OA_Dal_Maintenance_Statistics_AdServer', $oDal);

        // Set the controller class
        $oMaintenanceStatistics = new MAX_Maintenance_Statistics_AdServer();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Partially mock the class under test, so that the private
        // methods can be knocked out
        Mock::generatePartial(
            'MAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate',
            'PartialMockMAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate',
            array(
                '_summariseIntermediateRequests',
                '_summariseIntermediateImpressions',
                '_summariseIntermediateClicks',
                '_summariseIntermediateConnections',
                '_saveIntermediateSummaries'
            )
        );

        // Test 1
        $conf['modules']['Tracker'] = false;
        $conf['maintenance']['operationInterval'] = 30;
        $oSummariseIntermediate = new PartialMockMAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate($this);
        $oSummariseIntermediate->oController->updateUsingOI = false;
        $oSummariseIntermediate->oController->updateIntermediate = false;
        $oSummariseIntermediate->oController->updateFinal = false;
        $oSummariseIntermediate->expectNever('_summariseIntermediateRequests');
        $oSummariseIntermediate->expectNever('_summariseIntermediateImpressions');
        $oSummariseIntermediate->expectNever('_summariseIntermediateClicks');
        $oSummariseIntermediate->expectNever('_summariseIntermediateConnections');
        $oSummariseIntermediate->expectNever('_saveIntermediateSummaries');
        $oSummariseIntermediate->run();
        $oSummariseIntermediate->tally();

        // Test 2
        $conf['modules']['Tracker'] = false;
        $conf['maintenance']['operationInterval'] = 30;
        $oSummariseIntermediate = new PartialMockMAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate($this);
        $olastDateIntermediate = new Date('2006-03-09 10:59:59');
        $oStartDate = new Date('2006-03-09 10:59:59');
        $oStartDate->addSeconds(1);
        $oUpdateIntermediateToDate = new Date('2006-03-09 11:29:59');
        $oEndDate = new Date('2006-03-09 11:29:58');
        $oEndDate->addSeconds(1);
        $oSummariseIntermediate->oController->updateUsingOI = true;
        $oSummariseIntermediate->oController->updateIntermediate = true;
        $oSummariseIntermediate->oController->lastDateIntermediate = $olastDateIntermediate;
        $oSummariseIntermediate->oController->updateIntermediateToDate = $oUpdateIntermediateToDate;
        $oSummariseIntermediate->oController->updateFinal = false;
        $oSummariseIntermediate->expectOnce('_summariseIntermediateRequests', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->expectOnce('_summariseIntermediateImpressions', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->expectOnce('_summariseIntermediateClicks', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->expectNever('_summariseIntermediateConnections');
        $oSummariseIntermediate->expectOnce('_saveIntermediateSummaries', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->run();
        $oSummariseIntermediate->tally();

        // Test 3
        $conf['modules']['Tracker'] = false;
        $conf['maintenance']['operationInterval'] = 30;
        $oSummariseIntermediate = new PartialMockMAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate($this);
        $olastDateFinal = new Date('2006-03-09 10:59:59');
        $oStartDate = new Date('2006-03-09 10:59:59');
        $oStartDate->addSeconds(1);
        $oUpdateFinalToDate = new Date('2006-03-09 11:59:59');
        $oEndDate = new Date('2006-03-09 11:59:58');
        $oEndDate->addSeconds(1);
        $oSummariseIntermediate->oController->updateUsingOI = false;
        $oSummariseIntermediate->oController->updateIntermediate = false;
        $oSummariseIntermediate->oController->updateFinal = true;
        $oSummariseIntermediate->oController->lastDateFinal = $olastDateFinal;
        $oSummariseIntermediate->oController->updateFinalToDate = $oUpdateFinalToDate;
        $oSummariseIntermediate->expectOnce('_summariseIntermediateRequests', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->expectOnce('_summariseIntermediateImpressions', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->expectOnce('_summariseIntermediateClicks', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->expectNever('_summariseIntermediateConnections');
        $oSummariseIntermediate->expectOnce('_saveIntermediateSummaries', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->run();
        $oSummariseIntermediate->tally();

        // Test 4
        $conf['modules']['Tracker'] = false;
        $conf['maintenance']['operationInterval'] = 30;
        $oSummariseIntermediate = new PartialMockMAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate($this);
        $olastDateIntermediate = new Date('2006-03-09 10:59:59');
        $oStartDate0 = new Date('2006-03-09 10:59:59');
        $oStartDate0->addSeconds(1);
        $oStartDate1 = new Date('2006-03-09 11:29:59');
        $oStartDate1->addSeconds(1);
        $oStartDate2 = new Date('2006-03-09 11:59:59');
        $oStartDate2->addSeconds(1);
        $oUpdateIntermediateToDate = new Date('2006-03-09 12:29:59');
        $oEndDate0 = new Date('2006-03-09 11:29:58');
        $oEndDate0->addSeconds(1);
        $oEndDate1 = new Date('2006-03-09 11:59:58');
        $oEndDate1->addSeconds(1);
        $oEndDate2 = new Date('2006-03-09 12:29:58');
        $oEndDate2->addSeconds(1);
        $oSummariseIntermediate->oController->updateUsingOI = true;
        $oSummariseIntermediate->oController->updateIntermediate = true;
        $oSummariseIntermediate->oController->lastDateIntermediate = $olastDateIntermediate;
        $oSummariseIntermediate->oController->updateIntermediateToDate = $oUpdateIntermediateToDate;
        $oSummariseIntermediate->oController->updateFinal = false;
        $oSummariseIntermediate->expectCallCount('_summariseIntermediateRequests', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_summariseIntermediateRequests', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_summariseIntermediateRequests', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_summariseIntermediateRequests', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->expectCallCount('_summariseIntermediateImpressions', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_summariseIntermediateImpressions', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_summariseIntermediateImpressions', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_summariseIntermediateImpressions', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->expectCallCount('_summariseIntermediateClicks', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_summariseIntermediateClicks', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_summariseIntermediateClicks', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_summariseIntermediateClicks', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->expectNever('_summariseIntermediateConnections');
        $oSummariseIntermediate->expectCallCount('_saveIntermediateSummaries', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_saveIntermediateSummaries', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_saveIntermediateSummaries', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_saveIntermediateSummaries', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->run();
        $oSummariseIntermediate->tally();

        // Test 5
        $conf['modules']['Tracker'] = false;
        $conf['maintenance']['operationInterval'] = 30;
        $oSummariseIntermediate = new PartialMockMAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate($this);
        $olastDateFinal = new Date('2006-03-09 10:59:59');
        $oStartDate0 = new Date('2006-03-09 10:59:59');
        $oStartDate0->addSeconds(1);
        $oStartDate1 = new Date('2006-03-09 11:59:59');
        $oStartDate1->addSeconds(1);
        $oStartDate2 = new Date('2006-03-09 12:59:59');
        $oStartDate2->addSeconds(1);
        $oUpdateFinalToDate = new Date('2006-03-09 13:59:59');
        $oEndDate0 = new Date('2006-03-09 11:59:58');
        $oEndDate0->addSeconds(1);
        $oEndDate1 = new Date('2006-03-09 12:59:58');
        $oEndDate1->addSeconds(1);
        $oEndDate2 = new Date('2006-03-09 13:59:58');
        $oEndDate2->addSeconds(1);
        $oSummariseIntermediate->oController->updateUsingOI = false;
        $oSummariseIntermediate->oController->updateIntermediate = false;
        $oSummariseIntermediate->oController->updateFinal = true;
        $oSummariseIntermediate->oController->lastDateFinal = $olastDateFinal;
        $oSummariseIntermediate->oController->updateFinalToDate = $oUpdateFinalToDate;
        $oSummariseIntermediate->expectCallCount('_summariseIntermediateRequests', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_summariseIntermediateRequests', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_summariseIntermediateRequests', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_summariseIntermediateRequests', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->expectCallCount('_summariseIntermediateImpressions', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_summariseIntermediateImpressions', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_summariseIntermediateImpressions', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_summariseIntermediateImpressions', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->expectCallCount('_summariseIntermediateClicks', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_summariseIntermediateClicks', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_summariseIntermediateClicks', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_summariseIntermediateClicks', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->expectNever('_summariseIntermediateConnections');
        $oSummariseIntermediate->expectCallCount('_saveIntermediateSummaries', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_saveIntermediateSummaries', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_saveIntermediateSummaries', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_saveIntermediateSummaries', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->run();
        $oSummariseIntermediate->tally();

        // Test 6
        $conf['modules']['Tracker'] = true;
        $conf['maintenance']['operationInterval'] = 30;
        $oSummariseIntermediate = new PartialMockMAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate($this);
        $oSummariseIntermediate->oController->updateUsingOI = false;
        $oSummariseIntermediate->oController->updateIntermediate = false;
        $oSummariseIntermediate->oController->updateFinal = false;
        $oSummariseIntermediate->expectNever('_summariseIntermediateRequests');
        $oSummariseIntermediate->expectNever('_summariseIntermediateImpressions');
        $oSummariseIntermediate->expectNever('_summariseIntermediateClicks');
        $oSummariseIntermediate->expectNever('_summariseIntermediateConnections');
        $oSummariseIntermediate->expectNever('_saveIntermediateSummaries');
        $oSummariseIntermediate->run();
        $oSummariseIntermediate->tally();

        // Test 7
        $conf['modules']['Tracker'] = true;
        $conf['maintenance']['operationInterval'] = 30;
        $oSummariseIntermediate = new PartialMockMAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate($this);
        $olastDateIntermediate = new Date('2006-03-09 10:59:59');
        $oStartDate = new Date('2006-03-09 10:59:59');
        $oStartDate->addSeconds(1);
        $oUpdateIntermediateToDate = new Date('2006-03-09 11:29:59');
        $oEndDate = new Date('2006-03-09 11:29:58');
        $oEndDate->addSeconds(1);
        $oSummariseIntermediate->oController->updateUsingOI = true;
        $oSummariseIntermediate->oController->updateIntermediate = true;
        $oSummariseIntermediate->oController->lastDateIntermediate = $olastDateIntermediate;
        $oSummariseIntermediate->oController->updateIntermediateToDate = $oUpdateIntermediateToDate;
        $oSummariseIntermediate->oController->updateFinal = false;
        $oSummariseIntermediate->expectOnce('_summariseIntermediateRequests', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->expectOnce('_summariseIntermediateImpressions', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->expectOnce('_summariseIntermediateClicks', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->expectOnce('_summariseIntermediateConnections', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->expectOnce('_saveIntermediateSummaries', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->run();
        $oSummariseIntermediate->tally();

        // Test 8
        $conf['modules']['Tracker'] = true;
        $conf['maintenance']['operationInterval'] = 30;
        $oSummariseIntermediate = new PartialMockMAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate($this);
        $olastDateFinal = new Date('2006-03-09 10:59:59');
        $oStartDate = new Date('2006-03-09 10:59:59');
        $oStartDate->addSeconds(1);
        $oUpdateFinalToDate = new Date('2006-03-09 11:59:59');
        $oEndDate = new Date('2006-03-09 11:59:58');
        $oEndDate->addSeconds(1);
        $oSummariseIntermediate->oController->updateUsingOI = false;
        $oSummariseIntermediate->oController->updateIntermediate = false;
        $oSummariseIntermediate->oController->updateFinal = true;
        $oSummariseIntermediate->oController->lastDateFinal = $olastDateFinal;
        $oSummariseIntermediate->oController->updateFinalToDate = $oUpdateFinalToDate;
        $oSummariseIntermediate->expectOnce('_summariseIntermediateRequests', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->expectOnce('_summariseIntermediateImpressions', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->expectOnce('_summariseIntermediateClicks', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->expectOnce('_summariseIntermediateConnections', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->expectOnce('_saveIntermediateSummaries', array($oStartDate, $oEndDate));
        $oSummariseIntermediate->run();
        $oSummariseIntermediate->tally();

        // Test 9
        $conf['modules']['Tracker'] = true;
        $conf['maintenance']['operationInterval'] = 30;
        $oSummariseIntermediate = new PartialMockMAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate($this);
        $olastDateIntermediate = new Date('2006-03-09 10:59:59');
        $oStartDate0 = new Date('2006-03-09 10:59:59');
        $oStartDate0->addSeconds(1);
        $oStartDate1 = new Date('2006-03-09 11:29:59');
        $oStartDate1->addSeconds(1);
        $oStartDate2 = new Date('2006-03-09 11:59:59');
        $oStartDate2->addSeconds(1);
        $oUpdateIntermediateToDate = new Date('2006-03-09 12:29:59');
        $oEndDate0 = new Date('2006-03-09 11:29:58');
        $oEndDate0->addSeconds(1);
        $oEndDate1 = new Date('2006-03-09 11:59:58');
        $oEndDate1->addSeconds(1);
        $oEndDate2 = new Date('2006-03-09 12:29:58');
        $oEndDate2->addSeconds(1);
        $oSummariseIntermediate->oController->updateUsingOI = true;
        $oSummariseIntermediate->oController->updateIntermediate = true;
        $oSummariseIntermediate->oController->lastDateIntermediate = $olastDateIntermediate;
        $oSummariseIntermediate->oController->updateIntermediateToDate = $oUpdateIntermediateToDate;
        $oSummariseIntermediate->oController->updateFinal = false;
        $oSummariseIntermediate->expectCallCount('_summariseIntermediateRequests', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_summariseIntermediateRequests', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_summariseIntermediateRequests', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_summariseIntermediateRequests', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->expectCallCount('_summariseIntermediateImpressions', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_summariseIntermediateImpressions', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_summariseIntermediateImpressions', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_summariseIntermediateImpressions', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->expectCallCount('_summariseIntermediateClicks', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_summariseIntermediateClicks', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_summariseIntermediateClicks', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_summariseIntermediateClicks', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->expectCallCount('_summariseIntermediateConnections', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_summariseIntermediateConnections', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_summariseIntermediateConnections', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_summariseIntermediateConnections', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->expectCallCount('_saveIntermediateSummaries', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_saveIntermediateSummaries', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_saveIntermediateSummaries', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_saveIntermediateSummaries', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->run();
        $oSummariseIntermediate->tally();

        // Test 10
        $conf['modules']['Tracker'] = true;
        $conf['maintenance']['operationInterval'] = 30;
        $oSummariseIntermediate = new PartialMockMAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate($this);
        $olastDateFinal = new Date('2006-03-09 10:59:59');
        $oStartDate0 = new Date('2006-03-09 10:59:59');
        $oStartDate0->addSeconds(1);
        $oStartDate1 = new Date('2006-03-09 11:59:59');
        $oStartDate1->addSeconds(1);
        $oStartDate2 = new Date('2006-03-09 12:59:59');
        $oStartDate2->addSeconds(1);
        $oUpdateFinalToDate = new Date('2006-03-09 13:59:59');
        $oEndDate0 = new Date('2006-03-09 11:59:58');
        $oEndDate0->addSeconds(1);
        $oEndDate1 = new Date('2006-03-09 12:59:58');
        $oEndDate1->addSeconds(1);
        $oEndDate2 = new Date('2006-03-09 13:59:58');
        $oEndDate2->addSeconds(1);
        $oSummariseIntermediate->oController->updateUsingOI = false;
        $oSummariseIntermediate->oController->updateIntermediate = false;
        $oSummariseIntermediate->oController->updateFinal = true;
        $oSummariseIntermediate->oController->lastDateFinal = $olastDateFinal;
        $oSummariseIntermediate->oController->updateFinalToDate = $oUpdateFinalToDate;
        $oSummariseIntermediate->expectCallCount('_summariseIntermediateRequests', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_summariseIntermediateRequests', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_summariseIntermediateRequests', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_summariseIntermediateRequests', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->expectCallCount('_summariseIntermediateImpressions', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_summariseIntermediateImpressions', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_summariseIntermediateImpressions', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_summariseIntermediateImpressions', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->expectCallCount('_summariseIntermediateClicks', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_summariseIntermediateClicks', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_summariseIntermediateClicks', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_summariseIntermediateClicks', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->expectCallCount('_summariseIntermediateConnections', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_summariseIntermediateConnections', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_summariseIntermediateConnections', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_summariseIntermediateConnections', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->expectCallCount('_saveIntermediateSummaries', 3);
        $oSummariseIntermediate->expectArgumentsAt(0, '_saveIntermediateSummaries', array($oStartDate0, $oEndDate0));
        $oSummariseIntermediate->expectArgumentsAt(1, '_saveIntermediateSummaries', array($oStartDate1, $oEndDate1));
        $oSummariseIntermediate->expectArgumentsAt(2, '_saveIntermediateSummaries', array($oStartDate2, $oEndDate2));
        $oSummariseIntermediate->run();
        $oSummariseIntermediate->tally();
    }

    /**
     * A method to test the _summariseIntermediateRequests() method.
     */
    function test_summariseIntermediateRequests()
    {
        // Prepare dates
        $oStartDate = new Date('2006-03-09 10:00:00');
        $oEndDate   = new Date('2006-03-09 10:59:59');
        // Mock the DAL, and set expectations
        Mock::generate('OA_Dal_Maintenance_Statistics_AdServer_mysql');
        $oDal = new MockOA_Dal_Maintenance_Statistics_AdServer_mysql($this);
        $oDal->expectOnce('summariseRequests', array($oStartDate, $oEndDate));
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Statistics_AdServer', $oDal);
        // Test
        $oSummariseIntermediate = new MAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate();
        $oSummariseIntermediate->_summariseIntermediateRequests($oStartDate, $oEndDate);
        $oDal->tally();
    }

    /**
     * A method to test the _summariseIntermediateImpressions() method.
     */
    function test_summariseIntermediateImpressions()
    {
        // Prepare dates
        $oStartDate = new Date('2006-03-09 10:00:00');
        $oEndDate   = new Date('2006-03-09 10:59:59');
        // Mock the DAL, and set expectations
        Mock::generate('OA_Dal_Maintenance_Statistics_AdServer_mysql');
        $oDal = new MockOA_Dal_Maintenance_Statistics_AdServer_mysql($this);
        $oDal->expectOnce('summariseImpressions', array($oStartDate, $oEndDate));
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Statistics_AdServer', $oDal);
        // Test
        $oSummariseIntermediate = new MAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate();
        $oSummariseIntermediate->_summariseIntermediateImpressions($oStartDate, $oEndDate);
        $oDal->tally();
    }

    /**
     * A method to test the _summariseIntermediateClicks() method.
     */
    function test_summariseIntermediateClicks()
    {
        // Prepare dates
        $oStartDate = new Date('2006-03-09 10:00:00');
        $oEndDate   = new Date('2006-03-09 10:59:59');
        // Mock the DAL, and set expectations
        Mock::generate('OA_Dal_Maintenance_Statistics_AdServer_mysql');
        $oDal = new MockOA_Dal_Maintenance_Statistics_AdServer_mysql($this);
        $oDal->expectOnce('summariseClicks', array($oStartDate, $oEndDate));
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Statistics_AdServer', $oDal);
        // Test
        $oSummariseIntermediate = new MAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate();
        $oSummariseIntermediate->_summariseIntermediateClicks($oStartDate, $oEndDate);
        $oDal->tally();
    }

    /**
     * A method to test the _summariseIntermediateConnections() method.
     */
    function test_summariseIntermediateConnections()
    {
        // Prepare dates
        $oStartDate = new Date('2006-03-09 10:00:00');
        $oEndDate   = new Date('2006-03-09 10:59:59');
        // Mock the DAL, and set expectations
        Mock::generate('OA_Dal_Maintenance_Statistics_AdServer_mysql');
        $oDal = new MockOA_Dal_Maintenance_Statistics_AdServer_mysql($this);
        $oDal->expectOnce('summariseConnections', array($oStartDate, $oEndDate));
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Statistics_AdServer', $oDal);
        // Test
        $oSummariseIntermediate = new MAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate();
        $oSummariseIntermediate->_summariseIntermediateConnections($oStartDate, $oEndDate);
        $oDal->tally();
    }

    /**
     * A method to test the _saveIntermediateSummaries() method.
     */
    function test_saveIntermediateSummaries()
    {
        // Prepare dates
        $oStartDate = new Date('2006-03-09 10:00:00');
        $oEndDate   = new Date('2006-03-09 10:59:59');
        // Mock the DAL, and set expectations
        Mock::generate('OA_Dal_Maintenance_Statistics_AdServer_mysql');
        $oDal = new MockOA_Dal_Maintenance_Statistics_AdServer_mysql($this);
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
        $oDal->expectOnce('saveIntermediate', array($oStartDate, $oEndDate, $aTypes));
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Statistics_AdServer', $oDal);
        // Test
        $oSummariseIntermediate = new MAX_Maintenance_Statistics_AdServer_Task_SummariseIntermediate();
        $oSummariseIntermediate->_saveIntermediateSummaries($oStartDate, $oEndDate);
        $oDal->tally();
    }

}

?>
