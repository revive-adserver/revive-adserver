<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task.php';

/**
 * A class for testing the OA_Maintenance_Priority_AdServer_Task class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OA_Maintenance_Priority_AdServer_Task extends UnitTestCase
{

   /**
    * The constructor method.
    */
    function Test_OA_Maintenance_Priority_AdServer_Task()
    {
        $this->UnitTestCase();
        Mock::generate('OA_Dal_Maintenance_Priority');
    }

    function testRunnerHasResources()
    {
        // Mock the OA_Dal_Maintenance_Priority class used in the constructor method
        $oDal = new MockOA_Dal_Maintenance_Priority($this);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);

        $task = new OA_Maintenance_Priority_AdServer_Task();
        $this->assertTrue(is_object($task->oDal));
        $this->assertTrue(is_a($task->oDal, 'MockOA_Dal_Maintenance_Priority'));
    }
}

?>