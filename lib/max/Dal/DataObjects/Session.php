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
 * Table Definition for session
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Session extends DB_DataObjectCommon
{
    public $dalModelName = 'Session';
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'session';                         // table name
    public $sessionid;                       // VARCHAR(32) => openads_varchar => 130
    public $sessiondata;                     // TEXT() => openads_text => 162
    public $lastused;                        // DATETIME() => openads_datetime => 14
    public $user_id;                         // MEDIUMINT(9) => openads_mediumint => 1

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Session', $k, $v);
    }

    public $defaultValues = [
        'sessionid' => '',
        'sessiondata' => '',
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


    /**
     * Overrides _refreshUpdated() because the updated field is called 'lastused'.
     * This method is called on insert() and update().
     *
     */
    public function _refreshUpdated()
    {
        $this->lastused = OA::getNowUTC();
    }
}
