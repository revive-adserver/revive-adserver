<?php
/**
 * Table Definition for preference_publisher
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Preference_publisher extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'preference_publisher';            // table name
    var $publisher_id;                    // int(11)  not_null primary_key
    var $preference;                      // string(255)  not_null primary_key
    var $value;                           // blob(65535)  not_null blob

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Preference_publisher',$k,$v); }

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
