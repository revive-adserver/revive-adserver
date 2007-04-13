<?php
/**
 * Table Definition for plugins_channel_delivery_domains
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Plugins_channel_delivery_domains extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'plugins_channel_delivery_domains';    // table name
    var $domain_id;                       // int(10)  not_null primary_key unsigned auto_increment
    var $domain_name;                     // string(255)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Plugins_channel_delivery_domains',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
