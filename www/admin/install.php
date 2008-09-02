<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$Id$
*/

define('OA_UPGRADE_RECOVERY_INFORM',          -3);
define('OA_UPGRADE_RECOVERY',                 -2);
define('OA_UPGRADE_ERROR',                    -1);
define('OA_UPGRADE_WELCOME',                   0);
define('OA_UPGRADE_TERMS',                     1);
define('OA_UPGRADE_POLICY',                    5);
define('OA_UPGRADE_SYSCHECK',                  10);
define('OA_UPGRADE_APPCHECK',                  20);
define('OA_UPGRADE_LOGIN',                     25);
define('OA_UPGRADE_DBSETUP',                   30);
define('OA_UPGRADE_UPGRADE',                   35);
define('OA_UPGRADE_INSTALL',                   36);
define('OA_UPGRADE_CONFIGSETUP',               37);
define('OA_UPGRADE_ADMINSETUP',                40);
define('OA_UPGRADE_PLUGINS',                   60);
define('OA_UPGRADE_FINISH',                    70);

global $installing, $tabindex;
$installing = true;

error_reporting(E_ERROR);

require_once '../../init.php';

if (array_key_exists('btn_openads', $_POST) || (OA_INSTALLATION_STATUS == OA_INSTALLATION_STATUS_INSTALLED))
{
    require_once LIB_PATH . '/Admin/Redirect.php';
    OX_Admin_Redirect::redirect('advertiser-index.php');
}

require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';
require_once MAX_PATH.'/lib/OA/Upgrade/Login.php';

// setup oUpgrader, determine whether they are installing or that they can Upgrade
$oUpgrader = new OA_Upgrade();
$oSystemMgr = &$oUpgrader->oSystemMgr;
$oSystemMgr->getAllInfo();
if (!$oSystemMgr->checkMemory()) {
    $memory = getMinimumRequiredMemory() / 1048576;
    echo '<link rel="stylesheet" type="text/css" href="' . OX::assetPath() . '/css/install.css"/><br />';
    echo '<div class="sysmessage sysinfoerror" style="text-align: center;">The minimum amount of memory <a href="' . OX_PRODUCT_DOCSURL . '/requirements" target="_blank" style="color: #990000">required</a> by OpenX is <b>'. $memory
        .' MB</b>. <br />Please <a href="http://www.openx.org/support/faq.html" target="_blank" style="color: #990000">increase</a> your PHP memory_limit before continuing.</div>';
    exit(1);
}

@set_time_limit(600);

// required files for header & nav
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';

//  load translations for installer
Language_Loader::load('installer');

$options = new OA_Admin_Option('settings');

// clear the $session variable to prevent users pretending to be logged in.
unset($session);
define('phpAds_installing',     true);

// changed form name for javascript dependent fields
$GLOBALS['settings_formName'] = "frmOpenads";

$imgPath = OX::assetPath() . "/";
$installStatus = 'unknown';

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


if (array_key_exists('btn_startagain', $_POST))
{
    // Delete the cookie if user is restarting upgrader
    setcookie('oat', '');
}

