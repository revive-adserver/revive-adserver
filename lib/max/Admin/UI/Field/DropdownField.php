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
 * A view field for a dropdown (HTML SELECT).
 *
 * @package    Max
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
    function __construct($aFieldSelectionNames = array(), $fieldSelectionDefault = '')
    {
        parent::__construct();
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
