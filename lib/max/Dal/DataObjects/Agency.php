<?php
/**
 * Table Definition for agency
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Agency extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'agency';                          // table name
    var $agencyid;                        // int(9)  not_null primary_key auto_increment
    var $name;                            // string(255)  not_null
    var $contact;                         // string(255)  
    var $email;                           // string(64)  not_null
    var $username;                        // string(64)  
    var $password;                        // string(64)  
    var $permissions;                     // int(9)  
    var $language;                        // string(64)  
    var $logout_url;                      // string(255)  
    var $active;                          // int(1)  
    var $updated;                         // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Agency',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
