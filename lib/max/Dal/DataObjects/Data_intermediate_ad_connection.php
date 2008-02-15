<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
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

    var $__table = 'data_intermediate_ad_connection';    // table name
    var $data_intermediate_ad_connection_id;    // int(20)  not_null primary_key auto_increment
    var $server_raw_ip;                   // string(16)  not_null
    var $server_raw_tracker_impression_id;    // int(20)  not_null
    var $viewer_id;                       // string(32)  multiple_key
    var $viewer_session_id;               // string(32)  
    var $tracker_date_time;               // datetime(19)  not_null multiple_key binary
    var $connection_date_time;            // datetime(19)  binary
    var $tracker_id;                      // int(10)  not_null multiple_key unsigned
    var $ad_id;                           // int(10)  not_null multiple_key unsigned
    var $creative_id;                     // int(10)  not_null unsigned
    var $zone_id;                         // int(10)  not_null multiple_key unsigned
    var $tracker_channel;                 // string(255)  
    var $connection_channel;              // string(255)  
    var $tracker_channel_ids;             // string(64)  
    var $connection_channel_ids;          // string(64)  
    var $tracker_language;                // string(13)  
    var $connection_language;             // string(13)  
    var $tracker_ip_address;              // string(16)  
    var $connection_ip_address;           // string(16)  
    var $tracker_host_name;               // string(255)  
    var $connection_host_name;            // string(255)  
    var $tracker_country;                 // string(2)  
    var $connection_country;              // string(2)  
    var $tracker_https;                   // int(10)  unsigned
    var $connection_https;                // int(10)  unsigned
    var $tracker_domain;                  // string(255)  
    var $connection_domain;               // string(255)  
    var $tracker_page;                    // string(255)  
    var $connection_page;                 // string(255)  
    var $tracker_query;                   // string(255)  
    var $connection_query;                // string(255)  
    var $tracker_referer;                 // string(255)  
    var $connection_referer;              // string(255)  
    var $tracker_search_term;             // string(255)  
    var $connection_search_term;          // string(255)  
    var $tracker_user_agent;              // string(255)  
    var $connection_user_agent;           // string(255)  
    var $tracker_os;                      // string(32)  
    var $connection_os;                   // string(32)  
    var $tracker_browser;                 // string(32)  
    var $connection_browser;              // string(32)  
    var $connection_action;               // int(10)  unsigned
    var $connection_window;               // int(10)  unsigned
    var $connection_status;               // int(10)  not_null unsigned
    var $inside_window;                   // int(1)  not_null
    var $comments;                        // blob(65535)  blob
    var $updated;                         // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_intermediate_ad_connection',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>