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
 * Table Definition for data_intermediate_ad_variable_value
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_intermediate_ad_variable_value extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_intermediate_ad_variable_value';    // table name
    public $data_intermediate_ad_variable_value_id;    // BIGINT(20) => openads_bigint => 129 
    public $data_intermediate_ad_connection_id;    // BIGINT(20) => openads_bigint => 129 
    public $tracker_variable_id;             // INT(11) => openads_int => 129 
    public $value;                           // VARCHAR(50) => openads_varchar => 2 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Data_intermediate_ad_variable_value',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>