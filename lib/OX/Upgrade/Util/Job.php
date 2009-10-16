<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
$Id: Job.php 43405 2009-09-18 11:25:38Z lukasz.wikierski $
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