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
$Id: Controller.up.test.php 43405 2009-09-18 11:25:38Z lukasz.wikierski $
*/

require_once MAX_PATH . '/lib/OX/Upgrade/PostUpgradeTask/Controller.php';


/**
 * A class for testing the OX_Upgrade_PostUpgradeTask_Controller
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
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
