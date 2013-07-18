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

/**
 * A plain, single-line text-entry field used as a parameter for reports.
 */
class Admin_UI_TextField extends Admin_UI_Field
{
    /* @var string */
    var $_size;

    function display()
    {
        $sizeParameter = is_numeric($this->_size) ? " size='{$this->_size}'" : '';
        echo "
        <input type='text' name='{$this->_name}'{$sizeParameter} value='{$this->_value}' tabindex='".($this->_tabIndex++)."'>";
    }
}

?>