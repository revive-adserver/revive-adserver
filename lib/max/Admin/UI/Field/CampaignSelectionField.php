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
        $aParams += $this->coreParams;
        $aPlacements = Admin_DA::getPlacements($aParams, true);
        $aPlacements = $this->multiSort($aPlacements, "name", true);

        echo "
        <select name='{$this->_name}' tabindex='".($this->_tabIndex++)."'>";
        foreach ($aPlacements as $aPlacement) {
            $selected = $aPlacement['placement_id'] == $this->getValue() ? " selected='selected'" : '';
            $name = MAX_getPlacementName($aPlacement);
            echo "
            <option value='$aPlacement[placement_id]'$selected>" . htmlspecialchars($name) . "</option>";
        }
        echo "
        </select>";
    }
}

?>