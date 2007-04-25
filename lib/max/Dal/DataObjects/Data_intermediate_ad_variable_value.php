<?php
/**
 * Table Definition for data_intermediate_ad_variable_value
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_intermediate_ad_variable_value extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_intermediate_ad_variable_value';    // table name
    public $data_intermediate_ad_variable_value_id;    // int(20)  not_null primary_key auto_increment
    public $data_intermediate_ad_connection_id;    // int(20)  not_null multiple_key
    public $tracker_variable_id;             // int(11)  not_null multiple_key
    public $value;                           // string(50)  multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_intermediate_ad_variable_value',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
