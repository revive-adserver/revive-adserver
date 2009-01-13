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
require_once LIB_PATH . '/Maintenance/Statistics/Task/ManageConversions.php';

/**
 * A class for testing the OX_Maintenance_Statistics_Task_ManageConversions class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OX_Maintenance_Statistics_Task_ManageConversions extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OX_Maintenance_Statistics_Task_ManageConversions()
    {
        $this->UnitTestCase();
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
        $oDal->OX_Dal_Maintenance_Statistics();
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
        $oDal->OX_Dal_Maintenance_Statistics();
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