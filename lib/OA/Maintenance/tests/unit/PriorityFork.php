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

$path = dirname(__FILE__);
require_once $path . '/../../../../../init.php';

/**
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OA_Maintenance_PriorityFork
{

    function testForkRun()
    {
        require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';
        $pid = pcntl_fork();
        if ($pid == -1) {
            // something bad happened
        } else if ($pid == 0) {
            $resultChild = OA_Maintenance_Priority::run();
        } else {
            $resultParent = OA_Maintenance_Priority::run();
        }
        (isset($resultParent) && $resultParent === true) ? exit : exit(1);
    }
}

$test = new Test_OA_Maintenance_PriorityFork();
$test->testForkRun();

?>