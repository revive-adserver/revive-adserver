<?php
/**
 * Table Definition for plugins_channel_delivery_rules
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Plugins_channel_delivery_rules extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'plugins_channel_delivery_rules';    // table name
    public $rule_id;                         // int(10)  not_null primary_key unsigned auto_increment
    public $modifier;                        // string(100)  not_null
    public $client;                          // string(100)  not_null
    public $rule;                            // blob(65535)  not_null blob

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Plugins_channel_delivery_rules',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
