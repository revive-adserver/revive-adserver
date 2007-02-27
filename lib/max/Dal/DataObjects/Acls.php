<?php
/**
 * Table Definition for acls
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Acls extends DB_DataObjectCommon 
{
    var $onDeleteCascade = true;
    
	###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'acls';                            // table name
    var $bannerid;                        // int(9)  not_null primary_key multiple_key
    var $logical;                         // string(3)  not_null
    var $type;                            // string(32)  not_null
    var $comparison;                      // string(2)  not_null
    var $data;                            // blob(65535)  not_null blob
    var $executionorder;                  // int(10)  not_null primary_key unsigned

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Acls',$k,$v); }

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
