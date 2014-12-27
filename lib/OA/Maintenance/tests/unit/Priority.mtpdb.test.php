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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';

/**
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OA_Maintenance_Priority extends UnitTestCase
{

    function XXXtestRun()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $result = OA_Maintenance_Priority::run();
        $this->assertTrue($result);

        $phpPath    = $aConf['test']['phpPath'] .' -f';
        $testPath   = MAX_PATH .'/lib/OA/Maintenance/tests/unit/PriorityFork.php';
        $host       = $_SERVER['SERVER_NAME'];
        system("$phpPath $testPath $host", $result);

        // 0 means it executed successfully, meaning the test was successful
        $this->assertEqual($result, 0);
    }

}

?>