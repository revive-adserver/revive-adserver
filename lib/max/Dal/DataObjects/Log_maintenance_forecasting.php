<?php
/**
 * Table Definition for log_maintenance_forecasting
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Log_maintenance_forecasting extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'log_maintenance_forecasting';     // table name
    public $log_maintenance_forecasting_id;    // int(11)  not_null primary_key auto_increment
    public $start_run;                       // datetime(19)  not_null binary
    public $end_run;                         // datetime(19)  not_null binary
    public $operation_interval;              // int(11)  not_null
    public $duration;                        // int(11)  not_null
    public $updated_to;                      // datetime(19)  binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Log_maintenance_forecasting',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