if ($oUpgrader->isRecoveryRequired())
{
    if (array_key_exists('btn_recovery', $_POST))
    {
        $oUpgrader->recoverUpgrade();
        $action = OA_UPGRADE_RECOVERY;
    }
    else
    {
        $action = OA_UPGRADE_RECOVERY_INFORM;
    }
}
else if (array_key_exists('btn_syscheck', $_POST) || $_POST['dirPage'] == OA_UPGRADE_SYSCHECK)
{
    // store checkForUpdates value into session, so that they can be inserted into DB once DB has been created
    session_start();

    // Always check for updates
    $_SESSION['checkForUpdates'] = true;

    $aSysInfo = $oUpgrader->checkEnvironment();

    // Do not check for an upgrade package if environment errors exist
    if (!$aSysInfo['PERMS']['error'] && !$aSysInfo['PHP']['error'] && !$aSysInfo['FILES']['error'])
    {
        $halt = !$oUpgrader->canUpgrade();
        $installStatus = $oUpgrader->existing_installation_status;
        if ($installStatus == OA_STATUS_CURRENT_VERSION) {
            // Do not halt if the version is current
            $halt = false;
        }
    } else {
        $message = $strFixErrorsBeforeContinuing;
    }

    $action   = OA_UPGRADE_SYSCHECK;
}
else if (array_key_exists('btn_appcheck', $_POST))
{
    $action = OA_UPGRADE_APPCHECK;
}
else if (array_key_exists('btn_login', $_POST))
{
    $action = OA_UPGRADE_LOGIN;
}
else if (array_key_exists('btn_dbsetup', $_POST))
{
    if (!OA_Upgrade_Login::checkLogin()) {
        $message = $strUsernameOrPasswordWrong;
        $action = OA_UPGRADE_LOGIN;
    }
    elseif ($oUpgrader->canUpgrade())
    {
        $installStatus = $oUpgrader->existing_installation_status;

        if ($installStatus != OA_STATUS_NOT_INSTALLED &&
            (empty($_COOKIE['oat']) || $_COOKIE['oat'] != OA_UPGRADE_UPGRADE)) {
            // Hey, what's going on, we shouldn't be here, go back to login!
            $action = OA_UPGRADE_LOGIN;
        } else {
            $aDatabase = $oUpgrader->aDsn;
            $action    = OA_UPGRADE_DBSETUP;

            // Timezone support - hack
            if ($installStatus != OA_STATUS_NOT_INSTALLED) {
                if ($oUpgrader->versionInitialSchema['tables_core'] < 538) {
                    // Non TZ-enabled database
                    $errTz = true;
                }
            }
        }
    }
    else
    {
        $installStatus = $oUpgrader->existing_installation_status;
        if ($installStatus == OA_STATUS_CURRENT_VERSION)
        {
            $message = 'OpenX is up to date';
            $strInstallSuccess = $strOaUpToDate;
            $action = OA_UPGRADE_FINISH;
        }
        else
        {
            $action = OA_UPGRADE_ERROR;
        }
    }
}
else if (array_key_exists('btn_upgrade', $_POST))
{
    if (!OA_Upgrade_Login::checkLogin()) {
        $message = $strUsernameOrPasswordWrong;
        $action = OA_UPGRADE_LOGIN;
    }
    elseif ($oUpgrader->canUpgrade())
    {
        $installStatus = $oUpgrader->existing_installation_status;

        define('DISABLE_ALL_EMAILS', 1);

        OA_Permission::switchToSystemProcessUser('Installer');

        if ($installStatus == OA_STATUS_NOT_INSTALLED)
        {
            if ($oUpgrader->install($_POST['aConfig']))
            {
                $message = $strDBCreatedSuccesful.' '.OA_VERSION;
                $action  = OA_UPGRADE_INSTALL;
            }
        }
        else
        {
            if (empty($_COOKIE['oat']) || $_COOKIE['oat'] != OA_UPGRADE_UPGRADE) {
                // Hey, what's going on, we shouldn't be here, go back to login!
                $action = OA_UPGRADE_LOGIN;
            }
            elseif ($oUpgrader->upgrade($oUpgrader->package_file))
            {
                $message = $strUpgradeComplete;
                $action  = OA_UPGRADE_UPGRADE;

                // Timezone support - hack
                if ($oUpgrader->versionInitialSchema['tables_core'] < 538 && empty($_POST['noTzAlert'])) {
                    OA_Dal_ApplicationVariables::set('utc_update', OA::getNowUTC());
                }

                // Clear the menu cache to built a new one with the new settings
                OA_Admin_Menu::_clearCache(OA_ACCOUNT_MANAGER);
                OA_Admin_Menu::singleton();
            }
        }
    }

    if ((($action != OA_UPGRADE_UPGRADE) && ($action != OA_UPGRADE_INSTALL) && ($action != OA_UPGRADE_LOGIN)) || $oUpgrader->oLogger->errorExists)
    {
        // if they're being redirected from an install, they will have DB info in POST, otherwise they will have DBinfo in CONF
        if ($_POST['aConfig']) {
            $aDatabase = $_POST['aConfig'];
        } else {
            $aDatabase['database'] = $GLOBALS['_MAX']['CONF']['database'];
            $aDatabase['table']    = $GLOBALS['_MAX']['CONF']['table'];
        }

        $displayError = true;
        $action = OA_UPGRADE_DBSETUP;
    }
}
else if (array_key_exists('btn_configsetup', $_POST))
{
    if (!OA_Upgrade_Login::checkLogin()) {
        $message = $strUsernameOrPasswordWrong;
        $action = OA_UPGRADE_LOGIN;
    }
    else
    {
        $aConfig = $oUpgrader->getConfig();
    }
    //$action = ($_COOKIE['oat'] == OA_UPGRADE_INSTALL ? OA_UPGRADE_CONFIGSETUP : OA_UPGRADE_PLUGINS);
    $action = OA_UPGRADE_CONFIGSETUP;
}
else if (array_key_exists('btn_adminsetup', $_POST))
{
    if (!OA_Upgrade_Login::checkLogin()) {
        $message = $strUsernameOrPasswordWrong;
        $action = OA_UPGRADE_LOGIN;
    }
    else
    {
        // Acquire the sync settings from session in order to add them
        session_start();
        $syncEnabled = !empty($_SESSION['checkForUpdates']);

        // Always use the path we're using to install as admin UI path
        $aConfig = $oUpgrader->getConfig();
        $_POST['aConfig']['webpath']['admin'] = $aConfig['webpath']['admin'];

        // Store the detected timezone of the system, whatever that is
        require_once('../../lib/OA/Admin/Timezones.php');
        $timezone['timezone'] = OA_Admin_Timezones::getTimezone();

        if ($oUpgrader->saveConfig($_POST['aConfig']) && $oUpgrader->putSyncSettings($syncEnabled) && $oUpgrader->putTimezoneAccountPreference($aTimezone, true))
        {
            if (!checkFolderPermissions($_POST['aConfig']['store']['webDir'])) {
                $aConfig                    = $_POST['aConfig'];
                $aConfig['store']['webDir'] = stripslashes($aConfig['store']['webDir']);
                $errMessage                 = $strImageDirLockedDetected;
                $action                     = OA_UPGRADE_CONFIGSETUP;
            } else {
                if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL)
                {
                    //$oUpgrader->getAdmin();
                    $action = OA_UPGRADE_ADMINSETUP;
                }
                else
                {
                    $message = $strUpgradeComplete;
                    //$oUpgrader->setOpenadsInstalledOn();
                    $action = OA_UPGRADE_PLUGINS;;
                }
            }
        }
        else
        {
            $aConfig    = $_POST['aConfig'];
            if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL) {
                $errMessage = $strUnableCreateConfFile;
            } else {
                $errMessage = $strUnableUpdateConfFile;
            }
            $action     = OA_UPGRADE_CONFIGSETUP;
        }
    }
}
else if (array_key_exists('btn_adminsetup_back', $_POST))
{
    if (!OA_Upgrade_Login::checkLogin()) {
        $message = $strUsernameOrPasswordWrong;
        $action = OA_UPGRADE_LOGIN;
    }
    else
    {
        $aAdmin = unserialize(stripslashes($_POST['aAdminPost']));
        $action = OA_UPGRADE_ADMINSETUP;
    }
}
else if (array_key_exists('btn_terms', $_POST))
{
    $action = OA_UPGRADE_TERMS;
}
else if (array_key_exists('btn_plugins', $_POST))
{
    if (!OA_Upgrade_Login::checkLogin()) {
        $message = $strUsernameOrPasswordWrong;
        $action = OA_UPGRADE_LOGIN;
    }
    else
    {
        // deal with data from previous page
        if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL)
        {
            OA_Permission::switchToSystemProcessUser('Installer');

            // Save admin credentials
            $oUpgrader->putAdmin($_POST['aAdmin']);

            // Save admim account preference for timezone
            $oUpgrader->putTimezoneAccountPreference($_POST['aPrefs']);
        }
        $result = $oUpgrader->executePostUpgradeTasks();
        if (is_array($result))
        {
            $aPostTasks = $result;
        }
        $message = $strPostUpgradeTasks;
        $action = OA_UPGRADE_PLUGINS;
    }
}
else if (array_key_exists('btn_finish', $_POST))
{
    if (!OA_Upgrade_Login::checkLogin()) {
        $message = $strUsernameOrPasswordWrong;
        $action = OA_UPGRADE_LOGIN;
    }
    else
    {
        $message = $strUpgradeComplete;
    }
    //$oUpgrader->setOpenadsInstalledOn();
    $action = OA_UPGRADE_FINISH;
}
else if (array_key_exists('dirPage', $_POST) && !empty($_POST['dirPage']))
{
    $action = $_POST['dirPage'];
    if ($_POST['dirPage'] == OA_UPGRADE_SYSCHECK) {
        $aSysInfo = $oUpgrader->checkEnvironment();
        $halt = !$oUpgrader->canUpgrade();
        if (!$halt)
        {
            $halt = !$oUpgrader->checkUpgradePackage();
        }
    }
}
else
{
    $action = OA_UPGRADE_WELCOME;
}

