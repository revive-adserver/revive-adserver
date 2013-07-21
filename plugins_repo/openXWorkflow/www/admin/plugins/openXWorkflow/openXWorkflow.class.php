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
