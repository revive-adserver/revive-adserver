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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task.php';

/**
 * A class for testing the OA_Maintenance_Priority_AdServer_Task class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OA_Maintenance_Priority_AdServer_Task extends UnitTestCase
{
    public function __construct()
    {
        parent::__construct();
        Mock::generate('OA_Dal_Maintenance_Priority');
    }

    public function testRunnerHasResources()
    {
        // Mock the OA_Dal_Maintenance_Priority class used in the constructor method
        $oDal = new MockOA_Dal_Maintenance_Priority($this);
        $oServiceLocator = OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);

        $task = new class extends OA_Maintenance_Priority_AdServer_Task {
            public function run(): bool
            {
                return true;
            }
        };
        $this->assertTrue(is_object($task->oDal));
        $this->assertTrue(is_a($task->oDal, 'MockOA_Dal_Maintenance_Priority'));
    }
}
