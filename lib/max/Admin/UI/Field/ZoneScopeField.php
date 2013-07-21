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

require_once MAX_PATH . '/lib/max/Admin/UI/Field/ZoneIdField.php';

class Admin_UI_ZoneScopeField extends Admin_UI_ZoneIdField
{
    function displayZonesAsOptionList()
    {
        echo "
        <option value='all'>-- {$GLOBALS['strAllAvailZones']} --</option>";
        parent::displayZonesAsOptionList();
    }
}

?>
