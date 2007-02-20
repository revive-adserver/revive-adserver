<?php
/**
 * Table Definition for targetstats
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Targetstats extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'targetstats';                     // table name
    var $day;                             // date(10)  not_null binary
    var $campaignid;                      // int(9)  not_null
    var $target;                          // int(11)  not_null
    var $views;                           // int(11)  not_null
    var $modified;                        // int(4)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Targetstats',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
