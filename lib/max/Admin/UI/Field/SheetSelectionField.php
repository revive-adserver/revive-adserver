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

require_once MAX_PATH . '/lib/max/Admin/UI/Field.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/other/common.php';

class Admin_UI_SheetSelectionField extends Admin_UI_Field
{
    public function display()
    {
        if (!count($this->_value)) {
            echo "
            <input type='hidden' id='sheets_0' name='sheets[0]' value='1' checked='checked' /><label for='sheets_0'><strong>Default</strong></label><br />";
        } else {
            foreach ($this->_value as $k => $v) {
                echo "
                <input type='checkbox' id='sheets_$k' name='sheets[$k]' value='1' checked='checked' /><label for='sheets_$k'>{$v}</label><br />";
            }
        }
    }
    
    public function setValueFromArray($aFieldValues)
    {
        if (isset($aFieldValues['sheets']) && is_array($aFieldValues['sheets'])) {
            $this->_value = $aFieldValues['sheets'];
        } else {
            $this->_value = [];
        }
    }
}
