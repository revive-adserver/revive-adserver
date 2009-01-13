<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
$Id$
*/
require_once MAX_PATH.'/lib/OA/Admin/UI/component/decorator/Decorator.php';

class OA_Admin_UI_AbstractDecorator
    implements OA_Admin_UI_Decorator 
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
        $append = '';
        
        return $append;
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
            $content = $this->prepend().$content;
        }
        if ($this->_renderMode == 'wrap' || $this->_renderMode == 'append') {
            $content .= $this->append();
        }
        return $content;
    }    
}

?>
