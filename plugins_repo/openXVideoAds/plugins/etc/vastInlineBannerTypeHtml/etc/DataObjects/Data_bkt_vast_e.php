<?php
/**
 * Table Definition for data_bkt_vast_e
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Data_bkt_vast_e extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_bkt_vast_e';                 // table name
    public $interval_start;                  // DATETIME() => openads_datetime => 142
    public $creative_id;                     // MEDIUMINT(20) => openads_mediumint => 129
    public $zone_id;                         // MEDIUMINT(20) => openads_mediumint => 129
    public $vast_event_id;                   // MEDIUMINT(20) => openads_mediumint => 129
    public $count;                           // INT(11) => openads_int => 129

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Data_bkt_vast_e',$k,$v); }

    var $defaultValues = array(
                'interval_start' => '%NO_DATE_TIME%',
                'count' => 0,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>