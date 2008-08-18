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
$Id $
*/


/**
 * the upgrader will have disabled all plugins when it started upgrading
 * it should have dropped a file with a record of the orginal settings
 * read this file and the reconstruct settings array
 *
 * @return unknown
 */
if (!function_exists('getPluginOriginalSettings'))
{
    function getPluginOriginalSettings()
    {
        $file = MAX_PATH.'/var/plugins/recover/enabled.log';
        if (file_exists($file))
        {
            $aContent = explode(';', file_get_contents($file));
            $aResult = array();
            foreach ($aContent as $k => $v)
            {
                if (trim($v))
                {
                    $aLine = explode('=', trim($v));
                    if (is_array($aLine) && (count($aLine)==2) && (is_numeric($aLine[1])))
                    {
                        $aResult[$aLine[0]] = $aLine[1];
                    }
                }
            }
        }
        @unlink($file);
        return $aResult;
    }
}
// only set these variables if they've not been set by another task yet
if (!$upgradeTaskMessage)
{
    $upgradeTaskMessage = array();
}
if (!$upgradeTaskError)
{
    $upgradeTaskError   = array();
}
if (is_null($upgradeTaskResult))
{
    $upgradeTaskResult  = true;
}

$upgradeTaskError[] = 'Checking Installed Plugins';

require_once LIB_PATH.'/Plugin/PluginManager.php';
$oPluginManager     = new OX_PluginManager();
$aPluginSettings    = getPluginOriginalSettings();

foreach ($GLOBALS['_MAX']['CONF']['plugins'] as $name => $enabled)
{
    $aDiag   = $oPluginManager->getPackageDiagnostics($name);
    if ($aDiag['plugin']['error'])
    {
        $upgradeTaskError[] = 'Problems found with plugin '.$name.'.  The plugin has been disabled.  Go to the Configuration Plugins page for details ';
        foreach ($aDiag['plugin']['errors'] as $i => $msg)
        {
            $upgradeTaskError[] =$msg;
        }
        $upgradeTaskResult  = false;
    }
    foreach ($aDiag['groups'] as $idx => $aGroup)
    {
        if ($aGroup['error'])
        {
            $aDiag['plugin']['error'] = true;
            $upgradeTaskError[] = 'Problems found with components in group '.$aGroup['name'].'.  The '.$name.' plugin has been disabled.  Go to the Configuration->Plugins page for details ';
            foreach ($aGroup['errors'] as $i => $msg)
            {
                $upgradeTaskError[] =$msg;
            }
            $upgradeTaskResult  = false;
        }
    }
    $enabled = $aPluginSettings[$name]; // original setting
    $error   = $aDiag['plugin']['error']; // plugin-specific error
    $msg = $name.' installation status: ';
    $msg.= (!$error ? 'OK' : 'Errors, disabled');
    if ($enabled && (!$error))
    {
        if ($oPluginManager->enablePackage($name))
        {
            $msg.= ', enabled';
        }
        else
        {
            $msg.= ', failed to enable, check plugin configuration ';
        }
    }
    $upgradeTaskError[] = $msg;
}
// don't install default during tests - or test can destroy default plugins under development
if (!defined('TEST_ENVIRONMENT_RUNNING'))
{
    // now check to see if there are new default plugins that need installing and install them
    include MAX_PATH.'/etc/changes/tasks/openads_upgrade_task_Install_Plugins.php';
}
?>