if ($action == OA_UPGRADE_FINISH)
{
    OA_Upgrade_Login::autoLogin();

    // Delete the cookie
    setcookie('oat', '');
    $oUpgrader->setOpenadsInstalledOn();

    if (!$oUpgrader->removeUpgradeTriggerFile())
    {
        $message.= '. '.$strRemoveUpgradeFile;
        $strInstallSuccess = '<div class="sysinfoerror">'.$strOaUpToDateCantRemove.'</div>'.$strInstallSuccess;
    }
}

if ($installStatus == OA_STATUS_OAD_NOT_INSTALLED)
{
    setcookie('oat', OA_UPGRADE_INSTALL);
    $_COOKIE['oat'] = OA_UPGRADE_INSTALL;
}
elseif ($installStatus !== 'unknown')
{
    setcookie('oat', OA_UPGRADE_UPGRADE);
    $_COOKIE['oat'] = OA_UPGRADE_UPGRADE;
}

// Used to detmine which page is active in nav
$activeNav = array (
                    OA_UPGRADE_WELCOME        =>      '10',
                    OA_UPGRADE_TERMS          =>      '20',
                    OA_UPGRADE_SYSCHECK       =>      '30',
                    OA_UPGRADE_APPCHECK       =>      '30',
                    OA_UPGRADE_DBSETUP        =>      '50',
                    OA_UPGRADE_UPGRADE        =>      '50',
                    OA_UPGRADE_INSTALL        =>      '50',
                    OA_UPGRADE_CONFIGSETUP    =>      '60',
                    OA_UPGRADE_PLUGINS        =>      '80',
                    OA_UPGRADE_FINISH         =>      '100'
                  );
