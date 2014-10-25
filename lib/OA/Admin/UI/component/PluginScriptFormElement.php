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

/**
* An element used to add JS script embedded in plugin template
**/

require_once MAX_PATH.'/lib/OA/Admin/UI/component/CustomPluginFormElement.php';

class OA_Admin_UI_Component_PluginScriptFormElement 
    extends OA_Admin_UI_Component_CustomPluginFormElement
{
   /**
    * Class constructor
    * 
    * @param string $elementName    custom element name
    */
    function OA_Admin_UI_Component_PluginScriptFormElement($elementName = null, $pluginName = null, $vars = null)
    {
        parent::OA_Admin_UI_Component_CustomPluginFormElement($elementName, $pluginName, null, $vars);
        $this->_type = 'plugin-script';
    } 
} 
?>
