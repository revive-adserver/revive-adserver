<?php
/**
 * Table Definition for userlog
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Userlog extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'userlog';                         // table name
    var $userlogid;                       // int(9)  not_null primary_key auto_increment
    var $timestamp;                       // int(11)  not_null
    var $usertype;                        // int(4)  not_null
    var $userid;                          // int(9)  not_null
    var $action;                          // int(9)  not_null
    var $object;                          // int(9)  
    var $details;                         // blob(16777215)  blob

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Userlog',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
