<?php
/**
 * Table Definition for targetstats
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Targetstats extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'targetstats';                     // table name
    public $day;                             // date(10)  not_null binary
    public $campaignid;                      // int(9)  not_null
    public $target;                          // int(11)  not_null
    public $views;                           // int(11)  not_null
    public $modified;                        // int(4)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Targetstats',$k,$v); }

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
