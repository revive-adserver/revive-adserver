<?php
/**
 * Table Definition for ext_market_ad_size
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Ext_market_setting extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_market_setting';             // table name
    public $market_setting_id;               // MEDIUMINT(9) => openads_mediumint => 129
    public $market_setting_type_id;          // MEDIUMINT(9) => openads_mediumint => 129
    public $owner_type_id;                   // MEDIUMINT(9) => openads_mediumint => 129
    public $owner_id;                        // MEDIUMINT(9) => openads_mediumint => 129

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_market_setting',$k,$v); }

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