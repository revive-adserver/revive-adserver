<?php
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
    public $data_intermediate_ad_connection_id;    // int(20)  not_null primary_key auto_increment
    public $server_raw_ip;                   // string(16)  not_null
    public $server_raw_tracker_impression_id;    // int(20)  not_null
    public $viewer_id;                       // string(32)  multiple_key
    public $viewer_session_id;               // string(32)  
    public $tracker_date_time;               // datetime(19)  not_null multiple_key binary
    public $connection_date_time;            // datetime(19)  binary
    public $tracker_id;                      // int(10)  not_null multiple_key unsigned
    public $ad_id;                           // int(10)  not_null multiple_key unsigned
    public $creative_id;                     // int(10)  not_null unsigned
    public $zone_id;                         // int(10)  not_null multiple_key unsigned
    public $tracker_channel;                 // string(255)  
    public $connection_channel;              // string(255)  
    public $tracker_channel_ids;             // string(64)  
    public $connection_channel_ids;          // string(64)  
    public $tracker_language;                // string(13)  
    public $connection_language;             // string(13)  
    public $tracker_ip_address;              // string(16)  
    public $connection_ip_address;           // string(16)  
    public $tracker_host_name;               // string(255)  
    public $connection_host_name;            // string(255)  
    public $tracker_country;                 // string(2)  
    public $connection_country;              // string(2)  
    public $tracker_https;                   // int(10)  unsigned
    public $connection_https;                // int(10)  unsigned
    public $tracker_domain;                  // string(255)  
    public $connection_domain;               // string(255)  
    public $tracker_page;                    // string(255)  
    public $connection_page;                 // string(255)  
    public $tracker_query;                   // string(255)  
    public $connection_query;                // string(255)  
    public $tracker_referer;                 // string(255)  
    public $connection_referer;              // string(255)  
    public $tracker_search_term;             // string(255)  
    public $connection_search_term;          // string(255)  
    public $tracker_user_agent;              // string(255)  
    public $connection_user_agent;           // string(255)  
    public $tracker_os;                      // string(32)  
    public $connection_os;                   // string(32)  
    public $tracker_browser;                 // string(32)  
    public $connection_browser;              // string(32)  
    public $connection_action;               // int(10)  unsigned
    public $connection_window;               // int(10)  unsigned
    public $connection_status;               // int(10)  not_null unsigned
    public $inside_window;                   // int(1)  not_null
    public $comments;                        // blob(65535)  blob
    public $updated;                         // datetime(19)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_intermediate_ad_connection',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
