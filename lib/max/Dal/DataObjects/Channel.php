<?php
/**
 * Table Definition for channel
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Channel extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'channel';                         // table name
    var $channelid;                       // int(9)  not_null primary_key auto_increment
    var $agencyid;                        // int(9)  not_null
    var $affiliateid;                     // int(9)  not_null
    var $name;                            // string(255)  
    var $description;                     // string(255)  
    var $compiledlimitation;              // blob(65535)  not_null blob
    var $acl_plugins;                     // blob(65535)  blob
    var $active;                          // int(1)  
    var $comments;                        // blob(65535)  blob
    var $updated;                         // datetime(19)  not_null binary
    var $acls_updated;                    // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Channel',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
