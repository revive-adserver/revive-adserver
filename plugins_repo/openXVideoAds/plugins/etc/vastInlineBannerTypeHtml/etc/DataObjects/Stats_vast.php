<?php
/**
 * Table Definition for Stats_vast
 */
require_once MAX_PATH . '/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Stats_vast extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'stats_vast';                      // table name
    public $interval_start;                  // DATETIME() => openads_datetime => 142
    public $creative_id;                     // MEDIUMINT(20) => openads_mediumint => 129
    public $zone_id;                         // MEDIUMINT(20) => openads_mediumint => 129
    public $vast_event_id;                   // MEDIUMINT(20) => openads_mediumint => 129
    public $count;                           // INT(11) => openads_int => 129

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Stats_vast', $k, $v);
    }

    public $defaultValues = [
                'interval_start' => '%NO_DATE_TIME%',
                'count' => 0,
                ];

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
