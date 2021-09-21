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
 * Table Definition for password_recovery
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Password_recovery extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'password_recovery';               // table name
    public $user_type;                       // VARCHAR(64) => openads_varchar => 130
    public $user_id;                         // INT(10) => openads_int => 129
    public $recovery_id;                     // VARCHAR(64) => openads_varchar => 130
    public $updated;                         // DATETIME() => openads_datetime => 142

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Password_recovery', $k, $v);
    }

    public $defaultValues = [
        'user_type' => '',
        'recovery_id' => '',
        'updated' => '%DATE_TIME%',
    ];

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Table has no autoincrement/sequence so we override sequenceKey().
     *
     * @return array
     */
    public function sequenceKey()
    {
        return [false, false, false];
    }
}
