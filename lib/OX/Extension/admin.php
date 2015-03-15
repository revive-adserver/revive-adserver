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

require_once(LIB_PATH.'/Extension/ExtensionCommon.php');

/**
 * @package    OpenXExtension
 */
class OX_Extension_admin extends OX_Extension_Common
{
    function __construct()
    {

    }

    function runTasksOnDemand($task='')
    {
        $this->_cacheAllMenus();
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
        parent::runTasksAfterPluginInstall();
        $this->_cacheAllMenus();
    }

    function runTasksAfterPluginUninstall()
    {
        parent::runTasksAfterPluginUninstall();
        $this->_cacheAllMenus();
    }

    function runTasksAfterPluginEnable()
    {
        parent::runTasksAfterPluginEnable();
        $this->_cacheAllMenus();
    }

    function runTasksAfterPluginDisable()
    {
        parent::runTasksAfterPluginDisable();
        $this->_cacheAllMenus();
    }


}

?>