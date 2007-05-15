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
$Id $
*/

define('OA_UPGRADE_RECOVERY',                 -2);
define('OA_UPGRADE_ERROR',                    -1);
define('OA_UPGRADE_WELCOME',                   0);
define('OA_UPGRADE_TERMS',                     1);
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

global $installing;
$installing = true;

require_once '../../init.php';
require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';

// clear the $session variable to prevent users pretending to be logged in.
unset($session);
define('phpAds_installing',     true);

// CHANGE $_REQUEST TO $_POST

// MOVE THESE 2 FUNCTIONS SOMEWHERE ELSE - used in dbsetup.html

 /**
 * Return an array of supported DB types
 *
 * @return array
 */
function getSupportedDbTypes()
{
    // These values must be the same as used for the
    // data access layer file names!
    $types['mysql'] = 'mysql';
    $types['pgsql'] = 'pgsql';
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

$oUpgrader = new OA_Upgrade();

if ($oUpgrader->isRecoveryRequired())
{
    $oUpgrader->recoverUpgrade();
    $action = OA_UPGRADE_RECOVERY;
}
else if (array_key_exists('btn_syscheck', $_REQUEST))
{
    $aSysInfo = $oUpgrader->checkEnvironment();
    $halt = !$oUpgrader->canUpgrade();
    if (!$halt)
    {
        $halt = !$oUpgrader->checkUpgradePackage();
    }
    $action   = OA_UPGRADE_SYSCHECK;
}
else if (array_key_exists('btn_appcheck', $_REQUEST))
{
    $action = OA_UPGRADE_APPCHECK;
}
else if (array_key_exists('btn_dbsetup', $_REQUEST))
{
    if ($oUpgrader->canUpgrade())
    {
        $aDatabase = $oUpgrader->aDsn;
        $action    = OA_UPGRADE_DBSETUP;
    }
}
else if (array_key_exists('btn_upgrade', $_POST))
{
    if ($oUpgrader->canUpgrade())
    {
        if ($oUpgrader->existing_installation_status == OA_STATUS_NOT_INSTALLED)
        {
            if ($oUpgrader->install($_REQUEST['aConfig']))
            {
                $message = 'Successfully installed Openads version '.OA_VERSION;
                $action  = OA_UPGRADE_INSTALL;
            }
        }
        else
        {
            if ($oUpgrader->upgrade($oUpgrader->package_file))
            {
                $message = 'Successfully upgraded Openads to version '.OA_VERSION;
                $action  = OA_UPGRADE_UPGRADE;
            }
        }
    }
    if (($action != OA_UPGRADE_UPGRADE) && ($action != OA_UPGRADE_INSTALL))
    {
        $action = OA_UPGRADE_ERROR;
    }
}
else if (array_key_exists('btn_configsetup', $_REQUEST))
{
    $aConfig = $oUpgrader->getConfig();
    $action = OA_UPGRADE_CONFIGSETUP;
}
else if (array_key_exists('btn_adminsetup', $_REQUEST))
{
    if ($oUpgrader->saveConfig($_REQUEST['aConfig']))
    {
        if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL)
        {
            //$oUpgrader->getAdmin();
            $action = OA_UPGRADE_ADMINSETUP;
        }
        else
        {
            //$action = OA_UPGRADE_IDSETUP;
            $message = 'Congratulations you have finished upgrading Openads';
            $action = OA_UPGRADE_FINISH;
        }
    }
    else
    {
        $action = OA_UPGRADE_ERROR;
    }
}
else if (array_key_exists('btn_oaidsetup', $_REQUEST))
{
    $action = OA_UPGRADE_IDSETUP;
}
else if (array_key_exists('btn_datasetup', $_REQUEST))
{
    if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL)
    {
        $oUpgrader->putAdmin($_REQUEST['aAdmin']);
        $action = OA_UPGRADE_DATASETUP;
    }
    else
    {
        $action = OA_UPGRADE_FINISH;
        $message = 'Congratulations you have finished upgrading Openads';
    }
}
else if (array_key_exists('btn_terms', $_REQUEST))
{
    $action = OA_UPGRADE_TERMS;
}
else if (array_key_exists('btn_finish', $_REQUEST))
{
    if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL)
    {
        if (array_key_exists('chk_dummydata', $_REQUEST) && $_REQUEST['chk_dummydata'])
        {
            $oUpgrader->insertDummyData();
        }
        $message = 'Congratulations you have finished installing Openads';
    }
    else
    {
        $message = 'Congratulations you have finished upgrading Openads';
    }
    $oUpgrader->oConfiguration->setOpenadsInstalledOn();
    $action = OA_UPGRADE_FINISH;
}
else if (array_key_exists('btn_openads', $_REQUEST))
{
    header('location: http://'.$GLOBALS['_MAX']['CONF']['webpath']['admin']);
    exit();
}
else if (array_key_exists('dirPage', $_REQUEST))
{
    $action = $_POST['dirPage'];
}
else
{
    $action = OA_UPGRADE_WELCOME;
}

