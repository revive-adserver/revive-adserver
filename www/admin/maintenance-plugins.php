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
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("maintenance-index");
phpAds_MaintenanceSelection("plugins");


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

echo "<br />";
echo $strPluginsPrecis;
echo "<br /><br />";

phpAds_registerGlobal('action', 'returnurl');

if (!empty($action)) {
    OA_Permission::checkSessionToken();

    switch ($action) {
        case 'rep':
            // generates brief display and detailed log
            // with debug info on plugin installations and status
            require_once(LIB_PATH . '/Extension/ExtensionCommon.php');
            $oExtensionManager = new OX_Extension_Common();
            $aPlugins = $oExtensionManager->getPluginsDiagnostics();
            $oTpl = new OA_Admin_Template('plugin-report.html');
            $oTpl->assign('aPlugins', $aPlugins['simple']);
            $oTpl->assign('aErrors', $aPlugins['errors']);
            if ($fp = fopen(MAX_PATH . '/var/plugins-report.log', 'w')) {
                fwrite($fp, "********** Display array var_dump **********\n");
                fwrite($fp, print_r($aPlugins['simple'], true));
                fwrite($fp, "\n********** Errors array var_dump: **********\n");
                fwrite($fp, print_r($aPlugins['errors'], true));
                fwrite($fp, "\n********** getPluginsDiagnostics() var_dump: **********\n");
                fwrite($fp, print_r($aPlugins['detail'], true));
                fclose($fp);
            }
            break;
        case 'pref':
            // this rebuilds the cached array that holds the text and links
            // for the account-preferences drop-down list
            require_once(LIB_PATH . '/Extension/ExtensionCommon.php');
            $oExtensionManager = new OX_Extension_Common();
            $oExtensionManager->cachePreferenceOptions();
            break;
        case 'hook':
            // this rebuilds the cached array that holds the component hook registration array
            require_once(LIB_PATH . '/Extension/ExtensionCommon.php');
            $oExtensionManager = new OX_Extension_Common();
            $oExtensionManager->cacheComponentHooks();
            break;
        case 'reg':
            // currently rewrites delivery hooks to conf
            require_once(LIB_PATH . '/Extension/ExtensionDelivery.php');
            $oExtensionManager = new OX_Extension_Delivery();
            $oExtensionManager->runTasksOnDemand();
            break;
        case 'exp':
            $oTpl = new OA_Admin_Template('plugin-export.html');
            require_once LIB_PATH . '/Plugin/PluginExport.php';
            $oExporter = new OX_PluginExport();
            $aErrors = [];
            foreach ($GLOBALS['_MAX']['CONF']['plugins'] as $name => $enabled) {
                $aPlugins[$name]['file'] = '';
                $aPlugins[$name]['error'] = false;
                if ($file = $oExporter->exportPlugin($name)) {
                    $aPlugins[$name]['file'] = $file;
                } else {
                    $aPlugins[$name]['error'] = true;
                    $aErrors[] = $oExporter->aErrors;
                }
            }
            $oTpl->assign('aPlugins', $aPlugins);
            $oTpl->assign('aErrors', $aErrors);
            break;
        /*case 'dep':
            require_once LIB_PATH . '/Plugin/PluginManager.php';
            $oPluginManager = new OX_PluginManager();
            $oPluginManager->_cacheDependencies();
            if (empty($oPluginManager->aErrors))
            {
                $oPluginManager->aMessages[] = 'No dependency problems detected';
            }
            break;*/
        default:
    }
}

$token = 'token=' . urlencode(phpAds_SessionGetToken()) . '&amp;';

phpAds_ShowBreak();
echo "<img src='" . OX::assetPath() . "/images/" . $phpAds_TextDirection . "/icon-undo.gif' border='0' align='absmiddle'>&nbsp;<a href='maintenance-plugins.php?{$token}action=hook'>Rebuild Component Hooks Cache</a>&nbsp;&nbsp;";
phpAds_ShowBreak();
echo "<img src='" . OX::assetPath() . "/images/" . $phpAds_TextDirection . "/icon-undo.gif' border='0' align='absmiddle'>&nbsp;<a href='maintenance-plugins.php?{$token}action=pref'>Rebuild Preferences List</a>&nbsp;&nbsp;";
phpAds_ShowBreak();
echo "<img src='" . OX::assetPath() . "/images/" . $phpAds_TextDirection . "/icon-undo.gif' border='0' align='absmiddle'>&nbsp;<a href='maintenance-plugins.php?{$token}action=reg'>Rebuild Delivery Hooks Cache</a>&nbsp;&nbsp;";
phpAds_ShowBreak();
echo "<img src='" . OX::assetPath() . "/images/" . $phpAds_TextDirection . "/icon-undo.gif' border='0' align='absmiddle'>&nbsp;<a href='maintenance-plugins.php?{$token}action=rep'>Plugin Report</a>&nbsp;&nbsp;";
phpAds_ShowBreak();
echo "<img src='" . OX::assetPath() . "/images/" . $phpAds_TextDirection . "/icon-undo.gif' border='0' align='absmiddle'>&nbsp;<a href='maintenance-plugins.php?{$token}action=exp'>Export All Plugins</a>&nbsp;&nbsp;";
phpAds_ShowBreak();

/*echo "<img src='" . OX::assetPath() . "/images/".$phpAds_TextDirection."/icon-undo.gif' border='0' align='absmiddle'>&nbsp;<a href='maintenance-plugins.php?{$token}action=dep'>Check Dependencies</a>&nbsp;&nbsp;";
phpAds_ShowBreak();*/
if ($oTpl) {
    $oTpl->display();
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();
