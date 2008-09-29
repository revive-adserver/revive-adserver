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

require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/OA/OperationInterval.php';

require_once LIB_PATH . '/Maintenance/Statistics.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/SetUpdateRequirements.php';

/**
 * A class for testing the OX_Maintenance_Statistics_Task_SetUpdateRequirements class.
 *
 * Note that the _getMaintenanceStatisticsLastRunInfo() and _getEarliestLoggedDeliveryData()
 * methods are tested in the integration test suite, on account of the plugin and database
 * connectivity requirements.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OX_Maintenance_Statistics_Task_SetUpdateRequirements extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OX_Maintenance_Statistics_Task_SetUpdateRequirements()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oSetUpdateRequirements = new OX_Maintenance_Statistics_Task_SetUpdateRequirements();
        $this->assertTrue(is_a($oSetUpdateRequirements, 'OX_Maintenance_Statistics_Task_SetUpdateRequirements'));
    }

    /**
     * A method to test the run() method.
     */
    function testRun()
    {
        // Create a reference to the OpenX configuration so that settings
        // can be changed while the tests are running
        $aConf =& $GLOBALS['_MAX']['CONF'];

        // Create the database connection and service locator objects
        $oDbh            =& OA_DB::singleton();
        $oServiceLocator =& OA_ServiceLocator::instance();

        // Create the "log_maintenance_statistics" table required for the tests
        $oTables =& OA_DB_Table_Core::singleton();
        $oTables->createTable('log_maintenance_statistics');

        // Create the "controller" OX_Maintenance_Statistics class, and
        // register in the service locator
        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        // Create a partially mocked instance of the
        // OX_Maintenance_Statistics_Task_SetUpdateRequirements class
        Mock::generatePartial(
            'OX_Maintenance_Statistics_Task_SetUpdateRequirements',
            'PartialOX_Maintenance_Statistics_Task_SetUpdateRequirements',
            array(
                '_getMaintenanceStatisticsLastRunInfo',
                '_getEarliestLoggedDeliveryData',
                '_checkTables'
            )
        );

        // Prepare an array of times that the MSE should be run at, to
        // test the effects of different times and data sets
        $aMSERunTimes = array(
            0 => new Date('2008-08-12 13:00:01'),
            1 => new Date('2008-08-12 13:30:01'),
            2 => new Date('2008-08-12 14:00:01')
        );


        // Create an array of valid operation interval values for runnung tests
        $aOperationIntervals = array(30, 60);

        /*-------------------------------------------------------------*/
        /* NO DATA TESTS                                               */
        /*                                                             */
        /* Run tests where with operation intervals of 30 and 60 mins, */
        /* where there is no data in the database, and test that the   */
        /* result is that the MSE will not be run.                     */
        /*-------------------------------------------------------------*/

        foreach ($aMSERunTimes as $key => $oRunDate) {

            // Register the "current" date/time that the MSE is running at
            $oServiceLocator->register('now', $oRunDate);

            foreach ($aOperationIntervals as $operationInterval) {

                // Set the correct operation interval
                $aConf['maintenance']['operationInterval'] = $operationInterval;

                // Prepare the partially mocked instance of the
                // OX_Maintenance_Statistics_Task_SetUpdateRequirements class with
                // the expectations and return values required for the test run

                $oSetUpdateRequirements = new PartialOX_Maintenance_Statistics_Task_SetUpdateRequirements();

                $oSetUpdateRequirements->setReturnValue('_checkTables', true);

                $oSetUpdateRequirements->expectCallCount('_getMaintenanceStatisticsLastRunInfo', 2);
                $oSetUpdateRequirements->expectCallCount('_getEarliestLoggedDeliveryData', 2);

                $oSetUpdateRequirements->expectAt(0, '_getMaintenanceStatisticsLastRunInfo', array(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI, $oRunDate));
                $oSetUpdateRequirements->setReturnValueAt(0, '_getMaintenanceStatisticsLastRunInfo', null);

                $oSetUpdateRequirements->expectAt(0, '_getEarliestLoggedDeliveryData', array(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI));
                $oSetUpdateRequirements->setReturnValueAt(0, '_getEarliestLoggedDeliveryData', null);

                $oSetUpdateRequirements->expectAt(1, '_getMaintenanceStatisticsLastRunInfo', array(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR, $oRunDate));
                $oSetUpdateRequirements->setReturnValueAt(1, '_getMaintenanceStatisticsLastRunInfo', null);

                $oSetUpdateRequirements->expectAt(1, '_getEarliestLoggedDeliveryData', array(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR));
                $oSetUpdateRequirements->setReturnValueAt(1, '_getEarliestLoggedDeliveryData', null);

                // Create the OX_Maintenance_Statistics_Task_SetUpdateRequirements
                // object and run the task
                $oSetUpdateRequirements->OX_Maintenance_Statistics_Task_SetUpdateRequirements($this);
                $oSetUpdateRequirements->run();

                // Test the results of the task run
                $this->assertFalse($oSetUpdateRequirements->oController->updateIntermediate);
                $this->assertFalse($oSetUpdateRequirements->oController->updateFinal);

            }

        }

        /*-------------------------------------------------------------*/
        /* ONLY LOGGED DELIVERY DATA TESTS                             */
        /*                                                             */
        /* Run tests where with operation intervals of 30 and 60 mins, */
        /* where there is only delivery data in the database (i.e. no  */
        /* previous MSE run) and test that the result is that the MSE  */
        /* will be run from the appropriate date/time.                 */
        /*-------------------------------------------------------------*/

        // Set the value that will be returned for the last MSE run
        // update value, based on the earliest logged data, in terms of
        // the operation interval
        $oEarliestLoggedDataDateOI = new Date('2008-08-12 13:29:59');

        // Set the value that will be returned for the last MSE run
        // update value, based on the earliest logged data, in terms of
        // the hour
        $oEarliestLoggedDataDateHour = new Date('2008-08-12 12:59:59');

        foreach ($aMSERunTimes as $key => $oRunDate) {

            // Register the "current" date/time that the MSE is running at
            $oServiceLocator->register('now', $oRunDate);

            foreach ($aOperationIntervals as $operationInterval) {

                // Set the correct operation interval
                $aConf['maintenance']['operationInterval'] = $operationInterval;

                // Prepare the partially mocked instance of the
                // OX_Maintenance_Statistics_Task_SetUpdateRequirements class with
                // the expectations and return values required for the test run

                $oSetUpdateRequirements = new PartialOX_Maintenance_Statistics_Task_SetUpdateRequirements();

                $oSetUpdateRequirements->setReturnValue('_checkTables', true);

                $oSetUpdateRequirements->expectCallCount('_getMaintenanceStatisticsLastRunInfo', 2);
                $oSetUpdateRequirements->expectCallCount('_getEarliestLoggedDeliveryData', 2);

                $oSetUpdateRequirements->expectAt(0, '_getMaintenanceStatisticsLastRunInfo', array(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI, $oRunDate));
                $oSetUpdateRequirements->setReturnValueAt(0, '_getMaintenanceStatisticsLastRunInfo', null);

                $oSetUpdateRequirements->expectAt(0, '_getEarliestLoggedDeliveryData', array(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI));
                $oSetUpdateRequirements->setReturnValueAt(0, '_getEarliestLoggedDeliveryData', $oEarliestLoggedDataDateOI);

                $oSetUpdateRequirements->expectAt(1, '_getMaintenanceStatisticsLastRunInfo', array(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR, $oRunDate));
                $oSetUpdateRequirements->setReturnValueAt(1, '_getMaintenanceStatisticsLastRunInfo', null);

                $oSetUpdateRequirements->expectAt(1, '_getEarliestLoggedDeliveryData', array(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR));
                $oSetUpdateRequirements->setReturnValueAt(1, '_getEarliestLoggedDeliveryData', $oEarliestLoggedDataDateHour);

                // Create the OX_Maintenance_Statistics_Task_SetUpdateRequirements
                // object and run the task
                $oSetUpdateRequirements->OX_Maintenance_Statistics_Task_SetUpdateRequirements($this);
                $oSetUpdateRequirements->run();

                // Test the results of the task run
                if ($key == 0) {

                    // There is no data logged before "now"; therefore, no udpates will be run
                    $this->assertFalse($oSetUpdateRequirements->oController->updateIntermediate);
                    $this->assertFalse($oSetUpdateRequirements->oController->updateFinal);

                } elseif ($key == 1) {

                    // There is logged data before "now", but a complete operation interval
                    // will only have been passed at this stage IF the operation interval is
                    // 30 minutes; in that case, the MSE will update the intermedaite tables;
                    // otherwise, no updates will be run
                    if ($operationInterval == 30) {
                        $this->assertTrue($oSetUpdateRequirements->oController->updateIntermediate);
                        $this->assertFalse($oSetUpdateRequirements->oController->updateFinal);
                    } else {
                        $this->assertFalse($oSetUpdateRequirements->oController->updateIntermediate);
                        $this->assertFalse($oSetUpdateRequirements->oController->updateFinal);
                    }

                } elseif ($key == 2) {

                    // There is logged data before "now", and a complete operation interval
                    // will have been passed at this stage, and the update boundary is on the
                    // hour, so the MSE will update the intermedaite and final tables
                    $this->assertTrue($oSetUpdateRequirements->oController->updateIntermediate);
                    $this->assertTrue($oSetUpdateRequirements->oController->updateFinal);

                }

            }

        }

        /*-------------------------------------------------------------*/
        /* REAL PAST MSE OI RUN ONLY TESTS                             */
        /*                                                             */
        /* Run tests where with operation intervals of 30 and 60 mins, */
        /* where there the MSE has run previously on the basis of the  */
        /* operation interval, but not for the hour, and test that the */
        /* result is that the MSE will be run from the appropriate     */
        /* date/time.                                                  */
        /*-------------------------------------------------------------*/

        // Set the value that will be returned for the last MSE run
        // update value, based on the the operation interval
        $oLastMSERunOI = new Date('2008-08-12 13:29:59');

        // Set the value that will be returned for the last MSE run
        // update value, based on the earliest logged data, in terms of
        // the hour
        $oEarliestLoggedDataDateHour = new Date('2008-08-12 12:59:59');

        foreach ($aMSERunTimes as $key => $oRunDate) {

            // Register the "current" date/time that the MSE is running at
            $oServiceLocator->register('now', $oRunDate);

            foreach ($aOperationIntervals as $operationInterval) {

                // Set the correct operation interval
                $aConf['maintenance']['operationInterval'] = $operationInterval;

                // Prepare the partially mocked instance of the
                // OX_Maintenance_Statistics_Task_SetUpdateRequirements class with
                // the expectations and return values required for the test run

                $oSetUpdateRequirements = new PartialOX_Maintenance_Statistics_Task_SetUpdateRequirements();

                $oSetUpdateRequirements->setReturnValue('_checkTables', true);

                $oSetUpdateRequirements->expectCallCount('_getMaintenanceStatisticsLastRunInfo', 2);
                $oSetUpdateRequirements->expectCallCount('_getEarliestLoggedDeliveryData', 1);

                $oSetUpdateRequirements->expectAt(0, '_getMaintenanceStatisticsLastRunInfo', array(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI, $oRunDate));
                $oSetUpdateRequirements->setReturnValueAt(0, '_getMaintenanceStatisticsLastRunInfo', $oLastMSERunOI);

                $oSetUpdateRequirements->expectAt(1, '_getMaintenanceStatisticsLastRunInfo', array(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR, $oRunDate));
                $oSetUpdateRequirements->setReturnValueAt(1, '_getMaintenanceStatisticsLastRunInfo', null);

                $oSetUpdateRequirements->expectAt(0, '_getEarliestLoggedDeliveryData', array(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR));
                $oSetUpdateRequirements->setReturnValueAt(0, '_getEarliestLoggedDeliveryData', $oEarliestLoggedDataDateHour);

                // Create the OX_Maintenance_Statistics_Task_SetUpdateRequirements
                // object and run the task
                $oSetUpdateRequirements->OX_Maintenance_Statistics_Task_SetUpdateRequirements($this);
                $oSetUpdateRequirements->run();

                // Test the results of the task run
                if ($key == 0) {

                    // There is no data logged before "now"; therefore, no udpates will be run
                    $this->assertFalse($oSetUpdateRequirements->oController->updateIntermediate);
                    $this->assertFalse($oSetUpdateRequirements->oController->updateFinal);

                } elseif ($key == 1) {

                    // There is logged data before "now", but a complete operation interval
                    // will only have been passed at this stage IF the operation interval is
                    // 30 minutes; in that case, the MSE will update the intermedaite tables;
                    // otherwise, no updates will be run
                    if ($operationInterval == 30) {
                        $this->assertTrue($oSetUpdateRequirements->oController->updateIntermediate);
                        $this->assertFalse($oSetUpdateRequirements->oController->updateFinal);
                    } else {
                        $this->assertFalse($oSetUpdateRequirements->oController->updateIntermediate);
                        $this->assertFalse($oSetUpdateRequirements->oController->updateFinal);
                    }

                } elseif ($key == 2) {

                    // There is logged data before "now", and a complete operation interval
                    // will have been passed at this stage, and the update boundary is on the
                    // hour, so the MSE will update the intermedaite and final tables
                    $this->assertTrue($oSetUpdateRequirements->oController->updateIntermediate);
                    $this->assertTrue($oSetUpdateRequirements->oController->updateFinal);

                }

            }

        }

        /*-------------------------------------------------------------*/
        /* REAL PAST MSE RUN TESTS                                     */
        /*                                                             */
        /* Run tests where with operation intervals of 30 and 60 mins, */
        /* where there the MSE has run previously, and test that the   */
        /* result is that the MSE will be run from the appropriate     */
        /* date/time.                                                  */
        /*-------------------------------------------------------------*/

        // Set the value that will be returned for the last MSE run
        // update value, based on the the operation interval
        $oLastMSERunOI = new Date('2008-08-12 13:29:59');

        // Set the value that will be returned for the last MSE run
        // update value, based on the the hour
        $oLastMSERunHour = new Date('2008-08-12 12:59:59');

        foreach ($aMSERunTimes as $key => $oRunDate) {

            // Register the "current" date/time that the MSE is running at
            $oServiceLocator->register('now', $oRunDate);

            foreach ($aOperationIntervals as $operationInterval) {

                // Set the correct operation interval
                $aConf['maintenance']['operationInterval'] = $operationInterval;

                // Prepare the partially mocked instance of the
                // OX_Maintenance_Statistics_Task_SetUpdateRequirements class with
                // the expectations and return values required for the test run

                $oSetUpdateRequirements = new PartialOX_Maintenance_Statistics_Task_SetUpdateRequirements();

                $oSetUpdateRequirements->setReturnValue('_checkTables', true);

                $oSetUpdateRequirements->expectCallCount('_getMaintenanceStatisticsLastRunInfo', 2);
                $oSetUpdateRequirements->expectCallCount('_getEarliestLoggedDeliveryData', 0);

                $oSetUpdateRequirements->expectAt(0, '_getMaintenanceStatisticsLastRunInfo', array(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI, $oRunDate));
                $oSetUpdateRequirements->setReturnValueAt(0, '_getMaintenanceStatisticsLastRunInfo', $oLastMSERunOI);

                $oSetUpdateRequirements->expectAt(1, '_getMaintenanceStatisticsLastRunInfo', array(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR, $oRunDate));
                $oSetUpdateRequirements->setReturnValueAt(1, '_getMaintenanceStatisticsLastRunInfo', $oLastMSERunHour);

                // Create the OX_Maintenance_Statistics_Task_SetUpdateRequirements
                // object and run the task
                $oSetUpdateRequirements->OX_Maintenance_Statistics_Task_SetUpdateRequirements($this);
                $oSetUpdateRequirements->run();

                // Test the results of the task run
                if ($key == 0) {

                    // There is no data logged before "now"; therefore, no udpates will be run
                    $this->assertFalse($oSetUpdateRequirements->oController->updateIntermediate);
                    $this->assertFalse($oSetUpdateRequirements->oController->updateFinal);

                } elseif ($key == 1) {

                    // There is logged data before "now", but a complete operation interval
                    // will only have been passed at this stage IF the operation interval is
                    // 30 minutes; in that case, the MSE will update the intermedaite tables;
                    // otherwise, no updates will be run
                    if ($operationInterval == 30) {
                        $this->assertTrue($oSetUpdateRequirements->oController->updateIntermediate);
                        $this->assertFalse($oSetUpdateRequirements->oController->updateFinal);
                    } else {
                        $this->assertFalse($oSetUpdateRequirements->oController->updateIntermediate);
                        $this->assertFalse($oSetUpdateRequirements->oController->updateFinal);
                    }

                } elseif ($key == 2) {

                    // There is logged data before "now", and a complete operation interval
                    // will have been passed at this stage, and the update boundary is on the
                    // hour, so the MSE will update the intermedaite and final tables
                    $this->assertTrue($oSetUpdateRequirements->oController->updateIntermediate);
                    $this->assertTrue($oSetUpdateRequirements->oController->updateFinal);

                }

            }

        }

        // Reset the testing environment
        TestEnv::restoreEnv();
    }

}

?>