<?php
/**
 * Table Definition for ext_market_stats
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Ext_market_stats extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_market_stats';                // table name
    public $date_time;                       // DATETIME() => openads_datetime => 142 
    public $market_advertiser_id;            // CHAR(36) => openads_char => 2 
    public $website_id;                      // MEDIUMINT(9) => openads_mediumint => 129 
    public $ad_width;                        // SMALLINT(6) => openads_smallint => 129 
    public $ad_height;                       // SMALLINT(6) => openads_smallint => 129 
    public $zone_id;                         // MEDIUMINT(9) => openads_mediumint => 1 
    public $ad_id;                           // MEDIUMINT(9) => openads_mediumint => 1 
    public $impressions;                     // INT(11) => openads_int => 129 
    public $clicks;                          // INT(11) => openads_int => 1 
    public $requests;                        // INT(11) => openads_int => 1 
    public $revenue;                         // DECIMAL(17,5) => openads_decimal => 129 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_market_stats',$k,$v); }

    var $defaultValues = array();

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	/**
     * Table has no autoincrement/sequence so we override sequenceKey().
     *
     * @return array
     */
    function sequenceKey() {
        return array(false, false, false);
    }

    function _auditEnabled()
    {
        return false;
    }
}
?>