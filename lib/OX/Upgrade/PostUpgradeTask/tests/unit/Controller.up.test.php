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

require_once MAX_PATH . '/lib/OX/Upgrade/PostUpgradeTask/Controller.php';


/**
 * A class for testing the OX_Upgrade_PostUpgradeTask_Controller
 *
 * @package    OpenX
 * @subpackage TestSuite
 */
class OX_Upgrade_PostUpgradeTask_ControllerTest extends UnitTestCase
{

    function testgetTasksUrls()
    {
        Mock::generatePartial(
            'OA_Upgrade',
            'OA_UpgradeMock',
            array('getPostUpgradeTasks')
        );

        $baseInstallUrl = 'my base url';
        $oUpgrade = new OA_UpgradeMock($this);
        $oUpgrade->setReturnValue('getPostUpgradeTasks', array('task_1', 'task_2'));
        $GLOBALS['strPostInstallTaskRunning'] = 'Running task';

        $result = OX_Upgrade_PostUpgradeTask_Controller::getTasksUrls($baseInstallUrl, $oUpgrade);
        $expected = array(
            array('id' => 'task:task_1', 'name' => 'Running task: task_1', 'url' => $baseInstallUrl.'install-runtask.php?task=task_1'),
            array('id' => 'task:task_2', 'name' => 'Running task: task_2', 'url' => $baseInstallUrl.'install-runtask.php?task=task_2'));
        $this->assertEqual($result, $expected);
    }
}
