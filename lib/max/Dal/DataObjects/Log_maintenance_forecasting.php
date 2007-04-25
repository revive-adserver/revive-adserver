<?php
/**
 * Table Definition for log_maintenance_forecasting
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Log_maintenance_forecasting extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'log_maintenance_forecasting';     // table name
    var $log_maintenance_forecasting_id;    // int(11)  not_null primary_key auto_increment
    var $start_run;                       // datetime(19)  not_null binary
    var $end_run;                         // datetime(19)  not_null binary
    var $operation_interval;              // int(11)  not_null
    var $duration;                        // int(11)  not_null
    var $updated_to;                      // datetime(19)  binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Log_maintenance_forecasting',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
