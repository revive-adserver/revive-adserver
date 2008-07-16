<?php

$upgradeTaskMessage = array();
$upgradeTaskError   = array();
$upgradeTaskResult  = true;

require_once MAX_PATH.'/lib/OA/Plugin/PluginManager.php';
$oPluginManager = new OX_PluginManager();

$aInstalledPlugins = $GLOBALS['_MAX']['CONF']['plugins'];

include MAX_PATH.'/etc/default_plugins.php';
if ($aDefaultPlugins)
{
    $upgradeTaskError[] = 'Installing OpenX Plugins';
    foreach ($aDefaultPlugins AS $idx => $aPlugin)
    {
        $oPluginManager->clearErrors();
        if (!array_key_exists($aPlugin['name'],$aInstalledPlugins))
        {
            $filename = $aPlugin['name'].'.'.$aPlugin['ext'];
            $filepath = $aPlugin['path'].$filename;
            // TODO: refactor for remote paths?
            $oPluginManager->installPackage(array('tmp_name'=>$filepath, 'name'=>$filename));
            if ($oPluginManager->countErrors())
            {
                $upgradeTaskError[] = $aPlugin['name'].': Failed';
                foreach ($oPluginManager->aErrors as $errmsg)
                {
                    $upgradeTaskError[] = $errmsg;
                }
                $upgradeTaskResult  = false;
            }
            else
            {
                $oPluginManager->enablePackage($aPlugin['name']);
                $upgradeTaskError[] = $aPlugin['name'].': OK';
            }
        }
    }
}
$oPluginManager->cacheComponentGroups();
$oPluginManager->cachePackages();

?>