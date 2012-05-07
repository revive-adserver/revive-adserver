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
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once LIB_PATH . '/Plugin/PluginManager.php';
require_once LIB_PATH . '/Plugin/ComponentGroupManager.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

$oPluginManager = new OX_PluginManager();
$oComponentGroupManager = new OX_Plugin_ComponentGroupManager();

$action = $_REQUEST['action'];
$plugin = $_REQUEST['package'];
$group  = $_REQUEST['group'];
$parent = $_REQUEST['parent'];

if (OA_Admin_Settings::isConfigWritable()) {
//install
if (array_key_exists('install',$_POST))
{
    if (array_key_exists('filename',$_FILES))
    {
        $oPluginManager->installPackage($_FILES['filename']);
    }
}
else if (array_key_exists('import',$_POST))
{
    if (array_key_exists('filename',$_FILES))
    {
        $oPluginManager->installPackageCodeOnly($_FILES['filename']);
    }
}
else if (array_key_exists('upgrade',$_POST))
{
    if (array_key_exists('filename',$_FILES))
    {
        $oPluginManager->upgradePackage($_FILES['filename'],$plugin);
        $oTpl = new OA_Admin_Template('plugin-view.html');
        $aPackageInfo = $oPluginManager->getPackageInfo($plugin);
        $aComponents = $aPackageInfo['contents'];
        unset($aPackageInfo['contents']);
        if ($aPackageInfo['readme'])
        {
            $readme = file_get_contents($aPackageInfo['readme']);
        }
        $aPackageInfo['package'] = true;
        $oTpl->assign('aPackage',$aPackageInfo);
        $oTpl->assign('aPlugins',$aComponents);
        $oTpl->assign('readme',$readme);
        $oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?selection=packages"));
        $oTpl->assign('aWarnings',$oPluginManager->aWarnings);
        $oTpl->assign('aErrors',$oPluginManager->aErrors);
        $oTpl->assign('aMessages',$oPluginManager->aMessages);
    }
}
else if (array_key_exists('diagnose',$_POST))
{
    $oTpl = new OA_Admin_Template('plugin-view.html');
    $aPackageInfo = $oPluginManager->getPackageInfo($plugin);
    $aComponents = $aPackageInfo['contents'];
    unset($aPackageInfo['contents']);
    if ($aPackageInfo['readme'])
    {
        $readme = file_get_contents($aPackageInfo['readme']);
    }
    $aPackageInfo['package'] = true;
    $oTpl->assign('aPackage',$aPackageInfo);
    $oTpl->assign('aPlugins',$aComponents);
    $oTpl->assign('readme',$readme);
    $oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?selection=packages"));
    $oTpl->assign('aWarnings',$oPluginManager->aWarnings);

    $oPluginManager->getPackageDiagnostics($plugin);
    if (!count($oPluginManager->aErrors))
    {
        $oPluginManager->aMessages[] = 'No problems detected';
    }
    $oTpl->assign('aErrors',$oPluginManager->aErrors);
    $oTpl->assign('aMessages',$oPluginManager->aMessages);
}
else if (array_key_exists('export',$_POST))
{
    require_once LIB_PATH.'/Plugin/PluginExport.php';
    $oExporter = new OX_PluginExport();
    if ($file = $oExporter->exportPlugin($plugin))
    {
        $aMessages = 'Plugin exported to '.$file;
    }
    $oTpl = new OA_Admin_Template('plugin-view.html');
    $aPackageInfo = $oPluginManager->getPackageInfo($plugin);
    $aComponents = $aPackageInfo['contents'];
    unset($aPackageInfo['contents']);
    if ($aPackageInfo['readme'])
    {
        $readme = file_get_contents($aPackageInfo['readme']);
    }
    $aPackageInfo['package'] = true;
    $oTpl->assign('aPackage',$aPackageInfo);
    $oTpl->assign('aPlugins',$aComponents);
    $oTpl->assign('readme',$readme);
    $oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?selection=packages"));

    $oTpl->assign('aMessages',$aMessages);
    $oTpl->assign('aErrors',$oExporter->aErrors);
}
else if (array_key_exists('backup',$_POST))
{
    require_once LIB_PATH.'/Plugin/PluginExport.php';
    $oExporter = new OX_PluginExport();
    $oExporter->init($plugin);
    $aMessages = $oExporter->backupTables($plugin);
    $oTpl = new OA_Admin_Template('plugin-view.html');
    $aPackageInfo = $oPluginManager->getPackageInfo($plugin);
    $aComponents = $aPackageInfo['contents'];
    unset($aPackageInfo['contents']);
    if ($aPackageInfo['readme'])
    {
        $readme = file_get_contents($aPackageInfo['readme']);
    }
    $aPackageInfo['package'] = true;
    $oTpl->assign('aPackage',$aPackageInfo);
    $oTpl->assign('aPlugins',$aComponents);
    $oTpl->assign('readme',$readme);
    $oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?selection=packages"));

    $oTpl->assign('aMessages', ($aMessages ? $aMessages : array()));
    $oTpl->assign('aErrors',$oExporter->aErrors);
}
//actions
else if ('uninstall' == $action)
{
    $oTpl = new OA_Admin_Template('plugin-uninstall.html');
    $aPackageInfo = $oPluginManager->getPackageInfo($plugin);
    $aComponents = $aPackageInfo['contents'];
    unset($aPackageInfo['contents']);
    if ($aPackageInfo['uninstallReadme'])
    {
        $uninstallReadme = file_get_contents($aPackageInfo['uninstallReadme']);
    }
    $aPackageInfo['package'] = true;
    $oTpl->assign('aPackage',$aPackageInfo);
    $oTpl->assign('aPlugins',$aComponents);
    $oTpl->assign('uninstallReadme',$uninstallReadme);
    $oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?selection=packages"));
}
else if (array_key_exists('uninstallConfirmed',$_POST))
{
    $oPluginManager->uninstallPackage($plugin);
    if (!($oPluginManager->countErrors() || $oPluginManager->countWarnings()))
    {
        OX_Admin_Redirect::redirect('plugin-index.php');
    }
}
else if ('enable' == $action)
{
    if ($plugin)
    {
        $oPluginManager->enablePackage($plugin);
    }
    if (!($oPluginManager->countErrors() || $oPluginManager->countWarnings()))
    {
        OX_Admin_Redirect::redirect('plugin-index.php');
    }
}
else if ('disable' == $action)
{
    if ($plugin)
    {
        $oPluginManager->disablePackage($plugin);
    }
    else if ($group)
    {
        $oComponentGroupManager->disableComponentGroup($group);
    }
    if (!($oPluginManager->countErrors() || $oPluginManager->countWarnings()))
    {
        require_once LIB_PATH . '/Admin/Redirect.php';
        OX_Admin_Redirect::redirect('plugin-index.php');
    }
}
}
if ('info' == $action)
{
    if ($plugin)
    {
        if (!isset($GLOBALS['_MAX']['CONF']['plugins'][$plugin])) {
            require_once LIB_PATH . '/Admin/Redirect.php';
            OX_Admin_Redirect::redirect('plugin-index.php');
        }
        $oTpl = new OA_Admin_Template('plugin-view.html');
        $aPackageInfo = $oPluginManager->getPackageInfo($plugin);
        $aComponents = $aPackageInfo['contents'];
        unset($aPackageInfo['contents']);
        if ($aPackageInfo['readme'])
        {
            $readme = file_get_contents($aPackageInfo['readme']);
        }
        $aPackageInfo['package'] = true;
        $oTpl->assign('aPackage',$aPackageInfo);
        $oTpl->assign('aPlugins',$aComponents);
        $oTpl->assign('readme',$readme);
        $oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?selection=packages"));
    }
    else if ($group)
    {
        $oTpl = new OA_Admin_Template('plugin-group-view.html');
        $aGroupInfo = $oComponentGroupManager->getComponentGroupInfo($group);
        $aGroupInfo['pluginGroupComponents'] = $oComponentGroupManager->getComponentGroupObjectsInfo($aGroupInfo['extends'], $group);
        $oTpl->assign('aPlugin',$aGroupInfo);
        $oTpl->assign('parent', $parent);
        $oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?action=info&package=$parent"));
    }
}
else if ('settings' == $action)
{
    require_once LIB_PATH . '/Admin/Redirect.php';
    OX_Admin_Redirect::redirect("plugin-settings.php?group=$group&parent=$parent");
}
else if ('preferences'== $action)
{
    require_once LIB_PATH . '/Admin/Redirect.php';
    OX_Admin_Redirect::redirect("plugin-preferences.php?group=$group&parent=$parent");
}

