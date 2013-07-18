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

require_once MAX_PATH.'/lib/OX/Admin/UI/SessionStorage.php';
require_once MAX_PATH.'/lib/OX/Admin/UI/Install/InstallStatus.php';
require_once MAX_PATH.'/lib/OX/Admin/UI/Install/InstallUtils.php';
require_once MAX_PATH.'/lib/OX/Admin/UI/Install/Wizard.php';
require_once MAX_PATH.'/lib/OA/Upgrade/UpgradeLogger.php';

/**
 * class containing common codes for jobs tasks
 *  install plugins and run post upgrade tasks
 * 
 * @package    OpenXUpgrade
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_Upgrade_Util_Job
{

    /**
     * @var OA_UpgradeLogger
     */
    protected static $oLogger;
    
    /**
     * put job result to the session storage
     *
     * @param array $result
     */
    public static function saveJobResult($result)
    {
        if (!empty($result['name'])&& !empty($result['type'])) {
            $oStorage = OX_Admin_UI_Install_InstallUtils::getSessionStorage();
            $aJobStatuses = $oStorage->get('aJobStatuses');
            if (!isset($aJobStatuses)) {
                $aJobStatuses = array();
            }
            $aJobStatuses[$result['type'].':'.$result['name']] = $result; 
            $oStorage->set('aJobStatuses', $aJobStatuses);
        }
    }
    
    
    /**
     * Check if it's install process and given step is completed
     *
     * @param string $step
     * @param string $result result array (should contains name, type, status and errors fields)
     * @return bool
     */
    public static function isInstallerStepCompleted($step, &$result)
    {
        $oStorage = OX_Admin_UI_Install_InstallUtils::getSessionStorage();
        $oStatus = $oStorage->get('installStatus');
        if (!isset($oStatus) || (!$oStatus->isInstall() && !$oStatus->isUpgrade())) {
            self::logError($result, 'Installation process not detected');
            return false;
        } else {
            $oWizard = new OX_Admin_UI_Install_Wizard($oStatus);
            if (!$oWizard->isStepCompleted($step)) {
                self::logError($result, 'Invalid installation step detected');
                return false;    
            }
        }
        return true;
    }
    
    
    /**
     * Log errors to error log
     *
     * @param string $result result array (should contains name, type, status and errors fields)
     * @param string $message error message
     */
    public static function logError(&$result, $message)
    {
        if (!isset(self::$oLogger)) {
            self::$oLogger = new OA_UpgradeLogger();
        }
        $result['errors'][] = $message;
        self::$oLogger->logError($result['name'].'('.$result['type'].'): '. $message);
    }
    
}