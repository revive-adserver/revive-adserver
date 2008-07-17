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

require_once MAX_PATH . '/lib/max/Admin/UI/Field.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/other/common.php';

class Admin_UI_CampaignSelectionField extends Admin_UI_Field
{
    function display()
    {
        $aParams = array();
        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $aParams['agency_id'] = OA_Permission::getEntityId();
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $aParams['advertiser_id'] = OA_Permission::getEntityId();
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $aParams['publisher_id'] = OA_Permission::getEntityId();
        }
      
        $aPlacements = Admin_DA::getPlacements($aParams, true);
        $aPlacements = $this->multiSort($aPlacements, "name", true);

        echo "
        <select name='{$this->_name}' tabindex='".($this->_tabIndex++)."'>";
        foreach ($aPlacements as $aPlacement) {
            $selected = $aPlacement['placement_id'] == $this->getValue() ? " selected='selected'" : '';
            $name = MAX_getPlacementName($aPlacement);
            echo "
            <option value='$aPlacement[placement_id]'$selected>$name</option>";
        }
        echo "
        </select>";
    }
}

?>