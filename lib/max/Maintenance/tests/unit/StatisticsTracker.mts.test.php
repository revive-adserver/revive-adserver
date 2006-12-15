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
require_once MAX_PATH . '/lib/max/Dal/Maintenance/Statistics/Tracker/mysql.php';
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/Tracker.php';

/**
 * A class for testing the MAX_Maintenance_Statistics_Tracker class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMAX_Maintenance_Statistics_Tracker extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMAX_Maintenance_Statistics_Tracker()
    {
        $this->UnitTestCase();
        // Register a mocked DAL in the service locator
        Mock::generate('MAX_Dal_Maintenance_Statistics_Tracker_mysql');
        $oDal = new MockMAX_Dal_Maintenance_Statistics_Tracker_mysql($this);
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('MAX_Dal_Maintenance_Statistics_Tracker', $oDal);
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oMaintenanceStatistics = &new MAX_Maintenance_Statistics_Tracker();
        $this->assertTrue(is_a($oMaintenanceStatistics, 'MAX_Maintenance_Statistics_Tracker'));
        $this->assertEqual($oMaintenanceStatistics->module, 'Tracker');
        $oServiceLocator = &ServiceLocator::instance();
        $oTest = &$oServiceLocator->get('Maintenance_Statistics_Controller');
        $this->assertReference($oMaintenanceStatistics, $oTest);
        $this->assertTrue(is_a($oMaintenanceStatistics->oTaskRunner, 'MAX_Core_Task_Runner'));
        $this->assertEqual(count($oMaintenanceStatistics->oTaskRunner->aTasks), 5);
        $this->assertTrue(is_a($oMaintenanceStatistics->oTaskRunner->aTasks[0], 'MAX_Maintenance_Statistics_Tracker_Task_SetUpdateRequirements'));
        $this->assertTrue(is_a($oMaintenanceStatistics->oTaskRunner->aTasks[1], 'MAX_Maintenance_Statistics_Tracker_Task_SummariseIntermediate'));
        $this->assertTrue(is_a($oMaintenanceStatistics->oTaskRunner->aTasks[2], 'MAX_Maintenance_Statistics_Tracker_Task_SummariseFinal'));
        $this->assertTrue(is_a($oMaintenanceStatistics->oTaskRunner->aTasks[3], 'MAX_Maintenance_Statistics_Tracker_Task_DeleteOldData'));
        $this->assertTrue(is_a($oMaintenanceStatistics->oTaskRunner->aTasks[4], 'MAX_Maintenance_Statistics_Tracker_Task_LogCompletion'));
    }

}

?>
