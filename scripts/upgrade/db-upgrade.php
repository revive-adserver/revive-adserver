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

//error_reporting(E_ERROR);
error_reporting(E_ALL);

// Set the current path
$path = dirname(__FILE__);
require_once $path . '/../../init.php';

//print_r($GLOBALS['_MAX']['CONF']);
echo "max_path=". MAX_PATH . "\n";

require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';
require_once MAX_PATH.'/lib/OA/Upgrade/Login.php';
// required files for header & nav
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradePluginImport.php';

echo "start...\n";


define('DB_UPGRADE_ERROR_EXIT',               -5);
define('DB_UPGRADE_ERROR_RECOVER',            -2);
define('DB_UPGRADE_CONTINUE',                  0);
define('DB_UPGRADE_FINISH',                    5);


global $installing, $tabindex;
$installing = true;
// Setup oUpgrader
$oUpgrader = new OA_Upgrade();
echo "installstatus=". $oUpgrader->existing_installation_status ."=\n";
echo "upgradepath =" . $oUpgrader->upgradePath."\n";

// Some setup from install.php, may not be needed anymore
@set_time_limit(600);
//  load translations for installer
Language_Loader::load('installer');
$options = new OA_Admin_Option('settings');
// clear the $session variable to prevent users pretending to be logged in.
unset($session);
define('phpAds_installing',     true);
$installStatus = 'unknown';

////// start of the db upgrade process ////////
//TODO: logical needs to be rechecked ////////
$result = dbUpgradePrecheck($oUpgrader);
if ($result['action'] == DB_UPGRADE_ERROR_EXIT || $result['action'] == DB_UPGRADE_FINISH) {
    echo $result['message'] . "\n";
    exit;
}
echo "After precheck : " . $result['message'] . "\n";


echo "2.8. installstatus=". $oUpgrader->existing_installation_status ."=\n";
$result = dbUpgradeCanUpgrade($oUpgrader);
if ($result['action'] == DB_UPGRADE_ERROR_EXIT || $result['action'] == DB_UPGRADE_FINISH) {
    //echo "exit\n";
    echo $result['message'] . "\n";
    exit;
}
echo "After canUpgrade : " . $result['message'] . "\n";

$result = dbUpgradeUpgrade($oUpgrader);
if ($result['action'] == DB_UPGRADE_ERROR_EXIT || $result['action'] == DB_UPGRADE_FINISH) {
    echo "exit\n";
    echo $result['message'] . "\n";
    exit;
}
echo "After db upgrade : " . $result['message'] . "\n";


/*
$result = dbUpgradePost();
if ($result['action'] == DB_UPGRADE_ERROR_EXIT || $result['action'] == DB_UPGRADE_FINISH) {
    echo $result['message'] . "\n";
    exit;
}
*/

function dbUpgradePrecheck($oUpgrader)
{
    //TODO
    $action = DB_UPGRADE_CONTINUE;
    $message = '';
    return dbUpgradeSyscheck($oUpgrader);
    /*
    if (OA_INSTALLATION_STATUS == OA_INSTALLATION_STATUS_INSTALLED)
    {
        echo OA_INSTALLATION_STATUS ."\n";
        echo OA_INSTALLATION_STATUS_INSTALLED ."\n";
    }
    return array('action'=>$action, 'message'=>$message);
    */
}    

function dbUpgradeSyscheck($oUpgrader)
{
    $aSysInfo = $oUpgrader->checkEnvironment();
    $action = DB_UPGRADE_CONTINUE;
    $message = 'Pass Syscheck';
    echo "2. installstatus=". $oUpgrader->existing_installation_status ."=\n";
    // Do not check for an upgrade package if environment errors exist
    if (!$aSysInfo['PERMS']['error'] && !$aSysInfo['PHP']['error'] && !$aSysInfo['FILES']['error'])
    {
        $installStatus = $oUpgrader->existing_installation_status;
        if ($installStatus == OA_STATUS_CURRENT_VERSION) {
            // Do not halt if the version is current
            $action = DB_UPGRADE_SUCCESS;
            $message = "Openx is in the current version\n";
        }
        $message = "Openx needs to be upgraded\n";
    } else {
        $action = DB_UPGRADE_ERROR_EXIT;
        $message = $strFixErrorsBeforeContinuing;
    }
    echo "2.5. installstatus=". $oUpgrader->existing_installation_status ."=\n";
    return array('action'=>$action, 'message'=>$message);
}

