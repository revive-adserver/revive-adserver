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
 * Table Definition for log_maintenance_priority
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Log_maintenance_priority extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'log_maintenance_priority';        // table name
    public $log_maintenance_priority_id;     // INT(11) => openads_int => 129
    public $start_run;                       // DATETIME() => openads_datetime => 142
    public $end_run;                         // DATETIME() => openads_datetime => 142
    public $operation_interval;              // INT(11) => openads_int => 129
    public $duration;                        // INT(11) => openads_int => 129
    public $run_type;                        // TINYINT(3) => openads_tinyint => 129
    public $updated_to;                      // DATETIME() => openads_datetime => 14

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Log_maintenance_priority', $k, $v);
    }

    public $defaultValues = [
        'start_run' => '%NO_DATE_TIME%',
        'end_run' => '%NO_DATE_TIME%',
    ];

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
