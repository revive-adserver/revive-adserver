<?php
/**
 * Table Definition for ext_market_campaign_pref
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Ext_market_campaign_pref extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_market_campaign_pref';       // table name
    public $campaignid;                      // MEDIUMINT(9) => openads_mediumint => 129 
    public $is_enabled;                      // SMALLINT(1) => openads_smallint => 17 
    public $floor_price;                     // DECIMAL(10,4) => openads_decimal => 1 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_market_campaign_pref',$k,$v); }

    var $defaultValues = array(
                'campaignid' => 0,
                'is_enabled' => 0,
                );

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