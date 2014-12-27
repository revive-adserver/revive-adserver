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

require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';


/**
 * Controller to get tasks urls and clean up after tasks are runned
 *
 * @package    OpenXUpgrade
 */
class OX_Upgrade_PostUpgradeTask_Controller
{


    /**
     * Prepare urls to run post upgrade tasks
     *
     * @param string $baseInstalUrl base install url (prepared by OX_Admin_UI_Controller_Request::getBaseUrl)
     * @param OA_Upgrade $oUpgrade optional
     * @return array array of arrays of 'name' and 'url' strings
     */
    static function getTasksUrls($baseInstallUrl, OA_Upgrade $oUpgrade = null)
    {
        // init OA_Upgrade if needed
        if (!isset($oUpgrade)) {
            $oUpgrade = new OA_Upgrade();
        }
        $aUpgradeTasks = $oUpgrade->getPostUpgradeTasks();
        $aUrls = array();
        foreach ($aUpgradeTasks as $task) {
            $aUrls[] = array(
                'id' => 'task:'.$task,
                'name' => $GLOBALS['strPostInstallTaskRunning'].': '.$task,
                'url' => $baseInstallUrl.'install-runtask.php?task='.$task);
        }
        return $aUrls;
    }


    /**
     * Delete upgrade tasks file, to not trigger this tasks during another upgrade
     *
     * @param OA_Upgrade $oUpgrade optional
     * @return bool true on success
     */
    static function cleanUpTaskListFile(OA_Upgrade $oUpgrade = null)
    {
        // init OA_Upgrade if needed
        if (!isset($oUpgrade)) {
            $oUpgrade = new OA_Upgrade();
        }
        return $oUpgrade->pickupPostUpgradeTasksFile();
    }

}