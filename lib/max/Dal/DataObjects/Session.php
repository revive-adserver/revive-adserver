<?php
/**
 * Table Definition for session
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Session extends DB_DataObjectCommon 
{
    var $dalModelName = 'Session';
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'session';                         // table name
    public $sessionid;                       // string(32)  not_null primary_key
    public $sessiondata;                     // blob(65535)  not_null blob
    public $lastused;                        // datetime(19)  binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Session',$k,$v); }

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
     * Overrides _refreshUpdated() because the updated field is called 'lastused'.
     * This method is called on insert() and update().
     *
     */
    function _refreshUpdated()
    {
        $this->lastused = date('Y-m-d H:i:s');
    }
}
