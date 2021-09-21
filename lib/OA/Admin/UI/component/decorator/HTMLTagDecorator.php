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

require_once MAX_PATH . '/lib/OA/Admin/UI/component/decorator/AbstractDecorator.php';

class OA_Admin_UI_HTMLTagDecorator extends OA_Admin_UI_AbstractDecorator
{
    /**
     * HTML tag name
     * @var string
     */
    private $_tagName;
    
    /**
     * Attributes array for HTML tag
     *
     * @var array
     */
    private $_aAttributes;
    
    
    
    public function __construct($aParameters)
    {
        parent::__construct($aParameters);
        
        $this->_tagName = $aParameters['tag'] ? $aParameters['tag'] : 'span';
        $this->_aAttributes = $aParameters['attributes'] ? $aParameters['attributes'] :
            [];
    }
    
    
    /**
     *
     * @return text that should be prepended to element when rendered, empty string if none
     * or decorator mode is set to append mode only.
     * @see OA_Admin_UI_Decorator::prepend()
     */
    public function prepend()
    {
        $prepend = '';
        
        $renderMode = $this->getRenderMode();
        //only prepend if in applicable mode
        if ($renderMode == 'wrap' || $renderMode == 'prepend') {
            $prepend = "<" . $this->_tagName;
            foreach ($this->_aAttributes as $name => $value) {
                $value = addslashes($value);
                $prepend .= ' ' . $name . '="' . $value . '"';
            }
            $prepend .= ">";
        }
        
        return $prepend;
    }
    
    
    /**
     *
     * @return text that should be appended to element when rendered, empty string if none
     * or decorator mode is set to prepend mode only.
     * @see OA_Admin_UI_Decorator::append()
     */
    public function append()
    {
        $append = '';
        
        $renderMode = $this->getRenderMode();
        //only append if in applicable mode
        if ($renderMode == 'wrap' || $renderMode == 'append') {
            $append = "</" . $this->_tagName . ">";
        }
        
        return $append;
    }
}