function dbUpgradeCanUpgrade($oUpgrader) 
{
    $action    = DB_UPGRADE_CONTINUE;
    $message = "Openx can be upgraded\n";
    echo "3. installstatus=". $oUpgrader->existing_installation_status ."=\n";
    if (!$oUpgrader->canUpgrade()) {
        $installStatus = $oUpgrader->existing_installation_status;
        echo "4. installstatus=". $oUpgrader->existing_installation_status ."=\n";
        if ($installStatus == OA_STATUS_CURRENT_VERSION)
        {
            $message = 'OpenX is up to date';
            $strInstallSuccess = $strOaUpToDate;
            $action = DB_UPGRADE_FINISH;
        }
        else
        {
            $message = "Cannot upgrade";
            $action = DB_UPGRADE_ERROR_EXIT;
        }
    } else {
        $installStatus = $oUpgrader->existing_installation_status;
        echo "5. installstatus=". $oUpgrader->existing_installation_status ."=\n";
        $cookie_oat = getCookieOat($installStatus);
        echo "cookie=$cookie_oat; not_installed=". OA_STATUS_NOT_INSTALLED."\n";
        if ($installStatus != OA_STATUS_NOT_INSTALLED && 
            $cookie_oat != OA_UPGRADE_UPGRADE) {
            // Hey, what's going on, we shouldn't be here, go back to login!
            $action = DB_UPGRADE_ERROR_EXIT;
            $message = "we should not be here\n";
        } else {
            $action    = DB_UPGRADE_CONTINUE;
            $message = "Upgrade Continued";

            // Timezone support - hack
            if ($installStatus != OA_STATUS_NOT_INSTALLED) {
                if ($oUpgrader->versionInitialSchema['tables_core'] < 538) {
                    // Non TZ-enabled database
                    $message = "Non TZ-enabled database";
                }
            }
        }
    }
    return array('action'=>$action, 'message'=>$message);
}


function dbUpgradeDbsetup($oUpgrader)
{
        $installStatus = $oUpgrader->existing_installation_status;
        $aConfig = array();

        if ($installStatus != OA_STATUS_NOT_INSTALLED && 
            getCookieOat($installStatus) != OA_UPGRADE_UPGRADE) {
            // Hey, what's going on, we shouldn't be here, go back to login!
            echo "cannot be true\n";
        } else {
            $aDatabase = $oUpgrader->aDsn;
            if (empty($aDatabase['database']['socket']) 
              && $aDatabase['database']['type'] == 'mysql') {
                $aDatabase['database']['socket'] = str_replace("'", '', ini_get('mysql.default_socket'));
            }
            $aConfig = $oUpgrader->getConfig();
            $aConfig['database']['type'] = $aDatabase['database']['type'];
            $aConfig['database']['localsocket'] = ($aDatabase['database']['localsocket'] || $aDatabase['database']['protocol']=='unix');
            $aConfig['database']['socket'] = $aDatabase['database']['socket'];
            $aConfig['database']['host'] = $aDatabase['database']['host'];
            $aConfig['database']['port'] = $aDatabase['database']['port'];
            $aConfig['database']['username'] = $aDatabase['database']['username'];
            $aConfig['database']['password'] = $aDatabase['database']['password'];
            $aConfig['database']['name'] = $aDatabase['database']['name'];
            $aConfig['database']['type'] = $aDatabase['database']['type'];
            $aConfig['database']['prefix'] = $aDatabase['database']['prefix'];
        }
        return $aConfig;
}

