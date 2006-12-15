<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/max/Admin/UI/Field.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/other/common.php';

class Admin_UI_SheetSelectionField extends Admin_UI_Field
{
    function display()
    {
        if (!count($this->_value))
        {
            echo "
            <input type='hidden' name='sheets[0]' value='1' checked='checked' /> <strong>Default</strong><br />";
        } else {
            foreach ($this->_value as $k => $v) {
                echo "
                <input type='checkbox' name='sheets[$k]' value='1' checked='checked' /> {$v}<br />";
            }
        }
    }
    
    function setValueFromArray($aFieldValues)
    {
        if (isset($aFieldValues['sheets']) && is_array($aFieldValues['sheets'])) {
            $this->_value = $aFieldValues['sheets'];
        } else {
            $this->_value = array();
        }
    }
}

?>