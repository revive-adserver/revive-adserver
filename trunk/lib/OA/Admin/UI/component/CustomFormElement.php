<?php
/**
 * An  element used to add field controls with custom template. This kind of
 * control goes beyond ordinary form element eg. by combining them.
 */

require_once MAX_PATH.'/lib/pear/HTML/QuickForm/static.php';

class OA_Admin_UI_Component_CustomFormElement 
    extends HTML_QuickForm_static
{
    private $vars;
    private $visible;
    
   /**
    * Class constructor
    * 
    * @param string $elementName    custom element name
    */
    function OA_Admin_UI_Component_CustomFormElement($elementName = null, $elementLabel = null, $vars = null, $visible = true)
    {
        $this->HTML_QuickForm_static($elementName, $elementLabel);
        $this->_type = 'custom';
        $this->vars = $vars;
        $this->visible = $visible;
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
