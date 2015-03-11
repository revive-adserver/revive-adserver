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
 * An  element used to add field controls with custom plugin template. This kind of
 * control goes beyond ordinary form element eg. by combining them. 
 */

require_once MAX_PATH.'/lib/pear/HTML/QuickForm/static.php';

class OA_Admin_UI_Component_CustomPluginFormElement 
    extends HTML_QuickForm_static
{
    private $vars;
    private $pluginName;
    private $templateId;
    private $visible;    
    
    
   /**
    * Class constructor
    * 
    * @param mixed $elementName    custom element name or if its array then first element
    * is element name and the second one is template name
    */
    function __construct($elementName = null, $pluginName = null, $elementLabel = null, $vars = null, $visible = true)
    {
        if (is_array($elementName)) {
            $name = $elementName[0];
            $templateId = $elementName[1]; 
        }
        else {
            $name = $elementName;
            $templateId = $elementName;
        }
        
        parent::__construct($name, $elementLabel);
        $this->_type = 'plugin-custom';
        $this->pluginName = $pluginName;
        $this->templateId = $templateId; 
        $this->vars = $vars;
        $this->visible = true;
    }
    
    
    /**
     * Returns custom variables and values assigned to this element. 
     * This items are used during rendering phase of custom element
     *
     */
    function getTemplateId()
    {
        return $this->templateId;
    }    
    
    
    /**
     * Returns custom variables and values assigned to this element. 
     * This items are used during rendering phase of custom element
     *
     */
    function getVars()
    {
        return $this->vars;
    }
    

    /**
     * Returns a plugin name
     *
     */
    function getPluginName()
    {
        return $this->pluginName;
    }
    

    /**
     * Returns if this element is visible and thus should generate a break
     */
    function isVisible()
    {
        return $this->visible;
    }    
    
   
   /**
    * Accepts a renderer
    *
    * @param HTML_QuickForm_Renderer    renderer object
    */
    function accept(&$renderer, $required=false, $error=null)
    {
        $renderer->renderElement($this, $required, $error);
    } 
} 
?>