if (!empty($_COOKIE['oat']) && $_COOKIE['oat'] != OA_UPGRADE_UPGRADE) {
    $activeNav[OA_UPGRADE_ADMINSETUP]     =      '70';
} else {
    $activeNav[OA_UPGRADE_LOGIN]          =      '45';
}

ksort($activeNav);

// setup the nav to determine whether or not to show a valid link
$navLinks = array();
foreach ($activeNav as $key=>$val) {
    if ($val <= $activeNav[$action] && $action <= OA_UPGRADE_DBSETUP) {
        $navLinks[$key] = 'javascript: changePage('.$key.')';
    } else {
        $navLinks[$key] = '';
    }
}


// Setup array for navigation
$aInstallerSections = array (
    '10'     =>  new OA_Admin_Menu_Section('10',  'Welcome',           $navLinks[OA_UPGRADE_WELCOME], false, "qsg-install"),
    '20'     =>  new OA_Admin_Menu_Section('20',  'Terms',             $navLinks[OA_UPGRADE_TERMS], false, "qsg-install"),
    '25'     =>  new OA_Admin_Menu_Section('25',  'Policy',            $navLinks[OA_UPGRADE_POLICY], false, "qsg-install"),
    '30'     =>  new OA_Admin_Menu_Section('30',  'System Check',      $navLinks[OA_UPGRADE_SYSCHECK], false, "qsg-install"),
    '40'     =>  new OA_Admin_Menu_Section('40',  'Application Check', $navLinks[OA_UPGRADE_APPCHECK], false, "qsg-install"),
    '45'     =>  new OA_Admin_Menu_Section('45',  'Login',             $navLinks[OA_UPGRADE_LOGIN], false, "qsg-install"),
    '50'     =>  new OA_Admin_Menu_Section('50',  'Database',          $navLinks[OA_UPGRADE_DBSETUP], false, "qsg-install"),
    '60'     =>  new OA_Admin_Menu_Section('60',  'Configuration',     $navLinks[OA_UPGRADE_CONFIGSETUP], false, "qsg-install"),
    '70'     =>  new OA_Admin_Menu_Section('70',  'Admin',             $navLinks[OA_UPGRADE_ADMINSETUP], false, "qsg-install"),
    '80'     =>  new OA_Admin_Menu_Section('80',  'Tasks',             $navLinks[OA_UPGRADE_PLUGINS], false, "qsg-install"),
    '100'    =>  new OA_Admin_Menu_Section('100', 'Finished',          '')
);

