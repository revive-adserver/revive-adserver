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
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

/**
 * A class for testing the OA_Maintenance_Statistics_AdServer class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Test_OA_Maintenance_Statistics_AdServer extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Statistics_AdServer()
    {
        $this->UnitTestCase();
        // Register a mocked DAL in the service locator
        Mock::generate('OA_Dal_Maintenance_Statistics_AdServer_mysql');
        $oDal = new MockOA_Dal_Maintenance_Statistics_AdServer_mysql($this);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Statistics_AdServer', $oDal);
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oMaintenanceStatistics =& new OA_Maintenance_Statistics_AdServer();
        $this->assertTrue(is_a($oMaintenanceStatistics, 'OA_Maintenance_Statistics_AdServer'));
        $this->assertEqual($oMaintenanceStatistics->module, 'AdServer');
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oTest =& $oServiceLocator->get('Maintenance_Statistics_Controller');
        $this->assertReference($oMaintenanceStatistics, $oTest);
        $this->assertTrue(is_a($oMaintenanceStatistics->oTaskRunner, 'OA_Task_Runner'));
        $this->assertEqual(count($oMaintenanceStatistics->oTaskRunner->aTasks), 6);
        $this->assertTrue(is_a($oMaintenanceStatistics->oTaskRunner->aTasks[0], 'OA_Maintenance_Statistics_AdServer_Task_SetUpdateRequirements'));
        $this->assertTrue(is_a($oMaintenanceStatistics->oTaskRunner->aTasks[1], 'OA_Maintenance_Statistics_AdServer_Task_SummariseIntermediate'));
        $this->assertTrue(is_a($oMaintenanceStatistics->oTaskRunner->aTasks[2], 'OA_Maintenance_Statistics_AdServer_Task_SummariseFinal'));
        $this->assertTrue(is_a($oMaintenanceStatistics->oTaskRunner->aTasks[3], 'OA_Maintenance_Statistics_AdServer_Task_ManagePlacements'));
        $this->assertTrue(is_a($oMaintenanceStatistics->oTaskRunner->aTasks[4], 'OA_Maintenance_Statistics_AdServer_Task_DeleteOldData'));
        $this->assertTrue(is_a($oMaintenanceStatistics->oTaskRunner->aTasks[5], 'OA_Maintenance_Statistics_AdServer_Task_LogCompletion'));
    }

}

?>
