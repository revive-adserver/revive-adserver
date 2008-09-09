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

        $res = phpAds_dbQuery($query);

        while ($row = phpAds_dbFetchArray($res))
            $clientArray[$row['clientid']] = phpAds_buildName ($row['clientid'], $row['clientname']);

        return ($clientArray);
    }

}

?>
