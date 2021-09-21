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
 * Table Definition for ad_category_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Ad_category_assoc extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ad_category_assoc';               // table name
    public $ad_category_assoc_id;            // INT(10) => openads_int => 129
    public $category_id;                     // INT(10) => openads_int => 129
    public $ad_id;                           // INT(10) => openads_int => 129

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Ad_category_assoc', $k, $v);
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
