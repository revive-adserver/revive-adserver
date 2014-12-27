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

require_once MAX_PATH . '/lib/OX/Admin/UI/Wizard.php';

/**
 * @package OX_Admin_UI
 * @subpackage Install
 */
class OX_Admin_UI_Install_Wizard
    extends OX_Admin_UI_Wizard
{
    public function __construct($oInstallStatus, $currentStepId = null)
    {
        $oStorage = OX_Admin_UI_Install_InstallUtils::getSessionStorage();
        $aSteps = $this->initSteps($oInstallStatus, $oStorage);
        $aParams = array(
            'steps' => $aSteps['steps'],
            'stepsMetadata' => $aSteps['meta'],
            'current' => $currentStepId,
        );
        parent::__construct('install', $aParams, $oStorage);
    }


    /**
     * Builds step array. Uses information from InstallStatus (eg. if it's upgrade
     * or install) and also storage properties 'isMarketStepVisible', 'isLoginStepVisible'
     *
     * @param OX_Admin_UI_Install_InstallStatus $oStatus
     * @param OX_Admin_UI_Storage $oStorage
     * @return array array('steps' => $aSteps, 'meta' => $aMeta);
     */
    protected function initSteps($oStatus, $oStorage)
    {
        $aMeta = array();

        if ($oStatus->isRecovery()) {
            $aSteps = array(
                'recovery' => 'Recovery',
                'finish'   => 'Finish'
            );
        }
        if ($oStatus->isInstall()) {
            $aSteps = array(
                'welcome'       => 'Welcome',
                'database'      => 'Database',
                'configuration' => 'Configuration',
                'finish'        => 'Finish'
            );
            $aMeta = array(
                'finish' => array('secured' => true)
            );
        }
        else if ($oStatus->isUpgrade()) {
            $aSteps = array(
                'welcome'       => 'Welcome',
                'login'         => 'Administrator Login',
                'database'      => 'Database',
                'configuration' => 'Configuration',
                'finish'        => 'Finish'
            );

            $aMeta = array(
                'welcome'       => array('secured' => false),
                'login'         => array('secured' => false),
                'database'      => array('secured' => true),
                'configuration' => array('secured' => true),
                'finish'        => array('secured' => true)
            );


            // Hide steps which are not required
            if (!$oStorage->get('isLoginStepVisible')) {
                unset($aSteps['login']);
                unset($aMeta['login']);
            }
            if (!$oStorage->get('isConfigStepVisible')) {
                unset($aSteps['configuration']);
                unset($aMeta['configuration']);
            }
        }
        else if ($oStatus->isUpToDate()) {
            $aSteps = array(
                'uptodate' => 'Up To Date'
            );
        }
        return array('steps' => $aSteps, 'meta' => $aMeta);
    }
}

?>