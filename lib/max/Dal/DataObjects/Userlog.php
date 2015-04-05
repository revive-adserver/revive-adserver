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
 * Table Definition for userlog
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Userlog extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'userlog';                         // table name
    public $userlogid;                       // MEDIUMINT(9) => openads_mediumint => 129 
    public $timestamp;                       // INT(11) => openads_int => 129 
    public $usertype;                        // TINYINT(4) => openads_tinyint => 129 
    public $userid;                          // MEDIUMINT(9) => openads_mediumint => 129 
    public $action;                          // MEDIUMINT(9) => openads_mediumint => 129 
    public $object;                          // MEDIUMINT(9) => openads_mediumint => 1 
    public $details;                         // MEDIUMTEXT() => openads_mediumtext => 34 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Userlog',$k,$v); }

    var $defaultValues = array(
                'timestamp' => 0,
                'usertype' => 0,
                'userid' => 0,
                'action' => 0,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>