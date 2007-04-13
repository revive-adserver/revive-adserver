<?php
/**
 * Table Definition for tracker_append
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Tracker_append extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tracker_append';                  // table name
    var $tracker_append_id;               // int(11)  not_null primary_key auto_increment
    var $tracker_id;                      // int(9)  not_null multiple_key
    var $rank;                            // int(11)  not_null
    var $tagcode;                         // blob(65535)  not_null blob
    var $paused;                          // string(1)  not_null enum
    var $autotrack;                       // string(1)  not_null enum

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tracker_append',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
