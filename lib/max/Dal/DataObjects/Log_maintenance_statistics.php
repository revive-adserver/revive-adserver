<?php
/**
 * Table Definition for log_maintenance_statistics
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Log_maintenance_statistics extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'log_maintenance_statistics';      // table name
    var $log_maintenance_statistics_id;    // int(11)  not_null primary_key auto_increment
    var $start_run;                       // datetime(19)  not_null binary
    var $end_run;                         // datetime(19)  not_null binary
    var $duration;                        // int(11)  not_null
    var $adserver_run_type;               // int(2)  
    var $search_run_type;                 // int(2)  
    var $tracker_run_type;                // int(2)  
    var $updated_to;                      // datetime(19)  binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Log_maintenance_statistics',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
