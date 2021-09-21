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
 * An  element used to add field controls with custom template. This kind of
 * control goes beyond ordinary form element eg. by combining them.
 * Element name is used as a basis in deriving element template. Template name
 * is actually custom-{elementName}.html
 */

require_once MAX_PATH . '/lib/pear/HTML/QuickForm/static.php';

class OA_Admin_UI_Component_CustomFormElement extends HTML_QuickForm_static
{
    private $vars;
    private $visible;
    private $templateId;
    
    /**
     * Class constructor
     *
     * @param mixed $elementName    custom element name or if its array then first element
     * is element name and the second one is template name
     */
    public function __construct($elementName = null, $elementLabel = null, $vars = null, $visible = true)
    {
        if (is_array($elementName)) {
            $name = $elementName[0];
            $templateId = $elementName[1];
        } else {
            $name = $elementName;
            $templateId = $elementName;
        }
        
        parent::__construct($name, $elementLabel);
        $this->_type = 'custom';
        $this->templateId = $templateId;
        $this->vars = $vars;
        $this->visible = $visible;
    }


    /**
     * Returns custom variables and values assigned to this element.
     * This items are used during rendering phase of custom element
     *
     */
    public function getVars()
    {
        return $this->vars;
    }
    
    
    /**
     * Returns custom variables and values assigned to this element.
     * This items are used during rendering phase of custom element
     *
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }
    
    
    /**
     * Returns if this element is visible and thus should generate a break
     */
    public function isVisible()
    {
        return $this->visible;
    }
    
    
    
    /**
     * Accepts a renderer
     *
     * @param HTML_QuickForm_Renderer    renderer object
     */
    public function accept(&$renderer, $required = false, $error = null)
    {
        $renderer->renderElement($this, $required, $error);
    }
}
