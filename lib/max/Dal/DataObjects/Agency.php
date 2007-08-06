<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

/**
 * Table Definition for agency
 */
require_once 'AbstractUser.php';

class DataObjects_Agency extends DataObjects_AbstractUser
{
    var $onDeleteCascade = true;
    var $refreshUpdatedFieldIfExists = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'agency';                          // table name
    var $agencyid;                        // int(9)  not_null primary_key auto_increment
    var $name;                            // string(255)  not_null
    var $contact;                         // string(255)  
    var $email;                           // string(64)  not_null
    var $username;                        // string(64)  
    var $password;                        // string(64)  
    var $permissions;                     // int(9)  
    var $language;                        // string(64)  
    var $logout_url;                      // string(255)  
    var $active;                          // int(1)  
    var $updated;                         // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Agency',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Handle all necessary operations when new agency is created
     *
     * @see DB_DataObject::insert()
     */
    function insert()
    {
        $agencyid = parent::insert();
        if (!$agencyid) {
            return $agencyid;
        }

        // set agency preferences
        $doPreference = $this->factory('preference');
        if ($doPreference->get(0)) {
            // overwrite default ones
            $doPreference->agencyid = $agencyid;
            $doPreference = $this->_updatePreferences($doPreference);
            $doPreference->insert();
        }

        return $agencyid;
    }

    /**
     * Handle all necessary operations when new agency is updated
     *
     * @see DB_DataObject::update()
     */
    function update($dataObject = false)
    {
        $ret = parent::update($dataObject);
        if (!$ret) {
            return $ret;
        }
        $doPreference = $this->factory('preference');
        $doPreference->get($this->agencyid);
        $doPreference = $this->_updatePreferences($doPreference);
        $doPreference->update();

        return $ret;
    }

    /**
     * Overwrite preference settings with new
     * values taken from agency
     *
     * @param object $doPreference
     * @return object
     */
    function _updatePreferences($doPreference)
    {
        $doPreference->language = $this->language;
        $doPreference->name     = $this->name;
        $doPreference->admin_fullname = $this->contact;
        $doPreference->admin_email = $this->email;

        return $doPreference;
    }


    /**
     * Returns phpAds_Agency constant value.
     *
     * @return integer
     */
    function getUserType()
    {
        return phpAds_Agency;
    }


    /**
     * Returns agencyid.
     *
     * @return string
     */
    function getUserId()
    {
        return $this->agencyid;
    }
}

?>