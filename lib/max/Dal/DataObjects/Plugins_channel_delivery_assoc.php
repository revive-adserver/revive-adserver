<?php
/**
 * Table Definition for plugins_channel_delivery_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Plugins_channel_delivery_assoc extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'plugins_channel_delivery_assoc';    // table name
    var $rule_id;                         // int(10)  not_null primary_key multiple_key unsigned
    var $domain_id;                       // int(10)  not_null primary_key multiple_key unsigned
    var $rule_order;                      // int(4)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Plugins_channel_delivery_assoc',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
