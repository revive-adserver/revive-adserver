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

require_once MAX_PATH . '/lib/max/Dal/Reporting.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field.php';

class Admin_UI_PublisherIdField extends Admin_UI_Field
{
    function display()
    {
        global $session, $list_filters;
    
        if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER))
        {
            echo "<input type='hidden' name='{$this->_name}' value='".OA_Permission::getEntityId()."'>";
        }
        else
        {
        $dal = new MAX_Dal_Reporting();
        $aPublishers = $dal->phpAds_getPublisherArray('name');
        
        // if no default publisher set, set it to the first id in the array
        // - this is to ensure that we'll know which publisher to filter any other
        // dropdowns by even if no publisher is selected yet
        if (!isset($session['prefs']['GLOBALS']['report_publisher'])) {
            $list_filters['publisher'] = key($aPublishers);
        } else {
            $list_filters['publisher'] = $session['prefs']['GLOBALS']['report_publisher'];

        }

        echo "<input type='hidden' name='submit_type' value=''>";
        echo "<input type='hidden' name='changed_field' value=''>";
        echo "<input type='hidden' name='refresh_page' value='".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']."'>";
        echo "
        <select name='{$this->_name}' tabindex='".($this->_tabIndex++)."' onchange=\"form.submit_type.value='change';form.changed_field.value='publisher';submit();\"   >";
        foreach ($aPublishers as $publisherId => $aPublisher) {
            $selected = $publisherId == $this->getValue() ? " selected='selected'" : '';
            echo "
            <option value='$publisherId'$selected>$aPublisher</option>";
        }
        echo "
        </select>";
        }
    }
}

?>
