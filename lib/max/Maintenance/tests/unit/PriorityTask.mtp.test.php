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

require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer/Task.php';

/**
 * A class for testing the Maintenance_Priority_DeliveryLimitation class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Demian Turner
 */
class TestOfPriorityTask extends UnitTestCase
{

   /**
    * The constructor method.
    */
    function TestOfPriorityTask()
    {
        $this->UnitTestCase();
        Mock::generate('MAX_Dal_Maintenance_Priority');
    }

    function testRunnerHasResources()
    {
        // Mock the MAX_Dal_Maintenance_Priority class used in the constructor method
        $oDal = new MockMAX_Dal_Maintenance_Priority($this);
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('MAX_Dal_Maintenance_Priority', $oDal);

        $task = new MAX_Maintenance_Priority_Adserver_Task();
        $this->assertTrue(is_object($task->oDal));
        $this->assertTrue(is_a($task->oDal, 'MockMAX_Dal_Maintenance_Priority'));
    }
}

?>
