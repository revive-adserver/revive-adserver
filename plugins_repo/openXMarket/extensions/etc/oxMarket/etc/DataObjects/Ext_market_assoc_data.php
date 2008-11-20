<?php
/**
 * Table Definition for ext_market_assoc_data
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Ext_market_assoc_data extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_market_assoc_data';           // table name
    public $account_id;                      // MEDIUMINT(9) => openads_mediumint => 129 
    public $publisher_account_id;                      // VARCHAR(36) => openads_varchar => 130 
    public $status;                          // TINYINT(4) => openads_tinyint => 129 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_market_assoc_data',$k,$v); }

    var $defaultValues = array(
                'publisher_account_id' => '',
                'status' => 0,
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