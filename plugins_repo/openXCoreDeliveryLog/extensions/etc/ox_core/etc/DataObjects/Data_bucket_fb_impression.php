<?php
/**
 * Table Definition for data_bucket_fb_impression
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Data_bucket_fb_impression extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_bucket_fb_impression';       // table name
    public $interval_start;                  // DATETIME() => openads_datetime => 142
    public $primary_creative_id;             // BIGINT(20) => openads_bigint => 129
    public $creative_id;                     // BIGINT(20) => openads_bigint => 129
    public $zone_id;                         // BIGINT(20) => openads_bigint => 129
    public $count;                           // INTEGER(11) => openads_int => 1

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_bucket_fb_impression',$k,$v); }

    var $defaultValues = array(
                'interval_start' => '',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>