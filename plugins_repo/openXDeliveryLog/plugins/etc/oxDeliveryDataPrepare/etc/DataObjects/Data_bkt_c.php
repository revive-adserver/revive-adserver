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

require_once MAX_PATH . '/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

/**
 * DB_DataObject for data_bkt_c
 *
 * @package    Plugin
 * @subpackage openxDeliveryLog
 */
class DataObjects_Data_bkt_c extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_bkt_c';               // table name
    public $interval_start;                  // DATETIME() => openads_datetime => 142
    public $creative_id;                     // MEDIUMINT(9) => openads_mediumint => 129
    public $zone_id;                         // MEDIUMINT(9) => openads_mediumint => 129
    public $count;                           // INTEGER(11) => openads_int => 1

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Data_bkt_c', $k, $v);
    }

    public $defaultValues = [
        'interval_start' => '',
    ];

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
