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

class Admin_UI_PublisherIdField extends Admin_UI_Field
{
    public function display()
    {
        if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            echo "<input type='hidden' name='{$this->_name}' value='" . OA_Permission::getEntityId() . "'>";
        } else {
            $aPublishers = Admin_UI_PublisherIdField::_getPublisherArray('name');

            echo "
        <select name='{$this->_name}' tabindex='" . ($this->_tabIndex++) . "'>";
            foreach ($aPublishers as $publisherId => $aPublisher) {
                $selected = $publisherId == $this->getValue() ? " selected='selected'" : '';
                echo "
            <option value='$publisherId'$selected>$aPublisher</option>";
            }
            echo "
        </select>";
        }
    }

    public function _getPublisherArray($orderBy = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $query =
                "SELECT affiliateid,name" .
                " FROM " . $conf['table']['prefix'] . $conf['table']['affiliates'];
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $query =
                "SELECT affiliateid,name" .
                " FROM " . $conf['table']['prefix'] . $conf['table']['affiliates'] .
                " WHERE agencyid=" . OA_Permission::getEntityId();
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $query =
                "SELECT affiliateid,name" .
                " FROM " . $conf['table']['prefix'] . $conf['table']['affiliates'] .
                " WHERE affiliateid=" . OA_Permission::getEntityId();
        }
        $orderBy ? $query .= " ORDER BY $orderBy ASC" : 0;

        $oDbh = OA_DB::singleton();
        $oRes = $oDbh->query($query);

        while ($row = $oRes->fetchRow()) {
            $affiliateArray[$row['affiliateid']] = phpAds_buildAffiliateName($row['affiliateid'], $row['name']);
            ;
        }

        return ($affiliateArray);
    }
}
