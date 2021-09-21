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

require_once MAX_PATH . '/lib/OX/Upgrade/Util/Job.php';


class OX_Upgrade_Util_JobMock extends OX_Upgrade_Util_Job
{
    public static function setLogger($oLogger)
    {
        self::$oLogger = $oLogger;
    }
}

/**
 * A class for testing the OX_Upgrade_Util_Job
 *
 * @package    OpenX
 * @subpackage TestSuite
 */
class OX_Upgrade_Util_JobTest extends UnitTestCase
{
    public function testSaveJobResult()
    {
        // clear session data
        $oStorage = OX_Admin_UI_Install_InstallUtils::getSessionStorage();
        @$oStorage->set('aJobStatuses', null);

        $result = ['name' => 'test',
                        'type' => 'testtype',
                        'other_data' => 'testdata'];

        OX_Upgrade_Util_Job::saveJobResult($result);

        $aJobStatuses = $oStorage->get('aJobStatuses');
        $expected = [ 'testtype:test' => $result];
        $this->assertEqual($aJobStatuses, $expected);

        // clear session data
        $oStorage->set('aJobStatuses', null);
    }


    public function testIsInstallerStepCompleted()
    {
        $oStorage = OX_Admin_UI_Install_InstallUtils::getSessionStorage();
        $oStatus = $oStorage->set('installStatus', null);

        $aTask = ['name' => 'test', 'type' => 'testtype'];

        $result = OX_Upgrade_Util_Job::isInstallerStepCompleted('database', $aTask);
        $this->assertFalse($result);
        $this->assertEqual($aTask['errors'], ['Installation process not detected']);
        unset($aTask['errors']);

        Mock::generatePartial(
            'OX_Admin_UI_Install_InstallStatus',
            'OX_Admin_UI_Install_InstallStatusMock',
            ['isInstall', 'isUpgrade']
        );
        $oInstallStatus = new OX_Admin_UI_Install_InstallStatusMock($this);
        $oInstallStatus->setReturnValue('isInstall', true);
        $oInstallStatus->setReturnValue('isUpgrade', false);

        $oStatus = $oStorage->set('installStatus', $oInstallStatus);

        $result = OX_Upgrade_Util_Job::isInstallerStepCompleted('database', $aTask);

        $this->assertFalse($result);
        $this->assertEqual($aTask['errors'], ['Invalid installation step detected']);
        unset($aTask['errors']);

        $oWizard = new OX_Admin_UI_Install_Wizard($oInstallStatus);
        $oWizard->markStepAsCompleted('database');

        $result = OX_Upgrade_Util_Job::isInstallerStepCompleted('database', $aTask);
        $this->assertTrue($result);
        $this->assertTrue(empty($aTask['errors']));

        $oWizard->reset();
        $oStatus = $oStorage->set('installStatus', null);
    }


    public function testLogError()
    {
        Mock::generatePartial(
            'OA_UpgradeLogger',
            'OA_UpgradeLoggerMock',
            ['logError']
        );

        $oLogger = new OA_UpgradeLoggerMock($this);
        $oLogger->expectOnce('logError', ['test(testtype): test error']);

        $aTask = ['name' => 'test', 'type' => 'testtype'];
        OX_Upgrade_Util_JobMock::setLogger($oLogger);

        OX_Upgrade_Util_Job::logError($aTask, 'test error');

        $this->assertEqual($aTask['errors'], ['test error']);
    }
}
