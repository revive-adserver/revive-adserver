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
$Id: Job.up.test.php 43405 2009-09-18 11:25:38Z lukasz.wikierski $
*/

require_once MAX_PATH . '/lib/OX/Upgrade/Util/Job.php';


class OX_Upgrade_Util_JobMock extends OX_Upgrade_Util_Job {
    public static function setLogger($oLogger){ self::$oLogger = $oLogger;}
}

/**
 * A class for testing the OX_Upgrade_Util_Job
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_Upgrade_Util_JobTest extends UnitTestCase 
{
    
    function testSaveJobResult()
    {
        // clear session data
        $oStorage = OX_Admin_UI_Install_InstallUtils::getSessionStorage();
        @$oStorage->set('aJobStatuses', null);
        
        $result = array('name' => 'test', 
                        'type'=> 'testtype', 
                        'other_data' => 'testdata');
        
        OX_Upgrade_Util_Job::saveJobResult($result);
        
        $aJobStatuses = $oStorage->get('aJobStatuses');
        $expected = array( 'testtype:test' => $result);
        $this->assertEqual($aJobStatuses, $expected);
        
        // clear session data
        $oStorage->set('aJobStatuses', null);
    }
    
    
    function testIsInstallerStepCompleted()
    {
        $oStorage = OX_Admin_UI_Install_InstallUtils::getSessionStorage();
        $oStatus = $oStorage->set('installStatus', null);
        
        $aTask = array('name' => 'test', 'type'=> 'testtype');
        
        $result = OX_Upgrade_Util_Job::isInstallerStepCompleted('database', $aTask);
        $this->assertFalse($result);
        $this->assertEqual($aTask['errors'], array('Installation process not detected'));
        unset($aTask['errors']);
        
        Mock::generatePartial(
            'OX_Admin_UI_Install_InstallStatus',
            'OX_Admin_UI_Install_InstallStatusMock',
            array('isInstall', 'isUpgrade')
        );
        $oInstallStatus = new OX_Admin_UI_Install_InstallStatusMock($this);
        $oInstallStatus->setReturnValue('isInstall', true);
        $oInstallStatus->setReturnValue('isUpgrade', false);
        
        $oStatus = $oStorage->set('installStatus', $oInstallStatus);
        
        $result = OX_Upgrade_Util_Job::isInstallerStepCompleted('database', $aTask);
        
        $this->assertFalse($result);
        $this->assertEqual($aTask['errors'], array('Invalid installation step detected'));
        unset($aTask['errors']);
        
        $oWizard = new OX_Admin_UI_Install_Wizard($oInstallStatus);
        $oWizard->markStepAsCompleted('database');
        
        $result = OX_Upgrade_Util_Job::isInstallerStepCompleted('database', $aTask);
        $this->assertTrue($result);
        $this->assertTrue(empty($aTask['errors']));
        
        $oWizard->reset();
        $oStatus = $oStorage->set('installStatus', null);
    }
    
    
    function testLogError()
    {
        Mock::generatePartial(
            'OA_UpgradeLogger',
            'OA_UpgradeLoggerMock',
            array('logError')
        );
        
        $oLogger = new OA_UpgradeLoggerMock($this); 
        $oLogger->expectOnce('logError', array('test(testtype): test error'));
        
        $aTask = array('name' => 'test', 'type'=> 'testtype');
        OX_Upgrade_Util_JobMock::setLogger($oLogger);
        
        OX_Upgrade_Util_Job::logError($aTask, 'test error');
        
        $this->assertEqual($aTask['errors'], array('test error'));
    }
}
