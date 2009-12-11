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
$Id: oxMarket.class.php 37393 2009-06-03 05:48:57Z matthieu.aubry $
*/

require_once LIB_PATH.'/Plugin/Component.php';

/**
 *
 * @package    openXWorkflow
 * @subpackage openXWorkflow
 * @author     Bernard Lange <bernard.lange@openx.org>
 */
class Plugins_admin_openXWorkflow_openXWorkflow 
    extends OX_Component
{
    /** Cached plugin version string */
    private $pluginVersion;
    
    
    function __construct()
    {
    }
    
    
    public function onEnable()
    {
        $oUI = OA_Admin_UI::getInstance();
        $oUI->registerJSFile(MAX::constructURL(MAX_URL_ADMIN, 'plugins/openXWorkflow/public/assets/wk/js/ox.wizard.js'));        
        
        return true;    
    }
    
    
    public function onDisable()
    {
        return true;
    }
    
    
    
    public function afterLogin()
    {
    }
    
    
    function getConfigValue($configKey)
    {
        return $GLOBALS['_MAX']['CONF']['openXWorkflow'][$configKey];
    }     
    
    
    public function getPluginVersion()
    {
        if (!isset($this->pluginVersion)) {
            $oPluginManager = new OX_PluginManager();
            $aInfo =  $oPluginManager->getPackageInfo('openXWorkflow', false);    
            $this->pluginVersion = strtolower($aInfo['version']);
        }
        
        return $this->pluginVersion;        
    }    
}

?>
