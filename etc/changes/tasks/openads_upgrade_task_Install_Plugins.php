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

require_once LIB_PATH.'/Plugin/PluginManager.php';
$oPluginManager = new OX_PluginManager();

include MAX_PATH.'/etc/default_plugins.php';
if ($aDefaultPlugins)
{
    $upgradeTaskError[] = 'Installing OpenX Plugins';
    foreach ($aDefaultPlugins AS $idx => $aPlugin)
    {
        $oPluginManager->clearErrors();
        if (!array_key_exists($aPlugin['name'], $GLOBALS['_MAX']['CONF']['plugins']))
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

?>