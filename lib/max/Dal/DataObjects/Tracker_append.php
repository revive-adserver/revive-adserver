<?php
/**
 * Table Definition for tracker_append
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Tracker_append extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tracker_append';                  // table name
    public $tracker_append_id;               // int(11)  not_null primary_key auto_increment
    public $tracker_id;                      // int(9)  not_null multiple_key
    public $rank;                            // int(11)  not_null
    public $tagcode;                         // blob(65535)  not_null blob
    public $paused;                          // string(1)  not_null enum
    public $autotrack;                       // string(1)  not_null enum

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tracker_append',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
