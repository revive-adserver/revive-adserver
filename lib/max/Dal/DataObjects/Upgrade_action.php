<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * Table Definition for upgrade_action
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Upgrade_action extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'upgrade_action';                  // table name
    var $upgrade_action_id;               // int(10)  not_null primary_key unsigned auto_increment
    var $upgrade_name;                    // string(128)  
    var $version_to;                      // string(64)  not_null
    var $version_from;                    // string(64)  
    var $action;                          // int(2)  not_null
    var $description;                     // string(255)  
    var $logfile;                         // string(128)  
    var $confbackup;                      // string(128)  
    var $updated;                         // datetime(19)  multiple_key binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Upgrade_action',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