// setup which sections to display
$oMenu = OA_Admin_Menu::singleton();

//since we display installer nav as horizontal tabs we need to add two fake levels above
$firstLevelNavID = 'l1'.$activeNav[$action];
$secondLevelNavID = 'l2'.$activeNav[$action];
$oMenu->add(new OA_Admin_Menu_Section($firstLevelNavID,  '', ''));
$oMenu->addTo($firstLevelNavID, new OA_Admin_Menu_Section($secondLevelNavID,  '', ''));

//$currentSectionID = $firstLevelNavID;
$currentSectionID = $secondLevelNavID;

foreach ($activeNav as $val) {
    if ($oMenu->get($val) == null) {
        $oMenu->addTo($secondLevelNavID, $aInstallerSections[$val]);
//        $oMenu->addTo($firstLevelNavID, $aInstallerSections[$val]);
	}
}

// display header and navigation, with proper 'active page' marked using $activeNav[$action]
phpAds_PageHeader($activeNav[$action], new OA_Admin_UI_Model_PageHeaderModel(), $imgPath, false, false);
// calculate percentage complete
$currSection = $oMenu->get($currentSectionID);
$showSections = $currSection->getSections();

$totalNav     = count($showSections)-1;
$progressRate = 100 / $totalNav;

for($i = 0; $i < count($showSections); $i++) {
    if ($activeNav[$action] == $showSections[$i]->getId()) {
        if ($i == 0) {
            $progressVal = 0;
        } elseif ($i == $totalNav) {
            $progressVal = 100;
        } else {
            $progressVal = round(($i) * $progressRate);
        }
        break;
    } else {
        $progressVal = 0;
    }
}
// display main template
include 'templates/install-index.html';

// Do not remove. This is a marker that AJAX response parsers look for to
// determine whether the response did not redirect to the installer.
echo "<!-- install -->";

// display footer
phpAds_PageFooter($imgPath);

?>
