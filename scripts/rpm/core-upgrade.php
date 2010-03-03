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
*/
/**
 * A script to upgrade database for rpm install
 *
 * @package    OpenXScripts
 * @subpackage Tools
 * @author     Lun Li <lun.li@openx.org>
 */

unset($session);
$GLOBALS['installing'] = true;
define('phpAds_installing', true);

// Set the current path
require_once dirname(__FILE__) . '/../../init.php';
require_once MAX_PATH . '/scripts/rpm/lib-rpm.php';

preUpgrade();
if (file_exists('/opt/ox/adserver/etc/id') && trim(file_get_contents('/opt/ox/adserver/etc/id')) == 'masterconfig') {
    $customersFile = '/opt/ox/adserver/customers.xml';
    if (file_exists($customersFile)) {
        $customers = getCustomersArrayFromXMLFile($customersFile);
        foreach ($customers as $idx => $customer) {
            // Re-init using the customers UI domain name
            $GLOBALS['argv'][1] = $_SERVER['HTTP_HOST'] = $_SERVER['SERVER_NAME'] = $customer['admin'];
            $GLOBALS['_MAX']['CONF'] = parseIniFile();     
            $result = upgradeCustomer();
            echo "Upgrade of customer: {$customer['shortname']} result: {$result}\n"; 
        }
    } else {    
        // Just upgrade/install for the 'current' customer
        $result = upgradeCustomer();
        echo "Upgrade result: {$result}\n"; 
    }
} else {
    if (!is_dir(dirname(MAX_PATH) . '/openx.prev')) {
        // For an upgrade, the preUpgrade method will have up-ported all plugin files from the previous codebase
        // But for a fresh install, the default plugins should be unpacked
        $pluginsPath = MAX_PATH . '/etc/plugins';
        $PLUGINS_DIR = opendir($pluginsPath);
        while ($file = readdir($PLUGINS_DIR)) {
            if (is_file($pluginsPath . '/' . $file) && substr($file, strrpos($file, '.')) == '.zip') {
                $pluginName = substr($file, 0, strpos($file, '.'));
                unpackPlugin($pluginName);
            }
        }
    }
}
postUpgrade();

/**
 * This function checks that the system meets the upgrade requirements
 *
 * @param unknown_type $oUpgrader
 * @return mixed true if the system can be upgraded, string (reason) others
 */
function preUpgrade()
{
    $oUpgrader = new OA_Upgrade();
    $aSysInfo = $oUpgrader->checkEnvironment();
    
    // Do not check for an upgrade package if environment errors exist
    if (!empty($aSysInfo['PERMS']['error']) || !empty($aSysInfo['PHP']['error']) || !empty($aSysInfo['FILES']['error'])) {
        echo "System errors detected, unable to upgrade OpenX, check the error-log/UI for details\n";
    }
    
    $result = importPlugins($oUpgrader, dirname(MAX_PATH) . '/openx.prev');
    if ($result['action'] == CORE_UPGRADE_ERROR_EXIT) {
        return $result['message'];
    }
    // Make sure that any unbundled plugin .zip files are copied up from the previous codebase
    $prevPluginsPath = dirname(MAX_PATH) . '/openx.prev/etc/plugins';
    if (is_dir($prevPluginsPath)) {
        $aBundledPlugins = array();
        $pluginsPath = MAX_PATH . '/etc/plugins';
        $PLUGINS_DIR = opendir($pluginsPath);
        while ($file = readdir($PLUGINS_DIR)) {
            if (is_file($pluginsPath . '/' . $file) && substr($file, strrpos($file, '.')) == '.zip') {
                $aBundledPlugins[] = $file;
            }
        }
        $PREV_PLUGINS_DIR = opendir($prevPluginsPath);
        while ($file = readdir($PREV_PLUGINS_DIR)) {
            if (is_file($prevPluginsPath . '/' . $file) && substr($file, strrpos($file, '.')) == '.zip' && !in_array($file, $aBundledPlugins)) {
                copy($prevPluginsPath . '/' . $file, $pluginsPath . '/' . $file);
            }
        }
    }
    return true;
}

function postUpgrade()
{
    // Call the plugin-upgrade script for any bundled plugins (via an exec call)
    echo "Core upgrade complete - starting plugin upgrade process...\n";
    $pluginsPath = MAX_PATH . '/etc/plugins';
    $PLUGINS_DIR = opendir($pluginsPath);
    while ($file = readdir($PLUGINS_DIR)) {
        if (is_file($pluginsPath . '/' . $file) && substr($file, strrpos($file, '.')) == '.zip') {
            $pluginName = substr($file, 0, strpos($file, '.'));
            passthru('php ' . MAX_PATH . '/scripts/rpm/plugin-upgrade.php default ' . $pluginName);
        }
    }
    
    $oUpgrader = new OA_Upgrade();
    
    if (!$oUpgrader->removeUpgradeTriggerFile()) {
        $message = $GLOBALS['strRemoveUpgradeFile'];
        $strInstallSuccess = '<div class="sysinfoerror">'.$strOaUpToDateCantRemove.'</div>'.$strInstallSuccess;
    }
    touch(MAX_PATH . '/var/INSTALLED');
    cacheAllDataObjects();
}

function upgradeCustomer()
{
    $oUpgrader = new OA_Upgrade();
    
    // Restore the UPGRADE file which may have been removed by a previous customer's upgrade
    if (!is_file(MAX_PATH . '/var/UPGRADE'))  { touch (MAX_PATH . '/var/UPGRADE'); }
    if (is_file(MAX_PATH . '/var/INSTALLED')) { unlink(MAX_PATH . '/var/INSTALLED'); }
    
    if (!$oUpgrader->canUpgradeOrInstall(true)) {
        if ($oUpgrader->existing_installation_status == OA_STATUS_CURRENT_VERSION) {
            $message = 'OpenX is up to date';
        } else {
            $message = "Cannot upgrade ({$oUpgrader->existing_installation_status})";
        }
        return $message;
    } else {
        OA_Permission::switchToSystemProcessUser('Installer');
        
        if ($oUpgrader->existing_installation_status == OA_STATUS_NOT_INSTALLED) {
            return "Not installed";
        } else {
            if ($oUpgrader->upgrade($oUpgrader->package_file)) {
                $message = $GLOBALS['strUpgradeComplete'];
            } else {
                if (file_exists(MAX_PATH . '/var/RECOVER')) { unlink(MAX_PATH . '/var/RECOVER'); }
                return "Error upgrading";
            }
        }
    }
    
    $oSettings = new OA_Admin_Settings();
    $oSettings->writeConfigChange();
    
    @unlink(MAX_PATH.'/var/plugins/recover/enabled.log');
    $aUpgradeTasks = $oUpgrader->getPostUpgradeTasks();
    foreach ($aUpgradeTasks as $upgradeTask) {
        $oUpgrader->runPostUpgradeTask($upgradeTask);
    }
    
    $oUpgrader->setOpenadsInstalledOn();
    return 'Upgrade succeeded';
}

?>
