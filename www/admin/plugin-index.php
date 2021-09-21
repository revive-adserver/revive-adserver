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

$pattern = '/[^a-zA-Z0-9\._-]/';
$action = preg_replace($pattern, '', $_REQUEST['action']);
$plugin = preg_replace($pattern, '', $_REQUEST['package']);
$group = preg_replace($pattern, '', $_REQUEST['group']);
$parent = preg_replace($pattern, '', $_REQUEST['parent']);

if (OA_Admin_Settings::isConfigWritable()) {
    //install
    if (array_key_exists('install', $_POST)) {
        OA_Permission::checkSessionToken();

        if (array_key_exists('filename', $_FILES)) {
            $oPluginManager->installPackage($_FILES['filename']);
        }
    } elseif (array_key_exists('import', $_POST)) {
        OA_Permission::checkSessionToken();

        if (array_key_exists('filename', $_FILES)) {
            $oPluginManager->installPackageCodeOnly($_FILES['filename']);
        }
    } elseif (array_key_exists('upgrade', $_POST)) {
        OA_Permission::checkSessionToken();

        if (array_key_exists('filename', $_FILES)) {
            $oPluginManager->upgradePackage($_FILES['filename'], $plugin);
            $oTpl = new OA_Admin_Template('plugin-view.html');
            $aPackageInfo = $oPluginManager->getPackageInfo($plugin);
            $aComponents = $aPackageInfo['contents'];
            unset($aPackageInfo['contents']);
            if ($aPackageInfo['readme']) {
                $readme = file_get_contents($aPackageInfo['readme']);
            }
            $aPackageInfo['package'] = true;
            $oTpl->assign('aPackage', $aPackageInfo);
            $oTpl->assign('aPlugins', $aComponents);
            $oTpl->assign('readme', $readme);
            $oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?selection=packages"));
            $oTpl->assign('aWarnings', $oPluginManager->aWarnings);
            $oTpl->assign('aErrors', $oPluginManager->aErrors);
            $oTpl->assign('aMessages', $oPluginManager->aMessages);
        }
    } elseif (array_key_exists('diagnose', $_POST)) {
        OA_Permission::checkSessionToken();

        $oTpl = new OA_Admin_Template('plugin-view.html');
        $aPackageInfo = $oPluginManager->getPackageInfo($plugin);
        $aComponents = $aPackageInfo['contents'];
        unset($aPackageInfo['contents']);
        if ($aPackageInfo['readme']) {
            $readme = file_get_contents($aPackageInfo['readme']);
        }
        $aPackageInfo['package'] = true;
        $oTpl->assign('aPackage', $aPackageInfo);
        $oTpl->assign('aPlugins', $aComponents);
        $oTpl->assign('readme', $readme);
        $oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?selection=packages"));
        $oTpl->assign('aWarnings', $oPluginManager->aWarnings);

        $oPluginManager->getPackageDiagnostics($plugin);
        if (!count($oPluginManager->aErrors)) {
            $oPluginManager->aMessages[] = 'No problems detected';
        }
        $oTpl->assign('aErrors', $oPluginManager->aErrors);
        $oTpl->assign('aMessages', $oPluginManager->aMessages);
    } elseif (array_key_exists('export', $_POST)) {
        OA_Permission::checkSessionToken();

        require_once LIB_PATH . '/Plugin/PluginExport.php';
        $oExporter = new OX_PluginExport();
        if ($file = $oExporter->exportPlugin($plugin)) {
            $aMessages = 'Plugin exported to ' . $file;
        }
        $oTpl = new OA_Admin_Template('plugin-view.html');
        $aPackageInfo = $oPluginManager->getPackageInfo($plugin);
        $aComponents = $aPackageInfo['contents'];
        unset($aPackageInfo['contents']);
        if ($aPackageInfo['readme']) {
            $readme = file_get_contents($aPackageInfo['readme']);
        }
        $aPackageInfo['package'] = true;
        $oTpl->assign('aPackage', $aPackageInfo);
        $oTpl->assign('aPlugins', $aComponents);
        $oTpl->assign('readme', $readme);
        $oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?selection=packages"));

        $oTpl->assign('aMessages', $aMessages);
        $oTpl->assign('aErrors', $oExporter->aErrors);
    } elseif (array_key_exists('backup', $_POST)) {
        OA_Permission::checkSessionToken();

        require_once LIB_PATH . '/Plugin/PluginExport.php';
        $oExporter = new OX_PluginExport();
        $oExporter->init($plugin);
        $aMessages = $oExporter->backupTables($plugin);
        $oTpl = new OA_Admin_Template('plugin-view.html');
        $aPackageInfo = $oPluginManager->getPackageInfo($plugin);
        $aComponents = $aPackageInfo['contents'];
        unset($aPackageInfo['contents']);
        if ($aPackageInfo['readme']) {
            $readme = file_get_contents($aPackageInfo['readme']);
        }
        $aPackageInfo['package'] = true;
        $oTpl->assign('aPackage', $aPackageInfo);
        $oTpl->assign('aPlugins', $aComponents);
        $oTpl->assign('readme', $readme);
        $oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?selection=packages"));

        $oTpl->assign('aMessages', ($aMessages ? $aMessages : []));
        $oTpl->assign('aErrors', $oExporter->aErrors);
    }
    //actions
    elseif ('uninstall' == $action) {
        OA_Permission::checkSessionToken();

        $oTpl = new OA_Admin_Template('plugin-uninstall.html');
        $aPackageInfo = $oPluginManager->getPackageInfo($plugin);
        $aComponents = $aPackageInfo['contents'];
        unset($aPackageInfo['contents']);
        if ($aPackageInfo['uninstallReadme']) {
            $uninstallReadme = file_get_contents($aPackageInfo['uninstallReadme']);
        }
        $aPackageInfo['package'] = true;
        $oTpl->assign('aPackage', $aPackageInfo);
        $oTpl->assign('aPlugins', $aComponents);
        $oTpl->assign('uninstallReadme', $uninstallReadme);
        $oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?selection=packages"));
    } elseif (array_key_exists('uninstallConfirmed', $_POST)) {
        OA_Permission::checkSessionToken();

        $oPluginManager->uninstallPackage($plugin);
        if (!($oPluginManager->countErrors() || $oPluginManager->countWarnings())) {
            OX_Admin_Redirect::redirect('plugin-index.php');
        }
    } elseif ('enable' == $action) {
        OA_Permission::checkSessionToken();

        if ($plugin) {
            $oPluginManager->enablePackage($plugin);
        }
        if (!($oPluginManager->countErrors() || $oPluginManager->countWarnings())) {
            OX_Admin_Redirect::redirect('plugin-index.php');
        }
    } elseif ('disable' == $action) {
        OA_Permission::checkSessionToken();

        if ($plugin) {
            $oPluginManager->disablePackage($plugin);
        } elseif ($group) {
            $oComponentGroupManager->disableComponentGroup($group);
        }
        if (!($oPluginManager->countErrors() || $oPluginManager->countWarnings())) {
            require_once LIB_PATH . '/Admin/Redirect.php';
            OX_Admin_Redirect::redirect('plugin-index.php');
        }
    }
}
if ('info' == $action) {
    if ($plugin) {
        if (!isset($GLOBALS['_MAX']['CONF']['plugins'][$plugin])) {
            require_once LIB_PATH . '/Admin/Redirect.php';
            OX_Admin_Redirect::redirect('plugin-index.php');
        }
        $oTpl = new OA_Admin_Template('plugin-view.html');
        $aPackageInfo = $oPluginManager->getPackageInfo($plugin);
        $aComponents = $aPackageInfo['contents'];
        unset($aPackageInfo['contents']);
        if ($aPackageInfo['readme']) {
            $readme = file_get_contents($aPackageInfo['readme']);
        }
        $aPackageInfo['package'] = true;
        $oTpl->assign('aPackage', $aPackageInfo);
        $oTpl->assign('aPlugins', $aComponents);
        $oTpl->assign('readme', $readme);
        $oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?selection=packages"));
    } elseif ($group) {
        $oTpl = new OA_Admin_Template('plugin-group-view.html');
        $aGroupInfo = $oComponentGroupManager->getComponentGroupInfo($group);
        $aGroupInfo['pluginGroupComponents'] = $oComponentGroupManager->getComponentGroupObjectsInfo($aGroupInfo['extends'], $group);
        $oTpl->assign('aPlugin', $aGroupInfo);
        if ($parent) {
            $oTpl->assign('parent', $parent);
            $aPackageInfo = $oPluginManager->getPackageInfo($parent);
            if ($aPackageInfo['displayname']) {
                $oTpl->assign('parentDisplay', $aPackageInfo['displayname']);
            }
        }
        $oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?action=info&package=$parent"));
    }
} elseif ('settings' == $action) {
    require_once LIB_PATH . '/Admin/Redirect.php';
    OX_Admin_Redirect::redirect("plugin-settings.php?group=$group&parent=$parent");
} elseif ('preferences' == $action) {
    require_once LIB_PATH . '/Admin/Redirect.php';
    OX_Admin_Redirect::redirect("plugin-preferences.php?group=$group&parent=$parent");
} elseif (array_key_exists('checkdb', $_GET)) {
    $aInfo = $oComponentGroupManager->getComponentGroupInfo($_GET['checkdb']);
    $aSchema = $oComponentGroupManager->checkDatabase($_GET['checkdb'], $aInfo);
    $oTpl = new OA_Admin_Template('plugin-group-index.html');
    $oTpl->assign('parent', $_GET['parent']);
    $oTpl->assign('parenturl', MAX::constructURL(MAX_URL_ADMIN, "plugin-index.php?info={$_GET['parent']}&package=true"));
    $oTpl->assign('aHeader', $aInfo);
    $oTpl->assign('aPluginDB', $aSchema);
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("plugin-index", new OA_Admin_UI_Model_PageHeaderModel($GLOBALS['strPlugins']), '', false, true);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (is_null($oTpl)) {
    if (array_key_exists('selection', $_REQUEST) && ($_REQUEST['selection'] == 'groups')) {
        $oTpl = new OA_Admin_Template('plugin-group-index-list.html');
        $oTpl->assign('aWarnings', $oComponentGroupManager->aWarnings);
        $oTpl->assign('selected', 'groups');
        $oTpl->assign('aPlugins', $oComponentGroupManager->getComponentGroupsList());
    } else { //if ($_POST['selection']=='plugins')
        $oTpl = new OA_Admin_Template('plugin-index.html');
        $oTpl->assign('selected', 'plugins');
        $oTpl->assign('aPackages', $oPluginManager->getPackagesList());
        $oTpl->assign('aWarnings', $oPluginManager->aWarnings);
        $oTpl->assign('aErrors', $oPluginManager->aErrors);
        $oTpl->assign('aMessages', $oPluginManager->aMessages);
    }
}

// Determine if config file is writable
$configLocked = !OA_Admin_Settings::isConfigWritable();
$image = $configLocked ? 'closed' : 'open';
$oTpl->assign('configLocked', $configLocked);
$oTpl->assign('image', $image);
$oTpl->assign('token', phpAds_SessionGetToken());

$oTpl->display();

phpAds_PageFooter();
