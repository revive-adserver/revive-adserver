<?php
/**
 * Table Definition for ext_thorium_publisher_reporting
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Ext_thorium_publisher_reporting extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_thorium_publisher_reporting';    // table name
    public $day;                             // DATETIME() => openads_datetime => 14 
    public $p_account_id;                    // MEDIUMINT(9) => openads_mediumint => 129 
    public $p_website_id;                    // MEDIUMINT(9) => openads_mediumint => 129 
    public $impressions;                     // MEDIUMINT(9) => openads_mediumint => 129 
    public $revenue;                         // DECIMAL(10,4) => openads_decimal => 1 
    public $ad_size_id;                      // MEDIUMINT(9) => openads_mediumint => 129 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_thorium_publisher_reporting',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>