function dbUpgradeUpgrade($oUpgrader)
{
        define('DISABLE_ALL_EMAILS', 1);
        $action  = DB_UPGRADE_FINISH;
        $message = "upgrade\n";
        echo "before switch permissioN\n";

        OA_Permission::switchToSystemProcessUser('Installer');
        echo "after 1 switch permissioN\n";
        $installStatus = $oUpgrader->existing_installation_status;

        echo "after 2 switch permissioN\n";
        if ($installStatus == OA_STATUS_NOT_INSTALLED)
        {
            echo "not installed \n";
            $aConfig = dbUpgradeDbsetup($oUpgrader); 
            if ($oUpgrader->install($aConfig))
            {
                $message = $strDBCreatedSuccesful.' '.OA_VERSION;
                $action  = DB_UPGRADE_FINISH;
            }
        }
        else
        {
            echo "upgrade now ...\n";
            if (getCookieOat($installStatus) != OA_UPGRADE_UPGRADE) {
                // Hey, what's going on, we shouldn't be here, go back to login!
                $action = DB_UPGRADE_ERROR_EXIT;
                $message = "Upgrade Error\n";
                echo "Upgrade Error\n";
             
            }
            elseif ($oUpgrader->upgrade($oUpgrader->package_file))
            {
                $message = $strUpgradeComplete;
                $action  = DB_UPGRADE_CONTINUE;
                echo "upgrade finishes ...\n";

                // Timezone support - hack
                if ($oUpgrader->versionInitialSchema['tables_core'] < 538 && empty($_POST['noTzAlert'])) {
                    OA_Dal_ApplicationVariables::set('utc_update', OA::getNowUTC());
                }
             }
          }
    return array('action'=>$action, 'message'=>$message);
}


function dbUpgradePost() {
    OA_Admin_Menu::_clearCache(OA_ACCOUNT_ADMIN);
    OA_Admin_Menu::_clearCache(OA_ACCOUNT_MANAGER);
    OA_Admin_Menu::_clearCache(OA_ACCOUNT_ADVERTISER);
    OA_Admin_Menu::_clearCache(OA_ACCOUNT_TRAFFICKER);
    OA_Admin_Menu::singleton();
    return array('action'=>DB_UPGRADE_FINISH, 'message'=>"Done");
}


function getCookieOat($installStatus) 
{
    $oat_cookie = '';
    if ($installStatus == OA_STATUS_OAD_NOT_INSTALLED)
    {
        $oat_cookie = OA_UPGRADE_INSTALL;
    }
    elseif ($installStatus !== 'unknown')
    {
        $oat_cookie = OA_UPGRADE_UPGRADE;
    }
    return $oat_cookie;
}


 /**
 * Return an array of supported DB types
 *
 * @return array
 */
function getSupportedDbTypes()
{
    // These values must be the same as used for the
    // data access layer file names!
    $aTypes = array();
    if (extension_loaded('mysql'))
    {
        $aTypes['mysql'] = 'MySQL';
    }
    if (extension_loaded('pgsql'))
    {
        $aTypes['pgsql'] = 'PostgreSQL';
    }
    return $aTypes;
}

 /**
 * Return an array of supported Table types
 *
 * @return array
 */
function getSupportedTableTypes()
{
    // These values must be the same as used for the
    // data access layer file names!
    $aTypes = array();
    if (extension_loaded('mysql'))
    {
        $aTypes['MYISAM'] = 'MyISAM';
        $aTypes['INNODB'] = 'InnoDB';
    }
    if (empty($aTypes))
    {
        $aTypes[''] = 'Default';
    }
    return $aTypes;
}

 /**
 * Checks a folder to make sure it exists and is writable
 *
 * @param  int Folder the directory that needs to be tested
 * @return boolean - true if folder exists and is writable
 */
function checkFolderPermissions($folder) {
    if (!file_exists($folder))
    {
        return false;
    }
    elseif (!is_writable($folder))
    {
        return false;
    }
    return true;
}

?>
