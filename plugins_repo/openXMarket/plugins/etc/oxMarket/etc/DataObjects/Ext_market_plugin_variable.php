<?php
/**
 * Table Definition for ext_market_plugin_variable
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Ext_market_plugin_variable extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_market_plugin_variable';      // table name
    public $user_id;                         // MEDIUMINT(9) => openads_mediumint => 129
    public $name;                            // VARCHAR(255) => openads_varchar => 130
    public $value;                           // VARCHAR(255) => openads_varchar => 130

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_market_plugin_variable',$k,$v); }

    var $defaultValues = array(
                'name' => '',
                'value' => '',
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
}
?>