<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

/**
 * A view field for a dropdown (HTML SELECT).
 *
 * @package    Max
 * @author     Scott Switzer <scott@switzer.org>
 */
require_once MAX_PATH . '/lib/max/Admin/UI/Field.php';

class Admin_UI_DropdownField extends Admin_UI_Field
{
    /* @var array */
    var $_fieldSelectionNames;

    /**
     * PHP4-style constructor
     *
     * @param array $aFieldSelectionNames A list of the predefined 'friendly' selections.
     * @param string $fieldSelectionDefault The default selection.
     */
    function Admin_UI_DropdownField($aFieldSelectionNames = array(), $fieldSelectionDefault = '')
    {
        $this->_fieldSelectionNames = $aFieldSelectionNames;
        $this->_value = new OA_Admin_DaySpan($fieldSelectionDefault);
    }

    /**
     * A method to set the value of the field using the input querystring fields passed in from the HTML.
     *
     * @param array $aQuerystring The querystring of this field.
     */
    function setValueFromArray($aFieldValues)
    {
        $fieldSelectionName = $aFieldValues[$this->_name . '_preset'];
        if (!empty($fieldSelectionName)) {
            $this->setValue($fieldSelectionName);
        }
    }

    /**
     * A method that echos the HTML for this field.
     */
    function display()
    {
        $name = $this->_name;
        $value = is_null($this->_value) && !is_null($this->_defaultValue) ? $this->_defaultValue : $this->_value;
        $fieldSelectionValue = $this->_value;
        $aFieldSelectionNames = $this->_fieldSelectionNames;

        echo "
        <select name='{$name}_preset' id='{$name}_preset' tabindex='" . $this->_tabIndex++ . "'>";

        foreach ($aFieldSelectionNames as $v => $n) {
            $selected = $v == $fieldSelectionValue ? " selected='selected'" : '';
            echo "
            <option value='{$v}'{$selected}>{$n}</option>";
        }
        echo "
        </select>";
    }
}

?>
