<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

define('OA_UPGRADE_RECOVERY',                 -2);
define('OA_UPGRADE_ERROR',                    -1);
define('OA_UPGRADE_WELCOME',                   0);
define('OA_UPGRADE_TERMS',                     1);
define('OA_UPGRADE_POLICY',                    5);
define('OA_UPGRADE_SYSCHECK',                  10);
define('OA_UPGRADE_APPCHECK',                  20);
define('OA_UPGRADE_DBSETUP',                   30);
define('OA_UPGRADE_UPGRADE',                   35);
define('OA_UPGRADE_INSTALL',                   36);
define('OA_UPGRADE_CONFIGSETUP',               37);
define('OA_UPGRADE_ADMINSETUP',                40);
define('OA_UPGRADE_IDSETUP',                   50);
define('OA_UPGRADE_DATASETUP',                 60);
define('OA_UPGRADE_FINISH',                    70);

global $installing, $tabindex;
$installing = true;

require_once '../../init.php';

if (array_key_exists('btn_openads', $_POST) || (OA_INSTALLATION_STATUS == OA_INSTALLATION_STATUS_INSTALLED))
{
    require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
    MAX_Admin_Redirect::redirect();
}

require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';

// setup oUpgrader, determine whether they are installing or that they can Upgrade
$oUpgrader = new OA_Upgrade();
$oSystemMgr = &$oUpgrader->oSystemMgr;
$oSystemMgr->getAllInfo();
if (!$oSystemMgr->checkMemory()) {
    echo 'The minimum requirement amount of memory of Openads is <b>'. getMinimumRequiredMemory() 
        .' Bytes</b>. Please increase your PHP memory_limit before continuing.';
    exit(1);
}

@set_time_limit(60);

// required files for header & nav
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/www/admin/lib-permissions.inc.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';

// clear the $session variable to prevent users pretending to be logged in.
unset($session);
define('phpAds_installing',     true);

// changed form name for javascript dependent fields
$GLOBALS['settings_formName'] = "frmOpenads";

$imgPath = '';
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
    $types['mysql'] = 'MySQL';
    $types['pgsql'] = 'PostgreSQL';
    return $types;
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
    $types['MYISAM'] = 'MyISAM';
    $types['INNODB'] = 'InnoDB';
    return $types;
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

if ($oUpgrader->isRecoveryRequired())
{
    $oUpgrader->recoverUpgrade();
    $action = OA_UPGRADE_RECOVERY;
}
else if (array_key_exists('btn_syscheck', $_POST))
{
    // store updates_enabled value into session, so that they can be inserted into DB once DB has been created
    session_start();
    $_SESSION['updates_enabled']         = $_POST['updates_enabled'];

    $aSysInfo = $oUpgrader->checkEnvironment();

    // Do not check for an upgrade package if environment errors exist
    if (!$aSysInfo['PERMS']['error'] && !$aSysInfo['PHP']['error'] && !$aSysInfo['FILES']['error'])
    {
        $halt = !$oUpgrader->canUpgrade();
    } else {
        $message = $strFixErrorsBeforeContinuing;
    }

    $installStatus = $oUpgrader->existing_installation_status;
    if ($installStatus == OA_STATUS_CURRENT_VERSION)
    {
        $message = 'Openads is up to date';
        $strInstallSuccess = $strOaUpToDate;
        $action = OA_UPGRADE_FINISH;
    }
    else
    {
        $action   = OA_UPGRADE_SYSCHECK;
    }
}
else if (array_key_exists('btn_appcheck', $_POST))
{
    $action = OA_UPGRADE_APPCHECK;
}
else if (array_key_exists('btn_dbsetup', $_POST))
{
    if ($oUpgrader->canUpgrade())
    {
        $aDatabase = $oUpgrader->aDsn;
        $action    = OA_UPGRADE_DBSETUP;
    }
    else
    {
        $action    = OA_UPGRADE_ERROR;
    }
}
else if (array_key_exists('btn_upgrade', $_POST))
{
    if ($oUpgrader->canUpgrade())
    {
        if ($oUpgrader->existing_installation_status == OA_STATUS_NOT_INSTALLED)
        {
            if ($oUpgrader->install($_POST['aConfig']))
            {
                $message = 'Your database has successfully been created for Openads '.OA_VERSION;
                $action  = OA_UPGRADE_INSTALL;
            }
        }
        else
        {
            if ($oUpgrader->upgrade($oUpgrader->package_file))
            {
                $message = 'Your database has successfully been upgraded to Openads version '.OA_VERSION;
                $action  = OA_UPGRADE_UPGRADE;
            }
        }
    }
    
    if ((($action != OA_UPGRADE_UPGRADE) && ($action != OA_UPGRADE_INSTALL)) || $oUpgrader->oLogger->errorExists)
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
    $aConfig = $oUpgrader->getConfig();
    $action = OA_UPGRADE_CONFIGSETUP;
}
else if (array_key_exists('btn_adminsetup', $_POST))
{
    // acquire the community preferences from session in order to add them to preferences table using putCommunityPreferences
    $aCommunity = array();
    session_start();
    $aCommunity['updates_enabled']         = $_SESSION['updates_enabled'];

    if ($oUpgrader->saveConfig($_POST['aConfig']) && $oUpgrader->putCommunityPreferences($aCommunity))
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
                //Hide the IDsetup, instead display the finish page
                //$action = OA_UPGRADE_IDSETUP;
                $message = 'Congratulations you have finished upgrading Openads';
                $oUpgrader->setOpenadsInstalledOn();
                $action = OA_UPGRADE_FINISH;
            }
        }
    }
    else
    {
        $action = OA_UPGRADE_ERROR;
    }
}
else if (array_key_exists('btn_adminsetup_back', $_POST))
{
    $aAdmin = unserialize(stripslashes($_POST['aAdminPost']));
    $action = OA_UPGRADE_ADMINSETUP;
}
else if (array_key_exists('btn_oaidsetup', $_POST))
{
    $action = OA_UPGRADE_IDSETUP;
}
else if (array_key_exists('btn_datasetup', $_POST))
{
    if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL)
    {
        $_POST['aAdmin']['updates_enabled'] = $_POST['updates_enabled'];
        $oUpgrader->putAdmin($_POST['aAdmin']);
        $action = OA_UPGRADE_DATASETUP;
    }
    else
    {
        $action = OA_UPGRADE_FINISH;
        $message = 'Congratulations you have finished upgrading Openads';
    }
}
else if (array_key_exists('btn_terms', $_POST))
{
    $action = OA_UPGRADE_TERMS;
}
else if (array_key_exists('btn_policy', $_POST))
{
    $action = OA_UPGRADE_POLICY;
}
else if (array_key_exists('btn_finish', $_POST))
{
    if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL)
    {
        if (array_key_exists('chk_dummydata', $_POST) && $_POST['chk_dummydata'])
        {
            $oUpgrader->insertDummyData();
        }
        $message = 'Congratulations you have finished installing Openads';
    }
    else
    {
        $message = 'Congratulations you have finished upgrading Openads';
    }
    $oUpgrader->setOpenadsInstalledOn();
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
    if (!$oUpgrader->removeUpgradeTriggerFile())
    {
        $message.= '. '.$strRemoveUpgradeFile;
        $strInstallSuccess = '<div class="sysinfoerror">'.$strOaUpToDateCantRemove.'</div>'.$strInstallSuccess;
    }
}