if (($action == OA_UPGRADE_UPGRADE) || ($action == OA_UPGRADE_INSTALL))
{
    setcookie('oat', $action);
}

// required files for header & nav
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/www/admin/lib-permissions.inc.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';

// Used to detmine which page is active
$activeNav = array (
    OA_UPGRADE_WELCOME        =>      '1',
    OA_UPGRADE_TERMS          =>      '2',
    OA_UPGRADE_SYSCHECK       =>      '3',
    OA_UPGRADE_APPCHECK       =>      '3',
    OA_UPGRADE_DBSETUP        =>      '5',
    OA_UPGRADE_CONFIGSETUP    =>      '6',
    OA_UPGRADE_ADMINSETUP     =>      '7',
    OA_UPGRADE_IDSETUP        =>      '7',
    OA_UPGRADE_DATASETUP      =>      '9',
    OA_UPGRADE_UPGRADE        =>      '10',
    OA_UPGRADE_INSTALL        =>      '10',
    OA_UPGRADE_FINISH         =>      '10'
);

// setup the nav to determine whether or not to show a valid link
$navLinks = array();
foreach ($activeNav as $key=>$val) {
    if ( $val <= $activeNav[$action]) {
        $navLinks[$key] = 'javascript: changePage('.$key.')';
    } else {
        $navLinks[$key] = '';
    }
}

// Setup array for navigation
$phpAds_nav = array (
    '1'     =>  array($navLinks[OA_UPGRADE_WELCOME]     => 'Welcome'),
    '2'     =>  array($navLinks[OA_UPGRADE_TERMS]       => 'Terms'),
    '3'     =>  array($navLinks[OA_UPGRADE_SYSCHECK]    => 'System Check'),
    '4'     =>  array($navLinks[OA_UPGRADE_APPCHECK]    => 'Application Check'),
    '5'     =>  array($navLinks[OA_UPGRADE_DBSETUP]     => 'Database Setup'),
    '6'     =>  array($navLinks[OA_UPGRADE_CONFIGSETUP] => 'Configuration Setup'),
    '7'     =>  array($navLinks[OA_UPGRADE_ADMINSETUP]  => 'Admin Setup'),
    '8'     =>  array($navLinks[OA_UPGRADE_IDSETUP]     => 'Openads ID'),
    '9'     =>  array($navLinks[OA_UPGRADE_DATASETUP]   => 'Data Setup'),
    '10'    =>  array('' => 'Finished')
);
// determine string of action
phpAds_PageHeader($activeNav[$action],'', '../admin/', false, false);
// display navigation
$showSections = array();
foreach ($activeNav as $val) {
    if (!in_array($val, $showSections))
        $showSections[] = $val;
}
phpAds_ShowSections($showSections, false, true, '../admin/', $phpAds_nav);

// display main template
include 'tpl/index.html';

// display footer
phpAds_PageFooter('../admin/');

?>
