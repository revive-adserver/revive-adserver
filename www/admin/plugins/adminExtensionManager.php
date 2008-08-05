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
$Id$
*/

require_once(LIB_PATH.'/Extension/ExtensionCommon.php');

class OX_Extension_admin extends OX_Extension_Common
{
    function __construct()
    {

    }

    function _cacheAllMenus()
    {
        require_once MAX_PATH. '/lib/OA/Admin/Menu.php';
        require_once MAX_PATH. '/lib/OA/Admin/Menu/config.php';
        require_once(LIB_PATH.'/Plugin/PluginManager.php');

        return  $this->_cacheMergedMenu(OA_ACCOUNT_ADMIN) &&
                $this->_cacheMergedMenu(OA_ACCOUNT_MANAGER) &&
                $this->_cacheMergedMenu(OA_ACCOUNT_ADVERTISER) &&
                $this->_cacheMergedMenu(OA_ACCOUNT_TRAFFICKER);
    }

    function &_getMenuObjectForAccount($accountType)
    {
        $oMenu = new OA_Admin_Menu($accountType);
        $oMenu = _buildNavigation($accountType);
        return $oMenu;
    }

    function &_getGroupManagerObject()
    {
        return new OX_Plugin_ComponentGroupManager();
    }

    function _cacheMergedMenu($accountType)
    {
        $oMenu = $this->_getMenuObjectForAccount($accountType);

        $oManager = $this->_getGroupManagerObject();

        if (!$oManager->mergeMenu($oMenu, $accountType))
        {
            $oManager->_logError('Failed to merge menu for '.$accountType);
            return false;
        }
        if (!$oMenu->_saveToCache($accountType))
        {
            $oManager->_logError('Failed to cache menu for '.$accountType);
            return false;
        }
        return true;
    }

    function runTasksAfterPluginInstall()
    {
        $this->_cacheAllMenus();
    }

    function runTasksAfterPluginUninstall()
    {
        $this->_cacheAllMenus();
    }

    function runTasksAfterPluginEnable()
    {
        $this->_cacheAllMenus();
    }

    function runTasksAfterPluginDisable()
    {
        $this->_cacheAllMenus();
    }


}

?>