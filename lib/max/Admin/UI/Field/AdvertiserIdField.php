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
 * NOTE
 *
 * THIS CLASS APPEARS TO BE REDUNDANT
 * phpAds_dbQuery DOES NOT EXIST ANYMORE?
 *
 */

class Admin_UI_AdvertiserIdField extends Admin_UI_Field
{
    function display()
    {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER))
        {
            echo "<input type='hidden' name='{$this->_name}' value='".OA_Permission::getEntityId()."'>";
        }
        else
        {
        $aAdvertisers = Admin_UI_AdvertiserIdField::_getAdvertiserArray('clientname');

        echo "
        <select name='{$this->_name}' tabindex='".($this->_tabIndex++)."'>";
        foreach ($aAdvertisers as $advertiserId => $aAdvertiser) {
            $selected = $advertiserId == $this->getValue() ? " selected='selected'" : '';
            echo "
            <option value='$advertiserId'$selected>$aAdvertiser</option>";
        }
        echo "
        </select>";
        }
    }

    function _getAdvertiserArray($orderBy = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN))
        {
            $query =
                "SELECT clientid,clientname".
                " FROM ".$conf['table']['prefix'].$conf['table']['clients'];
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $query =
                "SELECT clientid,clientname".
                " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
                " WHERE agencyid=".OA_Permission::getEntityId();
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $query =
                "SELECT clientid,clientname".
                " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
                " WHERE clientid=".OA_Permission::getEntityId();
        }
        $orderBy ? $query .= " ORDER BY $orderBy ASC" : 0;

        $oDbh = OA_DB::singleton();
        $oRes = $oDbh->query($query);

        while ($row = $oRes->fetchRow()) {
            $clientArray[$row['clientid']] = phpAds_buildName ($row['clientid'], $row['clientname']);
        }

        return ($clientArray);
    }

}

?>
