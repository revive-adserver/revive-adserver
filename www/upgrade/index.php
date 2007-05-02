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

$oUpgrader = new OA_Upgrade();

if ($oUpgrader->oDBUpgrader->seekRecoveryFile())
{
    $oUpgrader->oDBUpgrader->prepRecovery();
    $action = OA_UPGRADE_RECOVERY;
}
else if (array_key_exists('btn_syscheck', $_REQUEST))
{
    $aSysInfo = $oUpgrader->checkEnvironment();
    $action   = OA_UPGRADE_SYSCHECK;
}
else if (array_key_exists('btn_appcheck', $_REQUEST))
{
    $halt = !$oUpgrader->canUpgrade();
    if (!$halt)
    {
        $halt = !$oUpgrader->checkUpgradePackage();
    }
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
    $oUpgrader->saveConfigDB($aConfig);
    if ($oUpgrader->canUpgrade())
    {
        if ($oUpgrader->existing_installation_status == OA_STATUS_NOT_INSTALLED)
        {
            $oUpgrader->aDsn['database'] = $_POST['database'];
            $oUpgrader->aDsn['table']    = $_POST['table'];
            if ($oUpgrader->install())
            {
                $message = 'Successfully installed Openads version '.OA_VERSION;
                $action  = OA_UPGRADE_INSTALL;
                setcookie('oat', $action);
            }
        }
        else
        {
            if ($oUpgrader->initDatabaseConnection())
            {
                if ($oUpgrader->checkDBPermissions())
                {
                    $oUpgrader->init($oUpgrader->package_file);
                    if ($oUpgrader->upgrade())
                    {
                        $message = 'Successfully upgraded Openads to version '.OA_VERSION;
                        $action  = OA_UPGRADE_UPGRADE;
                        setcookie('oat', $action);
                    }
                }
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
//        if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL)
//        {
//            $oUpgrader->getAdmin();
            $action = OA_UPGRADE_ADMINSETUP;
//        }
//        else
//        {
//            $action = OA_UPGRADE_IDSETUP;
//        }
    }
    else
    {
        $action = OA_UPGRADE_ERROR;
    }
}
else if (array_key_exists('btn_oaidsetup', $_REQUEST))
{
//    if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL)
//    {
        $oUpgrader->putAdmin($_REQUEST['aAdmin']);
//    }
    $action = OA_UPGRADE_IDSETUP;
}
else if (array_key_exists('btn_datasetup', $_REQUEST))
{
    // first save the openads id setup
    if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL)
    {
        $action = OA_UPGRADE_DATASETUP;
    }
    else
    {
        setcookie('oat', false);
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
        $message = 'Congratulations you have finished installing Openads';
    }
    else
    {
        $message = 'Congratulations you have finished upgrading Openads';
    }
    setcookie('oat', false);
    $action = OA_UPGRADE_FINISH;
}
else
{
    setcookie('oat', false);
    $action = OA_UPGRADE_WELCOME;
}

include 'tpl/index.html';


?>