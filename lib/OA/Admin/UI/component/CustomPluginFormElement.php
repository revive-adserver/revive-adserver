<?php
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
    
   /**
    * Class constructor
    * 
    * @param string $elementName    custom element name
    */
    function OA_Admin_UI_Component_CustomPluginFormElement($elementName = null, $pluginName = null, $elementLabel = null, $vars = null)
    {
        $this->HTML_QuickForm_static($elementName, $elementLabel);
        $this->_type = 'plugin-custom';
        $this->pluginName = $pluginName;
        $this->vars = $vars;
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
