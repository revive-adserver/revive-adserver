<?php
/**
 * Table Definition for ext_thorium_website_pref
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Ext_thorium_website_pref extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_thorium_website_pref';        // table name
    public $affiliateid;                     // MEDIUMINT(9) => openads_mediumint => 129 
    public $website_id;                      // CHAR(36) => openads_char => 130 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_thorium_website_pref',$k,$v); }

    var $defaultValues = array(
                'affiliateid' => 0,
                'website_id' => '',
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