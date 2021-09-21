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
 * Table Definition for tracker_append
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Tracker_append extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tracker_append';                  // table name
    public $tracker_append_id;               // INT(11) => openads_int => 129
    public $tracker_id;                      // MEDIUMINT(9) => openads_mediumint => 129
    public $rank;                            // INT(11) => openads_int => 129
    public $tagcode;                         // TEXT() => openads_text => 162
    public $paused;                          // ENUM('t','f') => openads_enum => 130
    public $autotrack;                       // ENUM('t','f') => openads_enum => 130

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Tracker_append', $k, $v);
    }

    public $defaultValues = [
        'tracker_id' => 0,
        'rank' => 0,
        'tagcode' => '',
        'paused' => 'f',
        'autotrack' => 'f',
    ];

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Override insert as "rank" is a keyword on MySQL 8 and identifiers need extra quoting.
     */
    public function insert()
    {
        global $_DB_DATAOBJECT;

        $quoteIdentifiers = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);

        $_DB_DATAOBJECT['CONFIG']['quote_identifiers'] = true;

        $return = parent::insert();

        $_DB_DATAOBJECT['CONFIG']['quote_identifiers'] = $quoteIdentifiers;

        return $return;
    }

    /**
     * Override insert as "rank" is a keyword on MySQL 8 and identifiers need extra quoting.
     */
    public function update($dataObject = false)
    {
        global $_DB_DATAOBJECT;

        $quoteIdentifiers = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);

        $_DB_DATAOBJECT['CONFIG']['quote_identifiers'] = true;

        $return = parent::update($dataObject);

        $_DB_DATAOBJECT['CONFIG']['quote_identifiers'] = $quoteIdentifiers;

        return $return;
    }
}