if ($installStatus == OA_STATUS_OAD_NOT_INSTALLED)
{
    setcookie('oat', OA_UPGRADE_INSTALL);
}
elseif ($installStatus != 'unknown')
{
    setcookie('oat', OA_UPGRADE_UPGRADE);
}

// Used to detmine which page is active in nav
$activeNav = array (
                    OA_UPGRADE_WELCOME        =>      '10',
                    OA_UPGRADE_TERMS          =>      '20',
                    OA_UPGRADE_POLICY         =>      '25',
                    OA_UPGRADE_SYSCHECK       =>      '30',
                    OA_UPGRADE_APPCHECK       =>      '30',
                    OA_UPGRADE_DBSETUP        =>      '50',
                    OA_UPGRADE_UPGRADE        =>      '50',
                    OA_UPGRADE_INSTALL        =>      '50',
                    OA_UPGRADE_CONFIGSETUP    =>      '60'
                  );
if ($_COOKIE['oat'] != OA_UPGRADE_UPGRADE) {
    $activeNav[OA_UPGRADE_ADMINSETUP]     =      '70';
    $activeNav[OA_UPGRADE_IDSETUP]        =      '70';
    $activeNav[OA_UPGRADE_DATASETUP]      =      '90';
}
$activeNav[OA_UPGRADE_FINISH] =      '100';

// setup the nav to determine whether or not to show a valid link
$navLinks = array();
foreach ($activeNav as $key=>$val) {
    if ($val <= $activeNav[$action] && $activeNav[$action] < $activeNav[OA_UPGRADE_CONFIGSETUP]) {
        $navLinks[$key] = 'javascript: changePage('.$key.')';
    } else {
        $navLinks[$key] = '';
    }
}

// Setup array for navigation
$phpAds_nav = array (
    '10'     =>  array($navLinks[OA_UPGRADE_WELCOME]     => 'Welcome'),
    '20'     =>  array($navLinks[OA_UPGRADE_TERMS]       => 'Terms'),
    '25'     =>  array($navLinks[OA_UPGRADE_POLICY]      => 'Policy'),
    '30'     =>  array($navLinks[OA_UPGRADE_SYSCHECK]    => 'System Check'),
    '40'     =>  array($navLinks[OA_UPGRADE_APPCHECK]    => 'Application Check'),
    '50'     =>  array($navLinks[OA_UPGRADE_DBSETUP]     => 'Database Setup'),
    '60'     =>  array($navLinks[OA_UPGRADE_CONFIGSETUP] => 'Configuration Setup'),
    '70'     =>  array($navLinks[OA_UPGRADE_ADMINSETUP]  => 'Admin Setup'),
    '80'     =>  array($navLinks[OA_UPGRADE_IDSETUP]     => 'Openads ID'),
    '90'     =>  array($navLinks[OA_UPGRADE_DATASETUP]   => 'Data Setup'),
    '100'    =>  array('' => 'Finished')
);

// display header, with proper 'active page' marked using $activeNav[$action]
phpAds_PageHeader($activeNav[$action],'', $imgPath, false, false);

// setup which sections to display
$showSections = array();
foreach ($activeNav as $val) {
    if (!in_array($val, $showSections))
        $showSections[] = $val;
}

// display navigation
phpAds_ShowSections($showSections, false, true, $imgPath, $phpAds_nav);

// calculate percentage complete
$totalNav     = count($showSections)-1;
$progressRate = 100 / $totalNav;
foreach($showSections as $key=>$val) {
    if ($val == $activeNav[$action]) {
        if ($key == 0) {
            $progressVal = 0;
        } elseif ($key == $totalNav) {
            $progressVal = 100;
        } else {
            $progressVal = round(($key) * $progressRate);
        }
        break;
    } else {
        $progressVal = 0;
    }
}
// display main template
include 'templates/install-index.html';

// display footer
phpAds_PageFooter($imgPath);

?>
