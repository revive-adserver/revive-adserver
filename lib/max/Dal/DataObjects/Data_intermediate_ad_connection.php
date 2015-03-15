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
 * Table Definition for data_intermediate_ad_connection
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_intermediate_ad_connection extends DB_DataObjectCommon
{
    var $refreshUpdatedFieldIfExists = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_intermediate_ad_connection';    // table name
    public $data_intermediate_ad_connection_id;    // BIGINT(20) => openads_bigint => 129 
    public $server_raw_ip;                   // VARCHAR(16) => openads_varchar => 130 
    public $server_raw_tracker_impression_id;    // BIGINT(20) => openads_bigint => 129 
    public $viewer_id;                       // VARCHAR(32) => openads_varchar => 2 
    public $viewer_session_id;               // VARCHAR(32) => openads_varchar => 2 
    public $tracker_date_time;               // DATETIME() => openads_datetime => 142 
    public $connection_date_time;            // DATETIME() => openads_datetime => 14 
    public $tracker_id;                      // INT(10) => openads_int => 129 
    public $ad_id;                           // INT(10) => openads_int => 129 
    public $creative_id;                     // INT(10) => openads_int => 129 
    public $zone_id;                         // INT(10) => openads_int => 129 
    public $tracker_channel;                 // VARCHAR(255) => openads_varchar => 2 
    public $connection_channel;              // VARCHAR(255) => openads_varchar => 2 
    public $tracker_channel_ids;             // VARCHAR(64) => openads_varchar => 2 
    public $connection_channel_ids;          // VARCHAR(64) => openads_varchar => 2 
    public $tracker_language;                // VARCHAR(13) => openads_varchar => 2 
    public $connection_language;             // VARCHAR(13) => openads_varchar => 2 
    public $tracker_ip_address;              // VARCHAR(16) => openads_varchar => 2 
    public $connection_ip_address;           // VARCHAR(16) => openads_varchar => 2 
    public $tracker_host_name;               // VARCHAR(255) => openads_varchar => 2 
    public $connection_host_name;            // VARCHAR(255) => openads_varchar => 2 
    public $tracker_country;                 // CHAR(2) => openads_char => 2 
    public $connection_country;              // CHAR(2) => openads_char => 2 
    public $tracker_https;                   // INT(10) => openads_int => 1 
    public $connection_https;                // INT(10) => openads_int => 1 
    public $tracker_domain;                  // VARCHAR(255) => openads_varchar => 2 
    public $connection_domain;               // VARCHAR(255) => openads_varchar => 2 
    public $tracker_page;                    // VARCHAR(255) => openads_varchar => 2 
    public $connection_page;                 // VARCHAR(255) => openads_varchar => 2 
    public $tracker_query;                   // VARCHAR(255) => openads_varchar => 2 
    public $connection_query;                // VARCHAR(255) => openads_varchar => 2 
    public $tracker_referer;                 // VARCHAR(255) => openads_varchar => 2 
    public $connection_referer;              // VARCHAR(255) => openads_varchar => 2 
    public $tracker_search_term;             // VARCHAR(255) => openads_varchar => 2 
    public $connection_search_term;          // VARCHAR(255) => openads_varchar => 2 
    public $tracker_user_agent;              // VARCHAR(255) => openads_varchar => 2 
    public $connection_user_agent;           // VARCHAR(255) => openads_varchar => 2 
    public $tracker_os;                      // VARCHAR(32) => openads_varchar => 2 
    public $connection_os;                   // VARCHAR(32) => openads_varchar => 2 
    public $tracker_browser;                 // VARCHAR(32) => openads_varchar => 2 
    public $connection_browser;              // VARCHAR(32) => openads_varchar => 2 
    public $connection_action;               // INT(10) => openads_int => 1 
    public $connection_window;               // INT(10) => openads_int => 1 
    public $connection_status;               // INT(10) => openads_int => 129 
    public $inside_window;                   // TINYINT(1) => openads_tinyint => 145 
    public $comments;                        // TEXT() => openads_text => 34 
    public $updated;                         // DATETIME() => openads_datetime => 142 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Data_intermediate_ad_connection',$k,$v); }

    var $defaultValues = array(
                'server_raw_ip' => '',
                'tracker_date_time' => '%NO_DATE_TIME%',
                'connection_status' => 4,
                'inside_window' => 0,
                'updated' => '%DATE_TIME%',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>