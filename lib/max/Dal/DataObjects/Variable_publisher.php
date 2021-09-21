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
 * Table Definition for variable_publisher
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Variable_publisher extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'variable_publisher';              // table name
    public $variable_id;                     // INT(11) => openads_int => 129
    public $publisher_id;                    // INT(11) => openads_int => 129
    public $visible;                         // TINYINT(1) => openads_tinyint => 145

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Variable_publisher', $k, $v);
    }

    public $defaultValues = [
        'visible' => 0,
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
