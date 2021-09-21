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

/**
 * Table Definition for upgrade_action
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Upgrade_action extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'upgrade_action';                  // table name
    public $upgrade_action_id;               // int(10)  not_null primary_key unsigned auto_increment
    public $upgrade_name;                    // string(128)
    public $version_to;                      // string(64)  not_null
    public $version_from;                    // string(64)
    public $action;                          // int(2)  not_null
    public $description;                     // string(255)
    public $logfile;                         // string(128)
    public $confbackup;                      // string(128)
    public $updated;                         // datetime(19)  multiple_key binary

    /* ZE2 compatibility trick*/
    public function __clone()
    {
        return $this;
    }

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Upgrade_action', $k, $v);
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
