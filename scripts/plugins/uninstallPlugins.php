<?php

if (!defined(MAX_PATH))
{
    require_once '../../init.php';
}
require_once LIB_PATH.'/Plugin/PluginManager.php';
include MAX_PATH.'/etc/default_plugins.php';
if ($aDefaultPlugins)
{
    foreach ($aDefaultPlugins AS $idx => &$aPlugin)
    {
        $oPluginManager = new OX_PluginManager();
        $oPluginManager->uninstallPackage($aPlugin['name']);
        unset($oPluginManager);
    }
}

?>