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

require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

/**
 * DB_DataObject for data_bkt_r
 *
 * @package    Plugin
 * @subpackage openxDeliveryLog
 */
class DataObjects_Data_bkt_a extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_bkt_a';             // table name
    public $server_conv_id;                  // BIGINT(20) => openads_mediumint => 129
    public $server_ip;                       // VARCHAR(16) => openads_varchar => 130
    public $tracker_id;                      // MEDIUMINT(9) => openads_mediumint => 129
    public $date_time;                       // DATETIME() => openads_datetime => 142
    public $action_date_time;                // DATETIME() => openads_datetime => 142
    public $creative_id;                     // MEDIUMINT(9) => openads_mediumint => 129
    public $zone_id;                         // MEDIUMINT(9) => openads_mediumint => 129
    public $ip_address;                      // VARCHAR(16) => openads_varchar => 130
    public $action;                          // INT(11) => openads_int => 1
    public $window;                          // INT(11) => openads_int => 1
    public $status;                          // INT(11) => openads_int => 1

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_bkt_a',$k,$v); }

    var $defaultValues = array(
                'server_ip' => '',
                'ip_address' => '',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>