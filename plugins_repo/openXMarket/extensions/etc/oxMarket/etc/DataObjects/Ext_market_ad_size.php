<?php
/**
 * Table Definition for ext_market_ad_size
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Ext_market_ad_size extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_market_ad_size';             // table name
    public $ad_size_id;                      // MEDIUMINT(9) => openads_mediumint => 129 
    public $length;                          // MEDIUMINT(9) => openads_mediumint => 129 
    public $width;                           // MEDIUMINT(9) => openads_mediumint => 129 
    public $description;                     // VARCHAR(64) => openads_varchar => 130 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_market_ad_size',$k,$v); }

    var $defaultValues = array(
                'description' => '',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>