else if (array_key_exists('checkdb',$_GET))
{
    $aInfo = $oComponentGroupManager->getComponentGroupInfo($_GET['checkdb']);
    $aSchema = $oComponentGroupManager->checkDatabase($_GET['checkdb'], $aInfo);
    $oTpl = new OA_Admin_Template('plugin-group-index.html');
    $oTpl->assign('parent', $_GET['parent']);
    $oTpl->assign('parenturl', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?info={$_GET['parent']}&package=true"));
    $oTpl->assign('aHeader',$aInfo);
    $oTpl->assign('aPluginDB',$aSchema);
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("plugin-index", new OA_Admin_UI_Model_PageHeaderModel($GLOBALS['strPlugins']), '', false, true);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (is_null($oTpl))
{
    if (array_key_exists('selection',$_REQUEST) && ($_REQUEST['selection']=='groups'))
    {
        $oTpl = new OA_Admin_Template('plugin-group-index-list.html');
        $oTpl->assign('aWarnings',$oComponentGroupManager->aWarnings);
        $oTpl->assign('selected','groups');
        $oTpl->assign('aPlugins',$oComponentGroupManager->getComponentGroupsList());
    }
    else //if ($_POST['selection']=='plugins')
    {
        $oTpl = new OA_Admin_Template('plugin-index.html');
        $oTpl->assign('selected','plugins');
        $oTpl->assign('aPackages',$oPluginManager->getPackagesList());
        $oTpl->assign('aWarnings',$oPluginManager->aWarnings);
        $oTpl->assign('aErrors',$oPluginManager->aErrors);
        $oTpl->assign('aMessages',$oPluginManager->aMessages);
    }
}

// Determine if config file is writable
$configLocked = !OA_Admin_Settings::isConfigWritable();
$image = $configLocked ? 'closed' : 'open';
$oTpl->assign('configLocked',     $configLocked);
$oTpl->assign('image',            $image);
$oTpl->assign('token',            phpAds_SessionGetToken());

$oTpl->display();

phpAds_PageFooter();

?>