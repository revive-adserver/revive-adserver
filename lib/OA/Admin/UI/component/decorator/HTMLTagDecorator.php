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
require_once MAX_PATH.'/lib/OA/Admin/UI/component/decorator/AbstractDecorator.php';

class OA_Admin_UI_HTMLTagDecorator 
    extends OA_Admin_UI_AbstractDecorator
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
            array();
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
            $prepend = "<".$this->_tagName;
            foreach ($this->_aAttributes as $name => $value) {
                $value = addslashes($value);
                $prepend .=' '.$name.'="'.$value.'"';
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
            $append = "</".$this->_tagName.">";
        }
        
        return $append;
    }    
}

?>
