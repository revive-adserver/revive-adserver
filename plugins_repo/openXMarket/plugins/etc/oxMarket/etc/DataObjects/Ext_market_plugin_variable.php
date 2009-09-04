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
    
    
    /**
     * This is extended get() method to find variable by user_id and name (pkey) 
     *
     * @param int $user_id
     * @param string $name
     * @return int Number of rows (1 for success)
     */
    function findByUserIdAndName($user_id, $name)
    {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->find();
        if ($this->fetch()) {
            return 1;
        }
        return 0;
    }
    
    
    /**
     * Get value of given variable for given user_id
     *
     * @param int $user_id
     * @param string $name
     * @return string can return null if preference doesn't exit
     */
    function findAndGetValue($user_id, $name)
    {
        $oPlugVar = OA_Dal::factoryDO('ext_market_plugin_variable');
        if ($oPlugVar->findByUserIdAndName($user_id, $name)>0) {
            return $oPlugVar->value;
        }
        return null;
    }
    
    
    /**
     * Set value for user_id account_id, variable pair
     *
     * @param int $user_id
     * @param string $name
     * @param string $value
     * @return bool true on success
     */
    function insertOrUpdateValue($user_id, $name, $value)
    {
        $oPlugVar = OA_Dal::factoryDO('ext_market_plugin_variable');
        $count = $oPlugVar->findByUserIdAndName($user_id, $name);
        $oPlugVar->value = (string)$value;
        if ($count>0) {
            if ($oPlugVar->update()=== false){
                return false;
            }
        } else {
            $oPlugVar->insert();
        }
        return true;
    }
}
?>