<?php
/**
 * Table Definition for data_bkt_r
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Data_bkt_a_var extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_bkt_a_var';             // table name
    public $server_conv_id;                  // MEDIUMINT(9) => openads_mediumint => 129
    public $server_ip;                       // VARCHAR(16) => openads_varchar => 130
    public $tracker_variable_id;             // MEDIUMINT(9) => openads_mediumint => 129
    public $value;                           // TEXT() => openads_text => 34

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_bkt_a_var',$k,$v); }

    var $defaultValues = array(
                'server_ip' => '',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>