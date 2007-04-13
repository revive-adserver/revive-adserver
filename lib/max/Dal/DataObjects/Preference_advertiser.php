<?php
/**
 * Table Definition for preference_advertiser
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Preference_advertiser extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'preference_advertiser';           // table name
    public $advertiser_id;                   // int(11)  not_null primary_key
    public $preference;                      // string(255)  not_null primary_key
    public $value;                           // blob(65535)  not_null blob

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Preference_advertiser',$k,$v); }

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
