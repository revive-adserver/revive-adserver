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

require_once MAX_PATH . '/lib/OA/Admin/UI/component/decorator/Decorator.php';

class OA_Admin_UI_AbstractDecorator implements OA_Admin_UI_Decorator
{
    /**
     * Either: append, prepend or wrap
     *
     * @var string
     */
    private $_renderMode;
    
    
    public function __construct($aParameters)
    {
        $this->_renderMode = $aParameters['mode'] ? $aParameters['mode'] : 'wrap';
    }
    
    /**
     *
     * @return text that should be prepended to element when rendered, empty string if none
     * or decorator mode is set to append mode only.
     * @see OA_Admin_UI_Decorator::prepend()
     */
    public function prepend()
    {
        return '';
    }
    
    
    /**
     *
     * @return text that should be appended to element when rendered, empty string if none
     * or decorator mode is set to prepend mode only.
     * @see OA_Admin_UI_Decorator::append()
     */
    public function append()
    {
        return '';
    }
    
    
    /**
     * Returns this decorator render mode. Either: append, prepend or wrap.
     *
     * @var string
     */
    public function getRenderMode()
    {
        return $this->_renderMode;
    }
    
    
    /**
     * Renders decorator's content -  prepends / appends / wraps content depending
     * on the getRenderMode value
     * @see OA_Admin_UI_Decorator::render()
     */
    public function render($content)
    {
        if ($this->_renderMode == 'wrap' || $this->_renderMode == 'prepend') {
            $content = $this->prepend() . $content;
        }
        if ($this->_renderMode == 'wrap' || $this->_renderMode == 'append') {
            $content .= $this->append();
        }
        return $content;
    }
}
