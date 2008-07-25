<?php

require_once LIB_PATH.'/Plugin/PluginManager.php';
$oPluginManager = new OX_PluginManager();

$upgradeTaskMessage = array();
$upgradeTaskError   = array();
$upgradeTaskResult  = true;
$enable             = true;
$upgradeTaskError[] = 'Checking OpenX Plugins';
foreach ($GLOBALS['_MAX']['CONF']['plugins'] as $name => $enabled)
{
    $aDiag  = $oPluginManager->getPackageDiagnostics($name);
    if ($aDiag['plugin']['error'])
    {
        $upgradeTaskError[] = 'Problems found with plugin '.$name.'.  The plugin has been disabled.  Go to the Configuration Plugins page for details ';
        foreach ($aDiag['plugin']['errors'] as $i => $msg)
        {
            $upgradeTaskError[] =$msg;
        }
        $enable = false;
        $upgradeTaskResult  = false;
    }
    foreach ($aDiag['groups'] as $idx => $aGroup)
    {
        if ($aGroup['error'])
        {
            $upgradeTaskError[] = 'Problems found with components in group '.$aGroup['name'].'.  The '.$name.' plugin has been disabled.  Go to the Configuration Plugins page for details ';
            foreach ($aGroup['errors'] as $i => $msg)
            {
                $upgradeTaskError[] =$msg;
            }
            $enable = false;
            $upgradeTaskResult  = false;
        }
    }
    if ($enable)
    {
        $oPluginManager->enablePackage($name);
        $upgradeTaskError[] = $name.' checked, OK, enabled';
    }
}
// now check to see if there are new default plugins that need installing and install them
include MAX_PATH.'/etc/changes/tasks/openads_upgrade_task_Install_Plugins.php';

?>